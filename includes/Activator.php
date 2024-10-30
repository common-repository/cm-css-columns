<?php

namespace codemacher\CssColumns;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CssColumns
 * @subpackage CssColumns/includes
 * @author     codemacher
 */
class Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		Shortcoder::get_instance()->register_shortcodes();
	}

}
