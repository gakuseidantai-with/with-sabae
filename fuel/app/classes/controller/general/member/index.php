<?php

class Controller_General_Member_Index extends Controller
{
	public function action_index()
	{
		// imageNameが空白（管理者）以外取得
		$users = Model_User::find_by(function($query) {
			return $query->where('ut_is_member', "1");
		});
		
		$presenter = Presenter::forge('general/member/index');
		$presenter->set('users', $users);
		return $presenter;
	}
}