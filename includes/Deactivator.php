<?php

namespace codemacher\CssColumns;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    CssColumns
 * @subpackage CssColumns/includes
 * @author     codemacher
 */
class Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		Shortcoder::get_instance()->unregister_shortcodes();
	}

}
