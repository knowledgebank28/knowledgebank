// JavaScript Document
(function() {
    // Creates a new plugin class and a custom listbox
    tinymce.create('tinymce.plugins.b_insert_shortcode_editor', {
        createControl: function(n, cm) {
            switch (n) {                
                case 'b_insert_shortcode_editor':
                var c = cm.createSplitButton('b_insert_shortcode_editor', {
                    title : 'Insert Responsive Category Slider Shortcode',
                    onclick : function() {
                    }
                });

                c.onRenderMenu.add(function(c, m) {
                    m.onShowMenu.add(function(c,m){
                        jQuery('#menu_'+c.id).height('auto').width('auto');
                        jQuery('#menu_'+c.id+'_co').height('auto').addClass('mceListBoxMenu'); 
                        var $menu = jQuery('#menu_'+c.id+'_co').find('tbody:first');
                        if($menu.data('added')) return;
                        $menu.append('');
                        $menu.append('<tr><td><div id="b-insert-shortcode" style="padding:10px 10px 10px">\
                        <label id="cat_type">Select Categories Type:<br />\
						<select name="cat_type" onchange="category_type_change()">\
							<option value="category">Category</option>\
							<option value="taxonomy">Taxonomy</option>\
							<option value="tag">Tags</option>\
						</select></label>\
						<label class="insert_lable_options" id="cat_id">Category ID or Slug:<br />\
						<input type="text" name="cat_id" value="" /></label>\
						<label class="insert_lable_options" id="tag_lists">Tags list:<br />\
						<i style="font-size:10px;">Ex: tag-one, tag-two, tag-three</i><br />\
						<i style="font-size:10px;">Note: To display all tags, leave the below box blank</i><br />\
						<textarea type="text" name="tag_lists" value=""></textarea></label>\
						<label class="insert_lable_options" id="custom_post">Custom Post Name:<br />\
						<input type="text" name="custom_post" value="" /></label>\
						<label class="insert_lable_options" id="tax_name">Taxonomy Name:<br />\
						<input type="text" name="tax_name" value="" /></label>\
						<label class="insert_lable_options" id="tax_id">Single or List Taxonomy ID/Slug:<br />\
						<textarea type="text" name="tax_id" value=""></textarea></label>\
						<label id="style">Choose Style:<br />\
						<select name="style">\
							<option value="post">Post</option>\
							<option value="gallery">Gallery</option>\
							<option value="events">Events</option>\
							<option value="product">Product</option>\
							<option value="news">News</option>\
						</select></label>\
						<label>Numbers Posts in a page:<br />\
                        <input type="text" name="number_post" value="" /></label>\
						<label>Choose Columns:<br />\
						<select name="columns">\
							<option value="1">1</option>\
							<option value="2">2</option>\
							<option value="3" selected>3</option>\
							<option value="4">4</option>\
							<option value="6">6</option>\
						</select></label>\
						<label>Choose Menu Type:<br />\
						<select name="menu_type">\
							<option value="horizontal">Horizontal</option>\
							<option value="vertical">Vertical</option>\
							<option value="hide">Hide</option>\
						</select></label>\
						<label>Orderby:<br />\
						<select name="b_orderby">\
							<option value="date">Post Date</option>\
							<option value="view">Post View</option>\
						</select></label>\
						<label>Order:<br />\
						<select name="b_order">\
							<option value="desc">desc</option>\
							<option value="asc">asc</option>\
						</select></label>\
						<label>Auto slide:<br />\
						<select name="auto_slide">\
							<option value="false">False</option>\
							<option value="true">True</option>\
						</select></label>\
						<label>Display Control Nav:<br />\
						<select name="control_nav">\
							<option value="on">Show</option>\
							<option value="off">Hide</option>\
						</select></label>\
						<label>Show Padding:<br />\
						<select name="b_padding">\
							<option value="yes">Yes</option>\
							<option value="no">No</option>\
						</select></label>\
						<label>Show Parent Menu:<br />\
						<select name="b_show_parent">\
							<option value="yes">Yes</option>\
							<option value="no">No</option>\
						</select></label>\
						<label>Image Ratio:<br />\
						<select name="image_ratio">\
							<option value="horizontal_rectangle">Horizontal Rectangle</option>\
							<option value="square">Square</option>\
							<option value="vertical_rectangle">Vertical Rectangle</option>\
							<option value="full_size">Full Size</option>\
						</select></label>\
						<label>Linkable or not:<br />\
						<select name="linkable">\
							<option value="on">On</option>\
							<option value="off">Off</option>\
						</select></label>\
                        </div></td></tr>');
                        jQuery('<input type="button" class="button" value="Insert" />').appendTo($menu)
                                .click(function(){
                       
                                var cat_type = $menu.find('select[name=cat_type]').val();								
								var style = $menu.find('select[name=style]').val();
								var number_post = $menu.find('input[name=number_post]').val();
								var columns = $menu.find('select[name=columns]').val();
								var menu_type = $menu.find('select[name=menu_type]').val();
								var cat_id = ($menu.find('input[name=cat_id]').val()) ? 'cat="'+$menu.find('input[name=cat_id]').val()+'"' : '';
								var tag_lists = ($menu.find('textarea[name=tag_lists]').val()) ? 'list_tags="'+$menu.find('textarea[name=tag_lists]').val()+'"' : '';
								var tax_name = ($menu.find('input[name=tax_name]').val()) ? 'tax_name="'+$menu.find('input[name=tax_name]').val()+'"' : '';
								var custom_post = ($menu.find('input[name=custom_post]').val()) ? 'custom_post="'+$menu.find('input[name=custom_post]').val()+'"' : '';
								var tax_id = ($menu.find('textarea[name=tax_id]').val()) ? 'cat="'+$menu.find('textarea[name=tax_id]').val()+'"' : '';
								var orderby = $menu.find('select[name=b_orderby]').val();
								var order = $menu.find('select[name=b_order]').val();
								var auto_slide = $menu.find('select[name=auto_slide]').val();
								var control_nav = $menu.find('select[name=control_nav]').val();
								var b_padding = $menu.find('select[name=b_padding]').val();
								var b_show_parent = $menu.find('select[name=b_show_parent]').val();
								var image_ratio = $menu.find('select[name=image_ratio]').val();
								var linkable = $menu.find('select[name=linkable]').val();
								if(cat_type =='taxonomy'){cat_id = tax_id;}
								
								var shortcode = '[res-cat-slider cat_type="'+cat_type+'" '+cat_id+' '+tax_name+' '+custom_post+' '+tag_lists+' per_page="'+number_post+'" columns="'+columns+'" style="'+style+'" pos_menu="'+menu_type+'" order_by="'+orderby+'" order="'+order+'" auto_slide="'+auto_slide+'" control_nav="'+control_nav+'" padding="'+b_padding+'" show_parent_menu="'+b_show_parent+'" image_ratio="'+image_ratio+'" linkable="'+linkable+'" /]<br class="nc"/>';

                                    tinymce.activeEditor.execCommand('mceInsertContent',false,shortcode);
                                    c.hideMenu();
                                }).wrap('<tr><td><div style="padding: 0 10px 10px"></div></td></tr>')
                 
                        $menu.data('added',true); 

                    });

                   // XSmall
					m.add({title : 'Insert Responsive Category Slider Shortcode', 'class' : 'mceMenuItemTitle'}).setDisabled(1);

                 });
                // Return the new splitbig_font_icon instance
                return c;
                
            }
            return null;
        }
    });
    tinymce.PluginManager.add('b_insert_shortcode_editor', tinymce.plugins.b_insert_shortcode_editor);
})();

function category_type_change(){
	var type_cat = jQuery('#b-insert-shortcode #cat_type select').val();
	if(type_cat == 'taxonomy'){
		jQuery('#b-insert-shortcode #tax_name, #b-insert-shortcode #custom_post, #b-insert-shortcode #tax_id').show();
		jQuery('#b-insert-shortcode #tag_lists').hide();
		jQuery('#b-insert-shortcode #cat_id').hide();
	}
	else if(type_cat == 'tag'){
		jQuery('#b-insert-shortcode #tag_lists').show();
		jQuery('#b-insert-shortcode #tax_name, #b-insert-shortcode #custom_post, #b-insert-shortcode #tax_id').hide();
		jQuery('#b-insert-shortcode #cat_id').hide();
	}
	else {
		jQuery('#b-insert-shortcode #cat_id').show();
		jQuery('#b-insert-shortcode #tax_name, #b-insert-shortcode #custom_post, #b-insert-shortcode #tax_id').hide();
		jQuery('#b-insert-shortcode #tag_lists').hide();
	}
}