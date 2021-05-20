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

    /**
     * 不要な項目削除
     */
    add_action('admin_menu', 'removeUnnecessaryMenus');

    /**
     * 投稿画面の不要項目削除
     */
    add_action( 'admin_menu' , 'removeUnnecessaryMeta_Post' );

    /**
     * 固定ページの不要項目削除
     */
    add_action( 'admin_menu' , 'removeUnnecessaryMeta_Page' );

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

    /**
     *
     */
    function removeUnnecessaryMenus () {
        global $menu;
//         remove_menu_page( 'edit-comments.php' );// コメント
    }

    /**
     *
     */
    function removeUnnecessaryMeta_Post() {
        if ( !current_user_can( 'administrator' ) ) {
//            remove_meta_box( 'commentsdiv' , 'post' , 'normal' );      // コメント
            remove_meta_box( 'tagsdiv-post_tag' , 'page' , 'side' );   // タグ
            remove_meta_box( 'trackbacksdiv' , 'post' , 'normal' );    // トラックバック
            remove_meta_box( 'commentstatusdiv' , 'post' , 'normal' ); // ディスカッション
        }
    }

    /**
     *
     */
    function removeUnnecessaryMeta_Page() {
        if ( !current_user_can( 'administrator' ) ) {
            remove_meta_box( 'commentsdiv' , 'page' , 'normal' );      // コメント
            remove_meta_box( 'tagsdiv-post_tag' , 'page' , 'side' );   // タグ
            remove_meta_box( 'trackbacksdiv' , 'page' , 'normal' );    // トラックバック
            remove_meta_box( 'commentstatusdiv' , 'page' , 'normal' ); // ディスカッション
        }
    }