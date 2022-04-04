<?php

include_once('Pagination.php');
include_once('SinglePost.php');
include_once('Categories.php');
include_once('Tags.php');

/**
 * 投稿取得基底クラス
 */
class PostsClass
{
    /**
     * 投稿タイプ
     */
    const post_type = "post";

    /**
     * カテゴリータクソノミー一覧
     * カスタムタクソノミーが複数存在する場合は
     */
    const taxonomies = ['category'];

    /**
     * タグタクソノミー一覧
     */
    const tag_taxonomies = ['post_tag'];

    /**
     * 現在ページ
     * @var int
     */
    public int $page;

    /**
     * @var false|mixed|void
     */
    private $per_page;

    /**
     * @var array
     */
    private array $query_args;

    /**
     * @var WP_Query
     */
    private WP_Query $query;

    /**
     * 総投稿数
     * @var int
     */
    public int $count;

    /**
     * 現在ページの投稿一覧
     * @var array
     */
    public array $posts;

    /**
     * 公開カテゴリー一覧
     * @var array
     */
    public array $categories;

    /**
     * 公開タグ一覧
     * @var array
     */
    public array $tags;

    /**
     * ページネーション
     * @var Pagination
     */
    public Pagination $pagination;

    public function __construct(int $page = 1, $per_page = null, $args_optional = [])
    {
        $this->page = $page;
        $this->post_type = static::post_type;
        $this->per_page = $per_page ?? get_option('posts_per_page');

        $args = [
            'post_type' => $this->post_type,
            'posts_per_page' => $this->per_page,
            'paged' => $this->page
        ];
        $this->query_args = $args_optional;
        if(count($this->query_args) > 0) {
            foreach($this->query_args as $key => $value) {
                $args[$key] = $value;
            }
        }
        $this->query = new WP_Query($args);

        $this->count = $this->query->found_posts;
        $this->posts = self::getPosts();
        $this->categories = self::getCategories();
        $this->tags = self::getTags();
        $this->pagination = new Pagination($this->count, $this->page, $this->per_page);
    }

    public function hasPost(): bool
    {
        return $this->count > 0;
    }

    private function getPosts(): array
    {
        $posts = [];
        foreach ($this->query->posts as $post) {
            $posts[] = new SinglePostClass($post);
        }
        return $posts;
    }

    private function getCategories(): array
    {
        $categories = [];
        foreach(static::taxonomies as $taxonomy) {
            $cat = new CategoriesClass($taxonomy, false);
            $categories[$taxonomy] = $cat->list();
        }
        return $categories;
    }

    private function getTags(): array
    {
        $tags = [];
        foreach(static::tag_taxonomies as $taxonomy) {
            $tag = new TagsClass($taxonomy);
            $tags[$taxonomy] = $tag->list();
        }

        return $tags;
    }

    /**
     * 1ページ以上あり、続きを見るリンクを有効化するか
     * @return bool
     */
    public function hasMore(): bool
    {
        return $this->count > $this->per_page;
    }

}
