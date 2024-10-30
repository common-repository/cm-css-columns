(function ($) {
  tinymce.PluginManager.add('cm_css_columns', function (editor, url) {
	var css_columns = new $.CssColumns(editor);
	// Add Menu Button to Visual Editor Toolbar
	editor.addButton('cm_css_columns', {
	  title: 'CSS3 Columns',
	  image: url + '/../assets/icon.png',
	  type: 'menubutton',
	  menu: [
		{
		  text: 'Insert [css_columns]',
		  onclick: function () {
			css_columns.openSettingsDialog('css_columns');
		  }
		},
		{
		  text: 'Insert [css_col_span]',
		  onclick: function () {
			css_columns.openSettingsDialog('css_col_span');
		  }
		},
		{
		  text: 'Insert [css_no_break]',
		  onclick: function () {
			css_columns.openSettingsDialog('css_no_break');
		  }
		}

	  ]
	});
  });

  $.CssColumns = function (editor) {
	var that = this;
	this.editor = editor;
	this.dialogs = new Array();
	this.dialogs['css_columns'] = _getNewDialog('css_columns');
	this.dialogs['css_col_span'] = _getNewDialog('css_col_span');
	this.dialogs['css_no_break'] = _getNewDialog('css_no_break');


	function _getNewDialog(shortcode) {
	  var tmp = $('<div id="' + shortcode + '_dialog"></div>');
	  tmp.append(_getDialogContent(shortcode));
	  var title = '[' + shortcode + '] attributes';
	  tmp.dialog({
		title: title,
		autoOpen: false,
		height: 400,
		width: 350,
		modal: true,
		dialogClass: shortcode + '_dialog',
		buttons: {
		  "Insert shortcode": function () {
			var options = _getDialogValues(shortcode);
			that.insertShortcode(shortcode, options);
			that.closeSettingsDialog(shortcode);
		  },
		  Cancel: function () {
			that.closeSettingsDialog(shortcode);
		  }
		},
		close: function () {
		  //console.log('dialog close cb for ' + shortcode);
		}
	  });
	  return tmp;
	}
	;

	function _getDialogContent(shortcode) {
	  if (shortcode === 'css_columns') {
		var tmp = $('<div class="inner"></div>');
		tmp.append($('<label for="count">Number of columns</label>'));
		tmp.append($('<input class="ui-corner-all" type="text" name="count" id="count" placeholder="' + $.CssColumns.defaultOptions.css_columns.count + '"/>'));
		tmp.append($('<label for="width">Optimal column width</label>'));
		tmp.append($('<input class="ui-corner-all" type="text" name="width" id="width" placeholder="' + $.CssColumns.defaultOptions.css_columns.width + '"/>'));
		tmp.append($('<label for="gap">Column gap</label>'));
		tmp.append($('<input class="ui-corner-all" type="text" name="gap" id="gap" placeholder="' + $.CssColumns.defaultOptions.css_columns.gap + '"/>'));
		tmp.append($('<label for="rule_color">Rule color</label>'));
		tmp.append($('<input class="ui-corner-all" type="color" name="rule_color" id="rule_color" placeholder="' + $.CssColumns.defaultOptions.css_columns.gap + '"/>'));
		var rule_section = $('<div class="rule_section"></div>');

		rule_section.append($('<label for="rule_style">Rule style</label>'));
		var rule_style = ($('<select name="rule_style" id="rule_style"></select>'));
		rule_style.append($('<option value="none">none</option>'));
		rule_style.append($('<option value="hidden">hidden</option>'));
		rule_style.append($('<option value="dotted">dotted</option>'));
		rule_style.append($('<option value="dashed">dashed</option>'));
		rule_style.append($('<option value="solid">solid</option>'));
		rule_style.append($('<option value="double">double</option>'));
		rule_style.append($('<option value="groove">groove</option>'));
		rule_style.append($('<option value="ridge">ridge</option>'));
		rule_style.append($('<option value="inset">inset</option>'));
		rule_style.append($('<option value="outset">outset</option>'));
		rule_style.append($('<option value="initial">initial</option>'));
		rule_style.append($('<option value="inherit">inherit</option>'));
		rule_section.append(rule_style);

		rule_section.append($('<label for="rule_width">Rule width</label>'));
		rule_section.append($('<input class="ui-corner-all" type="text" name="rule_width" id="rule_width" placeholder="' + $.CssColumns.defaultOptions.css_columns.rule_width + '"/>'));
		tmp.append(rule_section);
		return tmp;
	  } else if (shortcode === 'css_col_span') {
		var tmp = $('<div class="inner"></div>');
		tmp.append($('<label for="cols">Number of columns</label>'));
		tmp.append($('<input class="ui-corner-all" type="text" name="cols" id="cols" placeholder="' + $.CssColumns.defaultOptions.css_col_span.cols + '"/>'));
		tmp.append($('<label for="tag">HTML tag</label>'));
		tmp.append($('<input class="ui-corner-all" type="text" name="tag" id="tag" placeholder="' + $.CssColumns.defaultOptions.css_col_span.tag + '"/>'));
		return tmp;
	  } else if (shortcode === 'css_no_break') {
		var tmp = $('<div class="inner"></div>');
		tmp.append($('<label for="type">Type</label>'));
		var type = $('<select name="type" id="type"></select>');
		type.append($('<option selected disabled>'+$.CssColumns.defaultOptions.css_no_break.type+'</option>'));
		type.append($('<option value="auto">auto</option>'));
		type.append($('<option value="avoid">avoid</option>'));
		type.append($('<option value="initial">initial</option>'));
		type.append($('<option value="inherit">inherit</option>'));
		tmp.append(type);
		tmp.append($('<label for="tag">HTML tag</label>'));
		tmp.append($('<input class="ui-corner-all" type="text" name="tag" id="tag" placeholder="' + $.CssColumns.defaultOptions.css_no_break.tag + '"/>'));
		return tmp;
	  }
	}
	;

	function _getDialogValues(shortcode) {
	  var result = new Object();
	  if (shortcode === 'css_columns') {
		var dialog = that.dialogs['css_columns'];
		result.count = $('#count', dialog).val();
		result.width = $('#width', dialog).val();
		result.gap = $('#gap', dialog).val();
		result.rule_color = $('#rule_color', dialog).val();
		result.rule_style = $('#rule_style', dialog).val();
		result.rule_width = $('#rule_width', dialog).val();
	  } else if (shortcode === 'css_col_span') {
		var dialog = that.dialogs['css_col_span'];
		result.cols = $('#cols', dialog).val();
		result.tag = $('#tag', dialog).val();
	  } else if (shortcode === 'css_no_break') {
		var dialog = that.dialogs['css_no_break'];
		result.type = $('#type', dialog).val();
		result.tag = $('#tag', dialog).val();
	  }
	  return result;
	}
	;
  };

  $.CssColumns.prototype = {
	insertShortcode: function (shortcode, options) {
	  var orgText = this.editor.selection.getContent();
	  this.editor.undoManager.beforeChange();
	  var scode = '[' + shortcode;

	  if (shortcode === 'css_columns') {
		if (options.count !== '' && options.count !== $.CssColumns.defaultOptions.css_columns.count) {
		  scode += ' count=' + options.count;
		}
		if (options.width !== '' && options.width !== $.CssColumns.defaultOptions.css_columns.width) {
		  scode += ' width=' + options.width;
		}
		if (options.gap !== '' && options.gap !== $.CssColumns.defaultOptions.css_columns.gap) {
		  scode += ' gap=' + options.gap;
		}
		if (options.rule_color !== '' && options.rule_color !== $.CssColumns.defaultOptions.css_columns.rule_color) {
		  scode += ' rule_color=' + options.rule_color;
		}
		if (options.rule_style !== '' && options.rule_style !== $.CssColumns.defaultOptions.css_columns.rule_style) {
		  scode += ' rule_style=' + options.rule_style;
		}
		if (options.rule_width !== '' && options.rule_width !== $.CssColumns.defaultOptions.css_columns.rule_width) {
		  scode += ' rule_width=' + options.rule_width;
		}

	  } else if (shortcode === 'css_col_span') {
		if (options.cols !== '' && options.cols !== $.CssColumns.defaultOptions.css_col_span.cols) {
		  scode += ' cols=' + options.cols;
		}
		if (options.tag !== '' && options.tag !== $.CssColumns.defaultOptions.css_col_span.tag) {
		  scode += ' tag=' + options.tag;
		}
		
	  } else if (shortcode === 'css_no_break') {
		if (!$.isEmptyObject(options.type) && options.type !== '' && options.type !== $.CssColumns.defaultOptions.css_no_break.type) {
		  scode += ' type=' + options.type;
		}
		if (options.tag !== '' && options.tag !== $.CssColumns.defaultOptions.css_no_break.tag) {
		  scode += ' tag=' + options.tag;
		}
		
	  }
	  scode += ']';
	  scode += orgText;
	  scode += '[/' + shortcode + ']';
	  this.editor.selection.setContent(scode);
	},
	openSettingsDialog: function (shortcode) {
	  this.dialogs[shortcode].dialog("open");
	},
	closeSettingsDialog: function (shortcode) {
	  this.dialogs[shortcode].dialog("close");
	}
  };

  $.CssColumns.defaultOptions = {
	css_columns: {
	  gap: cm_css_columns_option_values["gap"],
	  width: cm_css_columns_option_values["width"],
	  count: cm_css_columns_option_values["count"],
	  rule_color: cm_css_columns_option_values["rule_color"],
	  rule_style: cm_css_columns_option_values["rule_style"],
	  rule_width: cm_css_columns_option_values["rule_width"]
	},
	css_col_span: {
	  cols: cm_css_columns_option_values["span_cols"],
	  tag: cm_css_columns_option_values["span_tag"]
	},
	css_no_break: {
	  type: cm_css_columns_option_values["no_break_type"],
	  tag: cm_css_columns_option_values["no_break_tag"]
	}
  };
})(jQuery);
