<?php

namespace codemacher\CssColumns;

require_once plugin_dir_path(dirname(__FILE__)) . 'admin/OptionsView.php';

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CssColumns
 * @subpackage CssColumns/admin
 * @author     codemacher
 */
class Admin {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;
  private $default_values;
  private $default_values_setting_name;
  private $generic_frontend_css_filename;
  private $optionsView;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->default_values_setting_name = $this->plugin_name . "_defaults";
    $this->generic_frontend_css_filename = WP_PLUGIN_DIR . '/' . $this->plugin_name . '/public/css/defaults.css';
    $initial_defaults = array(
        'gap' => '30px',
        'width' => '150px',
        'count' => 2,
        'rule_color' => 'inital',
        'rule_style' => 'none',
        'rule_width' => 'medium',
        'span_cols' => 'all',
        'span_tag' => 'div',
        'no_break_type' => 'avoid',
        'no_break_tag' => 'div'
    );
    $this->default_values = wp_parse_args(get_option($this->default_values_setting_name, $initial_defaults), $initial_defaults);

    $this->optionsView = new OptionsView($this->plugin_name, $this->default_values_setting_name, $this->default_values);

    if (!$this->exists_frontend_css()) {
      $this->write_frontend_css($this->default_values);
    }
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {
    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/admin.css', array(), $this->version, 'all');
    wp_enqueue_style('jquery-ui', '//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css', array(), '1.11.4', 'all');
  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {
    wp_register_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery'), $this->version, false);
    wp_enqueue_script('jquery-ui-dialog');
    // transfer the default values to javascript using the localize method
    wp_localize_script($this->plugin_name, 'cm_css_columns_option_values', $this->default_values);
    wp_enqueue_script($this->plugin_name);
  }

  /**
   * 
   * @param array $plugin_array
   * @return array
   */
  public function enqueue_mce_plugin_scripts($plugin_array) {
    $plugin_array['cm_css_columns'] = plugin_dir_url(__FILE__) . 'js/tinymce-cm-css-columns.js';
    return $plugin_array;
  }

  public function register_mce_buttons($buttons) {
    array_push($buttons, 'separator', 'cm_css_columns');
    return $buttons;
  }

  function getDefault_values_setting_name() {
    return $this->default_values_setting_name;
  }

  /**
   * Getter for access to the default values for the shortcode attributes.
   * @return array
   */
  public function getDefault_values() {
    return $this->default_values;
  }

  /**
   * Initialize all the settings and field, used as hook callback
   */
  public function init() {
    //delete_option($this->default_values_setting_name);
    register_setting($this->default_values_setting_name, $this->default_values_setting_name);

    add_settings_section(
            'css_columns_section', __('<code>[css_columns]</code> attributes', $this->plugin_name), array($this->optionsView, 'css_columns_section_text'), $this->plugin_name
    );
    add_settings_section(
            'css_col_span_section', __('<code>[css_col_span]</code> attributes', $this->plugin_name), array($this->optionsView, 'css_col_span_section_text'), $this->plugin_name
    );
    add_settings_section(
            'css_no_break_section', __('<code>[css_no_break]</code> attributes', $this->plugin_name), array($this->optionsView, 'css_no_break_section_text'), $this->plugin_name
    );
    add_settings_field('gap', 'gap', array($this->optionsView, 'display_css_columns_gap'), $this->plugin_name, 'css_columns_section');
    add_settings_field('width', 'width', array($this->optionsView, 'display_css_columns_width'), $this->plugin_name, 'css_columns_section');
    add_settings_field('count', 'count', array($this->optionsView, 'display_css_columns_count'), $this->plugin_name, 'css_columns_section');
    add_settings_field('rule_color', 'rule_color', array($this->optionsView, 'display_css_columns_rule_color'), $this->plugin_name, 'css_columns_section');
    add_settings_field('rule_style', 'rule_style', array($this->optionsView, 'display_css_columns_rule_style'), $this->plugin_name, 'css_columns_section');
    add_settings_field('rule_width', 'rule_width', array($this->optionsView, 'display_css_columns_rule_width'), $this->plugin_name, 'css_columns_section');

    add_settings_field('span_cols', 'cols', array($this->optionsView, 'display_css_col_span_cols'), $this->plugin_name, 'css_col_span_section');
    add_settings_field('span_tag', 'tag', array($this->optionsView, 'display_css_col_span_tag'), $this->plugin_name, 'css_col_span_section');

    add_settings_field('no_break_type', 'type', array($this->optionsView, 'display_css_no_break_type'), $this->plugin_name, 'css_no_break_section');
    add_settings_field('no_break_tag', 'tag', array($this->optionsView, 'display_css_no_break_tag'), $this->plugin_name, 'css_no_break_section');
  }

  /**
   * Hook callback to define the menu item for the plugin settings page.
   */
  public function menu() {
    add_options_page(
            __('CSS Columns Settings', $this->plugin_name), 'CSS Columns', 'manage_options', $this->plugin_name, array($this->optionsView, 'display_options_page')
    );
  }

  /**
   * Hook callback to call writing the static css file with the new stored values.
   * 
   * @param string $option name of the options, which are saved
   * @param array $old_value the old values before save
   * @param array $new_value the new values, which will be saved in DB
   */
  public function default_values_saved($old_value, $new_value) {
    $this->write_frontend_css($new_value);
  }

  /**
   * Methods checks, if the static css file with the default values exists.
   * 
   * @return boolean TRUE, if the file exists, otherwise FALSE
   */
  protected function exists_frontend_css() {
    return file_exists($this->generic_frontend_css_filename);
  }

  /**
   * Method to write the parameter values into the static css file.
   * 
   * @param array $values array with the values to write into the static css file
   */
  protected function write_frontend_css($values) {
    $file = fopen($this->generic_frontend_css_filename, "w") or die("Unable to open file!");
    $css = '.css_columns {'
            . '-moz-column-gap:' . $values["gap"]
            . '; -webkit-column-gap:' . $values["gap"]
            . '; column-gap:' . $values["gap"]
            . '; -moz-column-count:' . $values["count"]
            . '; -webkit-column-count:' . $values["count"]
            . '; column-count:' . $values["count"]
            . '; -moz-column-width:' . $values["width"]
            . '; -webkit-column-width:' . $values["width"]
            . '; column-width:' . $values["width"]
            . '; -moz-column-rule-color:' . $values["rule_color"]
            . '; -webkit-column-rule-color:' . $values["rule_color"]
            . '; column-rule-color:' . $values["rule_color"]
            . '; -moz-column-rule-style:' . $values["rule_style"]
            . '; -webkit-column-rule-style:' . $values["rule_style"]
            . '; column-rule-style:' . $values["rule_style"]
            . '; -moz-column-rule-width:' . $values["rule_width"]
            . '; -webkit-column-rule-width:' . $values["rule_width"]
            . '; column-rule-width:' . $values["rule_width"]
            . '; margin-bottom:1.5em'
            . ';'
            . '}';
    $css .= '.css_columns p:empty {display:none;}';
    $css .= '.css_col_span {'
            . '-webkit-column-span: ' . $values["span_cols"]
            . '; column-span: ' . $values["span_cols"]
            . '; '
            . '}';
    $css .= '.css_no_break {'
            . '-webkit-column-break-inside: ' . $values["no_break_type"]
            . '; page-break-inside: ' . $values["no_break_type"]
            . '; break-inside: ' . $values["no_break_type"]
            . ';'
            . '}';
    fwrite($file, $css);
    fclose($file);
  }

}
