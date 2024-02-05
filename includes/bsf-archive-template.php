<?php
/**
 * The template for archive Changelogs page
 *
 * @author Brainstormforce
 * @package Changelog/ArchiveTemplate
 */

get_header();
$bsf_changelog_scroll_pagination = get_option( 'bsf_changelog_scroll_pagination' );
$page_class = isset( $bsf_changelog_scroll_pagination ) && '1' === $bsf_changelog_scroll_pagination || 'yes' === $bsf_changelog_scroll_pagination ? 'bsf-infinite-scroll' : '';
$bsf_changelog_link_icon = get_option( 'bsf_changelog_link_icon' );
$link_icon = isset( $bsf_changelog_link_icon ) && '1' === $bsf_changelog_link_icon || 'yes' === $bsf_changelog_link_icon ? '<i class="dashicons dashicons-paperclip"></i>' : '';
$bsf_changelog_hide_featured_img = get_option( 'bsf_changelog_hide_featured_img' );
$img_class = isset( $bsf_changelog_hide_featured_img ) && '1' === $bsf_changelog_hide_featured_img || 'yes' === $bsf_changelog_hide_featured_img ? 'bsf-featured-img-hide' : ''; ?>

	<div class="wrap changelog-wraper <?php echo $page_class; ?>">
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
					<div id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> post type-chnangelogs status-publish format-standard chnangelogs_category">
						<header class="entry-header">
							<div class="pre-title" id="<?php echo ( sanitize_title( get_post_field( 'post_name', get_post() ) ) ); ?>">
								<div class="img-name-date-section">
								<div class="author-img-section">
									<?php if ( get_avatar( get_the_author_meta('ID') ) ) {
										echo get_avatar( get_the_author_meta('ID') );
                        			} else { ?>
                            			<img src="/images/no-image-default.jpg" />
                        			<?php } ?>
								</div>
								<div class="author-name-date-section">
									<div class="author-name"><?php the_author(); ?></div>
									<div class="publish-date"><?php echo get_the_date(); ?></div>
								</div>
								<?php $tags = get_the_terms( get_the_ID(), 'changelog_tag' );
								if ( $tags ) { ?>
								<div class="bsf-version-tag">
									<span class="bsf-version-no"><?php
										echo $tags[0]->name;
									?></span>
								</div>
								<?php } ?>
								</div>
								<?php $terms = wp_get_post_terms( get_the_ID(), 'product' );
								if ( $terms ) { ?>
								<div class="category-section">
									<a href="<?php echo get_term_link( (int) $terms[0]->term_id ); ?>" class="category-name">
									<?php
										echo $terms[0]->name;
									?>
									</a>
								</div>
								<?php } ?>
							</div>
							<a href="#<?php echo ( sanitize_title( get_post_field( 'post_name', get_post() ) ) ); ?>"><?php echo $link_icon; ?><h2 class="entry-title"><?php the_title(); ?> </h2></a>
						</header>
						<?php
						$img_pos = apply_filters( 'bsf_changelog_img_position_' . get_the_ID(), 'after' );
						$img_pos_all = apply_filters( 'bsf_changelog_img_position_all', 'after' );
						if ( ( 'before' === $img_pos || 'before' === $img_pos_all ) && has_post_thumbnail() ) { ?>
							<div class="bsf-changelog-img <?php echo $img_class; ?>" style="margin-bottom: 16px;"><?php the_post_thumbnail( 'full' ); ?></div>
						<?php }
						do_action( 'bsf_changelog_before_content_' . get_the_ID() );
						?>
						<?php if ( has_excerpt() ) { ?>
							<div class="bsf-entry-content content-closed clear" itemprop="text">
							<?php the_excerpt(); ?>
							</div>
							<span class="see-more-text">Continue Reading...</span>
						<?php } ?>
						<?php $style = has_excerpt() ? 'style="display:none;"': ''; ?>
						<div class="bsf-entry-content content-open clear" itemprop="text" <?php echo $style; ?>>
							<?php the_content(); ?>
						</div>
						<?php do_action( 'bsf_changelog_after_content_' . get_the_ID() );
						if ( ( 'after' === $img_pos || 'after' === $img_pos_all ) && ( 'before' !== $img_pos && 'before' !== $img_pos_all ) && has_post_thumbnail() ) { ?>
							<div class="bsf-changelog-img <?php echo $img_class; ?>"><?php the_post_thumbnail( 'full' ); ?></div>
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
		<?php
	get_footer();
