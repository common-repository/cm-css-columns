<?php

namespace codemacher\CssColumns;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    CssColumns
 * @subpackage CssColumns/includes
 * @author     codemacher
 */
/**
 * The class responsible for orchestrating the actions and filters of the
 * core plugin.
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Loader.php';

/**
 * The class responsible for defining internationalization functionality
 * of the plugin.
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/i18n.php';

/**
 * The class responsible for defining all actions that occur in the admin area.
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'admin/Admin.php';

/**
 * The class responsible for defining all actions that occur in the public-facing
 * side of the site.
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'public/PluginPublic.php';

require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Shortcoder.php';

class CorePlugin {

  /**
   * The loader that's responsible for maintaining and registering all hooks that power
   * the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
   */
  protected $loader;

  /**
   * The unique identifier of this plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The current version of the plugin.
   *
   * @since    1.0.0
   * @access   protected
   * @var      string    $version    The current version of the plugin.
   */
  protected $version;
  protected $shortcoder;
  protected $plugin_admin;

  /**
   * Define the core functionality of the plugin.
   *
   * Set the plugin name and the plugin version that can be used throughout the plugin.
   * Load the dependencies, define the locale, and set the hooks for the admin area and
   * the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function __construct() {

    $this->plugin_name = 'cm-css-columns';
    $this->version = '1.2.1';

    $this->shortcoder = new Shortcoder();
    $this->plugin_admin = new Admin($this->get_plugin_name(), $this->get_version());
    $this->shortcoder->setDefault_values($this->plugin_admin->getDefault_values());

    $this->load_dependencies();
    $this->set_locale();
    $this->define_admin_hooks();
    $this->define_admin_filter();
    $this->define_public_hooks();
  }

  /**
   * Load the required dependencies for this plugin.
   *
   * Include the following files that make up the plugin:
   *
   * - CssColumns_Loader. Orchestrates the hooks of the plugin.
   * - CssColumns_i18n. Defines internationalization functionality.
   * - CssColumns_Admin. Defines all hooks for the admin area.
   * - CssColumns_Public. Defines all hooks for the public side of the site.
   *
   * Create an instance of the loader which will be used to register the hooks
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function load_dependencies() {


    $this->loader = new Loader($this->shortcoder);
  }

  /**
   * Define the locale for this plugin for internationalization.
   *
   * Uses the CssColumns_i18n class in order to set the domain and to register the hook
   * with WordPress.
   *
   * @since    1.0.0
   * @access   private
   */
  private function set_locale() {

    $plugin_i18n = new i18n();

    $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
  }

  /**
   * Register all of the hooks related to the admin area functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_admin_hooks() {

    $this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_styles');
    $this->loader->add_action('admin_enqueue_scripts', $this->plugin_admin, 'enqueue_scripts');
    $this->loader->add_action('admin_menu', $this->plugin_admin, 'menu');
    $this->loader->add_action('admin_init', $this->plugin_admin, 'init');
    $this->loader->add_action('update_option_' . $this->plugin_admin->getDefault_values_setting_name(), $this->plugin_admin, 'default_values_saved',10,2);
  }

  private function define_admin_filter() {

    $this->loader->add_filter('mce_external_plugins', $this->plugin_admin, 'enqueue_mce_plugin_scripts', 10, 1);
    $this->loader->add_filter('mce_buttons', $this->plugin_admin, 'register_mce_buttons', 10, 1);
  }

  /**
   * Register all of the hooks related to the public-facing functionality
   * of the plugin.
   *
   * @since    1.0.0
   * @access   private
   */
  private function define_public_hooks() {

    $plugin_public = new PluginPublic($this->get_plugin_name(), $this->get_version());

    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
  }

  /**
   * Run the loader to execute all of the hooks with WordPress.
   *
   * @since    1.0.0
   */
  public function run() {
    $this->loader->run();
  }

  /**
   * The name of the plugin used to uniquely identify it within the context of
   * WordPress and to define internationalization functionality.
   *
   * @since     1.0.0
   * @return    string    The name of the plugin.
   */
  public function get_plugin_name() {
    return $this->plugin_name;
  }

  /**
   * The reference to the class that orchestrates the hooks with the plugin.
   *
   * @since     1.0.0
   * @return    Loader    Orchestrates the hooks of the plugin.
   */
  public function get_loader() {
    return $this->loader;
  }

  /**
   * Retrieve the version number of the plugin.
   *
   * @since     1.0.0
   * @return    string    The version number of the plugin.
   */
  public function get_version() {
    return $this->version;
  }

}
