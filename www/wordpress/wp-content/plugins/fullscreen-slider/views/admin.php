<?php
/**
 * Represents the view for the administration dashboard.
 * @package   FS_Slider
 * @author    Alex Ilie <contact@wptoolbox.co>
 * @license   GPL-2.0+
 * @link      http://wptoolbox.co
 * @copyright 2013 wptoolbox.co
 */
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<?php
		if ( ! isset( $_REQUEST['settings-updated'] ) )
			$_REQUEST['settings-updated'] = false;
	?>
	<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
		<div class="updated fade"><p><strong>Slider saved</strong></p></div>
	<?php endif; ?>

	<form action="options.php" method="post">
		<?php settings_fields( 'fs_slider_settings' ); ?>
		<?php
			$fs_options = $this->settings;
			$fs_images  = $this->slides;
		?>
		<div class="slider-settings">
			<h3>Settings</h3>
			<p>
				<label>Speed <br>
					<input type="text" name="fs_slider[speed]" class="widefat" value="<?php echo $fs_options['speed']; ?>">
				</label>
			</p>
			<p>
				<label>Animation <br>
					<select name="fs_slider[animation]" class="widefat">
						<option value="fade" <?php selected( 'fade', $fs_options['animation'] ); ?>>Fade</option>
						<option value="slide" <?php selected( 'slide', $fs_options['animation'] ); ?>>Slide</option>
					</select>
				</label>
			</p>
			<p>
				<label><input type="checkbox" name="fs_slider[htmlfix]" value="1" <?php checked( 1, $fs_options['htmlfix'] ); ?>> Check this if you are experiencing an extra vertical scrollbar on the frontend
				</label>
			</p>
		</div>
		<div class="slider-images">
			<h3>Images</h3>
			<a href="#" id="add-slide" class="button">Add slide</a>
			<ul id="sortable">
				<?php
					if ( ! empty( $fs_images ) ) {
						foreach ($fs_images as $key => $image) {
							?>
								<li class="ui-state-default">
									<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
									<input type="text" name="fs_images[<?php echo $key; ?>][url]" value="<?php echo $image['url']; ?>" class="url widefat">
									<a href="#" class="add-image">Add image</a>
									<a href="#" class="ui-icon ui-icon-circle-close remove-slide">remove</a>
								</li>
							<?php
						}
					}
				?>
			</ul>
		</div>
		<?php submit_button( 'Save', 'primary', 'submit' ); ?>
	</form>
	<div class="slide-placeholder">
		<li class="ui-state-default">
			<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
			<input type="text" name="fs_images[0][url]" value="" class="url widefat">
			<a href="#" class="add-image">Add image</a>
			<a href="#" class="ui-icon ui-icon-circle-close remove-slide">remove</a>
		</li>
	</div>
</div>