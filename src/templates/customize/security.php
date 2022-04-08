<?php

/*-----------------------------------------------------------------------------------*/
/* セキュリティ関連修正 */
/*-----------------------------------------------------------------------------------*/

/**
 * クリックジャッキング対策
 * x-frame-optionsヘッダを`SAMEORIGIN`で出力する
 */
add_action( 'send_headers', 'send_frame_options_header', 10, 0 );

/**
 * REST APIでユーザ名が外部から取得出来てしまうのを阻止する
 * @param $endpoints
 * @return mixed
 */
function disable_end_point_users( $endpoints ): mixed
{
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P[\d]+)'] );
    }
    return $endpoints;
}
add_filter( 'rest_endpoints', 'disable_end_point_users', 10, 1 );

/**
 * WordPressのバージョン表記を抑止する
 * @return string
 */
function disable_word_press_version_display(): string
{
    return '';
}
add_filter('the_generator', 'disable_word_press_version_display');

/**
 * 非ログイン時の管理画面露軍画面リダイレクト停止
 * @return void
 */
function remove_default_redirect()
{
    remove_action('template_redirect', 'wp_redirect_admin_locations', 1000);
}
add_action('init', 'remove_default_redirect');

/**
 * ログイン画面へのリダイレクト停止
 * @param $scheme
 * @return mixed|void
 */
function disable_redirect($scheme)
{
    if ( $user_id = wp_validate_auth_cookie( '',  $scheme) ) {
        return $scheme;
    }

    global $wp_query;
    $wp_query->set_404();
    get_template_part( 404 );
    exit();
}
add_filter('auth_redirect_scheme', 'disable_redirect', 9999);
