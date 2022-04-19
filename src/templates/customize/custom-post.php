<?php

/**
 * 投稿タイプ登録関数の実行
 * @return void
 */
function register_custom_post_types () {
    foreach(CUSTOM_POST_TYPES as $post_type) {
        register_custom_post_type(
            $post_type['label'],
            $post_type['id'],
            $post_type['override'] ?? null
        );
    }
}

/**
 * 投稿タイプの登録
 * @param string $name
 * @param string $id
 * @param array|null $override
 * @return void
 */
function register_custom_post_type (string $name, string $id, array $override = null) {
    $labels = [
        'name'               => $name,
        'singular_name'      => $name,
        'menu_name'          => $name,
        'all_items'          => $name . '一覧',
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
        'rest_base'        => $id,
        'rewrite'          => ['with_front' => false],

    ];

    if($override) {
        foreach($override as $key => $value) {
            $args[$key] = $value;
        }
    }

    register_post_type($id, $args);
}
add_action('init', 'register_custom_post_types');

function register_custom_taxonomies () {
    foreach(CUSTOM_TAXONOMIES as $taxonomy) {
        register_custom_taxonomy(
            $taxonomy['label'],
            $taxonomy['id'],
            $taxonomy['relation'] ?? 'post',
            $taxonomy['is_tag'] ?? false,
            $taxonomy['override'] ?? null
        );
    }
}

/**
 * カスタムタクソノミーの登録
 * @param string $name
 * @param string $id
 * @param string $relation
 * @param bool $isTag
 * @param array|null $override
 * @return void
 */
function register_custom_taxonomy (string $name, string $id, string $relation, bool $isTag = false, array $override = null) {

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
        'parent_item'        => '親階層の' . $name,

    ];

    $args = [
        'hierarchical'          => !$isTag,
        'update_count_callback' => '_update_post_term_count',
        'labels'                => $labels,
        'singular_label'        => $name,
        'public'                => true,
        'show_ui'               => true,
        'show_in_rest'          => true,

    ];

    if($override) {
        foreach($override as $key => $value) {
            $args[$key] = $value;
        }
    }

    register_taxonomy($id, $relation, $args);
}
add_action( 'init', 'register_custom_taxonomies' );
