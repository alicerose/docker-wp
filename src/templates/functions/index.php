<?php

include_once THEME_PATH . '/classes/core/SinglePost.php';

/**
 * 投稿IDから単一投稿または固定ページを取得する
 * @param int|null $id 指定しない場合、テンプレート側に渡されたグローバル変数から判別して取得する
 * @return SinglePostClass|null
 */
function getPostById(?int $id = null): SinglePostClass|null
{
    if(!$id) {
        global $post;
        $id = $post->ID;
    }
    $raw = get_post($id);

//    echo "<pre>";
//    var_dump($raw);
//    echo "</pre>";

    if(!$raw) {
        error_log("Post ID " . $id . " not found.");
        return null;
    }
    return new SinglePostClass($raw);
}
