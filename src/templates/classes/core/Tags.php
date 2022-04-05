<?php

include_once 'SingleTerm.php';

/**
 * タグ取得基底クラス
 */
class TagsClass {
    /**
     * @var string
     */
    private string $taxonomy;

    /**
     * @var array|int[]|string|string[]|WP_Error|WP_Term[]
     */
    private array $query;

    /**
     * @param string $taxonomy タクソノミー名
     * @param bool $empty 未使用のものを除外するか
     */
    public function __construct(string $taxonomy = 'post_tag', bool $empty = true)
    {
        $this->taxonomy = $taxonomy;
        $this->query = get_terms($this->taxonomy, [
            'hide_empty' => $empty
        ]);
    }

    public function list(): array
    {
        $arr = [];
        foreach($this->query as $tag) {
            $arr[] = new SingleTermClass($tag);
        }
        return $arr;
    }
}
