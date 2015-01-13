// JavaScript Document
(function() {
    tinymce.PluginManager.add('b_insert_shortcode_editor', function(editor, url) {
		editor.addButton('b_insert_shortcode_editor', {
			text: '',
			tooltip: 'Insert Responsive Category Slider Shortcode',
			icon: 'icon-b-category-slider',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Insert Responsive Category Slider Shortcode',
					body: [
						{type: 'listbox', 
							name: 'cat_type',
							id: 'cat_type',
							label: 'Select Category Type:', 
							'values': [
								{text: 'Category', value: 'category'},
								{text: 'Taxonomy', value: 'taxonomy'},
								{text: 'Tags', value: 'tag'}
							]
						},
						{type: 'textbox', name: 'cat_id', label: 'Category ID or Slug:', id: "cat_id", multiline: true, minWidth: 300, minHeight: 60},
						{type: 'textbox', name: 'tag_lists', label: 'Tags lists:', id: "tag_lists", multiline: true, minWidth: 300, minHeight: 60},
						{type: 'textbox', name: 'custom_post', label: 'Custom Post Name:', id: "custom_post"},
						{type: 'textbox', name: 'tax_name', label: 'Taxonomy Name:', id: "tax_name"},
						{type: 'listbox', 
							name: 'style',
							id: 'style',
							label: 'Choose Style:', 
							'values': [
								{text: 'Post', value: 'post'},
								{text: 'Gallery', value: 'gallery'},
								{text: 'Events', value: 'events'},
								{text: 'Product', value: 'product'},
								{text: 'News', value: 'news'}
							]
						},
						{type: 'textbox', name: 'number_post', label: 'Numbers Posts in a page:', id: "number_post"},
						{type: 'listbox', 
							name: 'columns', 
							label: 'Choose Columns:', 
							'values': [
								{text: '3', value: '3'},
								{text: '1', value: '1'},
								{text: '2', value: '2'},
								{text: '4', value: '4'},
								{text: '6', value: '6'}
							]
						},
						{type: 'listbox', 
							name: 'menu_type', 
							label: 'Choose Menu Type:', 
							'values': [
								{text: 'Horizontal', value: 'horizontal'},
								{text: 'Vertical', value: 'vertical'},
								{text: 'Hide', value: 'hide'}
							]
						},
						{type: 'listbox', 
							name: 'b_orderby', 
							label: 'Orderby:', 
							'values': [
								{text: 'Post Date', value: 'date'},
								{text: 'Post View', value: 'view'}
							]
						},
						{type: 'listbox', 
							name: 'b_order', 
							label: 'Order:', 
							'values': [
								{text: 'desc', value: 'desc'},
								{text: 'asc', value: 'asc'}
							]
						},
						{type: 'listbox', 
							name: 'auto_slide', 
							label: 'Auto slide:', 
							'values': [
								{text: 'False', value: 'false'},
								{text: 'True', value: 'true'}
							]
						},
						{type: 'listbox', 
							name: 'control_nav', 
							label: 'Display Control Nav:', 
							'values': [
								{text: 'Show', value: 'on'},
								{text: 'Hide', value: 'off'}
							]
						},
						{type: 'listbox', 
							name: 'b_padding', 
							label: 'Show Padding:', 
							'values': [
								{text: 'Yes', value: 'yes'},
								{text: 'No', value: 'no'}
							]
						},
						{type: 'listbox', 
							name: 'b_show_parent', 
							label: 'Show Parent Menu:', 
							'values': [
								{text: 'Yes', value: 'yes'},
								{text: 'No', value: 'no'}
							]
						},
						{type: 'listbox', 
							name: 'image_ratio', 
							label: 'Image Ratio:', 
							'values': [
								{text: 'Horizontal Rectangle', value: 'horizontal_rectangle'},
								{text: 'Square', value: 'square'},
								{text: 'Vertical Rectangle', value: 'vertical_rectangle'},
								{text: 'Full Size', value: 'full_size'}
							]
						},
						{type: 'listbox', 
							name: 'linkable', 
							label: 'Linkable or not::', 
							'values': [
								{text: 'On', value: 'on'},
								{text: 'Off', value: 'off'}
							]
						},
					],
					onsubmit: function(e) {
						//var uID =  Math.floor((Math.random()*100)+1);
						// Insert content when the window form is submitted
						editor.insertContent('[res-cat-slider cat_type="'+e.data.cat_type+'" cat="'+e.data.cat_id+'" tax_name="'+e.data.tax_name+'"  custom_post="'+e.data.custom_post+'"  list_tags="'+e.data.tag_lists+'"  per_page="'+e.data.number_post+'"  columns="'+e.data.columns+'"  style="'+e.data.style+'"  pos_menu="'+e.data.menu_type+'" order_by="'+e.data.b_orderby+'" order="'+e.data.b_order+'" auto_slide="'+e.data.auto_slide+'" control_nav="'+e.data.control_nav+'" padding="'+e.data.b_padding+'" show_parent_menu="'+e.data.b_show_parent+'" image_ratio="'+e.data.image_ratio+'" linkable="'+e.data.linkable+'" /]<br class="nc"/>');
					}
				});
			}
		});
	});
})();
