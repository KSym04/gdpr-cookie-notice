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

    // $content = "<div class=\"gdprcono-togglefy__wrapper\">
    //                 <div class=\"gdprcono-togglefy\">
    //                     <input type=\"checkbox\" class=\"check\" \>
    //                     <div class=\"b switch\"></div>
    //                     <div class=\"b track\"></div>
    //                 </div>
    //             </div>";

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
                    <button>" . esc_html__( 'All', 'gdprcono' ) . "</button>
                </div>";

	return $content;
}
add_shortcode( 'gdprcono_activate_all_button', 'gdprcono_activate_all_button_logic' );