<?php
/**
 * WEB・管理向け基底コントローラー
 */
abstract class Controller_Base_Web_Admin extends Controller_Base_Web
{
	/**
	 * ログインチェックを行うか
	 */ 
	protected $is_before_login_check = true;

	/**
	 * ログインユーザID
	 */
	protected $loginUserId = null;

	/**
	 * ログインユーザ情報
	 */
	protected $loginUserInfo = null;

	/**
	 * 起動前処理
	 */
	public function before()
	{
		// 親クラスのbefore実行
		parent::before();

		// ログインチェック
		if ($this->is_before_login_check) {
			// ログインしていない場合、ログアウト
			if (!Manager_Admin_Login::is_login()) {
				Manager_Admin_Login::logout();
				$this->redirect('/with-admin/login');
			}

			// ログイン情報取得
			$this->loginUserId   = Manager_Admin_Login::get_login_user_id();
			$this->loginUserInfo = Model_User::find_by_pk($this->loginUserId);

			// ログインユーザ情報が無い場合、ログアウト処理実行
			if (is_null($this->loginUserInfo)) {
				Manager_Admin_Login::logout();
				$this->redirect('/with-admin/login');
			}

			// Viewの共通変数に設定
			View::set_global('loginUserId',   $this->loginUserId);
			View::set_global('loginUserInfo', $this->loginUserInfo);
		}
	}
}