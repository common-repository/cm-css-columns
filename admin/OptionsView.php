<?php

namespace codemacher\CssColumns;

/**
 * Description of OptionsView
 *
 * @author codemacher
 */
class OptionsView {
	private $default_values_setting_name;
	private $plugin_name;
	private $default_values;
	//put your code here
	function __construct($plugin_name, $default_values_setting_name, $values) {
		$this->plugin_name = $plugin_name;
		$this->default_values_setting_name = $default_values_setting_name;
		$this->default_values = $values;
	}

	/**
	 * Method to render the options page for the plugin
	 */
	public function display_options_page() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?><br/><small><?php echo __('created by <a href="https://codemacher.de/">codemacher</a>',$this->plugin_name);?></small></h1>
      <?php settings_errors($this->default_values_setting_name); ?>
			<p><?php echo __('The plugin offers the following shortcodes: <code>[css_columns]</code>, <code>[css_col_span]</code>, <code>[css_no_break]</code>',$this->plugin_name); ?></p>
			<p><?php echo __('The following sections allow to <b>define the default attribute values for single shortcodes</b>. You can overwrite these values by adding the attribute to the shortcode and set its value in the editor. The possible values for an attribute correspond to the CSS3 values, so we simply reference to the corresponding w3school pages.',$this->plugin_name);?></p>
			<form method="post" action="options.php">
				<?php
        settings_fields($this->default_values_setting_name);
				do_settings_sections($this->plugin_name);
				submit_button();
				?>          
			</form>
		</div>
		<?php
	}

	/**
	 * Method to render the description for the [css_columns] section.
	 */
	public function css_columns_section_text() {
		echo __('This enclosing shortcode is used to define a multicolumn layout only using CSS3. For further reading you can visit <a href="http://www.w3schools.com/css/css3_multiple_columns.asp" target="_blank">CSS3 Multiple Columns on w3schools.com</a>.',$this->plugin_name);
	}

	/**
	 * Method to render the description for the [css_col_span] section.
	 */
	public function css_col_span_section_text() {
		echo __('This enclosing shortcode can only be used within <code>[css_columns]</code> to define content, which spans over multiple columns. <span style="color:red;"><b>WARNING:</b> not supported by Firefox yet!</span>',$this->plugin_name);
	}

	/**
	 * Method to render the description for the [css_no_break] section.
	 */
	public function css_no_break_section_text() {
		echo "";
	}

	/**
	 * Method to render the form fields for attribute 'gap' of [css_columns]
	 */
	public function display_css_columns_gap() {
		?>
		<input type="text" name="<?php echo $this->default_values_setting_name; ?>[gap]" id="css_columns_gap" value="<?php echo $this->default_values['gap']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[gap]"><?php echo __('Specifies the gap between the columns, e.g. in pixel <code>40px</code>. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-gap.asp" target="_blank">column-gap on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'width' of [css_columns]
	 */
	public function display_css_columns_width() {
		?>
		<input type="text" name="<?php echo $this->default_values_setting_name; ?>[width]" id="css_columns_width" value="<?php echo $this->default_values['width']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[width]"><?php echo __('Specifies a suggested, optimal width for the columns. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-width.asp" target="_blank">column-width on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'count' of [css_columns]
	 */
	public function display_css_columns_count() {
		?>
		<input type="number" name="<?php echo $this->default_values_setting_name; ?>[count]" id="css_columns_count" value="<?php echo $this->default_values['count']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[count]"><?php echo __('Specifies the number of columns an element should be divided into. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-count.asp" target="_blank">column-count on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'rule_color' of [css_columns]
	 */
	public function display_css_columns_rule_color() {
		?>
		<input type="color" name="<?php echo $this->default_values_setting_name; ?>[rule_color]" id="css_columns_rule_color" value="<?php echo $this->default_values['rule_color']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[rule_color]"><?php echo __('Specifies the color of the rule between columns. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-rule-color.asp" target="_blank">column-rule-color on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'rule_style' of [css_columns]
	 */
	public function display_css_columns_rule_style() {
		?>
		<select name="<?php echo $this->default_values_setting_name; ?>[rule_style]" id="css_columns_rule_style" >
			<?php $selected = $this->default_values['rule_style']; ?>
			<option value="none" <?php selected($selected, 'none'); ?>>none</option>
			<option value="hidden" <?php selected($selected, 'hidden'); ?>>hidden</option>
			<option value="dotted" <?php selected($selected, 'dotted'); ?>>dotted</option>
			<option value="dashed" <?php selected($selected, 'dashed'); ?>>dashed</option>
			<option value="solid" <?php selected($selected, 'solid'); ?>>solid</option>
			<option value="double" <?php selected($selected, 'double'); ?>>double</option>
			<option value="groove" <?php selected($selected, 'groove'); ?>>groove</option>
			<option value="ridge" <?php selected($selected, 'ridge'); ?>>ridge</option>
			<option value="inset" <?php selected($selected, 'inset'); ?>>inset</option>
			<option value="outset" <?php selected($selected, 'outset'); ?>>outset</option>
			<option value="initial" <?php selected($selected, 'initial'); ?>>initial</option>
			<option value="inherit" <?php selected($selected, 'inherit'); ?>>inherit</option>
		</select>
		<br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[rule_style]"><?php echo __('Specifies the style of the rule between columns. Description for the values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-rule-style.asp" target="_blank">column-rule-style on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'rule_width' of [css_columns]
	 */
	public function display_css_columns_rule_width() {
		?>
		<input type="text" name="<?php echo $this->default_values_setting_name; ?>[rule_width]" id="css_columns_rule_width" value="<?php echo $this->default_values['rule_width']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[rule_width]"><?php echo __('Specifies the width of the rule between columns. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-rule-width.asp" target="_blank">column-rule-width on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'cols' of [css_col_span]
	 */
	public function display_css_col_span_cols() {
		?>
		<input type="text" name="<?php echo $this->default_values_setting_name; ?>[span_cols]" id="css_col_span_cols" value="<?php echo $this->default_values['span_cols']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[span_cols]"><?php echo __('Specifies how many columns an element should span across. Same values like <a href="http://www.w3schools.com/cssref/css3_pr_column-span.asp" target="_blank">column-span on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'tag' of [css_col_span]
	 */
	public function display_css_col_span_tag() {
		?>
		<input type="text" name="<?php echo $this->default_values_setting_name; ?>[span_tag]" id="css_col_span_tag" value="<?php echo $this->default_values['span_tag']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[span_tag]"><?php echo __('Specifies the tag used for wrapping the spanning content, e.g. <code>span</code>, <code>h2</code>, <code>div</code>, ...',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'type' of [css_no_break]
	 */
	public function display_css_no_break_type() {
		?>
		<input type="text" name="<?php echo $this->default_values_setting_name; ?>[no_break_type]" id="css_no_break_type" value="<?php echo $this->default_values['no_break_type']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[no_break_type]"><?php echo __('Specifies whether a page break is allowed inside a specified element. Same values like <a href="http://www.w3schools.com/cssref/pr_print_pagebi.asp" target="_blank">page-break-inside on w3schools.com</a>',$this->plugin_name);?></label>
		<?php
	}

	/**
	 * Method to render the form fields for attribute 'tag' of [css_no_break]
	 */
	public function display_css_no_break_tag() {
		?>
		<input type="text" name="<?php echo $this->default_values_setting_name; ?>[no_break_tag]" id="css_no_break_tag" value="<?php echo $this->default_values['no_break_tag']; ?>" /><br/>
		<label class="description" for="<?php echo $this->default_values_setting_name; ?>[no_break_tag]"><?php echo __('Specifies the tag used for wrapping the non breaking content, e.g. <code>span</code>, <code>h2</code>, <code>div</code>, ...',$this->plugin_name);?></label>
		<?php
	}

}
