<?php
/**
 * 管理向けログイン管理クラス
 */
class Manager_Admin_Login
{
	/**
	 * セッション：ログインユーザIDキー
	 */
	const ADMIN_LOGIN_USER_ID_KEY = '__admin_login_user_id';

	/**
	 ** ログイン処理
	 *
	 * @param string $mailaddress メールアドレス
	 * @param string $password パスワード(暗号化前)
	 * @return boolean true:ログインできた、false:ログインできなかった
	 */
	public static function login($mailaddress, $password)
	{
		// ユーザ存在チェック
		$user = Model_User::find_one_by(array(
			'ut_email'      => $mailaddress,
			'ut_password'   => hash_hmac_sha256($password),
		));

		if (!is_empty($user)) {
			// print_r($user);
			// セッションにログイン情報を設定
			Session::set(self::ADMIN_LOGIN_USER_ID_KEY, $user->ut_user_id);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * ログアウト処理
	 */
	public static function logout()
	{
		// セッションのログイン情報を削除
		Session::delete(self::ADMIN_LOGIN_USER_ID_KEY);
	}

	/**
	 * ログイン中であるか
	 *
	 * @return boolean true:ログイン中、false：未ログイン
	 */
	public static function is_login()
	{
		return (!is_empty(self::get_login_user_id()));
	}

	/**
	 * ログインユーザID取得
	 *
	 * @return int ログインユーザID
	 */
	public static function get_login_user_id()
	{
		return Session::get(self::ADMIN_LOGIN_USER_ID_KEY);
	}
}