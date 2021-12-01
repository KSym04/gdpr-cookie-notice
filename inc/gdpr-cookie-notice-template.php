<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Get all pages and display select dropdown.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_dropdown_list_tpl( $selected, $args = array(), $type = 'link' ) {
    $content = '<select name="' . $args['name'] . '">';
        $pages = get_pages();
        foreach ( $pages as $page ) {
            $active_state = '';
            if( $selected == get_page_link( $page->ID ) ) {
                $active_state = 'selected';
            }

            if( 'ID' == $type ) {
                $content .= '<option ' . $active_state . ' value="' . $page->ID . '">';
            } else {
                $content .= '<option ' . $active_state . ' value="' . get_page_link( $page->ID ) . '">';
            }
            
                $content .= $page->post_title;
            $content .= '</option>';
        }
    $content .= '</select>';
    return $content;
}

/**
 * Build select element HTML.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_generate_select_html( $selected, $args = array() ) {
    $content = '<select name="' . $args['name'] . '">';
        foreach ( $args['options'] as $option ) {
            $active_state = '';
            if( strtolower( $selected ) == strtolower( $option['value'] ) ) {
                $active_state = 'selected';
            }
            $content .= '<option ' . $active_state . ' value="' . $option['value'] . '">';
                $content .= $option['key'];
            $content .= '</option>';
        }
    $content .= '</select>';
    return $content;
}

/**
 * Initiate notification bar.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_display_notification_bar() {
    global $wpdb;
    $session_key = sanitize_key( $_COOKIE['gdprstatus'] );
    $gdprtable = $wpdb->prefix . 'gdpr_sessions';
    $metadata = $wpdb->get_row( "SELECT session_status FROM $gdprtable WHERE session_key = '$session_key' LIMIT 1" );
    $metadata_session_status = $metadata->session_status;

    if( empty( $metadata_session_status ) ) {
        $metadata_session_status = 'hold';
    }

    // For tabbing serial.
    $serial_id = mt_rand( 100000, 999999 );
    remove_filter( 'the_content', 'wpautop' );
        
    // Clean vars.
    $headline_text = get_option( 'gpdrcono_headline_text' );
    $accept_text = get_option( 'gpdrcono_accept_text' );
    $reject_text = get_option( 'gpdrcono_reject_text' );
    $readmore_text = get_option( 'gpdrcono_readmore_text' );

    $gpdrcono_privacy_policy_page = do_shortcode( get_option( 'gpdrcono_privacy_policy_page' ) );
    $gpdrcono_cookie_required_settings_tab_content = do_shortcode( get_option( 'gpdrcono_cookie_required_settings_tab_content' ) );
    $gpdrcono_cookie_information_tab_content = do_shortcode( get_option( 'gpdrcono_cookie_information_tab_content' ) );
    $gpdrcono_switch_content = wpautop( get_option( 'gpdrcono_switch_content' ) );

    if( 'true' == get_option( 'gpdrcono_apply_wpautop' ) ) {
        $gpdrcono_privacy_policy_page = wpautop( $gpdrcono_privacy_policy_page );
        $gpdrcono_cookie_required_settings_tab_content = wpautop( $gpdrcono_cookie_required_settings_tab_content );
        $gpdrcono_cookie_information_tab_content = wpautop( $gpdrcono_cookie_information_tab_content );
        $gpdrcono_switch_content = wpautop( $gpdrcono_switch_content );
    }

    echo '<div class="gdprcono-front__wrapper gdprcono-front__wrapper-top gpdr-' . $metadata_session_status . '">
            <div class="gdprcono-front__inner">
                <p class="gdprcono-front__headline-text">
                    ' . $headline_text . '
                    <a href="' . get_option( 'gpdrcono_readmore_link' ) . '">' . $readmore_text . '</a>
                </p>
                <div class="gdprcono-front__action-button">
                    <button id="gdprcono-accept-btn">' . $accept_text . '</button>
                    <a id="gdprcono-settings-btn" href="#gdprcono-modal__main" rel="modal:open" class="gdprcono-front__dialog">
                        ' . __( 'Cookie Settings', 'gdprcono' ) . '
                    </a>
                    <button id="gdprcono-reject-btn">' . $reject_text . '</button>
                </div>
            </div>
          </div>';

        // Privacy policy page.
        $gpdrcono_privacy_policy_tab_title = get_option( 'gpdrcono_privacy_policy_tab_title' );
        if( $gpdrcono_privacy_policy_tab_title && get_option( 'gpdrcono_privacy_policy_page_switch' ) == 'true' ) {
            $tablist_1 = '<li data-tab-name="' . sanitize_title( $gpdrcono_privacy_policy_tab_title ) . $serial_id .'"><img src="' . plugins_url( 'assets/img/icons/lock-dark.png', dirname( __FILE__ ) ) . '" title="' . $gpdrcono_privacy_policy_tab_title . '" alt="' . $gpdrcono_privacy_policy_tab_title . '" /><img src="' . plugins_url( 'assets/img/icons/lock-white.png', dirname( __FILE__ ) ) . '" title="' . $gpdrcono_privacy_policy_tab_title . '" alt="' . $gpdrcono_privacy_policy_tab_title . '" />' . $gpdrcono_privacy_policy_tab_title . '</li>';

            $tablist_1_content = '<div class="gdprcono-tab__content" id="' . sanitize_title( $gpdrcono_privacy_policy_tab_title ) . $serial_id .'">
                                    <h3>' . $gpdrcono_privacy_policy_tab_title . '</h3>
                                    <div class="gdprcono-tab__content-inner">
                                        <article>' . $gpdrcono_privacy_policy_page . '</article>
                                    </div>
                                    <img src="' . plugins_url( 'assets/img/lock.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_privacy_policy_tab_title . '" />
                                  </div>';
        }

        // Cookie required settings.
        $gpdrcono_cookie_required_settings_tab_title = get_option( 'gpdrcono_cookie_required_settings_tab_title' );
        if( $gpdrcono_cookie_required_settings_tab_title && get_option( 'gpdrcono_cookie_required_settings_switch' ) == 'true' ) {
            $tablist_2 = '<li data-tab-name="' . sanitize_title( $gpdrcono_cookie_required_settings_tab_title ) . $serial_id . '"><img src="' . plugins_url( 'assets/img/icons/check-dark.png', dirname( __FILE__ ) ) . '" title="' . $gpdrcono_cookie_required_settings_tab_title . '" alt="' . $gpdrcono_cookie_required_settings_tab_title . '" /><img src="' . plugins_url( 'assets/img/icons/check-white.png', dirname( __FILE__ ) ) . '" title="' . $gpdrcono_cookie_required_settings_tab_title . '" alt="' . $gpdrcono_cookie_required_settings_tab_title . '" />' . $gpdrcono_cookie_required_settings_tab_title . '</li>';

            $tablist_2_content = '<div class="gdprcono-tab__content" id="' . sanitize_title( $gpdrcono_cookie_required_settings_tab_title ) . $serial_id . '">
                                    <h3>' . $gpdrcono_cookie_required_settings_tab_title . '</h3>
                                    <div class="gdprcono-tab__content-inner">
                                        <article>' . $gpdrcono_cookie_required_settings_tab_content . '<div class="switchcontent-box">' . $gpdrcono_switch_content . '</div></article>
                                    </div>
                                    <img src="' . plugins_url( 'assets/img/require-cookies.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_cookie_required_settings_tab_title . '" />
                                  </div>';
        }

        // Cookie information.
        $gpdrcono_cookie_information_tab_title = get_option( 'gpdrcono_cookie_information_tab_title' );
        if( $gpdrcono_cookie_information_tab_title && get_option( 'gpdrcono_cookie_information_switch' ) == 'true' ) {
            $tablist_3 = '<li data-tab-name="' . sanitize_title( $gpdrcono_cookie_information_tab_title ) . $serial_id . '"><img src="' . plugins_url( 'assets/img/icons/cookie-dark.png', dirname( __FILE__ ) ) . '" title="' . $gpdrcono_cookie_information_tab_title . '" alt="' . $gpdrcono_cookie_information_tab_title . '" /><img src="' . plugins_url( 'assets/img/icons/cookie-white.png', dirname( __FILE__ ) ) . '" title="' . $gpdrcono_cookie_information_tab_title . '" alt="' . $gpdrcono_cookie_information_tab_title . '" />' . $gpdrcono_cookie_information_tab_title . '</li>';

            $tablist_3_content = '<div class="gdprcono-tab__content" id="' . sanitize_title( $gpdrcono_cookie_information_tab_title ) . $serial_id . '">
                                    <h3>' . $gpdrcono_cookie_information_tab_title . '</h3>
                                    <div class="gdprcono-tab__content-inner">
                                        <article>' . $gpdrcono_cookie_information_tab_content . '</article>
                                    </div>
                                    <img src="' . plugins_url( 'assets/img/cookie-information.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_cookie_information_tab_title . '" />
                                  </div>';
        }

        echo '<div id="gdprcono-modal__main" class="modal">
                <ul class="gdprcono-tab__list">
                    ' . $tablist_1 . '
                    ' . $tablist_2 . '
                    ' . $tablist_3 . '
                </ul>
                ' . $tablist_1_content . '
                ' . $tablist_2_content . '
                ' . $tablist_3_content . '
                
                <div class="gdprcono-tab__activate-all">
                    ' . do_shortcode( '[gdprcono_activate_all_button]' ) . '
                </div>
              </div>';
              
    if( 'reject' == $metadata->session_status ) {
        gdprcono_clearall_cookies();
    }
}