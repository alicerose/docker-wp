<?php

class Pager
{
    /**
     * ページ番号
     * @var int
     */
    public int $p;

    /**
     * ラベル
     * @var string
     */
    public string $label;

    /**
     * クリック出来る状態かどうか
     * @var string
     */
    public string $status;

    /**
     * 現在ページかどうか
     * @var string
     */
    public string $current;

    /**
     * ページャのパスを返す
     * @var string
     */
    public string $path;

    public function __construct(int $p, $label, $enable = true, $current = false)
    {
        $this->p = $p;
        $this->label = (string) $label;
        $this->status = $enable ? '' : 'disabled'; // disabled属性はboolで切り分け出来ない
        $this->current = $current ? 'true' : 'false';
        $this->path = $this->path($p);
    }

    private function path($p): string
    {
        $path = '';
        if($p !== 1) $path .= $p . '/';

        // 絞り込みなどのクエリストリングを付与する場合は加工する
        if(isset($_GET['category'])) $path .= '?category=' . $_GET['category'];

        return $path;

    }
}
