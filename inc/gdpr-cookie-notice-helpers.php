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

            if( 'gdprstatus' == $name ) {
                continue;
            }

            setcookie( $name, '', $expiration_time );
            setcookie( $name, '', $expiration_time, $default_path );
        }
    }
}

/**
 * Cron jobs for purging expired data (activate).
 * 
 * @since 2.0.0
 */
function gdprcono_cronstarter_activation() {
    if( ! wp_next_scheduled( 'gdprcono_expired_sessions' ) ) {  
        wp_schedule_event( time(), 'daily', 'gdprcono_expired_sessions' );  
    }
}
add_action( 'wp', 'gdprcono_cronstarter_activation' );

/**
 * Cron jobs for purging expired data (deactivate).
 * 
 * @since 2.0.0
 */
function gdprcono_cronstarter_deactivate() {
    // find out when the last event was scheduled
    $timestamp = wp_next_scheduled( 'gdprcono_expired_sessions' );

    // unschedule previous event if any
    wp_unschedule_event( $timestamp, 'gdprcono_expired_sessions' );
}
register_deactivation_hook( __FILE__, 'gdprcono_cronstarter_deactivate' );

/**
 * Cron jobs for purging expired data (main purger).
 * 
 * @since 2.0.0
 */
function gdprcono_remove_expired_sessions() {
    global $wpdb;
    $gdprtable = $wpdb->prefix . 'gdpr_sessions';
    $timestamp_validity = time();
    $wpdb->get_row( "DELETE FROM $gdprtable WHERE ts < $timestamp_validity" );
}
add_action( 'gdprcono_expired_sessions', 'gdprcono_remove_expired_sessions' );