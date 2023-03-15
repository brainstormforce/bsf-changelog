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

get_header();
$bsf_changelog_scroll_pagination = get_option( 'bsf_changelog_scroll_pagination' );
$page_class = isset( $bsf_changelog_scroll_pagination ) && '1' === $bsf_changelog_scroll_pagination || 'yes' === $bsf_changelog_scroll_pagination ? 'bsf-infinite-scroll' : ''; ?>

<div class="wrap changelog-wraper <?php echo $page_class; ?>">
	<div id="bsf-changelog-primary" class="content-area">
		<main id="main" class="in-wrap" role="main">

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
				<div id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> post type-chnangelogs status-publish format-standard chnangelogs_category">
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
							<a href="#<?php echo ( sanitize_title( get_the_title() ) ); ?>" id="<?php echo ( sanitize_title( get_the_title() ) ); ?>"><h2 class="entry-title"><?php the_title(); ?> </h2></a>
						</header>
						<?php
						$img_pos = apply_filters( 'bsf_changelog_img_position_' . get_the_ID(), 'after' );
						if ( 'before' === $img_pos ) { ?>
							<div><?php the_post_thumbnail( 'full' ); ?></div>
						<?php }
						do_action( 'bsf_changelog_before_content_' . get_the_ID() );
						?>
						<div class="bsf-entry-content content-closed clear" itemprop="text">
							<?php
							if ( has_excerpt() ) {
								the_excerpt(); ?>
								<span class="see-more-text">...See more</span>
							<?php } ?>
						</div>
						<?php $style = has_excerpt() ? 'style="display: none"' : ''; ?>
						<div class="bsf-entry-content content-open clear" itemprop="text" <?php echo $style; ?>>
							<?php the_content(); ?>
						</div>
						<?php
						do_action( 'bsf_changelog_after_content_' . get_the_ID() );
						if ( 'after' === $img_pos ) { ?>
							<div><?php the_post_thumbnail( 'full' ); ?></div>
						<?php }
						?>
					</div>
				<?php
			endwhile;
		endif;
		?>

		</main><!-- #main -->
		<div class='bsf-pagination'>
		<?php the_posts_pagination(
			array(
				'prev_text'          => '&laquo;<span class="screen-reader-text">' . __( 'Previous page', 'bsf-changelog' ) . '</span>',
				'next_text'          => '<span class="screen-reader-text">' . __( 'Next page', 'bsf-changelog' ) . '</span>&raquo;',
			)
		); ?>
		</div>
		<?php if ( isset( $bsf_changelog_scroll_pagination ) && '1' === $bsf_changelog_scroll_pagination || 'yes' === $bsf_changelog_scroll_pagination ) { ?>
			<nav class="bsf-pagination-infinite">
				<div class="bsf-loader">
					<div class="bsf-loader-1"></div>
					<div class="bsf-loader-2"></div>
					<div class="bsf-loader-3"></div>
				</div>
			</nav>
		<?php } ?>
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer(); ?>
