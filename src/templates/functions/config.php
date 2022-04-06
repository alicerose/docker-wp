<?php

/*-----------------------------------------------------------------------------------*/
/* フラグ管理 */
/*
/* 案件ごとに差異のありそうな設定はこちらにフラグを切り出す
/*-----------------------------------------------------------------------------------*/

/**
 * WPが出力するCanonical URLを削除するかどうか
 * 自前で実装する（自動出力を停止）場合はtrue
 */
const DISABLE_WP_CANONICAL = false;

/**
 * ログイン画面・管理画面側のファビコンのURLを変更する
 * trueの場合、テーマディレクトリ直下の favicon.icoをヘッダに出力する
 */
const MODIFY_ADMIN_FAVICON = false;

/**
 * コメント機能をサイト全体で停止するか
 */
const DISABLE_WP_COMMENT = true;

/**
 * Gitハッシュを表示する
 * フロントはMetaタグでバージョンを追記
 * 管理画面はページ下部のフッタ文言に追加表示
 */
const ENABLE_GIT_HASH_DISPLAY = true;

/**
 * ログイン画面のロゴクリック時の遷移先をサイトトップに差し替える
 */
const REPLACE_LOGIN_LOGO_PATH = true;
