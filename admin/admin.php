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
    
    <h3 class="gdprcono__titlesub"><?php esc_html_e( 'Notification Bar', 'gdprcono' ) ?></h3>
    <form method="post" action="options.php" spellcheck="false" autocomplete="off">
        <?php settings_fields( 'gdprcono_options_group' ); ?>
        <?php wp_nonce_field( 'gdprcono_action', 'gdprcono_admin_nonce' ); ?>
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
            </table>
        <hr />
        <?php submit_button(); ?>
    </form>
</div>