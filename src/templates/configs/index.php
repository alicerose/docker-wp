<?php

/**
 * ページ送り字のURL接頭辞
 *
 * 指定すると /hogehoge/page/1/ といったURLになる
 * WordPressデフォルト値はpage
 * 変更する場合はリダイレクトも必要
 */
const PAGER_PREFIX = 'page';

/**
 * ページャの現在ページ前後の設置リンク数
 */
const PAGER_GUTTER = 2;

/**
 * 前のページへ戻るボタンの表記
 */
const PAGER_PREV_DOM = '<';

/**
 * 次のページへ進むボタンの表記
 */
const PAGER_NEXT_DOM = '>';
