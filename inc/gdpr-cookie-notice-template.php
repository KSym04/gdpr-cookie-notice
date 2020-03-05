<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Get all pages and display select dropdown.
 * 
 * @since 1.0.0
 * @package GDPR_Cookie_Notice_Compliance
 */
function gdprcono_dropdown_list_tpl( $selected = 0, $args = array() ) {
    $content = '<select ïd="' . $args['id'] . '" name="' . $args['name'] . '">';
        $pages = get_pages();
        foreach ( $pages as $page ) {
            $active_state = '';
            if( $selected == get_page_link( $page->ID ) ) {
                $active_state = 'selected';
            }
            $content .= '<option ' . $active_state . ' value="' . get_page_link( $page->ID ) . '">';
            $content .= $page->post_title;
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
    // Clean vars.
    $headline_text = get_option( 'gpdrcono_headline_text' );
    $accept_text = get_option( 'gpdrcono_accept_text' );
    $reject_text = get_option( 'gpdrcono_reject_text' );
    $readmore_text = get_option( 'gpdrcono_readmore_text' );
    $readmore_link = get_option( 'gpdrcono_readmore_link' );
    $notice_bgcolor = get_option( 'gpdrcono_notice_bgcolor' );
    $notice_txtcolor = get_option( 'gpdrcono_notice_txtcolor' );

    echo '<div class="gdprcono-front__wrapper gdprcono-front__wrapper-top">
            <div class="gdprcono-front__inner">
                
                <p class="gdprcono-front__headline-text">
                    ' . $headline_text . '
                    <a href="' . $readmore_link . '" class="gdprcono-front__dialog">' . $readmore_text . '</a>
                </p>

            </div>
          </div>';
}