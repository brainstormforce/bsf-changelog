<?php
/**
 * Functions related to shortcode for live search
 *
 * @package Changelog/Shortcode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_shortcode( 'changelog_product_list', 'bsf_render_changelog_list' );

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
		),
		$atts
	);

	$taxonomy_objects = get_terms(
		$get_args['category'],
		array(
			'hide_empty' => false,
		)
	);
	?>
	<div class="bsfc-title-wrap">
	<?php
		$changelog_title     = get_option( 'bsf_changelog_title' );
		$changelog_sub_title = get_option( 'bsf_changelog_sub_title' );

	if ( '' !== $changelog_title ) {
		echo '<h2 class="changelog-title">' . esc_attr( $changelog_title ) . '</h2>';
	}
	if ( '' !== $changelog_title ) {
		echo '<p class="changelog-sub-title">' . esc_attr( $changelog_sub_title ) . '</p>';
	}
	?>
	</div>
	<?php if ( $taxonomy_objects && ! is_wp_error( $taxonomy_objects ) ) : ?>
		<div class="bsf-changelog-cat-wrap clearfix">
			<?php
			foreach ( $taxonomy_objects as $key => $object ) {

				if ( $object->count ) {

					?>
				<div class="bsf-changelog-col" >
					<a class="bsf-changelog-link" href="<?php echo esc_url( get_term_link( $object->slug, $object->taxonomy ) ); ?>">
						<h4><?php echo esc_html( $object->name ); ?></h4>
						<span class="bsf-cat-count">
							<?php /* translators: %s: Version number count term */ ?>
							<?php printf( __( '%1$s Versions', 'bsf-changelog' ), $object->count ); ?>
						</span>
					</a>
				</div>

					<?php
				}
			}
			?>
		</div>

		<?php
	endif;

	return ob_get_clean();
}

