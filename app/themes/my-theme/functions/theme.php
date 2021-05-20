<?php

    /*-----------------------------------------------------------------------------------*/
    /* テーマに依存したカスタマイズ */
    /*-----------------------------------------------------------------------------------*/

    /**
     * サムネイル追加
     */
    add_theme_support('post-thumbnails');

    /**
     * サムネイルサイズ
     */
    add_image_size('OGP', 1200, 630, true);

    /**
     * カスタム投稿タイプ・カスタムフィールドも検索対象に含める
     * https://mohulog.com/20180620_1732/
     */
    add_filter('posts_search','searchIncludesCustomFields', 10, 2);

    /**
     * 「投稿」のメニュー名変更
     */
     // add_action( 'init', 'modify_post_menu_label' );

    /*-----------------------------------------------------------------------------------*/
    /* 関数 */
    /*-----------------------------------------------------------------------------------*/

    /**
     * @param $search
     * @param $wp_query
     * @return string
     */
    function searchIncludesCustomFields($search, $wp_query): string
    {
        global $wpdb;

        if (!$wp_query->is_search)
            return $search;
        if (!isset($wp_query->query_vars))
            return $search;

        $search_words = explode(' ', isset($wp_query->query_vars['s']) ? $wp_query->query_vars['s'] : '');
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

    /**
     * @param $name
     */
    function modify_post_label($name) {
        global $menu;
        global $submenu;
        $menu[5][0] = $name;
        $submenu['edit.php'][5][0] = $name.'一覧';
        $submenu['edit.php'][10][0] = '新しい'.$name;
    }

    /**
     *
     */
    function modify_post_menu_label() {
        $name = 'ニュース';
        add_action( 'admin_menu',
            function() use ( $name ) {
                modify_post_label( $name );
            }
        );

        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = $name;
        $labels->singular_name = $name;
        $labels->add_new = _x('追加', $name);
        $labels->add_new_item = $name.'の新規追加';
        $labels->edit_item = $name.'の編集';
        $labels->new_item = '新規'.$name;
        $labels->view_item = $name.'を表示';
        $labels->search_items = $name.'を検索';
        $labels->not_found = $name.'が見つかりませんでした';
        $labels->not_found_in_trash = 'ゴミ箱に'.$name.'は見つかりませんでした';
    }