<?php
/*
Plugin Name:	Oxygen Editor Links
Plugin URI:		https://wpdevdesign.com/custom-editor-links/
Description:	Provides a quick 1-click access to Frontend, Admin, Settings, Stylesheets and Selectors in Oxygen.
Version:		1.0.0
Author:			Sridhar Katakam
Author URI:		https://sridharkatakam.com
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt

This plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

This plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with This plugin. If not, see {URI to Plugin License}.
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'oxygen_before_toolbar_close', 'oel_add_links' );
/**
 * Outputs Oxygen's controls.
 */
function oel_add_links() {

	/* Load the admin bar class code ready for instantiation */
	require_once( ABSPATH . WPINC . '/class-wp-admin-bar.php' );
	$admin_bar_class = apply_filters( 'wp_admin_bar_class', 'WP_Admin_Bar' );
	if ( class_exists( $admin_bar_class ) ) {
		$admin_bar = new $admin_bar_class;
		wp_admin_bar_edit_menu($admin_bar);
		$admin_url = $admin_bar->get_node('edit')->href;
	} else {
		$admin_url = admin_url();
	} ?>

	<div class="oel-links">
		<a class="oel-link"
			ng-hide="iframeScope.ajaxVar.ctTemplate"
			ng-href="{{iframeScope.ajaxVar.frontendURL}}" target="_blank">
			<?php _e( 'Frontend', 'oxygen' );?>
		</a>
		<a class="oel-link"
			ng-show="iframeScope.ajaxVar.ctTemplate"
			ng-href="{{iframeScope.template.postData.frontendURL}}" target="_blank">
			<?php _e( 'Frontend', 'oxygen' );?>
		</a>
		<a class="oel-link"
			ng-href="<?php echo esc_url( $admin_url );?>" target="_blank">
			<?php _e( 'Admin', 'oxygen' );?>
		</a>
		<div ng-click="toggleSettingsPanel()"><?php _e( 'Settings', 'oxygen' );?></div>
		<div ng-click="switchTab('sidePanel','styleSheets');"><?php _e( 'Stylesheets', 'oxygen' );?></div>
		<div ng-click="switchTab('sidePanel','selectors');"><?php _e( 'Selectors', 'oxygen' );?></div>
	</div>

<?php }

add_action( 'oxygen_enqueue_ui_scripts', 'oel_enqueue_files' );
/**
 * Loads the plugin's CSS and JS files.
 */
function oel_enqueue_files() {

	wp_enqueue_style( 'oxygen-editor-links', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );

	wp_enqueue_script( 'oxygen-editor-links', plugin_dir_url( __FILE__ ) . 'assets/js/oel.js', array( 'jquery' ), '1.0.0', true );

}
