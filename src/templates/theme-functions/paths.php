<?php

    class ThemePaths {

        public static function getAssetDir() {
            echo get_template_directory() . '/assets';
        }

        public static function getAssetDirUri() {
            echo get_template_directory_uri() . '/assets';
        }

    }