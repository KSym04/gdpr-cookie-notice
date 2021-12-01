<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Accept cookie.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_accept_cookie_handler() { 
    $message = array();
    $message['status'] = false;

    $permit = sanitize_text_field( $_POST['permit'] );
    $session_key = $_COOKIE['gdprstatus'];
    if( 'accept' == $permit ) {
        $message['status'] = true;

        global $wpdb;
        $gdprtable = $wpdb->prefix . 'gdpr_sessions';
        $wpdb->update( 
            $gdprtable, 
            array( 
                'session_status' => 'accept'
            ), 
            array( 'session_key' => sanitize_key( $session_key ) ), 
            array( 
                '%s',
            ), 
            array( '%s' ) 
        );
    }
    
    echo json_encode( $message );
    unset( $_POST );
    exit();
}
add_action( 'wp_ajax_gdprcono_accept_cookie_handler', 'gdprcono_accept_cookie_handler' );
add_action( 'wp_ajax_nopriv_gdprcono_accept_cookie_handler', 'gdprcono_accept_cookie_handler' );

/**
 * Reject cookie.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_reject_cookie_handler() { 
    $message = array();
    $message['status'] = false;

    $permit = sanitize_text_field( $_POST['permit'] );
    $session_key = $_COOKIE['gdprstatus'];
    if( 'reject' == $permit ) {
        $message['status'] = true;

        global $wpdb;
        $gdprtable = $wpdb->prefix . 'gdpr_sessions';
        $wpdb->update( 
            $gdprtable, 
            array( 
                'session_status' => 'reject'
            ), 
            array( 'session_key' => sanitize_key( $session_key ) ), 
            array( 
                '%s',
            ), 
            array( '%s' ) 
        );
    }

    // Clear all cookies.
    gdprcono_clearall_cookies();

    echo json_encode( $message );
    unset( $_POST );
    exit();
}
add_action( 'wp_ajax_gdprcono_reject_cookie_handler', 'gdprcono_reject_cookie_handler' );
add_action( 'wp_ajax_nopriv_gdprcono_reject_cookie_handler', 'gdprcono_reject_cookie_handler' );