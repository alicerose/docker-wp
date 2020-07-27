<?php

//define('WP_DEBUG',true);
//define('WP_THEMES_ROOT',get_template_directory_uri());

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!empty($_SERVER['DOCUMENT_ROOT']) && !defined('WWW_ROOT')) {
    define('WWW_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS);
}
function wpinc($file) {
    include get_template_directory() . DS . $file;
}


/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/
/* カスタム投稿タイプ
============================================== */
function custom_entry_post_type() {
        $labels = array(
                'name' => 'カスタム投稿',
                'singular_name' => 'カスタム投稿',
                'add_new_item' => 'カスタム投稿を追加',
                'add_new' => '新規追加',
                'new_item' => '新しい記事',
                'view_item' => 'このカスタム投稿を表示',
                'not_found' => '記事がありません',
                'not_found_in_trash' => 'ゴミ箱にカスタム投稿の記事はありません。',
                'search_items' => '記事を検索',
        );
        $args = array(
                'labels' => $labels,
                'public' => true,
                'show_ui' => true,
                'query_var' => true,
                'hierarchical' => false,
                'menu_position' => 5,
                'supports' => array('title','editor','thumbnail',
      'custom-fields','excerpt','author','trackbacks',
      'comments','revisions','page-attributes'),
                'has_archive' => true
        );
        register_post_type('custom_entry', $args);
        register_taxonomy('custom_categories','custom_entry', array(
                'hierarchical' => true,
                'update_count_callback' => '_update_post_term_count',
                'label' => 'カテゴリー',
                'singular_label' => 'カテゴリー',
                'public'=> true,
                'show_ui' => true )
        );
}
add_action('init', 'custom_entry_post_type');


