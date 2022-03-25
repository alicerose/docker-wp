<?php

    class ThemePaths {

        public static function getAssetDir() {
            echo THEME_PATH . '/assets';
        }

        public static function getAssetDirUri() {
            echo THEME_URI . '/assets';
        }

    }
