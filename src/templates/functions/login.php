<?php

/*-----------------------------------------------------------------------------------*/
/* ログイン画面関連のカスタマイズ */
/*-----------------------------------------------------------------------------------*/

/**
 * ログイン画面用追加アセット
 * @return void
 */
function add_login_assets() {
    wp_enqueue_style ( 'custom-login', THEME_URI . '/assets/css/login.css' );
    wp_enqueue_script( 'custom-login', THEME_URI . '/assets/js/login.js' );
}
add_action( 'login_enqueue_scripts', 'add_login_assets' );

/**
 * ログイン画面のロゴクリック時の遷移先をWP公式からサイトトップへ変更
 * @return string
 */
function modify_login_logo_path(): string
{
    return get_bloginfo( 'url' );
}
if(REPLACE_LOGIN_LOGO_PATH) {
    add_filter( 'login_headerurl', 'modify_login_logo_path' );
}


/**
 * ログイン画面のロゴのtitle属性変更
 * @return string
 */
function modify_login_logo_title(): string
{
    return get_bloginfo('title') . 'を表示';
}
if(REPLACE_LOGIN_LOGO_PATH) {
    add_filter('login_headertext', 'modify_login_logo_title');
}

/**
 * ログイン画面のfavicon差し替え
 * @return void
 */
function modify_login_favicon() {
    if(MODIFY_ADMIN_FAVICON) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="' . THEME_URI . '/favicon.ico" />';
    }
}
add_action( 'login_head', 'modify_login_favicon' );
