<?php

include_once 'SingleTerm.php';

/**
 * カテゴリー取得基底クラス
 */
class CategoriesClass {
    /**
     * @var null|string
     */
    private mixed $taxonomy;

    /**
     * @var array|int[]|string|string[]|WP_Error|WP_Term[]
     */
    private array $raw;

    public function __construct($taxonomy = 'category')
    {
        $this->taxonomy = $taxonomy;
        $this->raw = get_terms($this->taxonomy);
    }

    public function list(): array
    {
        $arr = [];
        foreach($this->raw as $category) {
            $arr[] = new SingleTermClass($category);
        }

        return $arr;
    }
}
