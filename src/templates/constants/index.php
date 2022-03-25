<?php

    /**
     * 環境判別
     */
    define("ENVIRONMENT", getenv('WP_ENV') ?? $_SERVER['WP_ENV'] ?? 'local');
