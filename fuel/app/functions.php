<?php

/**
 * PHP5.4からでないと対応していないUnicodeアンエスケープをPHP5.3でもできるようにしたラッパー関数
 * @param mixed   $value
 * @param int     $options
 * @param boolean $unescapee_unicode
 */
function json_xencode($value, $options = 0, $unescapee_unicode = true)
{
  $v = json_encode($value, $options);
  if ($unescapee_unicode) {
    $v = unicode_encode($v);
    // スラッシュのエスケープをアンエスケープする
    $v = preg_replace('/\\\\\//', '/', $v);
  }
  return $v;
}

/**
 * Unicodeエスケープされた文字列をUTF-8文字列に戻す。
 * 参考:http://d.hatena.ne.jp/iizukaw/20090422
 * @param unknown_type $str
 */
function unicode_encode($str)
{
  return preg_replace_callback("/\\\\u([0-9a-zA-Z]{4})/", "encode_callback", $str);
}

function encode_callback($matches) {
  return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UTF-16");
}

/**
 * stdClassオブジェクトを配列化
 */
function obj2arr($value)
{
	if (!is_object($value)) return $value;
	$array = (array)$value;

	foreach ($array as &$contents)
	{
		$contents = obj2arr($contents);
	}

	return $array;
}

/**
 * 週番号を取得
 * 1〜7（月〜日）
 */
function getWeekCode()
{
	// 現在の日時を作成
	$dateTime = date_create();

	/**
	 * 曜日番号を取得
	 */
	return (int)date_format($dateTime, 'w');
}

/**
 * デバッグ用関数
 */
function pr($value)
{
	echo '<pre>';
	print_r($value);
	echo '</pre>';
}

/**
 * デバッグ用関数
 */
function va($value)
{
	echo '<pre>';
	var_dump($value);
	echo '</pre>';
}

/**
 * 空判定関数
 *
 * @param mixed $value 判定値
 * @return bool 判定結果(true:空、false:空以外)
 */
function is_empty($value)
{
	return empty($value) && ($value !== 0) && ($value !== '0');
}

/**
 * hash暗号化(sha256)
 *
 * @param string $value 暗号化前値
 * @return string hash暗号化(sha256)値
 */
function hash_hmac_sha256($value)
{
	$key = '_w_i_t_h_';
	return hash_hmac('sha256', $value, $key, false);
}

/**
 * SQLのlike句のワイルドカード値をエスケープ
 *
 * @param string $value エスケープ前の値
 * @return string エスケープ後の値
 */
function likeSqlEscape($value)
{
	$value = str_replace(
		array('\\', '%', '_'),
		array('\\\\', '\%', '\_'),
		$value
	);

	return $value;
}

/**
 * 個別エラーメッセージ用HTMLタグ作成
 *
 * @param string $error エラーメッセージ
 * @return string 個別エラーメッセージ用HTMLタグ
 */
function error_tag(&$error)
{
	if (isset($error)) {
		return '<p class="error-text">' . $error . '</p>';
	} else {
		return '';
	}
}
