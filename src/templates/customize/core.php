<?php

/*-----------------------------------------------------------------------------------*/
/* 全体のカスタマイズ */
/*-----------------------------------------------------------------------------------*/

/**
 * ヘッダ自動出力項目の削除
 */
function remove_unnecessary_header() {
    // WPのバージョン表記削除
    remove_action('wp_head','wp_generator');

    // 編集用RSDリンクの削除
    remove_action('wp_head', 'rsd_link');

    // Windows Live Writer編集用リンクの削除
    remove_action('wp_head', 'wlwmanifest_link');

    // RSSリンクの削除
    remove_action('wp_head', 'feed_links');
    remove_action('wp_head', 'feed_links_extra');

    // 短縮URLの削除
    remove_action('wp_head', 'wp_shortlink_wp_head');

    // ショートリンクの削除
    remove_action('template_redirect','wp_shortlink_header', 11, 0);
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);

    // WP-JSONリンクの削除
    remove_action( 'wp_head','rest_output_link_wp_head');

    // WP標準のCanonical削除
    if(DISABLE_WP_CANONICAL) remove_action( 'wp_head', 'rel_canonical');
}
add_action( 'init', 'remove_unnecessary_header' );

/**
 * 絵文字用リソース読み込みの削除
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Gitバージョンを返す
 * 取得できない場合（docker環境など）はfalseを返す
 * @param int $length 指定文字数で省略する
 * @return array|bool|string
 */
function get_git_hash(int $length = -1): array|bool|string
{
    $versionFile = THEME_PATH . '/.version';
    if(!file_exists($versionFile)) return false;

    $data = fopen($versionFile,'r');
    $version = str_replace("\n", '', fgets($data));
    fclose($data);

    if($length !== -1) {
        return mb_strimwidth($version, 0, $length);
    }

    return $version;

}
