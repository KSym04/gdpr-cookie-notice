<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Get full URL.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_get_fullurl() { 
    return ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

/**
 * Clear all cookies.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_clearall_cookies() { 
    if ( isset( $_SERVER['HTTP_COOKIE'] ) ) {
        $server_cookies = explode( ';', $_SERVER['HTTP_COOKIE'] );
        $expiration_time = time() - 31540000;
        $default_path = '/';
    
        foreach ( $server_cookies as $cookie ) {
            $all_parts = explode( '=', $cookie );
            $name = trim( $all_parts[0] );

            if( 'gdprconostatus' == $name ) {
                continue;
            }

            setcookie( $name, '', $expiration_time );
            setcookie( $name, '', $expiration_time, $default_path );
        }
    }
}