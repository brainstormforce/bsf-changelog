<?php
/**
 * Functions related to shortcode for live search
 *
 * @package Changelog/Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'chnagelog_wp_live_search', 'bsf_chnagelog_render_search_box' );
add_shortcode( 'chnagelog_wp_category_list', 'bsf_render_changelog_list' );

/**
 * For rendering the search box.
 *
 * @param int $atts Get attributes for the search field.
 * @param int $content Get content to search from.
 */
function bsf_chnagelog_render_search_box( $atts, $content = null ) {

	ob_start();
	$args = shortcode_atts(
		array(
			'placeholder' => __( 'Enter search string', 'bsf-chnagelogs' ),
		), $atts
	);

	?>

	<div id="bsf-live-search">
		<div class="bsf-search-container">
			<div id="bsf-search-wrap">
				<form role="search" method="get" id="bsf-searchform" class="clearfix" action="<?php echo home_url(); ?>">
					<input type="text" placeholder="<?php echo esc_attr( $args['placeholder'] ); ?>" onfocus="if (this.value == '') {this.value = '';}" onblur="if (this.value == '')  {this.value = '';}" value="" name="s" id="bsf-sq" autocapitalize="off" autocorrect="off" autocomplete="off">
					<div class="spinner live-search-loading bsf-search-loader">
						<img src="<?php echo esc_url( admin_url( 'images/spinner-2x.gif' ) ); ?>" >
					</div>
					<button type="submit" id="bsf-searchsubmit">
						<span class="chnagelogswp-search"></span>
						<span><?php _e( 'Search', 'bsf-chnagelogs' ); ?></span>
					</button>
				</form>
		  </div>
		</div>
	</div>

	<?php

	return ob_get_clean();
}

/**
 * Get the category list of chnagelogs.
 *
 * @param int $atts Get attributes for the categories.
 * @param int $content Get content to category.
 */
function bsf_render_changelog_list( $atts, $content = null ) {

	ob_start();

	$get_args = shortcode_atts(
		array(
			'category' => 'chnagelogs_category',
		), $atts
	);

	$taxonomy_objects = get_terms(
		$get_args['category'], array(
			'hide_empty' => false,
		)
	);

	?>

	<?php
	$chnagelog_title = get_option( 'bsf_chnagelog_title' );

	if ( '' != $chnagelog_title ) {
	?>
		<h1 class="chnagelogs-title"><?php echo esc_attr( $chnagelog_title ); ?></h1>
	<?php } ?>

	<div class="bsf-categories-wrap clearfix">

		
		<?php
		foreach ( $taxonomy_objects as $key => $object ) {

			$cat_link = get_category_link( $object->term_id );
			$category = get_category( $object->term_id );
			$count = $category->category_count;

			if ( $count > 0 ) {

			?>
			<div class="bsf-cat-col" >
				<a class="bsf-cat-link" href="<?php echo esc_url( $cat_link ); ?>">
					<h4><?php echo $object->name; ?></h4>
					<span class="bsf-cat-count">
						<?php echo $count . ' ' . __( 'Articles', 'bsf-chnagelogs' ); ?> 
					</span>
				</a>
			</div>

		<?php
			}
		}
?>
	</div>

	<?php

	return ob_get_clean();
}

/**
 * To load search results.
 */

