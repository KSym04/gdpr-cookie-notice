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
    if( 'accept' == $permit ) {
        $message['status'] = true;
        $host = parse_url( gdprcono_get_fullurl(), PHP_URL_HOST ); 
        setcookie( "gdprconostatus", "accept", time() + 315360000, "/", $host );
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
    if( 'reject' == $permit ) {
        $message['status'] = true;
        $host = parse_url( gdprcono_get_fullurl(), PHP_URL_HOST ); 
        setcookie( "gdprconostatus", "reject", time() + 172800, "/", $host );
    }

    // Clear all cookies.
    gdprcono_clearall_cookies();

    echo json_encode( $message );
    unset( $_POST );
    exit();
}
add_action( 'wp_ajax_gdprcono_reject_cookie_handler', 'gdprcono_reject_cookie_handler' );
add_action( 'wp_ajax_nopriv_gdprcono_reject_cookie_handler', 'gdprcono_reject_cookie_handler' );