<?php

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
            $arr[] = new CategoryClass($category);
        }

        return $arr;
    }
}

class CategoryClass {
    public int $id;
    public string $name;
    public string $slug;
    public string $description;
    public int $count;
    public int $parent;

    public function __construct(WP_Term $category)
    {
        $this->id = $category->term_taxonomy_id;
        $this->name = $category->name;
        $this->slug = urldecode($category->slug);
        $this->description =$category->description;
        $this->count = $category->count;
        $this->parent = $category->parent;
    }

    public function getShortName(): string
    {
        return mb_strimwidth( strip_tags( $this->name ), 0, 42, '…', 'UTF-8' );
    }
}
