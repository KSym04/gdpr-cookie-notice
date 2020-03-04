<?php
/*
Plugin Name: GDPR Cookie Notice & Compliance
Plugin URI: https://www.eteam.dk/om-eteam/
Description: Simple utility plugin for GDPR compliance
Version: 1.0.0
Author: Eteam.dk
Author URI: https://www.eteam.dk/
Copyright: Eteam.dk
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: gdprcono
Domain Path: /lang
*/

/*
    Copyright Eteam.dk

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1335, USA
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

if( ! class_exists( 'gdpr_cookie_notice_compliance' ) ) :

class gdpr_cookie_notice_compliance {

	/*
	*  __construct
	*
	*  A dummy constructor to ensure GDPR Cookie Notice & Compliance is only initialized once
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	public function __construct() {
		// Do nothing here.
	}

	/*
	*  initialize
	*
	*  The real constructor to initialize GDPR Cookie Notice & Compliance
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*
	*  @param	N/A
	*  @return	N/A
	*/
	public function initialize() {
		// Variables.
		$this->settings = array(
			'name'		 => __( 'GDPR Cookie Notice & Compliance', 'gdprcono' ),
			'version'	 => '1.0.0',
			'menu_slug'	 => 'gdpr-cookie-notice-compliance',
			'permission' => 'manage_options',
			'basename'	 => plugin_basename( __FILE__ ),
			'path'		 => plugin_dir_path( __FILE__ ),
			'dir'		 => plugin_dir_url( __FILE__ )
		);

		// Actions.
        add_action( 'admin_init', array( $this, 'admin_page_options_register' ) );
		add_action( 'admin_menu', array( $this, 'admin_page_url' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_page_styles_scripts' ) );
	}

	/*
	*  admin_page_url
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_page_url() {
		add_options_page(
			esc_html__( 'GDPR Cookie Notice & Compliance / Settings', 'gdprcono' ),
			esc_html__( 'GDPR Cookie Notice & Compliance', 'gdprcono' ),
			$this->settings['permission'], // capability
			$this->settings['menu_slug'],  // menu slug
			array( $this, 'admin_settings_page')
		);

		add_filter( 'plugin_action_links_' . $this->settings['basename'], array( $this, 'admin_settings_url') );
    }
    
	/*
	*  admin_page_options_register
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_page_options_register() {
        add_option( 'gpdrcono_headline_text', esc_html__( 'This website uses cookies for statistics and settings. By clicking further on the site you accept the use of cookies.', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_headline_text' );

        add_option( 'gpdrcono_accept_text', esc_html__( 'OK', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_accept_text' );

        add_option( 'gpdrcono_reject_text', esc_html__( 'No, thanks', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_reject_text' );

        add_option( 'gpdrcono_readmore_text', esc_html__( 'Read More', 'gdprcono' ) );
        register_setting( 'gdprcono_options_group', 'gpdrcono_readmore_text' );
	}

	/*
	*  admin_settings_page
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_settings_page() {
		$this->admin_save_settings();
        include( $this->settings['path'] . 'admin/admin.php' );
    }
    
    /*
	*  admin_save_settings
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_save_settings() {
		// Check user capability.
		if( ! current_user_can( $this->settings['permission'] ) ) {
			return;
		}

		// Security token.
		if( ! ( isset( $_POST['_wpnonce'] ) && check_admin_referer( 'gdprcono_action', 'gdprcono_admin_nonce' ) ) ) {
			return;
        }

        // Update options.
        update_option( 'gpdrcono_headline_text', sanitize_text_field( $_POST['gpdrcono_headline_text'] ) );
        update_option( 'gpdrcono_accept_text', '' );
        update_option( 'gpdrcono_reject_text', sanitize_text_field( $_POST['gpdrcono_reject_text'] ) );
        update_option( 'gpdrcono_readmore_text', sanitize_text_field( $_POST['gpdrcono_readmore_text'] ) );
	}

	/*
	*  admin_settings_url
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_settings_url( $url ) {
		$settings_url  = menu_page_url( $this->settings['menu_slug'], false );
		$settings_link = "<a href='{$settings_url}'>" . esc_html__( 'Settings', 'gdprcono' ) . "</a>";
		array_unshift( $url, $settings_link );

		return $url;
	}

	/*
	*  admin_page_styles_scripts
	*
	*  @type	function
	*  @date	03/04/2020
	*  @since	1.0.0
	*/
	public function admin_page_styles_scripts() {
		// Style.
		wp_enqueue_style( 'gdprcono-admin-base', plugin_dir_url( __FILE__ ) . 'assets/css/admin-style.css', array(), $this->settings['version'] );

		// Script.
		wp_enqueue_script( 'gdprcono-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin-script.js', array( 'jquery' ), $this->settings['version'] );
	}
}

/*
*  gdpr_cookie_notice_compliance
*
*  The main function responsible for returning the one true gdpr_cookie_notice_compliance Instance to functions everywhere.
*  Use this function like you would a global variable, except without needing to declare the global.
*
*  Example: <?php $gdpr_cookie_notice_compliance = gdpr_cookie_notice_compliance(); ?>
*
*  @type	function
*  @date	03/04/2020
*  @since	1.0.0
*
*  @param	N/A
*  @return	(object)
*/

function gdpr_cookie_notice_compliance() {
	global $gdpr_cookie_notice_compliance;
	if( ! isset($gdpr_cookie_notice_compliance) ) {
		$gdpr_cookie_notice_compliance = new gdpr_cookie_notice_compliance();
		$gdpr_cookie_notice_compliance->initialize();
	}

	return $gdpr_cookie_notice_compliance;
}

// initialize.
gdpr_cookie_notice_compliance();


endif; // class_exists check.