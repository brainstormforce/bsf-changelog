<?php
	/*
	 *
	 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
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
	get_header(); 
	 ;/* Start the Loop */ ?>
		
<?php

    $terms = get_terms(array(
        'taxonomy' => 'product',
        'hide_empty' => false,
        ));
     $count_cat = count($terms);

     if($count_cat < 1) {
?>

	<div class="changelog-content">
		<?php
			$q = new WP_Query(array(
			'post_type' => 'changelog',
				));
			while ($q->have_posts() ) :
				$q->the_post();
		?>
				<div class="content-all">
					<h3>
						<?php the_title(); 
						echo ' - ';
						 the_time( get_option( 'date_format' ) );  ?>
					</h3>
					<?php the_content(); ?>
				</div>
			<?php endwhile; ?>
	</div>
<?php
	} else {
		global $count_post;
		?> 
		<?php
		$myterms = get_terms(array(
        'taxonomy' => 'product',
        'hide_empty' => false,
        ));
		 foreach($myterms as $myterm) {
		 	$cat_name = $myterm->name;
		 	$cat_link = get_category_link($myterm);
		 	$count_post = 0;
		   		$q = new WP_Query(array(
		            'post_type' => 'changelog',
		            'tax_query' => array(
		            array(
		                'taxonomy' => 'product',
		                'field' => 'slug',
		                'terms' => array($myterm->slug)
		            )) ));
		   		while($q -> have_posts() ):
		   			$q -> the_post();
		   			$count_post = $count_post +1;
		   		endwhile;
		            ?>
		        <div class="bsf-cat-content">
				<div class="bsf-cat-col">
				<h4>
					<a href=<?php echo esc_url( $cat_link ); ?> >
					<?php echo $cat_name; ?></a>
				</h4>
					<?php echo $count_post.' Articles'; ?>
				</div>
				</div>
				<?php 
			}
	}	
