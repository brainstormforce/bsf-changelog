<?php
/*-----------Oveerride by using checkbox-------------*/

if (get_option('changelog-checkbox') === '1') { 
   
    add_filter('template_include', 'category_template');
}
function category_template( $template ) {
            if ( is_tax( 'product' ) ) {
                return plugin_dir_path(__FILE__) . 'taxonomy-product.php';
            }
            return $template;         
}

/*-------------------override archive file----------------------------*/

add_filter('template_include', 'changelog_template');

function changelog_template( $template ) {
    
  if ( is_post_type_archive('changelog') ) {

    $theme_files = array('archive-changelog.php');
    $exists_in_theme = locate_template($theme_files, false);

    if ( $exists_in_theme != '' ) {
      return $exists_in_theme;
    } else {

      return plugin_dir_path(__FILE__) . 'archive-changelog.php';
    }
  }
  return $template;
}

/*-------------------Custom post----------------------------*/
function changelog_post_type (){

    $singular = 'Changelog';
    $plural = 'Changelogs';

    $labels = array(
        'name'                  =>  'Changelog',
        'singular_name'         =>  $singular,
        'add_new'               =>  'Add '.$singular,
        'all_items'             =>   $plural,
        'add_new_item'          =>  'Add New '.$singular,
        'edit_item'             =>  'Edit '.$singular,
        'new_item'              =>  'New '.$singular,
        'view_item'             =>  'View '.$singular,
        'search_item'           =>  'Search '.$singular,
        'not_found'             =>  'No '.$singular.'Found',
        'not_found_in_trash'    =>  'No '.$plural.'Found in Trash',
        'parent_item_colon'     =>  'Parent '.$singular
    );
    $args = array(
        'labels'                 => $labels,
        'public'                 => true,
        'has_archive'            => true,
        'publicly_queryable'     => true,
        'show_in_nav_menus'      => true,
        'show_ui'                => true,
        'show_in_nav_menu'       => true,
        'show_in_admin_bar'      => true,
        'query_var'              => true,
        'rewrite'                => true,
        'capability_type'        => 'post',
        'hierarchical'           => false,
        'supports'               => array(                                     
                                        'editor',
                                        'excerpt',
                                        'thumbnail',
                                        'revisions',
                                        'comments',
                                        ),
        //'taxonomies' => array('category', 'post_tag'),
        'menu_position'          => 5,
        'menu_icon'              => 'dashicons-media-text',
        'exclude_from_search'    => false
        );
    register_post_type('changelog',$args);
    add_post_type_support('changelog', 'title');

}
add_action('init','changelog_post_type');

/*------------------------Custom Taxonomy--------------------------------*/

function changelog_categories () {
    $singular   =   'Product';
    $plural     =   'Products';

    $labels     =   array(
                        'name'                          => $plural,
                        'singular_name'                 => $singular,
                        'search_items'                  => 'Search ' , $plural,
                        'popular_items'                 => 'Popular ' , $plural,
                        'all_items'                     => 'All ' , $plural,
                        'parent_item'                   => null,
                        'parent_item_colon'             => null,
                        'edit_item'                     => 'Edit ' , $singular,
                        'update_item'                   => 'Update ' , $singular,
                        'add_new_item'                  => 'Add New ' , $singular,
                        'new_item_name'                 => 'New ' , $singular , 'Name',
                        'separate_items_with_commas'    => 'Separate' , $plural , ' with commas ',
                        'add_or_remove_items'           => 'Add or remove' , $plural,
                        'choose_from_most_used'         => 'Choose from the most used ', $plural,
                        'not_found'                     => 'No ' , $plural , ' found ',
                        'menu_name'                     => $plural,

                      );

    $args       =   array(
                        'hierarchical'                  => true,
                        'labels'                        => $labels,
                        'show_ui'                       => true,
                        'show_admin_column'             => true,
                        'update_count_callback'         => 'update_post_term_count',
                        'query_var'                     => true,
                        'rewrite'                       => array( 'slug' => 'product'),
                    );
        register_taxonomy('product' , 'changelog' , $args);

}
add_action('init','changelog_categories');

/*-----------------------Custom post - Settings------------------------*/



function register_changelog_settings() {
    register_setting("section", "changelog-checkbox");
    add_settings_Section("section", "Page Templates", null, "changelog");
    add_settings_field("changelog-checkbox", "Inbuilt Category Page Template", "changelog_checkbox_display", "changelog", "section"); 
}



function changelog_checkbox_display()
{
   ?>
<input type="checkbox" name="changelog-checkbox" value="1" <?php checked(1, get_option('changelog-checkbox'), true); ?> /> 
   <?php
}

add_action( 'admin_init' , 'register_changelog_settings' );

function form_submenu_page() {   
?>
 <div class="wrap">
         <h1>Changelog settings</h1>
  
         <form method="post" action="options.php">
            <?php
               settings_fields("section");
  
               do_settings_sections("changelog");
                 
               submit_button(); 
            ?>
         </form>
      </div>
<?php
}

function register_changelog_menu() {
    
     add_submenu_page( 'edit.php?post_type=changelog','option Title', 'Settings', 'manage_options','sub_menu_slug', 'form_submenu_page' );  
}

add_action( 'admin_menu' , 'register_changelog_menu' );


/*-------------shortcode to display posts categorywise----------------*/

add_shortcode( 'changelog-shortcode', 'changelog_shortcode_callback' );

function changelog_shortcode_callback( $atts ) {

    $atts = shortcode_atts(
        array(
    'product' => '',
    'hide_empty' => false
    ),$atts, 'changelog-shortcode');
    $product_type= $atts['product'] ;
 
    $q = new WP_Query(array(
            'post_type' => 'changelog',
            'tax_query' => array(
            array(
                'taxonomy' => 'product',
                'field' => 'slug',
                'terms' => array($product_type)
            ))        
                ));
            while ($q->have_posts() ) :
                $q->the_post();
?>
        <div class="content-all">
                <h3>
                    <?php the_title(); 
                    echo ' ';
                    the_time( get_option( 'date_format' ) );  ?>
                </h3>
                   <?php  the_content(); ?>
        </div>
            <?php endwhile; 
}

