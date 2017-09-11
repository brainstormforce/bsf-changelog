<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @since 1.0
 * @version 1.0
 */

	add_action( 'wp_enqueue_scripts', 'prefix_add_changelog_stylesheet' );
	/**
	 * Enqueue plugin style-file
	 */
	function prefix_add_changelog_stylesheet() {
	    // Respects SSL, Style.css is relative to the current file
	    wp_register_style( 'prefix-style', plugins_url('../css/style.css', __FILE__) );
	    wp_enqueue_style( 'prefix-style' );
	}
get_header(); ?>

<div>

	<div class="changelog-container">
		

		<?php if ( have_posts() ) : ?>
		<div class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</div><!-- .page-header -->
	<?php endif; ?>

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				?>

				<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?>">
					<h2 class="entry-title">
						<a rel="bookmark" href="<?php echo esc_url( the_permalink() ); ?>"><i class="dashicons-media-document dashicons"></i><?php the_title(); ?></a>
					</h2>
				</article>
				<?php
				//get_template_part( 'template-parts/content', get_post_format() );

			endwhile;
			the_posts_pagination( array(
				'prev_text' => '&laquo;<span class="screen-reader-text">' . __( 'Previous page', 'bsf-docs' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'bsf-docs' ) . '</span>&raquo;',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'bsf-docs' ) . ' </span>',
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		
	</div><!-- #primary -->
	
</div><!-- .wrap -->

<?php get_footer(); ?>
