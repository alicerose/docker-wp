<?php

use JetBrains\PhpStorm\Pure;

include_once 'SingleTerm.php';

/**
 * カテゴリー取得基底クラス
 */
class CategoriesClass {
    /**
     * @var string
     */
    private string $taxonomy;

    /**
     * @var int[]|string|string[]|WP_Error|WP_Term[]
     */
    private string|array|WP_Error $query;

    /**
     * @var array
     */
    public array $terms;

    /**
     * @param string $taxonomy 対象タクソノミー名
     * @param bool $empty 紐付いている記事が1件もないタームを除外するかどうか
     */
    public function __construct(string $taxonomy = 'category', bool $empty = true)
    {
        $this->taxonomy = $taxonomy;
        $this->query = get_terms($this->taxonomy, [
            'hide_empty' => $empty,
            'orderby'    => 'id',
        ]);

        $this->terms = self::getTerms();
    }

    /**
     * @return array
     */
    private function getTerms(): array
    {
        $terms = [];
        foreach($this->query as $category) {
            $terms[] = new SingleTermClass($category);
        }

        return $terms;
    }
}
