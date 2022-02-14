<?php

    /*-----------------------------------------------------------------------------------*/
    /* カスタム投稿タイプの追加 */
    /*-----------------------------------------------------------------------------------*/

    /**
     * カスタム投稿タイプの登録
     */
    add_action('init', 'registerCustomPostTypes');

    /**
     * カスタムタクソノミーの登録
     */
    add_action('init', 'registerCustomTaxonomies');

    /**
     * カスタムタクソノミーのURLリライト
     */
    add_action( 'init', 'rewriteCustomTaxonomies' );

    /*-----------------------------------------------------------------------------------*/
    /* 関数 */
    /*-----------------------------------------------------------------------------------*/

    /**
     *
     */
    function registerCustomPostTypes()
    {
        // sample
        registerPostType('サンプル', 'sample');
    }

    function registerCustomTaxonomies() {
        // sample
        registerCustomTaxonomy('sample-term', 'サンプル');
    }

    /**
     * @param $name
     * @param $type
     * @param $override array|null?
     */
    function registerPostType($name, $type, array $override = null) {
        $labels = [
            'name'               => $name,
            'singular_name'      => $name,
            'add_new_item'       => $name . 'を追加',
            'add_new'            => '新規追加',
            'new_item'           => '新しい' . $name,
            'edit_item'          => $name . 'の編集',
            'view_item'          => 'この' . $name . 'を表示',
            'not_found'          => $name . 'が登録されていません',
            'not_found_in_trash' => 'ゴミ箱に'. $name . 'はありません。',
            'search_items'       => $name . 'を検索',

        ];
        $args = [
            'labels'           => $labels,
            'public'           => true,
            'show_ui'          => true,
            'query_var'        => true,
            'hierarchical'     => false,
            'menu_position'    => 5,
            'supports'         => [
                'title',
                'editor',
                'thumbnail',
                'custom-fields',
                'revisions',
                'page-attributes',
                'author',
            ],
            'has_archive'      => true,
            'show_in_rest'     => true,
            'rest_base'        => $type,
            'rewrite'          => array('with_front' => false),

        ];

        if($override) {
            foreach($override as $key => $value) {
                $args[$key] = $value;
            }
        }

        register_post_type($type, $args);
    }

    /**
     * @param $taxonomyName
     * @param $label
     * @param $type array|string
     * @param $override array|null?
     */
    function registerCustomTaxonomy($taxonomyName, $label, $type = 'post', array $override = null) {

        $labels = [
            'name'               => $label,
            'singular_name'      => $label,
            'add_new_item'       => $label . 'を追加',
            'add_new'            => '新規追加',
            'new_item'           => '新しい' . $label,
            'edit_item'          => $label . 'の編集',
            'view_item'          => 'この' . $label . 'を表示',
            'not_found'          => $label . 'が登録されていません',
            'not_found_in_trash' => 'ゴミ箱に'. $label . 'はありません。',
            'search_items'       => $label . 'を検索',
            'parent_item'        => '親階層の' . $label,

        ];

        $args = [
            'hierarchical'          => true,
            'update_count_callback' => '_update_post_term_count',
            'labels'                => $labels,
            'singular_label'        => $label,
            'public'                => true,
            'show_ui'               => true,
            'show_in_rest'          => true,

        ];

        if($override) {
            foreach($override as $key => $value) {
                $args[$key] = $value;
            }
        }

        register_taxonomy($taxonomyName, $type, $args);
    }

    /**
     *
     */
    function rewriteCustomTaxonomies(){
//        add_rewrite_rule('area/([^/]+)/?$', 'index.php?custom_categories=$matches[1]', 'top');
    }