<?php

include_once 'Pagination.php';
include_once 'SinglePost.php';
include_once 'Categories.php';
include_once 'Tags.php';

/**
 * 投稿取得基底クラス
 * カスタム投稿タイプの場合はこのクラスを継承する
 */
class DefaultPostsClass
{
    /**
     * 投稿タイプ定数
     */
    const post_type = "post";

    /**
     * カテゴリータクソノミー一覧定数
     *
     * 対象タクソノミーが複数存在する場合は配列で指定
     */
    const taxonomies = ['category'];

    /**
     * タグタクソノミー一覧
     *
     * 対象タクソノミーが複数存在する場合は配列で指定
     */
    const tag_taxonomies = ['post_tag'];

    /**
     * 現在ページ
     * @var int
     */
    public int $page;

    /**
     * 投稿タイプ
     * @var string
     */
    private string $post_type;

    /**
     * 1ページあたりの表示件数
     * @var false|mixed|void
     */
    private $per_page;

    /**
     * 投稿取得クエリの上書き要素
     * 取得の仕方を変えたい場合の取得方法
     * @var array
     */
    private array $query_args;

    /**
     * 未加工の投稿取得クエリ結果
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
     * WP_Postを加工したものが配列で入っているのでループで回す
     * @var array
     */
    public array $posts;

    /**
     * 公開カテゴリー一覧
     * WP_Termを加工したものが配列で入っているのでループで回す
     * キーはタクソノミー名
     * @var array
     */
    public array $categories;

    /**
     * 公開タグ一覧
     * WP_Termを加工したものが配列で入っているのでループで回す
     * キーはタクソノミー名
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
            $posts[] = new SinglePostClass($post, self::taxonomies, self::tag_taxonomies);
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
