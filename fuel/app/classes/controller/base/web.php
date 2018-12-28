<?php
/**
 * WEB基底コントローラー
 */
abstract class Controller_Base_Web extends Controller
{
	/**
	 * リダイレクト
	 *
	 * @param string $url リダイレクト先URL
	 * @param boolean $commitTransaction トランザクションをコミットするか
	 */
	protected function redirect($url, $commitTransaction = true)
	{
		if ($commitTransaction) {
			// トランザクションコミット
			DB::commit_transaction();
		} else {
			// トランザクションロールバック
			DB::rollback_transaction();
		}
		Response::redirect($url);
	}
}