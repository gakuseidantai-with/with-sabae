<?php

class Controller_General_Index extends Controller
{
	public function action_index()
	{
		$presenter = Presenter::forge('general/index');
		return $presenter;
	}
}