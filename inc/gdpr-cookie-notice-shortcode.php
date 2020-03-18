<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Switch box for allowing cookies.
 * 
 * @since 1.0.0
 */
function gdprcono_cookie_switch_box_logic( $atts ) {
    // vars
    $content = NULL;
    settype( $content, 'string' );

    $content = "<div class=\"gdprcono-togglefy\" id=\"gdprcono-switch\">
                    <div class=\"toggle-text-off\">" . get_option( 'gpdrcono_switch_deactivate_text' ) . "</div>
                    <div class=\"glow-comp\"></div>
                    <div class=\"toggle-button\"></div>
                    <div class=\"toggle-text-on\">" . get_option( 'gpdrcono_switch_activate_text' ) . "</div>
                </div>";

	return $content;
}
add_shortcode( 'gdprcono_cookie_switch_box', 'gdprcono_cookie_switch_box_logic' );

/**
 * Activate all on lightbox.
 * 
 * @since 1.0.0
 */
function gdprcono_activate_all_button_logic( $atts ) {
    // Variables.
    $content = NULL;
    settype( $content, 'string' );

    $content = "<div class=\"gdprcono-popactivate\">
                    <a href=\"#close-modal\" rel=\"modal:close\" class=\"activateall-btn\">" . esc_html__( 'Activate All', 'gdprcono' ) . "</a>
                    <a href=\"#close-modal\" rel=\"modal:close\" class=\"savesettings-btn\">" . esc_html__( 'Save Settings', 'gdprcono' ) . "</a>
                </div>";

	return $content;
}
add_shortcode( 'gdprcono_activate_all_button', 'gdprcono_activate_all_button_logic' );