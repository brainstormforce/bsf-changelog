<?php
/**
 * Responsible for setting up constants, classes and includes.
 *
 * @author BrainstormForce
 * @package Changelog/Loader
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

if ( ! class_exists( 'Bsf_Changelog_Loader' ) ) {

	/**
	 * Responsible for setting up constants, classes and includes.
	 *
	 * @since 1.0
	 */
	final class Bsf_Changelog_Loader {

		/**
		 * The unique instance of the plugin.
		 *
		 * @var Instance variable
		 */
		private static $instance;

		/**
		 * Gets an instance of our plugin.
		 */
		public static function get_instance() {

			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor.
		 */
		private function __construct() {

			// minimum requirement for PHP version.
			$php = '5.4';

			// If current version is less than minimum requirement, display admin notice.
			if ( version_compare( PHP_VERSION, $php, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'php_version_notice' ) );
				return;
			}

			$this->define_constants();
			$this->load_files();
			$this->init_hooks();
			add_action( 'init', array( $this, 'bsf_changelog_init' ) );

			do_action( 'bsf_changelogs_loaded' );
		}
		/**
		 * Callback function for overide templates.
		 *
		 * @category InitCallBack
		 */
		function bsf_changelog_init() {
			$is_title_enabled = get_option( 'bsf_changelog_title' );
			if ( '' !== $is_title_enabled ) {
				add_filter( 'body_class', array( $this, 'bsf_changelogs_archive_title' ), 99 );
			}

			$is_cat_template_on = get_option( 'bsf_changelog_category_template' );
			if ( '1' === $is_cat_template_on || false === $is_cat_template_on ) {
				add_filter( 'template_include', array( $this, 'category_template' ), 99 );
				add_filter( 'body_class', array( $this, 'bsf_changelogs_body_tax_class' ) );
			}

			if ( ! ( '1' === $is_cat_template_on || false === $is_cat_template_on ) ) {
				add_filter( 'body_class', array( $this, 'bsf_single_product_body_class' ) );
			}

			add_action( 'bsf_changelog_after_version_content', array( $this, 'render_subversion_content' ) );
		}

		/**
		 * Render subversion content where $post_id set as Post Parent to other posts.
		 *
		 * @param int $id Post ID.
		 */
		public function render_subversion_content( $post_id ) {
			$args = array(
				'post_type'              => BSF_CHANGELOG_POST_TYPE,
				'posts_per_page'         => -1,
				'post_parent'            => get_the_ID(),
				'update_post_meta_cache' => false,
				'no_found_rows'          => true,
				'post_status'            => 'publish',
				'orderby'                => 'date',
				'fields'                 => 'ids',
				'order'                  => 'desc',
				'nopaging'               => true,
			);

			$sub_versions_query = new WP_Query( $args );

			if ( $sub_versions_query->have_posts() ) {
				?>
					<div class="bsf-sub-versions-wrapper">
						<div class="bsf-sub-versions-list">
							<?php
								while ( $sub_versions_query->have_posts() ) {
									$sub_versions_query->the_post();
									$post_id    = get_the_ID();
									$post_title = get_the_title();
									?>
										<div class="bsf-subversion-item">
											<h4 class="bsf-sub-version-title"><?php echo esc_attr( $post_title ); ?></h4>
											<span class="bsf-sub-version-date"> <?php echo get_the_date(); ?> </span>
											<div class="bsf-sub-version-content"><?php echo do_shortcode( get_the_content() ); ?></div>
										</div>
									<?php
								}
							?>
						</div>
						<div class="bsf-sub-versions-title">
							<span class="ast-subver-title"> <?php apply_filters( 'bsf_changelog_sub_version_show_text', _e( 'See More', 'bsf-changelog' ) ); ?> </span>
							<span class="bsf-subver-toggle">
								<svg class="ast-subver-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" width="16px" height="16.043px" viewBox="57 35.171 26 16.043" enable-background="new 57 35.171 26 16.043" xml:space="preserve"> <path d="M57.5,38.193l12.5,12.5l12.5-12.5l-2.5-2.5l-10,10l-10-10L57.5,38.193z"></path>
                				</svg>
							</span>
						</div>
					</div>
				<?php
				wp_reset_postdata();
			}
		}

		/**
		 * Initialization hooks
		 *
		 * @category Hooks
		 */
		function init_hooks() {
			register_activation_hook( BSF_CHANGELOG_BASE_FILE, array( $this, 'activation' ) );
			add_action( 'admin_menu', array( $this, 'register_options_menu' ), 10 );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_scripts' ), 10 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ), 10 );
			// Use this filter to overwrite archive page for bsf Changelogs post type.
			add_filter( 'archive_template', array( $this, 'get_bsf_changelog_archive_template' ) );
			// Call register settings function.
			add_action( 'admin_init', array( $this, 'register_bsf_changelogs_plugin_settings' ) );
		}

		/**
		 * Taxonomy Callback Function.
		 *
		 * @param array $template Overide taxonomy template.
		 */
		function category_template( $template ) {
			if ( is_tax( 'product' ) ) {
				$template = BSF_CHANGELOG_BASE_DIR . 'includes/changelog-taxonomy-template.php';
			}
			return $template;
		}

		/**
		 * Plugin activation hook.
		 *
		 * @author BrainstormForce
		 */
		function activation() {
			// Register post types.
			BSF_Changelog_post_Type::register_post_types();
			BSF_Changelog_post_Type::register_taxonomies();
			flush_rewrite_rules();

		}

		/**
		 * Add Class to body hooks
		 *
		 * @param array $classes It will add class to the body Changelog post.
		 * @category Hooks
		 * @return $classed
		 */
		function bsf_changelogs_archive_title( $classes ) {

			if ( is_post_type_archive( 'changelog' ) ) {
				$cls = array_merge( $classes, array( 'changelog-title-enabled' ) );
				return $cls;
			}
			return $classes;
		}

		/**
		 * Processes this test, when one of its tokens is encountered.
		 *
		 * @param Class-bsf-Changelogs-loader $classes load.
		 * @return $classes
		 */
		function bsf_changelogs_body_tax_class( $classes ) {

			if ( is_post_type_archive( 'changelog' ) || is_tax( 'product' ) && is_array( $classes ) ) {
				// Add clss to body.
				$cls = array_merge( $classes, array( 'product-tax-enabled' ) );
				return $cls;
			}
			return $classes;
		}

		/**
		 * Processes this test, when one of its tokens is encountered.
		 *
		 * @param Class-bsf-Changelogs-loader $classes load.
		 * @return $classes
		 */
		function bsf_single_product_body_class( $classes ) {

			if ( is_post_type_archive( 'changelog' ) && is_array( $classes ) ) {
				// Add clss to body.
				$cls = array_merge( $classes, array( 'single-product-enabled' ) );
				return $cls;
			}
			return $classes;
		}

		/**
		 * Register setting option variables.
		 */
		function register_bsf_changelogs_plugin_settings() {
			// Register our settings.
			register_setting( 'bsf-changelogs-settings-group', 'bsf_changelog_category_template' );
			register_setting( 'bsf-changelogs-settings-group', 'bsf_changelog_scroll_pagination' );
			register_setting( 'bsf-changelogs-settings-group', 'bsf_changelog_hide_featured_img' );
			register_setting( 'bsf-changelogs-settings-group', 'bsf_changelog_link_icon' );
			register_setting( 'bsf-changelogs-settings-group', 'bsf_changelog_title' );
			register_setting( 'bsf-changelogs-settings-group', 'bsf_changelog_sub_title' );
		}

		/**
		 * Regsiter option menu
		 *
		 * @category Filter
		 */
		function register_options_menu() {
			add_submenu_page(
				'edit.php?post_type=' . BSF_CHANGELOG_POST_TYPE,
				__( 'Changelog Settings', 'bsf-changelog' ),
				__( 'Changelog Settings', 'bsf-changelog' ),
				'manage_options',
				'bsf_changelog_settings',
				array( $this, 'render_changelog_options_page' )
			);
		}

		/**
		 * Includes options page
		 */
		function render_changelog_options_page() {
			require_once BSF_CHANGELOG_BASE_DIR . 'includes/bsf-changelog-options-page.php';
		}

		/**
		 * Shows an admin notice for outdated php version.
		 *
		 * @author BrainstormForce
		 */
		function php_version_notice() {

			$message = __( 'Your server seems to be running outdated, unsupported and vulnerable version of PHP. You are advised to contact your host provider and upgrade to PHP version 5.6 or greater.', 'bsf-changelog' );

			$this->render_admin_notice( $message, 'warning' );
		}

		/**
		 * Get Archive Template for the Changelogs base directory.
		 *
		 * @param int $archive_template Overirde archive templates.
		 * @author BrainstormForce
		 */
		function get_bsf_changelog_archive_template( $archive_template ) {

			if ( is_post_type_archive( BSF_CHANGELOG_POST_TYPE ) ) {
				$archive_template = BSF_CHANGELOG_BASE_DIR . 'includes/bsf-archive-template.php';
			}
			return $archive_template;
		}

		/**
		 * Get Single Page Template for Changelogs base directory.
		 *
		 * @param int $single_template Overirde single templates.
		 * @author BrainstormForce
		 */
		function get_bsf_changelogs_single_template( $single_template ) {

			if ( is_singular( 'changelog' ) ) {
				$single_template = BSF_CHANGELOG_BASE_DIR . 'includes/bsf-single-changelog-template.php';
			}
			return $single_template;
		}

		/**
		 * Renders an admin notice.
		 *
		 * @since 1.0
		 * @param string $message Error message.
		 * @param string $type Check type of user.
		 * @return void
		 */
		private function render_admin_notice( $message, $type = 'update' ) {

			if ( ! is_admin() ) {
				return;
			} elseif ( ! is_user_logged_in() ) {
				return;
			} elseif ( ! current_user_can( 'update_core' ) ) {
				return;
			}

			echo '<div class="' . $type . '">';
			echo '<p>' . $message . '</p>';
			echo '</div>';
		}

		/**
		 * Define constants.
		 *
		 * @since 1.0
		 * @return void
		 */
		private function define_constants() {

			$file = dirname( dirname( __FILE__ ) );

			define( 'BSF_CHANGELOG_VERSION', '1.0.7' );
			define( 'BSF_CHANGELOG_DIR_NAME', plugin_basename( $file ) );
			define( 'BSF_CHANGELOG_BASE_FILE', trailingslashit( $file ) . BSF_CHANGELOG_DIR_NAME . '.php' );
			define( 'BSF_CHANGELOG_BASE_DIR', plugin_dir_path( BSF_CHANGELOG_BASE_FILE ) );
			define( 'BSF_CHANGELOG_BASE_URL', plugins_url( '/', BSF_CHANGELOG_BASE_FILE ) );
			define( 'BSF_CHANGELOG_POST_TYPE', 'changelog' );
		}

		/**
		 * Loads classes and includes.
		 *
		 * @since 1.0
		 * @return void
		 */
		static private function load_files() {

			require_once BSF_CHANGELOG_BASE_DIR . 'classes/class-bsf-changelog-post-type.php';
			require_once BSF_CHANGELOG_BASE_DIR . 'includes/bsf-changelog-shortcode.php';
		}

		static function shorten_text($text, $length) {
			$text = preg_replace('/<!--(.|\s)*?-->/', '', $text);
			if (strlen($text) <= $length) {
				return $text;
			}

			$short_text = substr($text, 0, $length);

			$short_text = force_balance_tags($short_text) . '<span class="see-more-text">...See more</span>';
			$short_text = preg_replace('/<</', '<', $short_text);

			return $short_text;
		}


		/**
		 * Enqueue frontend scripts
		 *
		 * @since 1.0
		 */
		function enqueue_front_scripts() {
			if ( is_post_type_archive( 'changelog' ) || is_tax( 'product' ) ) {
				wp_enqueue_style( 'bsf-changelog-frontend-style', BSF_CHANGELOG_BASE_URL . 'assets/css/frontend.css' );
				wp_enqueue_script( 'bsf-changelog-frontend-script', BSF_CHANGELOG_BASE_URL . 'assets/js/frontend.js', array( 'jquery' ), BSF_CHANGELOG_VERSION, true );
				global $wp_query;
				wp_localize_script(
					'bsf-changelog-frontend-script',
					'bsf_pagination',
					array(
						'infinite_count' => 2,
						'hide_subversion_text' => apply_filters( 'bsf_changelog_sub_version_hide_text', __( 'Hide', 'bsf-changelog' ) ),
						'show_subversion_text' => apply_filters( 'bsf_changelog_sub_version_show_text', __( 'See More', 'bsf-changelog' ) ),
						'infinite_total' => $wp_query->max_num_pages,
					)
				);
			}
		}

		/**
		 * Enqueue admin scripts.
		 *
		 * @since 1.0
		 */
		function enqueue_admin_scripts() {
			wp_enqueue_style( 'bsf-changelog-options-style', BSF_CHANGELOG_BASE_URL . 'assets/css/admin.css' );
		}
	}

	$bsf_changelog_loader = Bsf_Changelog_Loader::get_instance();
}

