<?php

    /*-----------------------------------------------------------------------------------*/
    /* 全体のカスタマイズ */
    /*-----------------------------------------------------------------------------------*/

    /**
     * ヘッダの不要項目削除
     */
    add_action( 'init', 'removeUnnecessaryHeader' );

    /**
     * 絵文字機能の削除
     */
    add_action( 'init', 'disableEmojis' );

    /**
     * クリックジャッキング対策
     */
    add_action( 'send_headers', 'send_frame_options_header', 10, 0 );

    /**
     * ファイルシステムの変更
     */
    add_filter( 'filesystem_method','modifyFileMethod' );

    /*-----------------------------------------------------------------------------------*/
    /* 関数 */
    /*-----------------------------------------------------------------------------------*/

    /**
     *
     */
    function removeUnnecessaryHeader() {
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
    }

    /**
     *
     */
    function disableEmojis() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' );
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    }

    /**
     * @param $args
     * @return string
     */
    function modifyFileMethod($args): string
    {
        return 'direct';
    }