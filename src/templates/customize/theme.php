<?php

/**
 * WP制御でアセットを読み込む
 * @return void
 */
function add_assets() {

    if(DISABLE_WP_JQUERY) wp_deregister_script('jquery');

    foreach(ASSET_FILES_STYLE as $id) {
        asset_style($id);
    }

    foreach(ASSET_FILES_SCRIPT as $id) {
        if(is_array($id)) {
            asset_script($id[0], $id[1]);
        } else {
            asset_script($id);
        }
    }

}
add_action('wp_enqueue_scripts', 'add_assets');

/**
 * CSSファイルのキュー
 * @param $id
 * @return void
 */
function asset_style($id) {
    $url = THEME_URI . '/assets/css/' . $id . '.css';
    $path = THEME_PATH . '/assets/css/' . $id . '.css';
    if(!file_exists($path)) {
        return;
    }

    wp_enqueue_style(
        $id,
        $url,
        [],
        ENABLE_ASSET_VERSIONING_TIMESTAMP ? date('YmdGis', filemtime($path)) : null
    );
}

/**
 * JSファイルのキュー
 * @param $id
 * @param bool $in_footer フッタで読み込むかどうか
 * @return void
 */
function asset_script($id, bool $in_footer = true) {
    $url = THEME_URI . '/assets/js/' . $id . '.bundle.js';
    $path = THEME_PATH . '/assets/js/' . $id . '.bundle.js';
    if(!file_exists($path)) {
        return;
    }

    wp_enqueue_script(
        $id,
        $url,
        [],
        ENABLE_ASSET_VERSIONING_TIMESTAMP ? date('YmdGis', filemtime($path)) : null,
        $in_footer
    );
}

/**
 * サムネイルの有効化
 * @return void
 */
function enable_thumbnail () {
    if(ENABLE_EYE_CATCH_IMAGE) add_theme_support('post-thumbnails');
}
add_action( 'init', 'enable_thumbnail');

/**
 * 画像サイズの追加拡張
 * @return void
 */
function add_image_sizes () {
    foreach(ADD_IMAGE_SIZES as $size) {
        add_image_size($size['name'], $size['width'], $size['height'], $size['crop']);
    }
}
add_action( 'init', 'add_image_sizes');

/**
 * メニュー機能を有効化する
 * @return void
 */
function enable_menu () {
    $args = [];
    foreach(ENABLE_MENU as $menu) {
        $args[$menu['id']] = $menu['label'];
    }
    register_nav_menus($args);
}
add_action( 'after_setup_theme', 'enable_menu' );

/**
 * 検索対象を拡張する
 * @param $search
 * @param $wp_query
 * @return string
 */
function expand_search_result($search, $wp_query): string
{
    global $wpdb;

    // 検索対象を操作しないケース
    if (!$wp_query->is_search) return $search;
    if (!isset($wp_query->query_vars)) return $search;
    if (!EXPAND_SEARCH_RESULT) return $search;

    $search_words = explode(' ', $wp_query->query_vars['s'] ?? '');
    if ( count($search_words) > 0 ) {
        $search = '';

        /**
         * 投稿タイプを対象に追加
         */
        $search .= "AND post_type = 'custom_post_type'";

        foreach ( $search_words as $word ) {
            if ( !empty($word) ) {
                $search_word = '%' . esc_sql( $word ) . '%';
                $search .= " AND (
                        {$wpdb->posts}.post_title LIKE '{$search_word}'
                        OR {$wpdb->posts}.post_content LIKE '{$search_word}'
                        OR {$wpdb->posts}.ID IN (
                        SELECT distinct post_id
                        FROM {$wpdb->postmeta}
                        WHERE meta_value LIKE '{$search_word}'
                        )
                    ) ";
            }
        }
    }
    return $search;
}
add_filter( 'posts_search', 'expand_search_result', 10, 2 );

/**
 * リライトルール初期化
 */
if(ALWAYS_FLUSH_REWRITE_RULES) {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}
