<?php
/**
 * パスワード変更画面コントローラー
 */
class Controller_Admin_Password extends Controller_Base_Web_Admin
{
	/**
	 * ログイン画面
	 */
	public function action_index()
	{
		$error     = Session::get_flash('error');
		$success   = Session::get_flash('success');
		// 画面表示
		return $this->make_password_change_presenter($error, $success);
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
		// 古いパスワード
		$oldPassword   = Input::post('old_password');
		// 新しいパスワード
		$newPassword   = Input::post('new_password');
		// 新しいパスワード（確認）
		$reNewPassword = Input::post('re_new_password');
		
		// バリデーション
		$error         = null;

		if (is_empty($oldPassword)) {
			$error = '古いパスワードが未入力です';
		} elseif ($newPassword != $reNewPassword) {
			$error = '新しいパスワードが一致しません';
		}

		if (!is_empty($error)) {
			// エラーが存在する場合
			return $this->make_password_change_presenter($error);

		} else {
			// hash済みの古いパスワード
			$hashedOldPassword = hash_hmac_sha256($oldPassword);

			// 古いパスワードがあっているか検証
			if ($loginUserInfo['ut_password'] === $hashedOldPassword) {
				$user              = Model_User::find_by_pk($loginUserId);
				$user->ut_password = hash_hmac_sha256($newPassword);
				$result            = $user->save();

				if ($result == 0) {
					DB::rollback_transaction();
					Session::set_flash('error', 'ユーザー情報を更新できませんでした。');
					$this->redirect('/with-admin/password');
				}

				Manager_Admin_Login::logout();
				Session::set_flash('success', 'パスワードを更新しました。再ログインしてください');
				$this->redirect('/with-admin/login');

			} else {
				$error = "古いパスワードが一致しません";
				return $this->make_password_change_presenter($error);
			}
		}
	}

	/**
	 * ログイン画面のプレゼンタ作成
	 *
	 * @param string $success 成功メッセージ
	 * @param string $error エラーメッセージ
	 * @return Presenter ログイン画面のプレゼンタ
	 */
	private function make_password_change_presenter($error = null, $success = null)
	{
		// プレゼンタ作成
		$presenter = Presenter::forge('admin/password');
		$presenter->set('error'  , $error);
		$presenter->set('success', $success);
		return $presenter;
	}
}