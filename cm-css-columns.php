<?php
namespace codemacher\CssColumns;
/**
 *
 * @link              https://codemacher.de
 * @since             1.0.0
 * @package           CssColumns
 *
 * @wordpress-plugin
 * Plugin Name:       CM CSS Columns
 * Plugin URI:        https://codemacher.de/wordpress/plugins/css_columns
 * Description:       Use column layouts without any layout builder! Wrap your content and display columns.
 * Version:           1.2.1
 * Author:            codemacher
 * Author URI:        https://codemacher.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cm-css-columns
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-css-columns-activator.php
 */
function activate_cm_css_columns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Activator.php';
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-css-columns-deactivator.php
 */
function deactivate_cm_css_columns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/Deactivator.php';
	Deactivator::deactivate();
}

register_activation_hook( __FILE__, '\codemacher\CssColumns\activate_cm_css_columns' );
register_deactivation_hook( __FILE__, '\codemacher\CssColumns\deactivate_cm_css_columns' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/CorePlugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cm_css_columns() {

	$plugin = new CorePlugin();
	$plugin->run();

}
run_cm_css_columns();