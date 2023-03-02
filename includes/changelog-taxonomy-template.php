<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Changelog
 * @subpackage CategoryTemplate
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<div class="wrap changelog-wraper">
	<div id="bsf-changelog-primary" class="content-area">
		<main id="main" class="in-wrap" role="main">

		<?php if ( have_posts() ) : ?>
		<section class="bsfc-archive-description">
			<div class="bsf-changelog-header">
				<?php
					$all_prodcut_url = site_url() . '/' . BSF_CHANGELOG_POST_TYPE;
					echo '<h1 class="page-title">' . single_cat_title( '', false ) . '</h1>';
				?>
					<a href="<?php echo esc_url( $all_prodcut_url ); ?>"><?php _e( 'All Changelogs', 'bsf-changelog' ); ?></a>
					<?php echo '/ ' . single_cat_title( '', false ); ?>
			</div><!-- .page-header -->
		</section>
	<?php endif; ?>

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

<?php get_footer(); ?>
