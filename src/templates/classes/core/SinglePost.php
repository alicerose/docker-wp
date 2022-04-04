<?php

/**
 * 投稿詳細基底クラス
 */
class SinglePostClass
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $date;

    /**
     * @var string
     */
    public string $slug;

    /**
     * @var string
     */
    public string $status;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $content;

    /**
     * @var false|string
     */
    public $thumbnail;


    public function __construct(WP_Post $post)
    {
        $this->id = $post->ID;
        $this->date = date('Y.m.d', strtotime($post->post_date));
        $this->slug = $post->post_name;
        $this->status = $post->post_status;
        $this->title = $post->post_title;
        $this->content = $post->post_content;
        $this->thumbnail = get_the_post_thumbnail_url($post->ID);
    }
}
