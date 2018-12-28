<?php

class Controller_Admin_Index extends Controller_Base_Web_Admin
{
	public function action_index()
	{
		$error     = Session::get_flash('error');
		$success   = Session::get_flash('success');

		$presenter = Presenter::forge('admin/index');
		$presenter->set('error'  , $error);
		$presenter->set('success', $success);
		return $presenter;
	}
}