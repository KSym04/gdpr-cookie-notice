<?php
/**
 * Admin Page Settings
 *
 * @package GDPR Cookie Notice & Compliance
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly. ?>

<div class="gdprcono wrap">
    <h1 class="gdprcono__title"><?php esc_html_e( 'GDPR Cookie Notice & Compliance', 'gdprcono' ) ?></h1>
    
    <form method="post" action="options.php" spellcheck="false" autocomplete="off">
        <?php settings_fields( 'gdprcono_options_group' ); ?>
        <?php wp_nonce_field( 'gdprcono_action', 'gdprcono_admin_nonce' ); ?>
        
        <h3 class="gdprcono__titlesub"><?php esc_html_e( 'Notification Bar', 'gdprcono' ) ?></h3>
            <table>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_headline_text"><?php esc_html_e( 'Headline Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <textarea id="gpdrcono_headline_text" name="gpdrcono_headline_text"><?php echo get_option( 'gpdrcono_headline_text' ); ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_accept_text"><?php esc_html_e( 'Accept Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_accept_text" name="gpdrcono_accept_text" value="<?php echo get_option( 'gpdrcono_accept_text' ); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_reject_text"><?php esc_html_e( 'Reject Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_reject_text" name="gpdrcono_reject_text" value="<?php echo get_option( 'gpdrcono_reject_text' ); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_readmore_text"><?php esc_html_e( 'Read More Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_readmore_text" name="gpdrcono_readmore_text" value="<?php echo get_option( 'gpdrcono_readmore_text' ); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_readmore_link"><?php esc_html_e( 'Read More URL', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $selected_args = array( 
                                'id' => 'gpdrcono_readmore_link',
                                'name' => 'gpdrcono_readmore_link'
                            );

                            echo gdprcono_dropdown_list_tpl( get_option( 'gpdrcono_readmore_link' ), $selected_args ); ?>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_notice_bgcolor"><?php esc_html_e( 'Notice Background Color', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" class="gpdrcono-notice-bgcolor" id="gpdrcono_notice_bgcolor" name="gpdrcono_notice_bgcolor" value="<?php echo get_option( 'gpdrcono_notice_bgcolor' ); ?>" data-default-color="#333333" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_notice_txtcolor"><?php esc_html_e( 'Notice Text Color', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" class="gpdrcono-notice-txtcolor" id="gpdrcono_notice_txtcolor" name="gpdrcono_notice_txtcolor" value="<?php echo get_option( 'gpdrcono_notice_txtcolor' ); ?>" data-default-color="#ffffff" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_notice_txtcolor_hover"><?php esc_html_e( 'Notice Text Color - Hover', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" class="gpdrcono-notice-txtcolor" id="gpdrcono_notice_txtcolor_hover" name="gpdrcono_notice_txtcolor_hover" value="<?php echo get_option( 'gpdrcono_notice_txtcolor_hover' ); ?>" data-default-color="#ffffff" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_apply_wpautop"><?php esc_html_e( 'Apply wpautop', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_apply_wpautop_args = array( 
                                'class' => 'small',
                                'id' => 'gpdrcono_apply_wpautop',
                                'name' => 'gpdrcono_apply_wpautop',
                                'options' => array( 
                                    array(
                                        'key' => esc_html__( 'Yes', 'gdprcono' ),
                                        'value' => 'true'
                                    ),
                                    array(
                                        'key' => esc_html__( 'No', 'gdprcono' ),
                                        'value' => 'false'
                                    )
                                )
                            );

                            echo gdprcono_generate_select_html( get_option( 'gpdrcono_apply_wpautop' ), $gpdrcono_apply_wpautop_args ); ?>
                    </td>
                </tr>
            </table>
        <hr />

        <h3 class="gdprcono__titlesub"><?php esc_html_e( 'Privacy Policy (tab)', 'gdprcono' ) ?></h3>
            <table>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_privacy_policy_page_switch"><?php esc_html_e( 'Display', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_privacy_policy_page_switch_args = array( 
                                'class' => 'small',
                                'id' => 'gpdrcono_privacy_policy_page_switch',
                                'name' => 'gpdrcono_privacy_policy_page_switch',
                                'options' => array( 
                                    array(
                                        'key' => esc_html__( 'Yes', 'gdprcono' ),
                                        'value' => 'true'
                                    ),
                                    array(
                                        'key' => esc_html__( 'No', 'gdprcono' ),
                                        'value' => 'false'
                                    )
                                )
                            );

                            echo gdprcono_generate_select_html( get_option( 'gpdrcono_privacy_policy_page_switch' ), $gpdrcono_privacy_policy_page_switch_args ); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_privacy_policy_tab_title"><?php esc_html_e( 'Tab Title', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_privacy_policy_tab_title" name="gpdrcono_privacy_policy_tab_title" value="<?php echo get_option( 'gpdrcono_privacy_policy_tab_title' ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_privacy_policy_page"><?php esc_html_e( 'Privacy Policy Content', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_privacy_policy_page_args = array(
                                'wpautop' => true,
                                'media_buttons' => false,
                                'textarea_rows' => 20,
                                'tabindex' => '',
                                'tabfocus_elements' => ':prev,:next', 
                                'editor_css' => '', 
                                'editor_class' => '',
                                'teeny' => false,
                                'dfw' => false,
                                'tinymce' => true,
                                'quicktags' => true
                            );
                        
                            echo wp_editor( get_option( 'gpdrcono_privacy_policy_page' ), 'gpdrcono_privacy_policy_page', $gpdrcono_privacy_policy_page_args ); ?>
                    </td>
                </tr>
            </table>
        <hr />


        <h3 class="gdprcono__titlesub"><?php esc_html_e( 'Cookie Required Settings (tab)', 'gdprcono' ) ?></h3>
            <table>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_cookie_required_settings_switch"><?php esc_html_e( 'Display', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_cookie_required_settings_switch_args = array( 
                                'class' => 'small',
                                'id' => 'gpdrcono_cookie_required_settings_switch',
                                'name' => 'gpdrcono_cookie_required_settings_switch',
                                'options' => array( 
                                    array(
                                        'key' => esc_html__( 'Yes', 'gdprcono' ),
                                        'value' => 'true'
                                    ),
                                    array(
                                        'key' => esc_html__( 'No', 'gdprcono' ),
                                        'value' => 'false'
                                    )
                                )
                            );

                            echo gdprcono_generate_select_html( get_option( 'gpdrcono_cookie_required_settings_switch' ), $gpdrcono_cookie_required_settings_switch_args ); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_cookie_required_settings_tab_title"><?php esc_html_e( 'Tab Title', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_cookie_required_settings_tab_title" name="gpdrcono_cookie_required_settings_tab_title" value="<?php echo get_option( 'gpdrcono_cookie_required_settings_tab_title' ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_cookie_required_settings_tab_content"><?php esc_html_e( 'Content', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_cookie_required_settings_tab_content_args = array(
                                'wpautop' => true,
                                'media_buttons' => false,
                                'textarea_rows' => 20,
                                'tabindex' => '',
                                'tabfocus_elements' => ':prev,:next', 
                                'editor_css' => '', 
                                'editor_class' => '',
                                'teeny' => false,
                                'dfw' => false,
                                'tinymce' => true,
                                'quicktags' => true
                            );
                        
                            echo wp_editor( get_option( 'gpdrcono_cookie_required_settings_tab_content' ), 'gpdrcono_cookie_required_settings_tab_content', $gpdrcono_cookie_required_settings_tab_content_args ); ?>
                    </td>
                </tr>
            </table>
        <hr />

        <h3 class="gdprcono__titlesub"><?php esc_html_e( 'Cookie Information (tab)', 'gdprcono' ) ?></h3>
            <table>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_cookie_information_switch"><?php esc_html_e( 'Display', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_cookie_information_switch_args = array( 
                                'class' => 'small',
                                'id' => 'gpdrcono_cookie_information_switch',
                                'name' => 'gpdrcono_cookie_information_switch',
                                'options' => array( 
                                    array(
                                        'key' => esc_html__( 'Yes', 'gdprcono' ),
                                        'value' => 'true'
                                    ),
                                    array(
                                        'key' => esc_html__( 'No', 'gdprcono' ),
                                        'value' => 'false'
                                    )
                                )
                            );

                            echo gdprcono_generate_select_html( get_option( 'gpdrcono_cookie_information_switch' ), $gpdrcono_cookie_information_switch_args ); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_cookie_information_tab_title"><?php esc_html_e( 'Tab Title', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_cookie_information_tab_title" name="gpdrcono_cookie_information_tab_title" value="<?php echo get_option( 'gpdrcono_cookie_information_tab_title' ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_cookie_information_tab_content"><?php esc_html_e( 'Content', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_cookie_information_tab_content_args = array(
                                'wpautop' => true,
                                'media_buttons' => false,
                                'textarea_rows' => 20,
                                'tabindex' => '',
                                'tabfocus_elements' => ':prev,:next', 
                                'editor_css' => '', 
                                'editor_class' => '',
                                'teeny' => false,
                                'dfw' => false,
                                'tinymce' => true,
                                'quicktags' => true
                            );
                        
                            echo wp_editor( get_option( 'gpdrcono_cookie_information_tab_content' ), 'gpdrcono_cookie_information_tab_content', $gpdrcono_cookie_information_tab_content_args ); ?>
                    </td>
                </tr>
            </table>

        <hr />
        <h3 class="gdprcono__titlesub"><?php esc_html_e( 'Switch box (button)', 'gdprcono' ) ?></h3>
            <table>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_switch_activate_text"><?php esc_html_e( 'Activate Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_switch_activate_text" name="gpdrcono_switch_activate_text" value="<?php echo get_option( 'gpdrcono_switch_activate_text' ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_switch_deactivate_text"><?php esc_html_e( 'Deactivate Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_switch_deactivate_text" name="gpdrcono_switch_deactivate_text" value="<?php echo get_option( 'gpdrcono_switch_deactivate_text' ); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label class="label" for="gpdrcono_switch_content"><?php esc_html_e( 'Notice', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <?php 
                            $gpdrcono_switch_content_args = array(
                                'wpautop' => true,
                                'media_buttons' => false,
                                'textarea_rows' => 20,
                                'tabindex' => '',
                                'tabfocus_elements' => ':prev,:next', 
                                'editor_css' => '', 
                                'editor_class' => '',
                                'teeny' => false,
                                'dfw' => false,
                                'tinymce' => true,
                                'quicktags' => true
                            );
                        
                            echo wp_editor( get_option( 'gpdrcono_switch_content' ), 'gpdrcono_switch_content', $gpdrcono_switch_content_args ); ?>
                    </td>
                </tr>
            </table>
        <hr />

        <?php submit_button(); ?>
    </form>
</div>