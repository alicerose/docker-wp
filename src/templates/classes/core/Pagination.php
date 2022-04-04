<?php

/**
 * ページネーション基底クラス
 */
class Pagination {

    /**
     * 全件数
     * @var int
     */
    private int $count;

    /**
     * 現在ページ
     * @var int
     */
    private int $current;

    /**
     * ページごとの件数
     * @var int
     */
    private int $per;

    /**
     * 総ページ数
     * @var false|float
     */
    private $total;

    /**
     * ページごとのクラス配列
     * @var array
     */
    public array $pages;

    function __construct($count, $current, $perPage) {
        $this->count = $count;
        $this->current = $current;
        $this->per = $perPage;
        $this->total = ceil($count / $perPage);
        $this->pages = $this->pages();
    }

    /**
     * ページャが必要かどうか（１ページ以上あるか）
     * @return bool
     */
    function hasPager(): bool
    {
        return $this->count > $this->per;
    }

    function pages(): array
    {
        $arr = [];

        /**
         * 前のページ
         */
        $arr[] = new Pager($this->current - 1, PAGER_PREV_DOM, $this->current - 1 > 0);

        /**
         * 現在ページより前のリスト
         */
        $i = 0;
        while ($i < PAGER_GUTTER) {

            $page = $this->current - PAGER_GUTTER + $i;

            // 対象が1未満ならbreak
            if($page < 1) {
                $i++;
                continue;
            }

            // ラベルはページ番号そのまま
            $arr[] = new Pager($page, $page);

            $i++;
        }

        /**
         * 現在ページ
         */
        $arr[] = new Pager($this->current, $this->current, true, true);

        /**
         * 現在ページよりあと
         */
        $i = 0;
        while ($i < PAGER_GUTTER + count($arr) - 1) {

            $page = $this->current + $i + 1;

            // 現在ページと前のページ分を含めて総数が規定数以上なら終了
            if(count($arr) >= PAGER_GUTTER * 2 + 2) {
                break;
            }

            // 追加予定が最終ページを超過してたら終了
            if($page > $this->total) {
                break;
            }

            // ラベルはページ番号そのまま
            $arr[] = new Pager($page, $page);

            $i++;
        }

        /**
         * 次のページ
         */
        $arr[] = new Pager($this->current + 1, PAGER_NEXT_DOM, $this->current + 1 <= $this->total);

        if(count($arr) >= PAGER_GUTTER * 2 + 3) return $arr;

        /**
         * 現在ページより前のページャが足りなかったら補填する
         */
        $i = 1;
        while($i < PAGER_GUTTER * 2) {
            // ページャ数が足りていれば終了
            if(count($arr) >= PAGER_GUTTER * 2 + 3) break;

            $p = $arr[1]->p - 1;

            // 補填対象ページが1未満なら終了
            if($p < 1) break;

            array_splice($arr, 1, 0, [new Pager($p, $p)]);

            $i++;
        }

        return $arr;
    }
}

class Pager {

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
        if(isset($_GET['category'])) $path .= '?category=' . $_GET['category'];
        return $path;

    }
}
