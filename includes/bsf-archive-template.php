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
							<div class="pre-title">
								<div class="author-img-section">
									<?php if ( get_avatar( get_the_author_id() ) ) {
										echo get_avatar( get_the_author_id() );
                        			} else { ?>
                            			<img src="/images/no-image-default.jpg" />
                        			<?php } ?>
								</div>
								<div class="author-name-date-section">
										<div class="author-name"><?php the_author(); ?></div>
										<a href="<?php echo get_post_permalink(); ?>" class="publish-date"><?php echo get_the_date(); ?></a>
								</div>
								<div class="category-section">
									<?php $terms = wp_get_post_terms( get_the_ID(), 'product' ); ?>
									<a href="<?php echo get_term_link( (int) $terms[0]->term_id ); ?>" class="category-name">
									<?php
										echo $terms[0]->name;
									?>
									</a>
								</div>
							</div>
							<a href="#<?php echo ( sanitize_title( get_the_title() ) ); ?>"><h2 id="<?php echo ( sanitize_title( get_the_title() ) ); ?>" class="entry-title"><?php the_title(); ?> </h2></a>
							<div class="changelog-publish-date"><?php echo get_the_date( 'j M Y' ); ?></div>
						</header>
						<div class="bsf-entry-content content-closed clear" itemprop="text">
							<?php
							$str = get_the_content();
							$content = substr( $str, 0, apply_filters( 'bsf-changelog-content-length', 600 ) );
							echo $content; ?>
							<span class="see-more-text">...See more</span>
						</div>
						<div class="bsf-entry-content content-open clear" itemprop="text">
							<?php the_content(); ?>
						</div>
						<div><?php the_post_thumbnail( 'full' ); ?></div>
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
