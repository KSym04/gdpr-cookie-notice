<?php
/**
 * Uninstall Plugin
 *
 * @package Turn Off REST API
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

delete_option( 'gpdrcono_headline_text' );
delete_option( 'gpdrcono_accept_text' );
delete_option( 'gpdrcono_reject_text' );
delete_option( 'gpdrcono_readmore_text' );
delete_option( 'gpdrcono_readmore_link' );
delete_option( 'gpdrcono_notice_bgcolor' );
delete_option( 'gpdrcono_notice_txtcolor' );
delete_option( 'gpdrcono_notice_txtcolor_hover' );
delete_option( 'gpdrcono_privacy_policy_page_switch' );
delete_option( 'gpdrcono_privacy_policy_tab_title' );
delete_option( 'gpdrcono_privacy_policy_page' );
delete_option( 'gpdrcono_cookie_required_settings_switch' );
delete_option( 'gpdrcono_cookie_required_settings_tab_title' );
delete_option( 'gpdrcono_cookie_required_settings_tab_content' );
delete_option( 'gpdrcono_cookie_information_switch' );
delete_option( 'gpdrcono_cookie_information_tab_title' );
delete_option( 'gpdrcono_cookie_information_tab_content' );
delete_option( 'gpdrcono_switch_activate_text' );
delete_option( 'gpdrcono_switch_deactivate_text' );
delete_option( 'gpdrcono_switch_content' );
delete_option( 'gpdrcono_apply_wpautop' );

delete_site_option( 'gpdrcono_headline_text' );
delete_site_option( 'gpdrcono_accept_text' );
delete_site_option( 'gpdrcono_reject_text' );
delete_site_option( 'gpdrcono_readmore_text' );
delete_site_option( 'gpdrcono_readmore_link' );
delete_site_option( 'gpdrcono_notice_bgcolor' );
delete_site_option( 'gpdrcono_notice_txtcolor' );
delete_site_option( 'gpdrcono_notice_txtcolor_hover' );
delete_site_option( 'gpdrcono_privacy_policy_page_switch' );
delete_site_option( 'gpdrcono_privacy_policy_tab_title' );
delete_site_option( 'gpdrcono_privacy_policy_page' );
delete_site_option( 'gpdrcono_cookie_required_settings_switch' );
delete_site_option( 'gpdrcono_cookie_required_settings_tab_title' );
delete_site_option( 'gpdrcono_cookie_required_settings_tab_content' );
delete_site_option( 'gpdrcono_cookie_information_switch' );
delete_site_option( 'gpdrcono_cookie_information_tab_title' );
delete_site_option( 'gpdrcono_cookie_information_tab_content' );
delete_site_option( 'gpdrcono_switch_activate_text' );
delete_site_option( 'gpdrcono_switch_deactivate_text' );
delete_site_option( 'gpdrcono_switch_content' );
delete_site_option( 'gpdrcono_apply_wpautop' );