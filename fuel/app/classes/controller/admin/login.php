<?php
/**
 * ログイン画面コントローラー
 */
class Controller_Admin_Login extends Controller_Base_Web_Admin
{
	/**
	 * ログインチェックを行うか (false:行わない)
	 */
	public $is_before_login_check = false;

	/**
	 * ログイン画面
	 */
	public function action_index()
	{
		$error     = Session::get_flash('error');
		$success   = Session::get_flash('success');
		// 画面表示
		return $this->make_login_presenter(null, $error, $success);
	}

	/**
	 * ログイン実行
	 */
	public function post_index()
	{
		// パラメータ取得
		// メールアドレス
		$mailaddress = Input::post('mailaddress');
		// パスワード
		$password = Input::post('password');

		// バリデーション
		$error = null;
		if (is_empty($mailaddress)) {
			$error = 'メールアドレスが未入力です。';
		} elseif (!Valid::is_mail($mailaddress)) {
			$error = 'メールアドレスの形式が正しくありません。';
		} elseif (is_empty($password)) {
			$error = 'パスワードが未入力です。';
		}

		if (!is_empty($error)) {
			// エラーが存在する場合
			return $this->make_login_presenter($mailaddress, $error);

		} else {
			// ログイン処理
			$isSuccess = Manager_Admin_Login::login($mailaddress, $password);
			if ($isSuccess) {
				Session::set_flash('success', 'ログインしました');
				$this->redirect('/with-admin');
			} else {
				return $this->make_login_presenter($mailaddress, 'ログインできませんでした。');
			}
		}
	}

	/**
	 * ログアウト実行
	 */
	public function action_logout()
	{
		// ログアウト処理
		Manager_Admin_Login::logout();

		Session::set_flash('success', 'ログアウトしました');

		// ログイン画面にリダイレクト
		$this->redirect('/with-admin/login');
	}

	/**
	 * ログイン画面のプレゼンタ作成
	 *
	 * @param string $mailaddress メールアドレス
	 * @param string $error エラーメッセージ
	 * @return Presenter ログイン画面のプレゼンタ
	 */
	private function make_login_presenter($mailaddress = null, $error = null, $success = null)
	{
		// プレゼンタ作成
		$presenter = Presenter::forge('admin/login');
		$presenter->set('error', $error);
		$presenter->set('success', $success);
		$presenter->set('mail' , $mailaddress);
		return $presenter;
	}
}