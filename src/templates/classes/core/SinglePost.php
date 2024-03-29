<?php

include_once 'SingleTerm.php';
include_once 'Author.php';

/**
 * 投稿詳細基底クラス
 */
class SinglePostClass
{
    /**
     * 投稿ID
     * @var int
     */
    public int $id;

    /**
     * 投稿日時
     * @var string
     */
    public string $date;

    /**
     * 投稿スラッグ
     * @var string
     */
    public string $slug;

    /**
     * 投稿ステータス
     * @var string
     */
    public string $status;

    /**
     * 投稿タイトル
     * @var string
     */
    public string $title;

    /**
     * 投稿コンテンツ
     * @var string
     */
    public string $content;

    /**
     * サムネイルURL
     * @var false|string
     */
    public string|false $thumbnail;

    /**
     * 付与カテゴリー一覧
     * @var array
     */
    public array $categories;

    /**
     * 付与タグ一覧
     * @var array
     */
    public array $tags;

    /**
     * パーマリンク
     * @var string|false|WP_Error
     */
    public string|false|WP_Error $url;

    /**
     * 記事作成者情報
     * @var AuthorClass
     */
    public AuthorClass $author;

    /**
     * @param WP_Post $post
     * @param array $categories
     * @param array $tags
     */
    public function __construct(WP_Post $post, array $categories = [], array $tags = [])
    {
        $this->id = $post->ID;
        $this->date = date('Y.m.d', strtotime($post->post_date));
        $this->slug = $post->post_name;
        $this->status = $post->post_status;
        $this->title = $post->post_title;
        $this->content = $post->post_content;
        $this->thumbnail = get_the_post_thumbnail_url($post->ID);
        $this->url = get_permalink($this->id);
        $this->author = new AuthorClass($post->post_author);

        $this->categories = $this->getTaxonomies($categories);
        $this->tags = $this->getTaxonomies($tags);
    }

    /**
     * 投稿のタクソノミー取得
     * @param $taxonomies
     * @return array
     */
    private function getTaxonomies($taxonomies): array
    {
        $arr = [];
        foreach($taxonomies as $taxonomy) {
            $terms = get_the_terms($this->id, $taxonomy);
            if(!$terms) return $arr;
            foreach($terms as $term) {
                $arr[] = new SingleTermClass($term);
            }
        }

        return $arr;
    }

    /**
     * 公開ステータスかどうか
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->status === 'publish';
    }

    /**
     * 固定ページかどうか
     * @return bool
     */
    public function isPage(): bool
    {
        return is_page();
    }
}
