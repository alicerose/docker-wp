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
    add_action( 'admin_menu', 'removeUnnecessaryMenus' );

    /**
     * 投稿画面の不要項目削除
     */
    add_action( 'admin_menu' , 'removeUnnecessaryMeta_Post' );

    /**
     * 固定ページの不要項目削除
     */
    add_action( 'admin_menu' , 'removeUnnecessaryMeta_Page' );

    /**
     * 不要なダッシュボード項目の削除
     */
    add_action('wp_dashboard_setup', 'removeUnnecessaryDashboards' );

    /**
     * 管理画面に独自項目を追加する
     */
    add_action('admin_menu', 'addCustomAdminPage');

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
        echo "Env: " . ENVIRONMENT;
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

    /**
     * @return void
     */
    function removeUnnecessaryDashboards() {
//        remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); //サイトヘルスステータス
//        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); //概要
//        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); //アクティビティ
//        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); //クイックドラフト
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); //WordPressニュース
        remove_action( 'welcome_panel', 'wp_welcome_panel' ); //ようこそ
    }

    /**
     * @return void
     */
    function addCustomAdminPage() {
        add_menu_page(
            // $page_title　：　ページタイトル（title）,
            "カスタムタイトル",
            // $menu_title　：　メニュータイトル,
            "カスタム項目",
            // $capability　：　メニュー表示するユーザーの権限,
            // https://wpdocs.osdn.jp/%E3%83%A6%E3%83%BC%E3%82%B6%E3%83%BC%E3%81%AE%E7%A8%AE%E9%A1%9E%E3%81%A8%E6%A8%A9%E9%99%90
            "manage_options",
            // $menu_slug,　：　メニューのスラッグ,
            "custom",
            // $function,　：　メニュー表示時に使われる関数,
            "customAdminTop",
            // $icon_url,　：　メニューのテキスト左のアイコン,
            // https://developer.wordpress.org/resource/dashicons/#editor-paste-word
            "dashicons-admin-generic",
            // $position 　：　メニューを表示する位置;
            "40"
        );
    }

    /**
     * 簡易マニュアルとかならこれで充分？
     * @return void
     */
    function customAdminTop() {
        if (!current_user_can( 'manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        ?>
        <div class="wrap">
            <h1>カスタム項目</h1>
            <p>テスト</p>
        </div>
        <?php
    }