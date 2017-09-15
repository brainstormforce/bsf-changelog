<?php
/**
 * Functions related to shortcode for live search
 *
 * @package Changelog/Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'changelog_wp_category_list', 'bsf_render_changelog_list' );

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
			'category' => 'product',
		), $atts
	);

	$taxonomy_objects = get_terms(
		$get_args['category'], array(
			'hide_empty' => false,
		)
	);

	?>

	<?php
	$chnagelog_title = get_option( 'bsf_changelog_title' );

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

