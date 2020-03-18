<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Get all pages and display select dropdown.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_dropdown_list_tpl( $selected = 0, $args = array(), $type = 'link' ) {
    $content = '<select class="' . $args['class'] . '" ïd="' . $args['id'] . '" name="' . $args['name'] . '">';
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
function gdprcono_generate_select_html( $selected = 0, $args = array() ) {
    $content = '<select class="' . $args['class'] . '" ïd="' . $args['id'] . '" name="' . $args['name'] . '">';
        foreach ( $args['options'] as $option ) {
            $active_state = '';
            if( strtolower( $selected ) == strtolower( $option ) ) {
                $active_state = 'selected';
            }
            $content .= '<option ' . $active_state . ' value="' . strtolower( $option ) . '">';
                $content .= ucwords( $option );
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
    if( 'reject' == $_COOKIE['gdprconostatus'] ) {
        gdprcono_clearall_cookies();
    }

    //if( 'hold' == $_COOKIE['gdprconostatus'] ) {
        $serial_id = mt_rand(100000,999999);
        
        // Clean vars.
        $headline_text = get_option( 'gpdrcono_headline_text' );
        $accept_text = get_option( 'gpdrcono_accept_text' );
        $reject_text = get_option( 'gpdrcono_reject_text' );
        $readmore_text = get_option( 'gpdrcono_readmore_text' );

        echo '<div class="gdprcono-front__wrapper gdprcono-front__wrapper-top">
                <div class="gdprcono-front__inner">
                    <p class="gdprcono-front__headline-text">
                        ' . $headline_text . '
                        <a href="#gdprcono-modal__main" rel="modal:open" class="gdprcono-front__dialog">' . $readmore_text . '</a>
                    </p>

                    <div class="gdprcono-front__action-button">
                        <button id="gdprcono-accept-btn">' . $accept_text . '</button>
                        <button id="gdprcono-reject-btn">' . $reject_text . '</button>
                    </div>
                </div>
              </div>';

        // Privacy policy page.
        $gpdrcono_privacy_policy_tab_title = get_option( 'gpdrcono_privacy_policy_tab_title' );
        if( $gpdrcono_privacy_policy_tab_title && get_option( 'gpdrcono_privacy_policy_page_switch' ) == 'yes' ) {
            $tablist_1 = '<li data-tab-name="' . sanitize_title( $gpdrcono_privacy_policy_tab_title ) . $serial_id .'"><img src="' . plugins_url( 'assets/img/icons/lock-dark.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_privacy_policy_tab_title . '" /><img src="' . plugins_url( 'assets/img/icons/lock-white.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_privacy_policy_tab_title . '" />' . $gpdrcono_privacy_policy_tab_title . '</li>';

            $tablist_1_content = '<div class="gdprcono-tab__content" id="' . sanitize_title( $gpdrcono_privacy_policy_tab_title ) . $serial_id .'">
                                    <h3>' . $gpdrcono_privacy_policy_tab_title . '</h3>
                                    <div class="gdprcono-tab__content-inner">
                                        <article>' . get_option( 'gpdrcono_privacy_policy_page' ) . '</article>
                                    </div>
                                    <img src="' . plugins_url( 'assets/img/lock.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_privacy_policy_tab_title . '" />
                                  </div>';
        }

        // Cookie required settings.
        $gpdrcono_cookie_required_settings_tab_title = get_option( 'gpdrcono_cookie_required_settings_tab_title' );
        if( $gpdrcono_cookie_required_settings_tab_title && get_option( 'gpdrcono_cookie_required_settings_switch' ) == 'yes' ) {
            $tablist_2 = '<li data-tab-name="' . sanitize_title( $gpdrcono_cookie_required_settings_tab_title ) . $serial_id . '"><img src="' . plugins_url( 'assets/img/icons/check-dark.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_cookie_required_settings_tab_title . '" /><img src="' . plugins_url( 'assets/img/icons/check-white.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_cookie_required_settings_tab_title . '" />' . $gpdrcono_cookie_required_settings_tab_title . '</li>';

            $tablist_2_content = '<div class="gdprcono-tab__content" id="' . sanitize_title( $gpdrcono_cookie_required_settings_tab_title ) . $serial_id . '">
                                    <h3>' . $gpdrcono_cookie_required_settings_tab_title . '</h3>
                                    <div class="gdprcono-tab__content-inner">
                                        <article>' . do_shortcode( get_option( 'gpdrcono_cookie_required_settings_tab_content' ) ) . '<div class="switchcontent-box">' . get_option( 'gpdrcono_switch_content' ) . '</div></article>
                                    </div>
                                    <img src="' . plugins_url( 'assets/img/require-cookies.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_cookie_required_settings_tab_title . '" />
                                  </div>';
        }

        // Cookie information.
        $gpdrcono_cookie_information_tab_title = get_option( 'gpdrcono_cookie_information_tab_title' );
        if( $gpdrcono_cookie_information_tab_title && get_option( 'gpdrcono_cookie_information_switch' ) == 'yes' ) {
            $tablist_3 = '<li data-tab-name="' . sanitize_title( $gpdrcono_cookie_information_tab_title ) . $serial_id . '"><img src="' . plugins_url( 'assets/img/icons/cookie-dark.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_cookie_information_tab_title . '" /><img src="' . plugins_url( 'assets/img/icons/cookie-white.png', dirname( __FILE__ ) ) . '" alt="' . $gpdrcono_cookie_information_tab_title . '" />' . $gpdrcono_cookie_information_tab_title . '</li>';

            $tablist_3_content = '<div class="gdprcono-tab__content" id="' . sanitize_title( $gpdrcono_cookie_information_tab_title ) . $serial_id . '">
                                    <h3>' . $gpdrcono_cookie_information_tab_title . '</h3>
                                    <div class="gdprcono-tab__content-inner">
                                        <article>' . do_shortcode( get_option( 'gpdrcono_cookie_information_tab_content' ) ). '</article>
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
    //}
}