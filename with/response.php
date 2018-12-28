<?php
/**
 * curl_get_contents
 * file_get_contentsの代替関数。
 * allow_url_fopen=off時にURLからファイル内容を取得する際に使用します
 * @param string $url
 * @param integer $timeout
 * @return string
 * @link http://blog.mach3.jp/2010/12/21/use-curl-for-filegetcontents.html
 */
function curl_get_contents( $url, $timeout=60 )
{
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    $result = curl_exec( $ch );
    curl_close( $ch );
    return $result;
}

/**
 * get_mime_type
 * 画像周りのmimeタイプを取得します
 * @param string $path
 * @return string
 */
function get_mime_type( $path )
{
	$mimeTypeList = array(
		"jpg"  => "image/jpeg",
		"jpeg" => "image/jpeg",
		"jp2"  => "image/jp2",
		"png"  => "image/png",
		"gif"  => "image/gif",
		"bmp"  => "image/bmp"
	);

	$info = pathinfo($path);

	if( isset($info["extension"]) && isset($mimeTypeList[ $info["extension"] ]) ){
		return $mimeTypeList[ $info["extension"] ];
	}else if( !function_exists("mime_content_type") ){
		return exec("file -Ib ".$path);
	}else{
		return mime_content_type($path);
	}
}

/**
 * 画像のサイズを変形して保存する
 * @param string $srcPath
 * @param string $dstPath
 * @param int $width
 * @param int $height
 */
function transform_image_size($srcPath, $dstPath, $width, $height)
{
    list($originalWidth, $originalHeight, $type) = getimagesize($srcPath);
    switch ($type) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($srcPath);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($srcPath);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($srcPath);
            break;
        default:
            throw new RuntimeException("サポートしていない画像形式です: $type");
    }

    $canvas = imagecreatetruecolor($width, $height);
    imagecopyresampled($canvas, $source, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);
    imagejpeg($canvas, $dstPath);
    imagedestroy($source);
    imagedestroy($canvas);
}

/**
 * 内接サイズを計算する
 * @param int $width
 * @param int $height
 * @param int $containerWidth
 * @param int $containerHeight
 * @return array
 */
function get_contain_size($width, $height, $containerWidth, $containerHeight)
{
    $ratio = $width / $height;
    $containerRatio = $containerWidth / $containerHeight;
    if ($ratio > $containerRatio) {
        return [$containerWidth, intval($containerWidth / $ratio)];
    } else {
        return [intval($containerHeight * $ratio), $containerHeight];
    }
}

/**
 * 画像のサムネイルを保存する
 * @param string $srcPath
 * @param string $dstPath
 * @param int $maxWidth
 * @param int $maxHeight
 */
function make_thumbnail($srcPath, $dstPath, $maxWidth, $maxHeight)
{
    list($originalWidth, $originalHeight) = getimagesize($srcPath);
    list($canvasWidth, $canvasHeight) = get_contain_size($originalWidth, $originalHeight, $maxWidth, $maxHeight);
    transform_image_size($srcPath, $dstPath, $canvasWidth, $canvasHeight);
}

$f = isset($_GET["f"]) ? $_GET["f"] : "";
$file_uri = str_replace("\0", "", $f);

// 値を取得
if( $file = curl_get_contents($file_uri) ){
  $mime = get_mime_type($file_uri);
  header("Content-Type: {$mime}");
  print $file;
  exit();
}

print "Error";
exit();