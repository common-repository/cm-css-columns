=== CM CSS Columns ===
Contributors: codemacher
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=C53QMVCECEQPA
Tags: css3, columns, shortcode
Requires at least: 4.5.0
Tested up to: 4.9.8
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A shortcode plugin to use the CSS3 Multiple Columns layout feature.

== Description ==

The plugin offers different shortcodes to use the [CSS3 Multiple Columns](http://www.w3schools.com/css/css3_multiple_columns.asp).
For better user experience it includes an integration into the visual editor. You can enter all attributes with the help of dialogs, so you don't need to write the shortcodes by hand.

The plugin simply wraps the enclosed content into a container and defines according CSS rules.
The attributes for the shortcodes and examples you can find under "Other Notes".

All default values can be changed in the settings page. With saving the settings a static CSS file is written and included for better performance.

== Installation ==

1. Extract and upload `cm-css-columns.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the shortcodes in the editor.

== Screenshots ==

1. settings page to define the default attribute values
2. marked content in Visual Editor and opening the shortcode menu
3. attribute dialog for inserting [css_columns] shortcode in Visual Editor
4. Visual Editor after inserting the shortcode with default values
5. Frontend rendering result

== Frequently Asked Questions ==

= Do I have to use shortcodes? =

No. You can also use the dialogs to insert the shortcode with visual editor.

== Changelog ==

= 1.2.1 =
* tested in last WordPress versions

= 1.2.0 = 
* Added: attributes dialog for [css_col_span]-shortcode
* Added: attributes dialog for [css_no_break]-shortcode

= 1.1.1 =
* Added: attributes dialog for [css_columns]-shortcode
* Fixed: generating and including the CSS file with default values

= 1.1.0 =
* Added: menu button in visual editor to wrap selected text with shortcodes

= 1.0.2 =
* Fixed: backend javascript error

= 1.0.1 =
* Fixed: activation/deactivation 

= 1.0 =
* initial release version

== Upgrade Notice ==

= 1.1.1 =
Important bugfix for undefined CSS Styles

= 1.0.2 =
Bugfix for the backend javascript errors.

== Shortcodes ==

Here is the list of shortcodes with the corresponding attributes:
= [css_columns] =

This is an enclosing shortcode to distribute content into a CSS3 multiple columns layout. As content you can use any complex markup. A div-Tag with CSS classes and default definitions is used to wrap the content. The default values for the attributes can be changed in the settings page of the plugin.

*Possible attributes:*

* **gap** - Specifies the gap between the columns, e.g. in pixel <code>40px</code>. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-gap.asp" target="_blank">column-gap on w3schools.com</a>
* **width** - Specifies a suggested, optimal width for the columns. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-width.asp" target="_blank">column-width on w3schools.com</a>
* **count** - Specifies the number of columns an element should be divided into. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-count.asp" target="_blank">column-count on w3schools.com</a>
* **rule_color** - Specifies the color of the rule between columns. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-rule-color.asp" target="_blank">column-rule-color on w3schools.com</a>
* **rule_style** - Specifies the style of the rule between columns. Description for the values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-rule-style.asp" target="_blank">column-rule-style on w3schools.com</a>
* **rule_width** - Specifies the width of the rule between columns. Possible values can be found on <a href="http://www.w3schools.com/cssref/css3_pr_column-rule-width.asp" target="_blank">column-rule-width on w3schools.com</a>

*Example:*

<code>[css_columns gap=30px width=120px count=3 rule_color="#000000" rule_style=solid rule_width=medium]
.... here goes the complex content ....
[/css_columns]</code>

= [css_col_span] =

This is an enclosing shortcode, which only can be used within the [css_columns] shortcode. You can define content, which spans over multiple columns.

*Possible attributes:*

* **cols** - Specifies how many columns an element should span across. Same values like <a href="http://www.w3schools.com/cssref/css3_pr_column-span.asp" target="_blank">column-span on w3schools.com</a>
* **tag** - Specifies the tag used for wrapping the spanning content, e.g. <code>span</code>, <code>h2</code>, <code>div</code>, ...

*Example:*

<code>[css_col_span cols=2 tag=div]
... here goes the spanning content ....
[/css_col_span]</code>

= [css_no_break] =

This is an enclosing shortcode, which only can be used within the [css_columns] shortcode. You can define content, which never breaks into different columns. **WARNING** Feature is not supported by Firefox yet!

*Possible attributes:*

* **type** - Specifies whether a page break is allowed inside a specified element. Same values like <a href="http://www.w3schools.com/cssref/pr_print_pagebi.asp" target="_blank">page-break-inside on w3schools.com</a>
* **tag** - Specifies the tag used for wrapping the non breaking content, e.g. <code>span</code>, <code>h2</code>, <code>div</code>, ...

*Example:*

<code>[css_no_break type=avoid tag=div]
... here goes the non-breakable complex content ....
[/css_no_break]
</code>
