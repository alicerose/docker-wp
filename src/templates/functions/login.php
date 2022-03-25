<?php

    /*-----------------------------------------------------------------------------------*/
    /* ログイン画面のカスタマイズ */
    /*-----------------------------------------------------------------------------------*/

    /**
     * ログイン画面のアセット追加
     */
//    add_action( 'login_enqueue_scripts', 'addLoginAssets' );

    /**
     * ログイン画面のロゴクリック時のリンク先URL
     */
    add_filter( 'login_headerurl', 'modifyLoginLogoPath' );

    /**
     * ログイン画面のロゴタイトル
     */
    add_filter( 'login_headertext', 'modifyLoginLogoTitle' );

    /**
     * ログイン画面のfavicon
     */
    add_action( 'login_head', 'modifyLoginFavicon' );

    /*-----------------------------------------------------------------------------------*/
    /* 関数 */
    /*-----------------------------------------------------------------------------------*/

    function addLoginAssets() {
        wp_enqueue_style( 'custom-login', get_template_directory_uri() . '/assets/css/login.css' );
        wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/assets/js/login.js' );
    }

    /**
     * @return string
     */
    function modifyLoginLogoPath(): string
    {
        return get_bloginfo( 'url' );
    }

    /**
     * @return string
     */
    function modifyLoginLogoTitle(): string
    {
        return get_bloginfo('title') . 'を表示';
    }

    /**
     *
     */
    function modifyLoginFavicon() {
        echo '<link rel="shortcut icon" type="image/x-icon" href="' . get_template_directory_uri()  . '/favicon.ico" />';
    }