<?php

namespace codemacher\CssColumns;

use WP;

/*
 *   File: CssColumns_Shortcode.php
 *   Project: CSS Columns Wordpress Plugin 
 *
 *   Copyright(c) 2016 codemacher UG (haftungsbeschränkt) All Rights Reserved.
 *
 *   Created on : 05.08.2016, 17:44:46
 */

/**
 * Description of CssColumns_Shortcode
 *
 * @author Marcel Deutschel (marcel.deutschel@codemacher.de)
 */
class Shortcoder {

  private $default_values = NULL;

  public static function get_instance() {
	  static $instance = NULL;
	  if (!$instance) {
		  $instance = new Shortcoder();
	  }
	  return $instance;
  }
  /**
   * Public setter for the $default_values
   * 
   * @param array $default_values array of default values
   */
  function setDefault_values($default_values) {
    $this->default_values = $default_values;
  }

  /**
   * Method to register all shortcodes in Wordpress
   */
  public function register_shortcodes() {
    add_shortcode("css_columns", array($this, 'exec_css_columns'));
    add_shortcode("css_no_break", array($this, 'exec_css_no_break'));
    add_shortcode("css_col_span", array($this, 'exec_css_col_span'));
  }

  /**
   * Method to unregister all shortcodes in Wordpress
   */
  public function unregister_shortcodes() {
    remove_shortcode("css_columns");
    remove_shortcode("css_no_break");
    remove_shortcode("css_col_span");
  }

  /**
   * Callback to handle the execution of shortcode [css_columns]
   * 
   * @param array $atts the shortcode attributes
   * @param string $content the enclosed content
   * @return string the resulting string, after transforming the content with the shortcode
   */
  public function exec_css_columns($atts, $content = "") {
    $new_atts = wp_parse_args($atts);

    $style = "";
    if (array_key_exists('gap', $new_atts)) {
      $style .= '-moz-column-gap:' . $new_atts["gap"] . ' ;-webkit-column-gap:' . $new_atts["gap"] . '; column-gap:' . $new_atts["gap"] . '; ';
    }
    if (array_key_exists('count', $new_atts)) {
      $style .= '-moz-column-count:' . $new_atts["count"] . '; -webkit-column-count:' . $new_atts["count"] . '; column-count:' . $new_atts["count"] . '; ';
    }
    if (array_key_exists('width', $new_atts)) {
      $style .= '-moz-column-width:' . $new_atts["width"] . '; -webkit-column-width:' . $new_atts["width"] . '; column-width:' . $new_atts["width"] . '; ';
    }
    if (array_key_exists('rule_color', $new_atts)) {
      $style .= '-moz-column-rule-color:' . $new_atts["rule_color"] . '; -webkit-column-rule-color:' . $new_atts["rule_color"] . '; column-rule-color:' . $new_atts["rule_color"] . '; ';
    }
    if (array_key_exists('rule_style', $new_atts)) {
      $style .= '-moz-column-rule-style:' . $new_atts["rule_style"] . '; -webkit-column-rule-style:' . $new_atts["rule_style"] . '; column-rule-style:' . $new_atts["rule_style"] . '; ';
    }
    if (array_key_exists('rule_width', $new_atts)) {
      $style .= '-moz-column-rule-width:' . $new_atts["rule_width"] . '; -webkit-column-rule-width:' . $new_atts["rule_width"] . '; column-rule-width:' . $new_atts["rule_width"] . '; ';
    }
    $result = '<div class="css_columns" style="' . $style . '">' . do_shortcode($content) . '</div>';
    return $result;
  }

  /**
   * Callback to handle the execution of shortcode [css_no_break]
   * 
   * @param array $atts the shortcode attributes
   * @param string $content the enclosed content
   * @return string the resulting string, after transforming the content with the shortcode
   */
  public function exec_css_no_break($atts, $content = "") {
    $new_atts = wp_parse_args($atts);

    $style = "";
    if (array_key_exists('type', $new_atts)) {
      $style .= '-webkit-column-break-inside: ' . $new_atts["type"] . '; page-break-inside: ' . $new_atts["type"] . '; break-inside: ' . $new_atts["type"] . ';';
    }
    if (!array_key_exists('tag', $new_atts)) {
      $new_atts['tag'] = $this->default_values['no_break_tag'];
    }
    $result = '<' . $new_atts["tag"] . ' class="css_no_break" style="' . $style . '">' . do_shortcode($content) . '</' . $new_atts["tag"] . '>';
    return $result;
  }

  /**
   * Callback to handle the execution of shortcode [css_col_span]
   * 
   * @param array $atts the shortcode attributes
   * @param string $content the enclosed content
   * @return string the resulting string, after transforming the content with the shortcode
   */
  public function exec_css_col_span($atts, $content = "") {
    $new_atts = wp_parse_args($atts);

    $style = "";
    if (array_key_exists('cols', $new_atts)) {
      $style .= '-webkit-column-span: ' . $new_atts["cols"] . '; column-span: ' . $new_atts["cols"] . '; ';
    }
    if (!array_key_exists('tag', $new_atts)) {
      $new_atts['tag'] = $this->default_values['span_tag'];
    }
    $result = '<' . $new_atts["tag"] . ' class="css_col_span" style="' . $style . '">' . do_shortcode($content) . '</' . $new_atts["tag"] . '>';
    return $result;
  }

}
