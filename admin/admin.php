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
            <table>
                <tr valign="top">
                    <th scope="row">
                        <label for="gpdrcono_headline_text"><?php esc_html_e( 'Headline Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <textarea id="gpdrcono_headline_text" name="gpdrcono_headline_text"><?php echo get_option( 'gpdrcono_headline_text' ); ?></textarea>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="gpdrcono_accept_text"><?php esc_html_e( 'Accept Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_accept_text" name="gpdrcono_accept_text" value="<?php echo get_option( 'gpdrcono_accept_text' ); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="gpdrcono_reject_text"><?php esc_html_e( 'Reject Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_reject_text" name="gpdrcono_reject_text" value="<?php echo get_option( 'gpdrcono_reject_text' ); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="gpdrcono_readmore_text"><?php esc_html_e( 'Read More Text', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_readmore_text" name="gpdrcono_readmore_text" value="<?php echo get_option( 'gpdrcono_readmore_text' ); ?>" />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">
                        <label for="gpdrcono_readmore_link"><?php esc_html_e( 'Read More URL', 'gdprcono' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="gpdrcono_readmore_link" name="gpdrcono_readmore_link" value="<?php echo get_option( 'gpdrcono_readmore_link' ); ?>" />
                    </td>
                </tr>
            </table>
        <hr />
        <?php submit_button(); ?>
    </form>
</div>