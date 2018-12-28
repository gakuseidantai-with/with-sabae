<?php
/**
 * ログ出力クラス
 */
class Log extends \Fuel\Core\Log
{
	public static function ex($e)
	{
		$message = "[".$e->getCode()."]";

		$message .= $e->getMessage();

		$message .= " in ". $e->getFile(). " on line ". $e->getLine();

		Log::error($message);
	}
}