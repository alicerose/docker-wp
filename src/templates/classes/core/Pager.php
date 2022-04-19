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
        $this->status = $enable ? '' : 'data-disabled tabindex="-1"'; // disabled属性はboolで切り分け出来ない
        $this->current = $current ? 'data-current' : '';
        $this->path = $enable ? $this->path($p) : '#';
    }

    /**
     * ページャのパス生成
     * @param int $p
     * @return string
     */
    private function path(int $p): string
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $path = strpos($url, PAGER_PREFIX) ? strstr($url, PAGER_PREFIX, true) : $url;

        if($p !== 1) {
            $path .= mb_strlen(PAGER_PREFIX) ? PAGER_PREFIX . '/' . $p : $p;
            $path .= '/';
        }

        // 絞り込みなどのクエリストリングを付与する場合は加工する
        if(isset($_GET['category'])) $path .= '?category=' . $_GET['category'];

        return $path;

    }
}
