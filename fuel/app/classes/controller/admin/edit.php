<?php
/**
 * パスワード変更画面コントローラー
 */
class Controller_Admin_Edit extends Controller_Base_Web_Admin
{
	/**
	 * ログイン画面
	 */
	public function action_index()
	{
		$error     = Session::get_flash('error');
		$success   = Session::get_flash('success');
		// 画面表示
		return $this->make_edit_presenter($error, $success);
	}

	/**
	 * ログイン実行
	 */
	public function post_index()
	{
		// ログイン中のユーザーID
		$loginUserId   = Manager_Admin_Login::get_login_user_id();
		// ログイン中のユーザー情報
		$loginUserInfo = Model_User::find_by_pk($loginUserId);
		
		$name          = Input::post('ut_name');
		$mailaddress   = Input::post('ut_email');
		$college       = Input::post('ut_college');
		$catchPhrase   = Input::post('ut_catchphrase');

		// バリデーション
		$error         = array();

		// 画像がアップロードされたか
		$isUpload      = false;

		// ニックネームバリデーション
		if (is_empty($name)) {
			$error['name'] = 'ニックネームが未入力です。';
		}

		// メールアドレスバリデーション
		if (is_empty($mailaddress)) {
			$error['mailaddress'] = 'メールアドレスが未入力です。';
		} elseif (!Valid::is_mail($mailaddress)) {
			$error['mailaddress'] = 'メールアドレスの形式が正しくありません。';
		} else {
			// メールアドレスが変更されていたら
			if ($loginUserInfo['ut_email'] != $mailaddress) {
				// 既にメールアドレスが使用されていないかチェック
				$user = Model_User::find_by(array(
					'ut_email'  => $mailaddress,
				));

				if (!is_null($user)) {
					$error['mailaddress'] = 'このメールアドレスは既に利用されています。';
				}
			}
		}

		// 大学バリデーション
		if (is_empty($college)) {
			$error['college'] = '大学が入力されていません。';
		}

		// キャッチフレーズバリデーション
		if (is_empty($catchPhrase)) {
			$error['catchphrase'] = 'キャッチフレーズが入力されていません。';
		}
		
		// inputからアップロードされた
		if (isset($_FILES['selfPicture'])) {
			// アップロードエラーがない
			if ($_FILES['selfPicture']['error'] === 0) {
				$isUpload    = true;
				$selfPicture = base64_encode(file_get_contents($_FILES['selfPicture']['tmp_name']));
			}
			else
			{
				// アップロードエラー
				$selfPicture = null;
				// エラーコードの解析
				$errorDetail = $this->checkUploadErrorCode($_FILES['selfPicture']['error']);
				// 未アップロードに関するエラーは無視
				if (!is_empty($errorDetail)) {
					// アップロードされた画像に問題がある
					$isUpload       = true;
					$error['image'] = $errorDetail;
				}
			}
		}
		else {
			// input以外からデータがPOSTされた
			$selfPicture = Input::post('selfPicture');
			$isUpload    = true;
		}

		// -----------------------
		// 画像アップロードに関する変数
		// -----------------------
		static $UPLOAD_DIR = DOCROOT.'images'.DS.'members';

		if (!is_empty($error))
		{
			// エラーが存在する場合
			return $this->make_edit_presenter($error);
		}
		else
		{
			// 画像がアップロードされているか
			if ($isUpload)
			{
				// アップロードされている
				// base64形式の画像をデコード
				$imageData = base64_decode($selfPicture);
				// 画像のバリデーション
				if (($FILE_EXTENSION = Valid::is_imageValid($imageData)) !== false)
				{
					// アップロードプロセス
					$save_as = $UPLOAD_DIR.DS.$loginUserId.'.'.$FILE_EXTENSION;
					$result  = file_put_contents($save_as, $imageData);
					if ($result === false) {
						$error['image'] = 'アップロードに失敗しました。';
						DB::rollback_transaction();
						DB::start_transaction();
						// エラー
						return $this->make_edit_presenter($error);
					}
				}
				else
				{
					$error['image'] = "アップロードされた画像形式は対応していません：$FILE_EXTENSION";
					DB::rollback_transaction();
					DB::start_transaction();
					// エラー
					return $this->make_edit_presenter($error);
				}
			}
			else
			{
			}
		}

		$user = Model_User::find_by_pk($loginUserId);
		$user->ut_name        = $name;
		$user->ut_email       = $mailaddress;
		$user->ut_college     = $college;
		$user->ut_catchphrase = $catchPhrase;
		$result               = $user->save();

		if ($result == 0) {
			DB::rollback_transaction();
			DB::start_transaction();
			// 更新完了メッセージをセッションに登録
			Session::set_flash('error', 'ユーザー情報の更新に失敗しました。');
			// 支援サービス一覧にリダイレクト
			$this->redirect('/with-admin');
		}

		// 更新完了メッセージをセッションに登録
		Session::set_flash('success', 'ユーザー情報の更新が完了しました。');
		// 支援サービス一覧にリダイレクト
		$this->redirect('/with-admin');
	}

	/**
	 * 画像アップロードの際に出力されるエラーの特定
	 * @param     int $errorData エラーコード
	 * @return string            エラー内容
	 */
	private function checkUploadErrorCode($errorData) {
		switch ($errorData) {
			case UPLOAD_ERR_OK:
			//値: 0; この場合のみ、ファイルあり
			return null;

			case UPLOAD_ERR_INI_SIZE:
				//値: 1; アップロードされたファイルは、php.ini の upload_max_filesize ディレクティブの値を超えています（post_max_size, upload_max_filesize）
				return 'アップロードされたファイルが大きすぎます。' . ini_get('upload_max_filesize') . '以下のファイルをアップロードしてください。';

			case UPLOAD_ERR_FORM_SIZE:
				//値: 2; アップロードされたファイルは、HTML フォームで指定された MAX_FILE_SIZE を超えています。
				return 'アップロードされたファイルが大きすぎます。' . ($_POST['MAX_FILE_SIZE'] / 1000) . 'KB以下のファイルをアップロードしてください。';

			case UPLOAD_ERR_PARTIAL:
				//値: 3; アップロードされたファイルは一部のみしかアップロードされていません。
				return 'アップロードに失敗しています（通信エラー）。もう一度アップロードをお試しください。';

			case UPLOAD_ERR_NO_FILE:
				//値: 4; ファイルはアップロードされませんでした。（この場合のみ、ファイルがないことを表している）
				return null;

			case UPLOAD_ERR_NO_TMP_DIR:
				//値: 6; テンポラリフォルダがありません。PHP 4.3.10 と PHP 5.0.3 で導入されました。
				return 'アップロードに失敗しています（システムエラー）。もう一度アップロードをお試しください。';

			default:
				//UPLOAD_ERR_CANT_WRITE 値: 7; ディスクへの書き込みに失敗しました。PHP 5.1.0 で導入されました。
				//UPLOAD_ERR_EXTENSION 値: 8; ファイルのアップロードが拡張モジュールによって停止されました。 PHP 5.2.0 で導入されました。 
				//何かおかしい
				return 'アップロードファイルをご確認ください。';
		}
	}

	/**
	 * ログイン画面のプレゼンタ作成
	 *
	 * @param string $success 成功メッセージ
	 * @param string $error エラーメッセージ
	 * @return Presenter ログイン画面のプレゼンタ
	 */
	private function make_edit_presenter($error = null, $success = null)
	{
		// プレゼンタ作成
		$presenter = Presenter::forge('admin/edit');
		$presenter->set('error'  , $error);
		$presenter->set('success', $success);
		return $presenter;
	}
}