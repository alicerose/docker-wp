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
