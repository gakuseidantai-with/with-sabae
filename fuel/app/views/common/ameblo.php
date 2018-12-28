<?php

date_default_timezone_set('Asia/Tokyo');

/* ---------- 初期設定 ----------- */
// アメブロのアカウント
$ameblo_account = "gakuren";

// 取得したいRSSのurl
$blog_rss_url = "http://rssblog.ameba.jp/gakuren/rss20.xml";

// 取得表示したい件数
$post_count = 6;

// 記事タイトル表示文字数（バイト数ではありません）
$title_length = 50;

// 記事表示文字数（バイト数ではありません）
$description_length = 20;

// キャッシュを使用するかどうか
$cache_flg = false; // trueは使用する falseは使用しない（常にHTTPリクエスト発行する）
// キャッシュを使用する（HTTPリクエストを行わない）秒数
$cache_sec = 3600; // 3600秒 ＝ 30分
// キャシュを保存するディレクトリ
// 指定するディレクトリは パーミッションを　707 か 777 に設定してください
$cache_dir = "/cache";


// magpierss のモジュールを読込み
require_once("magpierss/rss_fetch.inc");
// echo DOCROOT;

// キャッシュ期間を指定する この指定数値（単位は秒）だけキャッシュを利用
// その間はHTTPリクエストを行いません。
define("MAGPIE_CACHE_ON", $cache_flg);
define("MAGPIE_CACHE_AGE", $cache_sec);

// キャッシュを保存するディレクトリを指定
define("MAGPIE_CACHE_DIR", $cache_dir);

// エンコードを UTF-8 に指定
define("MAGPIE_OUTPUT_ENCODING", "UTF-8");

// RSSを取得する
$rss = fetch_rss($blog_rss_url);

$cnt = 0;
foreach ($rss->items as $item) {
    // 記事の中で最初に使われている画像を検索、設定する
    if( preg_match_all('/<img(.+?)>/is', $item['description'], $matches) ){
        foreach( $matches[0] as $img ){
            if( preg_match('/src=[\'"](.+?jpe?g)[\'"]/', $img, $m) ){
                $item['thumbnail'] = $m[1];
            }
        }
    }

    // レスポンス用のPHPへのパスへ設定する
    $data = array("f" => (string)$item['thumbnail']);
    $item['thumbnail'] = sprintf("response.php?%s", http_build_query($data));


    // リンクアドレス
    $url = mb_convert_encoding($item['link'],"UTF-8","auto");
    // タイトル
    $title = mb_substr(mb_convert_encoding($item['title'],"UTF-8","auto"), 0, $title_length);
    // 記事内容
    $description = mb_substr(strip_tags(mb_convert_encoding($item['description'],"UTF-8","auto")), 0, $description_length);
    // 日付
    $date = date("Y/m/d", intval($item['date_timestamp']));
    // PR除く
    if (preg_match("/^PR:.+$/", $title) != 0) continue;
/* ----- この下のHTMLを変更するとフォーマットを変更できます ----- */
echo <<< END
    <div class="col-md-6 blog_view" style="border-radius: 20px;">
        <a href="
END;

echo $item['link'];

echo <<< END
" class="item-grid text-center">
            <img class="image" src="
END;

echo $item['thumbnail'];

echo <<< END
" style="float: left;" />
            <div class="v-align">
                <div class="v-align-middle">
                    <h3 class="title">$title</h3>
                    <h5 class="category">
                        $date<br />
                        $description
                    </h5>
                </div>
            </div>
        </a>
    </div>
END;
/* ----- この上のHTMLを変更するとフォーマットを変更できます ----- */
    // 設定件数取得したら終了
    if ($cnt == $post_count - 1) {
        break;
    }
    $cnt ++;
}
?>
