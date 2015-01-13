<?php
/**
 * @package   Responsive Category Slider
 * @author     ThemeLead Team <support@themelead.com>
 * @copyright  Copyright 2014 themelead.com. All Rights Reserved.
 * @license    GPLv2 or later - http://www.gnu.org/licenses/gpl-2.0.html
 * Websites: http://www.themelead.com
 * Technical Support:  Free Forum Support - http://support.themelead.com
 */
if (!class_exists('b_widget_res_cat_slider')) {
	class b_widget_res_cat_slider extends WP_Widget
	{
	  function b_widget_res_cat_slider()
	  {
		$widget_ops = array('classname' => 'WPB_Widget', 'description' => 'Displays list categories, tags of post and post type by slider and ajax' );
		$this->WP_Widget('WPB_Widget', 'Responsive Categories Slider', $widget_ops);
	  }
	 
	  function form($instance)
	  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '','cat_id' => '' ) );
		$title = !empty($instance['title']) ? $instance['title'] : '';
		$cat_type = !empty($instance['cat_type']) ? $instance['cat_type'] : 'category';
		$category = !empty($instance['category']) ? $instance['category'] : '';
		$list_tags = !empty($instance['list_tags']) ? $instance['list_tags'] : '';
		$custom_post = !empty($instance['custom_post']) ? $instance['custom_post'] : '';
		$tax_name = !empty($instance['tax_name']) ? $instance['tax_name'] : '';
		$tax_id = !empty($instance['tax_id']) ? $instance['tax_id'] : '';
		$style = !empty($instance['style']) ? $instance['style'] : 'post';
		$num_posts = !empty($instance['num_posts']) ? $instance['num_posts'] : '6';
		$columns = !empty($instance['columns']) ? $instance['columns'] : '3';
		$menu_type = !empty($instance['menu_type']) ? $instance['menu_type'] : 'horizontal';
		$orderby = !empty($instance['orderby']) ? $instance['orderby'] : 'date';
		$order = !empty($instance['order']) ? $instance['order'] : 'desc';
		$auto_slide = !empty($instance['auto_slide']) ? $instance['auto_slide'] : 'false';
		$control_nav = !empty($instance['control_nav']) ? $instance['control_nav'] : 'on';
		$b_padding = !empty($instance['b_padding']) ? $instance['b_padding'] : 'yes';
		$b_show_parent = !empty($instance['b_show_parent']) ? $instance['b_show_parent'] : 'yes';
		$image_ratio = !empty($instance['image_ratio']) ? $instance['image_ratio'] : 'horizontal_rectangle';
		$linkable = !empty($instance['linkable']) ? $instance['linkable'] : 'on';
		
		
	   // Get the existing categories of post
		$categories = get_categories(array( 'hide_empty' => 0));

		$cat_options = array();
		$cat_options[] = '<option value="category">All Category</option>';
		foreach ($categories as $cat) {
			$selected = $category === $cat->cat_ID ? ' selected="selected"' : '';
			$cat_options[] = '<option value="' . $cat->cat_ID .'"' . $selected . '>' . $cat->name . '</option>';
		}
		
		//Get list custom post name of website
		$args = array(
		  'public'   => true,
		  '_builtin' => false
		); 
		$output = 'names'; // or objects
		$operator = 'and'; // 'and' or 'or'
		$post_types = get_post_types( $args, $output, $operator );
		$custom_post_options = array();
		if ( $post_types ) {
		  foreach ( $post_types  as $post_type ) {
			$selected = $custom_post === $post_type ? 'selected = "selected"': '';
			$custom_post_options[] = '<option value="' . $post_type .'"' . $selected . '>' . $post_type . '</option>';
		  }
		}
		
		//Get list taxonomy name of website
		$args1 = array(
		  'public'   => true,
		  '_builtin' => false
		); 
		$output1 = 'names'; // or objects
		$operator1 = 'and'; // 'and' or 'or'
		$taxonomies = get_taxonomies( $args1, $output1, $operator1 );
		$tax_options = array();
		if ( $taxonomies ) {
		  foreach ( $taxonomies  as $taxonomy ) {
			$selected = $tax_name === $taxonomy ? 'selected = "selected"': '';
			$tax_options[] = '<option value="' . $taxonomy .'"' . $selected . '>' . $taxonomy . '</option>';
		  }
		}
		
		//Options for category type
		$type_optionss = array('category', 'taxonomy', 'tags');
		$type_options = array();
		foreach($type_optionss as $value){
			$selected = $cat_type === $value ? 'selected = "selected"': '';
			$type_options[] = '<option value="' . $value .'"' . $selected . '>' . ucfirst($value) . '</option>';
		}
		//Options for colums
		$column_optionss = array('3', '1', '2', '4', '6');
		$column_options = array();
		foreach($column_optionss as $value){
			$selected = $columns === $value ? 'selected = "selected"': '';
			$column_options[] = '<option value="' . $value .'"' . $selected . '>' . $value . '</option>';
		}
		//Options for styles
		$style_optionss = array('post', 'gallery', 'events', 'product', 'news');
		$style_options = array();
		foreach($style_optionss as $value){
			$selected = $style === $value ? 'selected = "selected"': '';
			$style_options[] = '<option value="' . $value .'"' . $selected . '>' . ucfirst($value) . '</option>';
		}
		//Options for menu type
		$menu_optionss = array('horizontal', 'vertical', 'hide');
		$menu_options = array();
		foreach($menu_optionss as $value){
			$selected = $menu_type === $value ? 'selected' : '';
			$menu_options[] = '<option value="' . $value .'"' . $selected . '>' . ucfirst($value) . '</option>';
		}
		global $id_widget;
		$id_widget = rand();
	?>
		
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<!--<p><label for="<?php echo $this->get_field_id('cat_id'); ?>">Category id: <input class="widefat" id="<?php echo $this->get_field_id('cat_id'); ?>" name="<?php echo $this->get_field_name('cat_id'); ?>" type="text" value="<?php echo esc_attr($cat_id); ?>" /></label></p>-->
		<p id="category_type">
			<label for="<?php echo $this->get_field_id('cat_type'); ?>">
				<?php _e('Choose Categories Type (optional):'); ?>
			</label>
			<select onchange="b_load_option_widget(jQuery(this).val(), jQuery(this).attr('alt'))" id="<?php echo $this->get_field_id('cat_type'); ?>" alt="<?php echo $id_widget;?>" class="widefat" name="<?php echo $this->get_field_name('cat_type'); ?>">
				<option <?php selected( $cat_type, 'category'); ?> value="category"><?php  _e('Category');?></option>
				<option <?php selected( $cat_type, 'taxonomy'); ?> value="taxonomy"><?php  _e('Taxonomy');?></option> 
				<option <?php selected( $cat_type, 'tags'); ?> value="tags"><?php  _e('Tags');?></option>   
			</select>
		</p>
		<p id="category_select_<?php echo $id_widget;?>" class="b_widget_hide" style="<?php echo ($cat_type != 'category') ? 'display: none;' : "";?>">
			<label for="<?php echo $this->get_field_id('category'); ?>">
				<?php _e('Choose category (optional):'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('category'); ?>" class="widefat" name="<?php echo $this->get_field_name('category'); ?>">
				<?php echo implode('', $cat_options); ?>
			</select>
		</p>
		<p id="list_tag_fill_<?php echo $id_widget;?>" class="b_widget_hide" style="<?php echo ($cat_type != 'tags') ? 'display: none;' : "";?>">
			<label for="<?php echo $this->get_field_id('list_tags'); ?>">
				<?php _e('List Tags slug you want show:'); ?>
				<span style="font-size: 11px; display: block;"><?php _e('Example:  tag-one, tag-two, tag-three'); ?></span>
				<textarea class="widefat" id="<?php echo $this->get_field_id('list_tags'); ?>" name="<?php echo $this->get_field_name('list_tags'); ?>"><?php echo esc_attr($list_tags); ?></textarea>
			</label>
		</p>
		<p id="custom_post_select_<?php echo $id_widget;?>" class="b_widget_hide" style="<?php echo ($cat_type != 'taxonomy') ? 'display: none;' : "";?>">
			<label for="<?php echo $this->get_field_id('custom_post'); ?>">
				<?php _e('Choose Custom Post (optional):'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('custom_post'); ?>" class="widefat" name="<?php echo $this->get_field_name('custom_post'); ?>">
				<?php echo implode('', $custom_post_options); ?>
			</select>
		</p>
		<p id="taxonomy_select_<?php echo $id_widget;?>" class="b_widget_hide" style="<?php echo ($cat_type != 'taxonomy') ? 'display: none;' : "";?>">
			<label for="<?php echo $this->get_field_id('tax_name'); ?>">
				<?php _e('Choose Taxonomy (optional):'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('tax_name'); ?>" class="widefat" name="<?php echo $this->get_field_name('tax_name'); ?>">
				<?php echo implode('', $tax_options); ?>
			</select>
		</p>
		<p id="taxonomy_id_<?php echo $id_widget;?>" class="b_widget_hide" style="<?php echo ($cat_type != 'taxonomy') ? 'display: none;' : "";?>">
			<label for="<?php echo $this->get_field_id('tax_id'); ?>">
				<?php _e('Taxonomy ID or Slug:'); ?> 
				<span style="font-size: 11px; display: block;"><?php _e('Note: If you want show all posts in taxonomy then vacant this'); ?></span>
				<textarea class="widefat" id="<?php echo $this->get_field_id('tax_id'); ?>" name="<?php echo $this->get_field_name('tax_id'); ?>"><?php echo esc_attr($tax_id); ?></textarea>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('style'); ?>">
				<?php _e('Choose style (optional):'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('style'); ?>" class="widefat" name="<?php echo $this->get_field_name('style'); ?>">
				<?php echo implode('', $style_options); ?>
			</select>
		</p>
		<p><label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Numbers Posts in a page:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" type="text" value="<?php echo esc_attr($num_posts); ?>" /></label></p>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>">
				<?php _e('Choose Columns (optional):'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('columns'); ?>" class="widefat" name="<?php echo $this->get_field_name('columns'); ?>">
				<?php echo implode('', $column_options); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('menu_type'); ?>">
				<?php _e('Choose Menu Type (optional):'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('menu_type'); ?>" class="widefat" name="<?php echo $this->get_field_name('menu_type'); ?>">
				<?php echo implode('', $menu_options); ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('orderby'); ?>">
				<?php _e('Orderby:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('orderby'); ?>" class="widefat" name="<?php echo $this->get_field_name('orderby'); ?>">
				<option <?php selected( $orderby, 'date'); ?> value="date"><?php  _e('Post Date');?></option>
				<option <?php selected( $orderby, 'view'); ?> value="view"><?php  _e('Post View');?></option> 
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>">
				<?php _e('Order:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('order'); ?>" class="widefat" name="<?php echo $this->get_field_name('order'); ?>">
				<option <?php selected( $order, 'desc'); ?> value="desc"><?php  _e('desc');?></option>
				<option <?php selected( $order, 'asc'); ?> value="asc"><?php  _e('asc');?></option> 
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('auto_slide'); ?>">
				<?php _e('Auto Slide:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('auto_slide'); ?>" class="widefat" name="<?php echo $this->get_field_name('auto_slide'); ?>">
				<option <?php selected( $auto_slide, 'false'); ?> value="false"><?php  _e('False');?></option>
				<option <?php selected( $auto_slide, 'true'); ?> value="true"><?php  _e('True');?></option> 
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('control_nav'); ?>">
				<?php _e('Display Control Nav:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('control_nav'); ?>" class="widefat" name="<?php echo $this->get_field_name('control_nav'); ?>">
				<option <?php selected( $control_nav, 'on'); ?> value="on"><?php  _e('Show');?></option>
				<option <?php selected( $control_nav, 'off'); ?> value="off"><?php  _e('Hide');?></option> 
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('b_padding'); ?>">
				<?php _e('Show Padding?:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('b_padding'); ?>" class="widefat" name="<?php echo $this->get_field_name('b_padding'); ?>">
				<option <?php selected( $b_padding, 'yes'); ?> value="yes"><?php  _e('Yes');?></option>
				<option <?php selected( $b_padding, 'no'); ?> value="no"><?php  _e('No');?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('b_show_parent'); ?>">
				<?php _e('Show Parent Menu:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('b_show_parent'); ?>" class="widefat" name="<?php echo $this->get_field_name('b_show_parent'); ?>">
				<option <?php selected( $b_show_parent, 'yes'); ?> value="yes"><?php  _e('Yes');?></option>
				<option <?php selected( $b_show_parent, 'no'); ?> value="no"><?php  _e('No');?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image_ratio'); ?>">
				<?php _e('Image Ratio:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('image_ratio'); ?>" class="widefat" name="<?php echo $this->get_field_name('image_ratio'); ?>">
				<option <?php selected( $image_ratio, 'horizontal_rectangle'); ?> value="horizontal_rectangle"><?php  _e('Horizontal Rectangle');?></option>
				<option <?php selected( $image_ratio, 'square'); ?> value="square"><?php  _e('Square');?></option>
				<option <?php selected( $image_ratio, 'vertical_rectangle'); ?> value="vertical_rectangle"><?php  _e('Vertical Rectangle');?></option>
				<option <?php selected( $image_ratio, 'full_size'); ?> value="full_size"><?php  _e('Full Size');?></option> 
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('linkable'); ?>">
				<?php _e('Linkable or not?:'); ?>
			</label>
			<select id="<?php echo $this->get_field_id('linkable'); ?>" class="widefat" name="<?php echo $this->get_field_name('linkable'); ?>">
				<option <?php selected( $linkable, 'on'); ?> value="on"><?php  _e('On');?></option>
				<option <?php selected( $linkable, 'off'); ?> value="off"><?php  _e('Off');?></option> 
			</select>
		</p>
	  <?php
	  }
	  //Update items
	  function update($new_instance, $old_instance)
	  {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['cat_type'] = $new_instance['cat_type'];
		$instance['category'] = $new_instance['category'];
		$instance['list_tags'] = $new_instance['list_tags'];
		$instance['custom_post'] = $new_instance['custom_post'];
		$instance['tax_name'] = $new_instance['tax_name'];
		$instance['tax_id'] = $new_instance['tax_id'];
		$instance['style'] = $new_instance['style'];
		$instance['num_posts'] = $new_instance['num_posts'];
		$instance['columns'] = $new_instance['columns'];
		$instance['menu_type'] = $new_instance['menu_type'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['order'] = $new_instance['order'];
		$instance['auto_slide'] = $new_instance['auto_slide'];
		$instance['control_nav'] = $new_instance['control_nav'];
		$instance['b_padding'] = $new_instance['b_padding'];
		$instance['b_show_parent'] = $new_instance['b_show_parent'];
		$instance['image_ratio'] = $new_instance['image_ratio'];
		$instance['linkable'] = $new_instance['linkable'];
		
		
		
		return $instance;
	  }
	  //Display widget
	  function widget($args, $instance)
	  {
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$cat_id = empty($instance['category']) ? ' ' : $instance['category'];
		$list_tags = empty($instance['list_tags']) ? ' ' : $instance['list_tags'];
		$style_choose = empty($instance['style']) ? ' ' : $instance['style'];
		$num_posts = empty($instance['num_posts']) ? ' ' : $instance['num_posts'];
		$columns = empty($instance['columns']) ? ' ' : (int)$instance['columns'];
		$cat_type = empty($instance['cat_type']) ? ' ' : $instance['cat_type'];
		$custom_post = empty($instance['custom_post']) ? ' ' : $instance['custom_post'];
		$tax_name = empty($instance['tax_name']) ? ' ' : $instance['tax_name'];
		$tax_id = empty($instance['tax_id']) ? ' ' : $instance['tax_id'];
		$menu_type = empty($instance['menu_type']) ? ' ' : $instance['menu_type'];
		$orderby = empty($instance['orderby']) ? ' ' : $instance['orderby'];
		$order = empty($instance['order']) ? ' ' : $instance['order'];
		$auto_slide = empty($instance['auto_slide']) ? ' ' : $instance['auto_slide'];
		$control_nav = empty($instance['control_nav']) ? ' ' : $instance['control_nav'];
		$b_padding = empty($instance['b_padding']) ? ' ' : $instance['b_padding'];
		$b_show_parent = empty($instance['b_show_parent']) ? ' ' : $instance['b_show_parent'];
		$image_ratio = empty($instance['image_ratio']) ? ' ' : $instance['image_ratio'];
		$linkable = empty($instance['linkable']) ? ' ' : $instance['linkable'];
		
		
	 
		if (!empty($title)):
		  echo $before_title . $title . $after_title;
		endif;
			if($cat_type == 'tags'){
				if(empty($list_tags)){
					echo do_shortcode('[res-cat-slider cat_type="tag" per_page="'.$num_posts.'" columns="'.$columns.'" style="'.$style_choose.'" pos_menu="'.$menu_type.'" order_by="'.$orderby.'" order="'.$order.'" auto_slide="'.$auto_slide.'" control_nav="'.$control_nav.'" padding="'.$b_padding.'" show_parent_menu="'.$b_show_parent.'" image_ratio="'.$image_ratio.'" linkable="'.$linkable.'"][/res-cat-slider]');
				}
				else{
					echo do_shortcode('[res-cat-slider cat_type="tag" list_tags="'.$list_tags.'" per_page="'.$num_posts.'" columns="'.$columns.'" style="'.$style_choose.'" pos_menu="'.$menu_type.'" order_by="'.$orderby.'" order="'.$order.'" auto_slide="'.$auto_slide.'" control_nav="'.$control_nav.'" padding="'.$b_padding.'" show_parent_menu="'.$b_show_parent.'" image_ratio="'.$image_ratio.'" linkable="'.$linkable.'"][/res-cat-slider]');
				}
			}
			else if($cat_type == 'taxonomy'){
				if(empty($tax_id) || ($tax_id = '')){
					echo do_shortcode('[res-cat-slider cat_type="taxonomy" custom_post="'.$custom_post.'" tax_name="'.$tax_name.'" per_page="'.$num_posts.'" columns="'.$columns.'" style="'.$style_choose.'" pos_menu="'.$menu_type.'" order_by="'.$orderby.'" order="'.$order.'" auto_slide="'.$auto_slide.'" control_nav="'.$control_nav.'" padding="'.$b_padding.'" show_parent_menu="'.$b_show_parent.'" image_ratio="'.$image_ratio.'" linkable="'.$linkable.'"][/res-cat-slider]');
				}
				else {
					echo do_shortcode('[res-cat-slider cat_type="taxonomy" custom_post="'.$custom_post.'" tax_name="'.$tax_name.'" cat="'.$tax_id.'" per_page="'.$num_posts.'" columns="'.$columns.'" style="'.$style_choose.'" pos_menu="'.$menu_type.'" order_by="'.$orderby.'" order="'.$order.'" auto_slide="'.$auto_slide.'" control_nav="'.$control_nav.'" show_parent_menu="'.$b_show_parent.'" padding="'.$b_padding.'" image_ratio="'.$image_ratio.'" linkable="'.$linkable.'"][/res-cat-slider]');
				}
			}
			else{
				echo do_shortcode('[res-cat-slider cat_type="category" per_page="'.$num_posts.'" columns="'.$columns.'" style="'.$style_choose.'" pos_menu="'.$menu_type.'" cat="'.$cat_id.'" order_by="'.$orderby.'" order="'.$order.'" auto_slide="'.$auto_slide.'" control_nav="'.$control_nav.'" padding="'.$b_padding.'" show_parent_menu="'.$b_show_parent.'" image_ratio="'.$image_ratio.'" linkable="'.$linkable.'"][/res-cat-slider]');
			}
		
		echo $after_widget;
	  }
	}
}

add_action( 'widgets_init', 'b_responsive_category_slider_widget' );

if(!function_exists('b_responsive_category_slider_widget')){
	function b_responsive_category_slider_widget() {
		register_widget( 'b_widget_res_cat_slider' );
	}
}