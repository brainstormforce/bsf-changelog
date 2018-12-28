<?php
/**
 * Post Types
 *
 * Registers post types and taxonomies.
 *
 * @class     BSF_Changelog_post_Type
 * @category  Class
 * @author    Brainstormforce
 * @package   Changelog/PostType
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * BSF_Changelog_Post_Type Class.
 */
class BSF_Changelog_Post_Type {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 11 );
		add_action( 'init', array( __CLASS__, 'register_post_types' ), 10 );
	}

	/**
	 * Register core taxonomies.
	 */
	public static function register_taxonomies() {

		if ( ! is_blog_installed() ) {
			return;
		}

		do_action( 'bsf_changelogs_before_register_taxonomy' );

		register_taxonomy(
			'product',
			apply_filters( 'product', array( BSF_CHANGELOG_POST_TYPE ) ),
			array(
				'hierarchical'      => true,
				'label'             => __( 'Products', 'bsf-changelog' ),
				'labels'            => array(
					'name'              => __( 'Product categories', 'bsf-changelog' ),
					'singular_name'     => __( 'Product', 'bsf-changelog' ),
					'menu_name'         => _x( 'Products', 'Admin menu name', 'bsf-changelog' ),
					'search_items'      => __( 'Search categories', 'bsf-changelog' ),
					'all_items'         => __( 'All Product', 'bsf-changelog' ),
					'parent_item'       => __( 'Parent product', 'bsf-changelog' ),
					'parent_item_colon' => __( 'Parent product:', 'bsf-changelog' ),
					'edit_item'         => __( 'Edit product', 'bsf-changelog' ),
					'update_item'       => __( 'Update product', 'bsf-changelog' ),
					'add_new_item'      => __( 'Add new product', 'bsf-changelog' ),
					'new_item_name'     => __( 'New product name', 'bsf-changelog' ),
					'not_found'         => __( 'No product found', 'bsf-changelog' ),
				),
				'show_ui'           => true,
				'query_var'         => true,
				'show_admin_column' => true,
				'show_in_rest'      => true,
				'hierarchical'      => true,
				'rewrite'           => array(
					'slug'       => apply_filters( 'bsf_changelog_taxonomy', 'product' ),
					'with_front' => false,
				),
			)
		);

		register_taxonomy(
			'changelog_tag',
			apply_filters( 'bsf_taxonomy_objects_changelog_tag', array( BSF_CHANGELOG_POST_TYPE ) ),
			apply_filters(
				'bsf_taxonomy_args_changelog_tag',
				array(
					'hierarchical' => false,
					'label'        => __( 'Version tags', 'bsf-changelog' ),
					'labels'       => array(
						'name'                       => __( 'Version tags', 'bsf-changelog' ),
						'singular_name'              => __( 'Tag', 'bsf-changelog' ),
						'menu_name'                  => _x( 'Tags', 'Admin menu name', 'bsf-changelog' ),
						'search_items'               => __( 'Search tags', 'bsf-changelog' ),
						'all_items'                  => __( 'All tags', 'bsf-changelog' ),
						'edit_item'                  => __( 'Edit tag', 'bsf-changelog' ),
						'update_item'                => __( 'Update tag', 'bsf-changelog' ),
						'add_new_item'               => __( 'Add new tag', 'bsf-changelog' ),
						'new_item_name'              => __( 'New tag name', 'bsf-changelog' ),
						'popular_items'              => __( 'Popular tags', 'bsf-changelog' ),
						'separate_items_with_commas' => __( 'Separate tags with commas', 'bsf-changelog' ),
						'add_or_remove_items'        => __( 'Add or remove tags', 'bsf-changelog' ),
						'choose_from_most_used'      => __( 'Choose from the most used tags', 'bsf-changelog' ),
						'not_found'                  => __( 'No tags found', 'bsf-changelog' ),
					),
					'show_ui'      => true,
					'query_var'    => true,
					'show_in_rest' => true,
					'rewrite'      => array(
						'slug'       => 'changelogs-tag',
						'with_front' => false,
					),
				)
			)
		);

		do_action( 'bsf_changelog_after_register_taxonomy' );
	}

	/**
	 * Register core post types.
	 */
	public static function register_post_types() {
		if ( ! is_blog_installed() ) {
			return;
		}

		do_action( 'bsf_changelog_register_post_type' );

		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'custom-fields',
		);

		$has_comments = get_option( 'bsf_search_has_comments' );
		$has_comments = ! $has_comments ? false : $has_comments;

		if ( ! $has_comments ) {
			$supports[] = 'comments';
		}

		register_post_type(
			BSF_CHANGELOG_POST_TYPE,
			apply_filters(
				'bsf_register_post_type_changelog',
				array(
					'labels'              => array(
						'name'                  => __( 'Changelog', 'bsf-changelog' ),
						'singular_name'         => __( 'Changelog', 'bsf-changelog' ),
						'all_items'             => __( 'All Versions', 'bsf-changelog' ),
						'menu_name'             => _x( 'Changelogs', 'Admin menu name', 'bsf-changelog' ),
						'add_new'               => __( 'Add Version', 'bsf-changelog' ),
						'add_new_item'          => __( 'Add New Version', 'bsf-changelog' ),
						'edit'                  => __( 'Edit', 'bsf-changelog' ),
						'edit_item'             => __( 'Edit Version', 'bsf-changelog' ),
						'new_item'              => __( 'New Version', 'bsf-changelog' ),
						'view'                  => __( 'View Version', 'bsf-changelog' ),
						'view_item'             => __( 'View Version', 'bsf-changelog' ),
						'search_items'          => __( 'Search Version', 'bsf-changelog' ),
						'not_found'             => __( 'No version found', 'bsf-changelog' ),
						'not_found_in_trash'    => __( 'No Version found in trash', 'bsf-changelog' ),
						'parent'                => __( 'Parent Version', 'bsf-changelog' ),
						'featured_image'        => __( 'changelogs image', 'bsf-changelog' ),
						'set_featured_image'    => __( 'Set changelogs image', 'bsf-changelog' ),
						'remove_featured_image' => __( 'Remove Version image', 'bsf-changelog' ),
						'use_featured_image'    => __( 'Use as Version image', 'bsf-changelog' ),
						'items_list'            => __( 'Version list', 'bsf-changelog' ),
					),
					'description'         => __( 'This is where you can add new changelogs to your site.', 'bsf-changelog' ),
					'public'              => true,
					'show_ui'             => true,
					'map_meta_cap'        => true,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
					'query_var'           => true,
					'supports'            => $supports,
					'has_archive'         => true,
					'show_in_nav_menus'   => true,
					'show_in_rest'        => true,
				)
			)
		);

		do_action( 'bsf_changelog_after_register_post_type' );
	}
}

BSF_Changelog_Post_Type::init();


