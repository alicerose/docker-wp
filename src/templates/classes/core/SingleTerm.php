<?php

class SingleTermClass {
    /**
     * タームのID
     * @var int
     */
    public int $id;

    /**
     * ターム名称
     * @var string
     */
    public string $name;

    /**
     * タームスラッグ
     * @var string
     */
    public string $slug;

    /**
     * タームの概要文
     * @var string
     */
    public string $description;

    /**
     * このタームの累計使用記事数
     * @var int
     */
    public int $count;

    /**
     * 親タームのID
     * @var int
     */
    public int $parent_id;

    /**
     * 所属タクソノミー種別
     * @var string
     */
    public string $taxonomy;

    /**
     * 所属タクソノミーID
     * @var int
     */
    public int $taxonomy_id;

    public function __construct(WP_Term $term)
    {
        $this->id = $term->term_id;
        $this->name = $term->name;
        $this->slug = urldecode($term->slug);
        $this->description =$term->description;
        $this->count = $term->count;
        $this->parent_id = $term->parent;
        $this->taxonomy = $term->taxonomy;
        $this->taxonomy_id = $term->term_taxonomy_id;
    }

    /**
     * 省略名称を取得する
     * @return string
     */
    public function getShortName(): string
    {
        return mb_strimwidth( strip_tags( $this->name ), 0, 42, '…', 'UTF-8' );
    }
}
