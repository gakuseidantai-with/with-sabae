<?php
/**
 * バリデーションクラス
 */
class Valid
{
	/**
	 * 半角数字チェック
	 *
	 * @param  string  $value チェック対象文字列
	 * @param  boolean $allowMinus マイナス値を許可するか(true:許可、false:不許可)
	 * @return boolean true:OK、false:NG
	 */
	public static function is_num($value, $allowMinus = false)
	{
		if ($allowMinus) {
			return (boolean)preg_match("/^-?[0-9]+$/", $value);
		} else {
			return (boolean)preg_match("/^[0-9]+$/", $value);
		}
	}

	/**
	 * 全角カタカナチェック
	 *
	 * @param  string  $value チェック対象文字列
	 * @return boolean true:OK、false:NG
	 */
	public static function is_katakana($value)
	{
		return (boolean)preg_match("/^[ァ-ヶー]+$/u", $value);
	}

	/**
	 * メールアドレスチェック
	 *
	 * @param  string  $value チェック対象文字列
	 * @return boolean true:OK、false:NG
	 */
	public static function is_mail($value)
	{
		return (boolean)preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $value);
	}

	/**
	 * 電話番号チェック
	 *
	 * @param  string  $value チェック対象文字列
	 * @return boolean true:OK、false:NG
	 */
	public static function is_phone($value)
	{
		return (boolean)preg_match("/^[0-9]+(\-[0-9]+)*$/", $value);
	}

	/**
	 * ICFタグチェック
	 *
	 * @param  string  $value チェック対象文字列
	 * @return boolean true:OK、false:NG
	 */
	public static function is_icf($value)
	{
		return (boolean)preg_match("/^([a-z0-9])+$/", $value);
	}

	/**
	 * 日付チェック
	 *
	 * @param  string  $ymd チェック対象文字列
	 * @return boolean true:OK、false:NG
	 */
	public static function is_date($ymd, $isInput = false)
	{
		if (is_empty($ymd)) {
			return false;
		}

		if ($isInput) {
			if (!(boolean)preg_match("/^\d{4}\/\d{2}\/\d{2}$/", $ymd)) {
				return false;
			}
		}

		if (strlen($ymd) === 10 && mb_strlen($ymd) === 10) {
			$ymd = str_replace('-', '', $ymd);
			$ymd = str_replace('/', '', $ymd);
		}

		if (strlen($ymd) !== 8 || mb_strlen($ymd) !== 8 || !self::is_num($ymd)) {
			return false;
		}

		$y = intval(substr($ymd, 0, 4));
		$m = intval(substr($ymd, 4, 2));
		$d = intval(substr($ymd, 6, 2));
		return checkdate($m, $d, $y);
	}

	/**
	 * 月チェック
	 *
	 * @param  string  $ym チェック対象文字列
	 * @return boolean true:OK、false:NG
	 */
	public static function is_month($ym, $isInput = false)
	{
		if (is_empty($ym)) {
			return false;
		}

		if ($isInput) {
			if (!(boolean)preg_match("/^\d{4}\/\d{2}$/", $ym)) {
				return false;
			}
		}

		if (strlen($ym) == 7 && mb_strlen($ym) === 7) {
			$ym = str_replace('-', '', $ym);
			$ym = str_replace('/', '', $ym);
		}

		if (strlen($ym) !== 6 || mb_strlen($ym) !== 6 || !self::is_num($ym)) {
			return false;
		}

		$y = intval(substr($ym, 0, 4));
		$m = intval(substr($ym, 4, 2));
		$d = 1;

		return checkdate($m, $d, $y);
	}

	/**
	 * 指定された拡張子の画像チェック
	 * @param  string  $imageData base64_decodeされた画像データ
	 * @return mixed   許可した拡張子: 拡張子名, 未許可の拡張子: FLASE
	 */
	public static function is_imageValid($imageData) {
		// 画像のバリデーション
		$mineType = finfo_buffer(finfo_open(), $imageData, FILEINFO_MIME_TYPE);
		//拡張子の配列（拡張子の種類を増やせば、画像以外のファイルでもOKです）
		$extension_array = array(
			'jpg' => 'image/jpeg',
			'png' => 'image/png'
		);

		if ($ext = array_search($mineType, $extension_array, true)) {
			return $ext;
		} else {
			return false;
		}
	}
}
