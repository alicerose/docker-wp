<?php

/*-----------------------------------------------------------------------------------*/
/* カスタム投稿タイプ・カスタムタクソノミー */
/*-----------------------------------------------------------------------------------*/

/**
 * カスタム投稿タイプの設定
 *
 * 必要数分だけ配列で渡す
 *
 * id 必須 投稿タイプ識別子（重複不可）
 * label 必須 投稿タイプ表示名
 * override 上書きパラメータ
 * 　投稿タイプのアイコンを変えるときなどは
 * 　menu_iconにアイコン名を渡す
 * 　（参照名は https://developer.wordpress.org/resource/dashicons/#welcome-widgets-menus から探す）
 *
 */
const CUSTOM_POST_TYPES = [
    [
        'id'       => 'sample',
        'label'    => 'サンプル',
        'override' => [
            'menu_icon' => 'dashicons-open-folder'
        ]
    ],
    [
        'id'       => 'example',
        'label'    => '例'
    ],
];

/**
 * カスタムタクソノミーの登録
 *
 * id 必須 タクソノミー識別子（重複不可）
 * label 必須 タクソノミー表示名
 * relation 関連付ける投稿タイプ（指定しないとpost = デフォルトの投稿になる）
 * is_tag タグ形式（＝タクソノミー間で階層を設けないようにする）かどうか
 * override 上書きパラメータ
 */
const CUSTOM_TAXONOMIES = [
    [
        'id'       => 'cat_test',
        'label'    => 'カテゴリー形式',
        'relation' => 'sample',
    ],
    [
        'id'       => 'tag_test',
        'label'    => 'タグ形式',
        'relation' => 'sample',
        'is_tag'   => true,
    ],
];

/*-----------------------------------------------------------------------------------*/
/* フロント・管理画面双方に影響のあるフラグ */
/*-----------------------------------------------------------------------------------*/

/**
 * 環境・Gitハッシュを表示する
 * フロントはMetaタグでGitハッシュをバージョンとして追記
 * 管理画面はページ下部のフッタ文言に追加表示
 * ローカル環境時はGitハッシュは表示しない
 */
const ENABLE_GIT_HASH_DISPLAY = true;

/*-----------------------------------------------------------------------------------*/
/* フロントに影響のあるフラグ */
/*-----------------------------------------------------------------------------------*/

/**
 * WPが出力するCanonical URLを削除するかどうか
 * 自前で実装する（自動出力を停止）場合はtrue
 */
const DISABLE_WP_CANONICAL = false;

/**
 * WP同梱のjQueryをロードするか
 */
const DISABLE_WP_JQUERY = true;

/**
 * WP制御で読み込むCSSファイル
 *
 * 拡張子前（*.css）を配列で記載する
 * ファイルは/assets/css/配下にあるのを前提
 * 読み込みは記載順
 */
const ASSET_FILES_STYLE = [
    'app',
];

/**
 * WP制御で読み込むCSSファイル
 *
 * 拡張子前（*.bundle.js）を配列で記載する
 * ファイルは/assets/js/配下にあるのを前提
 * 読み込みは記載順
 * 文字列でなく配列にし、第2引数にfalseを渡すとフッタでなくヘッダで読み込むようになる
 * 'app', => フッタ読み込み
 * ['app2', false], => ヘッダ読み込み（true渡すとフッタ読み込み）
 */
const ASSET_FILES_SCRIPT = [
    'app',
    'vendor'
];

/**
 * アセットファイルにタイムスタンプのパラメータを付与する
 *
 */
const ENABLE_ASSET_VERSIONING_TIMESTAMP = true;

/**
 * 検索対象をカスタム投稿タイプ・カスタムフィールドまで含めるように拡張する
 */
const EXPAND_SEARCH_RESULT = true;

/*-----------------------------------------------------------------------------------*/
/* 管理画面に影響のあるフラグ */
/*-----------------------------------------------------------------------------------*/

/**
 * アイキャッチ機能（サムネイル）を有効にする
 */
const ENABLE_EYE_CATCH_IMAGE = true;

/**
 * メニュー機能を有効にする
 * 配列を追加すると、位置を追加出来る
 */
const ENABLE_MENU = [
    [
        'id'    => 'global-menu',
        'label' => 'メインメニュー'
    ],
    [
        'id'    => 'sub-menu',
        'label' => 'サブメニュー'
    ],
];

/**
 * 登録可能な画像サイズを追加する
 */
const ADD_IMAGE_SIZES = [
    [
        'name'   => 'OGP',
        'width'  => 1200,
        'height' => 620,
        'crop'   => true,
    ]
];

/**
 * 管理画面左下の文言を差し替える
 * false: デフォルト
 * true:
 *   ENABLE_GIT_HASH_DISPLAY　がtrue : Git・環境表示
 *   ENABLE_GIT_HASH_DISPLAY　がfalse: REPLACED_BOTTOM_MESSAGE を表示
 *
 */
const REPLACE_BOTTOM_MESSAGE = true;

/**
 * 差し替えて表示する文言
 */
const REPLACED_BOTTOM_MESSAGE = 'メッセージを入れてください';

/**
 * ログイン画面・管理画面側のファビコンのURLを変更する
 * trueの場合、テーマディレクトリ直下の favicon.icoをヘッダに出力する
 */
const MODIFY_ADMIN_FAVICON = false;

/**
 * 管理画面からコメントメニューを非表示にするか
 * サイトにコメント欄がない場合はtrue推奨
 * ページ自体は無効化されないので、直接アクセスは出来る
 */
const DISABLE_WP_COMMENT = true;

/**
 * ログイン画面のロゴクリック時の遷移先をサイトトップに差し替える
 */
const REPLACE_LOGIN_LOGO_PATH = true;

/**
 * 管理画面へアクセスしやすいようにする自動リダイレクトを停止する
 * falseがWP標準、trueは明示的に管理画面ログインページのURLにアクセスする必要あり
 */
const DISABLE_ADMIN_REDIRECT = true;
