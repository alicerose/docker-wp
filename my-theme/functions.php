<?php

//define('WP_DEBUG',true);
//define('WP_THEMES_ROOT',get_template_directory_uri());

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!empty($_SERVER['DOCUMENT_ROOT']) && !defined('WWW_ROOT')) {
    define('WWW_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS);
}
function wpinc($file)
{
    include get_template_directory() . DS . $file;
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/
/* カスタム投稿タイプ
 ============================================== */
function custom_entry_post_type()
{
    $labels = [
        'name' => '店舗情報',
        'singular_name' => '店舗情報',
        'add_new_item' => '店舗情報を追加',
        'add_new' => '新規追加',
        'new_item' => '新しい店舗',
        'view_item' => 'この店舗を表示',
        'not_found' => '店舗がありません',
        'not_found_in_trash' => 'ゴミ箱に店舗情報はありません。',
        'search_items' => '店舗を検索',
    ];
    $args = [
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'query_var' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => [
            'title',
            'editor',
            'thumbnail',
            'custom-fields',
            'excerpt',
            'author',
            'trackbacks',
            'comments',
            'revisions',
            'page-attributes',
        ],
        'has_archive' => true,
    ];
    register_post_type('custom_entry', $args);
    register_taxonomy('custom_categories', 'custom_entry', [
        'hierarchical' => true,
        'update_count_callback' => '_update_post_term_count',
        'label' => 'カテゴリー',
        'singular_label' => 'カテゴリー',
        'public' => true,
        'show_ui' => true,
    ]);
}
add_action('init', 'custom_entry_post_type');

/**
 * カスタムメニュー
 */
function register_my_menus()
{
    register_nav_menus([
        //複数のナビゲーションメニューを登録する関数
        //'「メニューの位置」の識別子' => 'メニューの説明の文字列',
        'main-menu' => 'Main Menu',
        'footer-menu' => 'Footer Menu',
    ]);
}
add_action('after_setup_theme', 'register_my_menus');

/**
 * サムネイル追加
 */
add_theme_support('post-thumbnails');

/**
 * サムネイルサイズ
 */
add_image_size('custom_thumbnails', 80, 80, true);

/**
 * カスタムフィールドをREST APIで編集可能にする
 */
add_filter('acf/rest_api/field_settings/edit_in_rest', '__return_true');

/**
 * Gitのハッシュを返す
 * @return string
 */
function git_hash()
{
    return trim(exec('git log --pretty="%H" -n1 HEAD'));
}

/**
 * アセットファイル読み込み制御
 */
function add_files()
{
    // WordPress提供のjquery.jsを読み込まない
    wp_deregister_script('jquery');

    define("TEMPLATE_DIRE", get_template_directory_uri());
    define("TEMPLATE_PATH", get_template_directory());

    function wp_css($css_name, $file_path){
        wp_enqueue_style($css_name,TEMPLATE_DIRE.$file_path, array(), date('YmdGis', filemtime(TEMPLATE_PATH.$file_path)));
    }
    function wp_script($script_name, $file_path, $bool = true){
        wp_enqueue_script($script_name,TEMPLATE_DIRE.$file_path, array(), date('YmdGis', filemtime(TEMPLATE_PATH.$file_path)), $bool);
    }

    wp_script('theme_script','/assets/js/app.js');
    wp_css('theme_style','/assets/css/common.css');

}
add_action('wp_enqueue_scripts', 'add_files');
