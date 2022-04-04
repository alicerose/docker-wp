<?php

/**
 * テーマディレクトリのURI
 */
define("THEME_URI", get_template_directory_uri());

/**
 * テーマディレクトリへのサーバパス
 */
define("THEME_PATH", get_template_directory());

/**
 * 環境判別
 */
define("ENVIRONMENT", getenv('WP_ENV') ?? $_SERVER['WP_ENV'] ?? 'local');
