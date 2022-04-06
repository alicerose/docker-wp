<?php

/*-----------------------------------------------------------------------------------*/
/* 管理画面関連のカスタマイズ */
/*-----------------------------------------------------------------------------------*/

/**
 * 管理画面用追加アセット
 * admin.js, admin.cssを追加で読み込む
 */
function add_admin_assets() {
    wp_enqueue_style ( 'custom-admin',  THEME_URI . '/assets/css/admin.css' );
    wp_enqueue_script( 'custom-admin',  THEME_URI . '/assets/js/admin.bundle.js' );
    wp_enqueue_script( 'custom-vendor', THEME_URI . '/assets/js/vendor.bundle.js' );
}
add_action( 'admin_enqueue_scripts', 'add_admin_assets' );

/**
 * 管理画面のファビコン設定
 * @return void
 */
function replace_admin_favicon() {
    if(MODIFY_ADMIN_FAVICON) {
        echo '<link rel="shortcut icon" type="image/x-icon" href="' . THEME_URI . '/favicon.ico" />';
    }
}
add_action( 'admin_head', 'replace_admin_favicon' );

/**
 * 管理画面の下部テキスト差し替え
 */
function replace_admin_footer_text() {
    $str = ENVIRONMENT . "環境";

    if(ENABLE_GIT_HASH_DISPLAY) {
      $hash = get_git_hash(8);
      if($hash) $str .= "({$hash})";
    }
    echo $str;
}
add_filter( 'admin_footer_text', 'replace_admin_footer_text' );

/**
 * ダッシュボード項目編集
 * コメントアウトしたものは表示「される」
 * @return void
 */
function remove_unnecessary_dashboard_box() {
//    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' ); //サイトヘルスステータス
//    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); //概要
//    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); //アクティビティ
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); //クイックドラフト
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); //WordPressニュース
    remove_action( 'welcome_panel', 'wp_welcome_panel' ); //ようこそ
}
add_action('wp_dashboard_setup', 'remove_unnecessary_dashboard_box' );

/**
 * 管理画面項目制御
 *
 * コメントアウトしたものは表示「される」
 * カスタム投稿タイプやロールに応じた制御があれば別途追記
 * @return void
 */
function remove_unnecessary_menus () {

    // コメントは使用しないケースが結構あるので別途制御
    if(DISABLE_WP_COMMENT) {
        remove_menu_page( 'edit-comments.php' );
    }

    // メイン項目一覧
//    remove_menu_page( 'index.php' ); // ダッシュボード.
//    remove_menu_page( 'edit.php' ); // 投稿.
//    remove_menu_page( 'upload.php' ); // メディア.
//    remove_menu_page( 'edit.php?post_type=page' ); // 固定.
//    remove_menu_page( 'themes.php' ); // 外観.
//    remove_menu_page( 'plugins.php' ); // プラグイン.
//    remove_menu_page( 'users.php' ); // ユーザー.
//    remove_menu_page( 'tools.php' ); // ツール.
//    remove_menu_page( 'options-general.php' ); // 設定.
//
    // サブメニュー項目一覧
//    remove_submenu_page( 'index.php', 'index.php' ); // ダッシュボード / ホーム.
//    remove_submenu_page( 'index.php', 'update-core.php' ); // ダッシュボード / 更新.
//
//    remove_submenu_page( 'edit.php', 'edit.php' ); // 投稿 / 投稿一覧.
//    remove_submenu_page( 'edit.php', 'post-new.php' ); // 投稿 / 新規追加.
//    remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // 投稿 / カテゴリー.
//    remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // 投稿 / タグ.
//
//    remove_submenu_page( 'upload.php', 'upload.php' ); // メディア / ライブラリ.
//    remove_submenu_page( 'upload.php', 'media-new.php' ); // メディア / 新規追加.
//
//    remove_submenu_page( 'edit.php?post_type=page', 'edit.php?post_type=page' ); // 固定 / 固定ページ一覧.
//    remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' ); // 固定 / 新規追加.
//
//    remove_submenu_page( 'themes.php', 'themes.php' ); // 外観 / テーマ.
//    remove_submenu_page( 'themes.php', 'customize.php?return=' . rawurlencode( $_SERVER['REQUEST_URI'] ) ); // 外観 / カスタマイズ.
//    remove_submenu_page( 'themes.php', 'nav-menus.php' ); // 外観 / メニュー.
//    remove_submenu_page( 'themes.php', 'widgets.php' ); // 外観 / ウィジェット.
//    remove_submenu_page( 'themes.php', 'theme-editor.php' ); // 外観 / テーマエディタ.
//
//    remove_submenu_page( 'plugins.php', 'plugins.php' ); // プラグイン / インストール済みプラグイン.
//    remove_submenu_page( 'plugins.php', 'plugin-install.php' ); // プラグイン / 新規追加.
//    remove_submenu_page( 'plugins.php', 'plugin-editor.php' ); // プラグイン / プラグインエディタ.
//
//    remove_submenu_page( 'users.php', 'users.php' ); // ユーザー / ユーザー一覧.
//    remove_submenu_page( 'users.php', 'user-new.php' ); // ユーザー / 新規追加.
//    remove_submenu_page( 'users.php', 'profile.php' ); // ユーザー / あなたのプロフィール.
//
//    remove_submenu_page( 'tools.php', 'tools.php' ); // ツール / 利用可能なツール.
//    remove_submenu_page( 'tools.php', 'import.php' ); // ツール / インポート.
//    remove_submenu_page( 'tools.php', 'export.php' ); // ツール / エクスポート.
//    remove_submenu_page( 'tools.php', 'site-health.php' ); // ツール / サイトヘルス.
//    remove_submenu_page( 'tools.php', 'export_personal_data' ); // ツール / 個人データのエクスポート.
//    remove_submenu_page( 'tools.php', 'remove_personal_data' ); // ツール / 個人データの消去.
//
//    remove_submenu_page( 'options-general.php', 'options-general.php' ); // 設定 / 一般.
//    remove_submenu_page( 'options-general.php', 'options-writing.php' ); // 設定 / 投稿設定.
//    remove_submenu_page( 'options-general.php', 'options-reading.php' ); // 設定 / 表示設定.
//    remove_submenu_page( 'options-general.php', 'options-discussion.php' ); // 設定 / ディスカッション.
//    remove_submenu_page( 'options-general.php', 'options-media.php' ); // 設定 / メディア.
//    remove_submenu_page( 'options-general.php', 'options-permalink.php' ); // 設定 / メディア.
//    remove_submenu_page( 'options-general.php', 'privacy.php' ); // 設定 / プライバシー.
}
add_action( 'admin_menu', 'remove_unnecessary_menus', 999 );
