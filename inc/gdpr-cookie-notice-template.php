<?php

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

/**
 * Get all pages and display select dropdown.
 * 
 * @since 1.0.0
 * @package GDPR Cookie Notice & Compliance
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