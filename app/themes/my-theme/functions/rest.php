<?php

    /*-----------------------------------------------------------------------------------*/
    /* REST API関連のカスタマイズ */
    /*-----------------------------------------------------------------------------------*/

    /**
     * 不要なヘッダの削除
     */
    add_action( 'rest_api_init', 'removeUnnecessaryHeaders' );

    /**
     * REST APIでユーザ名が外部から取得出来てしまうのを阻止する
     */
    add_filter( 'rest_endpoints', 'disableEndPointUsers', 10, 1 );

    /**
     * ACFをREST APIで編集可能にする
     */
    add_filter( 'acf/rest_api/field_settings/edit_in_rest', '__return_true' );

    /*-----------------------------------------------------------------------------------*/
    /* 関数 */
    /*-----------------------------------------------------------------------------------*/

    /**
     *
     */
    function removeUnnecessaryHeaders() {
        remove_action('template_redirect','wp_shortlink_header', 11, 0);
        remove_action('template_redirect', 'rest_output_link_header', 11, 0);
    }

    /**
     * @param $endpoints
     * @return mixed
     */
    function disableEndPointUsers( $endpoints ) {
        if ( isset( $endpoints['/wp/v2/users'] ) ) {
            unset( $endpoints['/wp/v2/users'] );
        }
        if ( isset( $endpoints['/wp/v2/users/(?P[\d]+)'] ) ) {
            unset( $endpoints['/wp/v2/users/(?P[\d]+)'] );
        }
        return $endpoints;
    }