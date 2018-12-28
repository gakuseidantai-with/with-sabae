<?php
/**
 * エラー画面コントローラー
 */
class Controller_Error_Index extends Controller
{
	/**
	 * 404
	 */
	public function action_404()
	{
		$view = View::forge('error/404');
		return $view;
	}

	/**
	 * 500
	 */
	public function action_500()
	{
		$view = View::forge('error/500');
		return $view;
	}

	/**
	 * 503
	 */
	public function action_503()
	{
		$view = View::forge('error/503');
		return $view;
	}
}