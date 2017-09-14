<?php
/**
 * The template for archive Changelogs page
 *
 * @author Brainstormforce
 * @package changelog/ArchiveTemplate
 */

get_header(); ?>

<?php
	// display live search box.
	echo do_shortcode( '[changelog_wp_live_search]' );
?>
<div class="wrap changelogs-archive-wraper">

	<?php

	// Display category list.
	echo do_shortcode( '[changelog_wp_category_list]' );

	?>

</div><!-- .wrap -->

<?php
get_footer();
