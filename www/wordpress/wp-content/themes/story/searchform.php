<?php
/**
 * The template for displaying search forms in Sugar & Spice
 *
 * @package Sugar & Spice
 */
?>
<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'sugarspice' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'sugarspice' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<a href="javascript:{}" onclick="document.getElementById('searchform').submit(); return false;" title="Search" class="searchsubmit"><i class="icon-search"></i></a>
</form>
