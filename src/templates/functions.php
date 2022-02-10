<?php

    //define('WP_DEBUG',true);
    //define('WP_THEMES_ROOT',get_template_directory_uri());

    if (!defined('DS')) {
        define('DS', DIRECTORY_SEPARATOR);
    }

    if (!empty($_SERVER['DOCUMENT_ROOT']) && !defined('WWW_ROOT')) {
        define('WWW_ROOT', $_SERVER['DOCUMENT_ROOT'] . DS);
    }

    /*-----------------------------------------------------------------------------------*/
    /* 定数呼び出し */
    /*-----------------------------------------------------------------------------------*/

    include_once('constants/index.php');

    /*-----------------------------------------------------------------------------------*/
    /* 基本設定 */
    /*-----------------------------------------------------------------------------------*/

    include_once('functions/core.php');

    /*-----------------------------------------------------------------------------------*/
    /* WP REST API関連 */
    /*-----------------------------------------------------------------------------------*/

    include_once('functions/rest.php');

    /*-----------------------------------------------------------------------------------*/
    /* ログイン画面拡張 */
    /*-----------------------------------------------------------------------------------*/

    include_once('functions/login.php');

    /*-----------------------------------------------------------------------------------*/
    /* 管理画面拡張 */
    /*-----------------------------------------------------------------------------------*/

    include_once('functions/admin.php');

    /*-----------------------------------------------------------------------------------*/
    /* テーマの拡張 */
    /*-----------------------------------------------------------------------------------*/

    include_once('functions/theme.php');

    /*-----------------------------------------------------------------------------------*/
    /* カスタム投稿タイプ */
    /*-----------------------------------------------------------------------------------*/

    include_once('functions/custom-post.php');

    /*-----------------------------------------------------------------------------------*/
    /* カスタムフィールド */
    /*-----------------------------------------------------------------------------------*/

    include_once('functions/custom-fields.php');

    /*-----------------------------------------------------------------------------------*/
    /* テーマテンプレート */
    /*-----------------------------------------------------------------------------------*/

    include_once('theme-functions/paths.php');