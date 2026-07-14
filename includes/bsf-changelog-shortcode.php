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
		$bsf_changelog_default_raw_url = get_option( 'bsf_changelog_default_raw_url' );

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

add_shortcode( 'changelog_product_tabs', 'bsf_render_changelog_product_tabs' );

/**
 * Renders a product tab for each 'product' term, with that product's changelog
 * entries underneath. Same tab markup/behaviour as the archive page's opt-in
 * product tabs, so it can be dropped on any page.
 *
 * All panels render up-front (a tab click just shows/hides one via JS - see
 * frontend.js), so each panel is capped at 'limit' entries to keep the page's
 * total query/HTML cost bounded no matter how many changelog posts a product
 * ends up with; a "View all" link covers the rest via that product's own
 * (fully paginated) archive page.
 *
 * @param array $atts Shortcode attributes: 'products' (comma-separated slugs, order respected), 'default' (slug shown first), 'limit' (max entries per panel, default 15).
 */
function bsf_render_changelog_product_tabs( $atts ) {

	$atts = shortcode_atts(
		array(
			'products' => '',
			'default'  => '',
			'limit'    => 15,
		),
		$atts,
		'changelog_product_tabs'
	);

	$limit = max( 1, (int) $atts['limit'] );

	$requested_slugs = array_filter( array_map( 'trim', explode( ',', $atts['products'] ) ) );

	$bsf_changelog_loader = Bsf_Changelog_Loader::get_instance();
	$terms                = $bsf_changelog_loader->get_product_terms_by_slugs( $requested_slugs );

	if ( empty( $terms ) ) {
		return '';
	}

	$term_slugs   = wp_list_pluck( $terms, 'slug' );
	$default_slug = in_array( $atts['default'], $term_slugs, true ) ? $atts['default'] : $terms[0]->slug;

	ob_start();
	?>
	<div class="bsf-product-tabs-wrap">
		<?php $bsf_changelog_loader->render_product_tabs_nav( $terms, $default_slug ); ?>

		<?php foreach ( $terms as $term ) : ?>
			<div class="bsf-product-tab-panel<?php echo esc_attr( $term->slug === $default_slug ? '' : ' bsf-tab-hidden' ); ?>" data-bsf-product-panel="<?php echo esc_attr( $term->slug ); ?>">
				<?php
				$product_changelogs = get_posts(
					array(
						'post_type'      => BSF_CHANGELOG_POST_TYPE,
						'posts_per_page' => $limit,
						'post_status'    => 'publish',
						'post_parent'    => 0,
						'orderby'        => 'date',
						'order'          => 'DESC',
						'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
							array(
								'taxonomy' => 'product',
								'field'    => 'slug',
								'terms'    => $term->slug,
							),
						),
					)
				);

				if ( ! $product_changelogs ) {
					echo '<p>' . esc_html__( 'No versions found for this product yet.', 'bsf-changelog' ) . '</p>';
					continue;
				}

				global $post;
				foreach ( $product_changelogs as $post ) {
					setup_postdata( $post );
					?>
					<div id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> type-chnangelogs">
						<div class="bsf-changelog-post-wrapper">
							<header class="entry-header">
								<div class="pre-title">
									<div class="author-name-date-section">
										<div class="publish-date"><?php echo esc_html( get_the_date() ); ?></div>
									</div>
								</div>
								<h2 class="entry-title"><?php the_title(); ?></h2>
							</header>
							<div class="bsf-entry-content clear"><?php the_content(); ?></div>
						</div>
						<?php $bsf_changelog_loader->render_subversion_content( get_the_ID() ); ?>
					</div>
					<?php
				}
				wp_reset_postdata();

				if ( $term->count > $limit ) {
					?>
					<a class="bsf-product-tab-view-all" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
						<?php
						/* translators: %s: Product name. */
						printf( esc_html__( 'View all %s versions', 'bsf-changelog' ), esc_html( $term->name ) );
						?>
					</a>
					<?php
				}
				?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
	return ob_get_clean();
}

