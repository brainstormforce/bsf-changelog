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
						<h2 class="entry-title"><?php the_title(); ?> </h2>
						<div class="changelog-publish-date"><?php echo  get_the_date( 'j M Y' ); ?></div>
					</header>
					<div class="bsf-entry-content clear" itemprop="text">
						<?php the_content(); ?>
					</div>
					<?php edit_post_link( 'Edit' ); ?>
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
