<?php

/**
 * 投稿者情報取得基底クラス
 */
class AuthorClass
{
    /**
     * ユーザID
     * @var int
     */
    public int $id;

    /**
     * ユーザ表示名
     * @var string
     */
    public string $name;

    /**
     * ユーザURL
     * @var string
     */
    public string $url;

    /**
     * ユーザメールアドレス
     * @var string
     */
    public string $email;

    /**
     * ユーザ紹介文
     * @var string
     */
    public string $profile;

    public function __construct(int $id)
    {
        $this->id = $id;

        $user = get_userdata($id);
        $this->name = $user->display_name;
        $this->url = $user->user_url;
        $this->email = $user->user_email;
        $this->profile = $user->description;
    }

}
