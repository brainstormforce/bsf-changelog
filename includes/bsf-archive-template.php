<?php
/**
 * The template for archive Changelogs page
 *
 * @author Brainstormforce
 * @package Changelog/ArchiveTemplate
 */

get_header();?>

<?php $has_multiple_product = get_option( 'bsf_changelog_category_template' ); ?>
<div class="wrap changelogs-archive-wraper">
	<?php
		// Display category list.
	if ( ( '1' === $has_multiple_product || false === $has_multiple_product ) ) {
		echo do_shortcode( '[changelog_product_list]' );
	}
	?>
</div><!-- .wrap -->
	<?php if ( ! ( '1' === $has_multiple_product || false === $has_multiple_product ) ) { ?>
	<div class="wrap changelog-wraper">
		<div id="bsf-changelog-primary" class="content-area">
			<main id="main" class="in-wrap" role="main">

			<?php
				$changelog_title     = get_option( 'bsf_changelog_title' );
				$changelog_sub_title = get_option( 'bsf_changelog_sub_title' );
			?>
			<?php if ( '' !== $changelog_title ) { ?>
			<section class="bsfc-archive-description">
				<div class="bsf-changelog-header">
				<?php
				if ( '' !== $changelog_title ) {
					echo '<h1 class="page-title ">' . esc_attr( $changelog_title ) . '</h1>';
				}
				if ( '' !== $changelog_sub_title ) {
					echo '<p class="page-sub-title">' . esc_attr( $changelog_sub_title ) . '</p>';
				}
				?>
				</div><!-- .page-header -->
			</section>
			<?php } ?>
			<?php
			if ( have_posts() ) :
				?>
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file.
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					?>
					<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> post type-chnangelogs status-publish format-standard chnangelogs_category">
						<header class="entry-header">
							<h2 class="entry-title"><?php the_title(); ?> </h2>
							<div class="changelog-publish-date"><?php echo  get_the_date( 'j M Y' ); ?></div>
						</header>
						<div class="bsf-entry-content clear" itemprop="text">
							<?php the_content(); ?>
						</div>
					</article>
					<?php
				endwhile;
				the_posts_pagination(
					array(
						'prev_text'          => '&laquo;<span class="screen-reader-text">' . __( 'Previous page', 'bsf-changelog' ) . '</span>',
						'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'bsf-changelog' ) . '</span>&raquo;',
						'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'bsf-changelog' ) . ' </span>',
					)
				);

			endif;
			?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- .wrap -->
		<?php
	}
	get_footer();
