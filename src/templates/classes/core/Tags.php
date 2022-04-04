<?php

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
            $arr[] = new TagClass($tag);
        }
        return $arr;
    }
}

class TagClass {
    public int $id;
    public string $name;
    public string $slug;
    public string $description;
    public int $count;

    public function __construct(WP_Term $category)
    {
        $this->id = $category->term_taxonomy_id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description =$category->description;
        $this->count = $category->count;
    }
}
