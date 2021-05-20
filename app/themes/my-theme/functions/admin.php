<?php

    /*-----------------------------------------------------------------------------------*/
    /* 管理画面のカスタマイズ */
    /*-----------------------------------------------------------------------------------*/

    /**
     * 管理画面用追加アセット
     */
//    add_action( 'admin_enqueue_scripts', 'addAdminAsset' );

    /**
     * 管理画面のfavicon差し替え
     */
//    add_action( 'admin_head', 'replaceAdminFavicon' );

    /**
     * 管理画面のフッターテキスト差し替え
     */
    add_filter( 'admin_footer_text', 'replaceAdminFooterText' );

    /*-----------------------------------------------------------------------------------*/
    /* 関数 */
    /*-----------------------------------------------------------------------------------*/

    /**
     *
     */
    function addAdminAsset() {
        wp_enqueue_style( 'custom-admin', get_template_directory_uri() . '/assets/css/admin.css' );
        wp_enqueue_script( 'custom-admin', get_template_directory_uri() . '/assets/js/admin.js' );
    }

    /**
     *
     */
    function replaceAdminFavicon() {
        echo '<link rel="shortcut icon" type="image/x-icon" href="' . get_template_directory_uri()  . '/favicon.ico" />';
    }


    /**
     *
     */
    function replaceAdminFooterText() {
        echo 'Footer Text';
    }