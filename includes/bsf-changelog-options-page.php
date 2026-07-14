<?php
/**
 * Live search options page
 *
 * @package Live search options page
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

?>

<div class="wrap">
	<div class="bsf-options-form-wrap clearfix">

		<h1><?php esc_html_e( 'Changelogs Settings', 'bsf-changelog' ); ?></h1>
		<form method="post" action="options.php">
					<?php settings_fields( 'bsf-changelogs-settings-group' ); ?>
					<?php do_settings_sections( 'bsf-changelogs-settings-group' ); ?>
					<table  class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e( 'Do You Have Multiple Products?', 'bsf-changelog' ); ?></th>
							<td>
								<?php
								$bsf_changelog_category_template = get_option( 'bsf_changelog_category_template' );
								if ( isset( $bsf_changelog_category_template ) && '1' === $bsf_changelog_category_template || 'yes' === $bsf_changelog_category_template ) {
									echo '<input type="checkbox" checked name="bsf_changelog_category_template" value="1">';
								} else {
									echo '<input type="checkbox" name="bsf_changelog_category_template" value="1">';
								}
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Enable Infinite Scroll pagination?', 'bsf-changelog' ); ?></th>
							<td>
								<?php
								$bsf_changelog_scroll_pagination = get_option( 'bsf_changelog_scroll_pagination' );
								if ( isset( $bsf_changelog_scroll_pagination ) && '1' === $bsf_changelog_scroll_pagination || 'yes' === $bsf_changelog_scroll_pagination ) {
									echo '<input type="checkbox" checked name="bsf_changelog_scroll_pagination" value="1">';
								} else {
									echo '<input type="checkbox" name="bsf_changelog_scroll_pagination" value="1">';
								}
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Hide Featured Image when content is expanded?', 'bsf-changelog' ); ?></th>
							<td>
								<?php
								$bsf_changelog_hide_featured_img = get_option( 'bsf_changelog_hide_featured_img' );
								if ( isset( $bsf_changelog_hide_featured_img ) && '1' === $bsf_changelog_hide_featured_img || 'yes' === $bsf_changelog_hide_featured_img ) {
									echo '<input type="checkbox" checked name="bsf_changelog_hide_featured_img" value="1">';
								} else {
									echo '<input type="checkbox" name="bsf_changelog_hide_featured_img" value="1">';
								}
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Enable link icon for Changelog title?', 'bsf-changelog' ); ?></th>
							<td>
								<?php
								$bsf_changelog_link_icon = get_option( 'bsf_changelog_link_icon' );
								if ( isset( $bsf_changelog_link_icon ) && '1' === $bsf_changelog_link_icon || 'yes' === $bsf_changelog_link_icon ) {
									echo '<input type="checkbox" checked name="bsf_changelog_link_icon" value="1">';
								} else {
									echo '<input type="checkbox" name="bsf_changelog_link_icon" value="1">';
								}
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Expand sub versions by default?', 'bsf-changelog' ); ?></th>
							<td>
								<?php
								$bsf_changelog_expand_subversions_default = get_option( 'bsf_changelog_expand_subversions_default' );
								if ( isset( $bsf_changelog_expand_subversions_default ) && '1' === $bsf_changelog_expand_subversions_default || 'yes' === $bsf_changelog_expand_subversions_default ) {
									echo '<input type="checkbox" checked name="bsf_changelog_expand_subversions_default" value="1">';
								} else {
									echo '<input type="checkbox" name="bsf_changelog_expand_subversions_default" value="1">';
								}
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Show Product Tabs on Archive Page?', 'bsf-changelog' ); ?></th>
							<td>
								<?php
								$bsf_changelog_enable_product_tabs = get_option( 'bsf_changelog_enable_product_tabs' );
								if ( isset( $bsf_changelog_enable_product_tabs ) && '1' === $bsf_changelog_enable_product_tabs || 'yes' === $bsf_changelog_enable_product_tabs ) {
									echo '<input type="checkbox" checked name="bsf_changelog_enable_product_tabs" value="1">';
								} else {
									echo '<input type="checkbox" name="bsf_changelog_enable_product_tabs" value="1">';
								}
								?>
								<p class="description"><?php _e( 'Shows a tab for each product on the main Changelog archive page, so visitors can switch between products without leaving the page. Off by default.', 'bsf-changelog' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Product Tabs Order', 'bsf-changelog' ); ?></th>
							<td>
								<input type="text" class="regular-text code" placeholder="product-one, product-two, product-three" name="bsf_changelog_product_tabs_order" value="<?php echo esc_attr( get_option( 'bsf_changelog_product_tabs_order' ) ); ?>"/>
								<p class="description"><?php _e( 'Optional. Comma-separated product slugs, in the order you want the tabs to appear. The first one listed is shown by default. Leave blank to show every product in its default order.', 'bsf-changelog' ); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Changelog Page Title', 'bsf-changelog' ); ?></th>
							<td>
								<?php
									$default_title = get_option( 'bsf_changelog_title' );
									$default_title = 'Changelog Title Area';
								?>
								<input type="text" class="regular-text code" name="bsf_changelog_title" value="<?php echo get_option( 'bsf_changelog_title' ); ?> "/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Changelog Page Sub-Title', 'bsf-changelog' ); ?></th>
							<td>
								<input type="text" class="regular-text code" name="bsf_changelog_sub_title" value="<?php echo get_option( 'bsf_changelog_sub_title' ); ?> "/>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Changelog Raw File URL', 'bsf-changelog' ); ?></th>
							<td>
								<input type="text" placeholder="https://raw.githubusercontent.com/brainstormforce/bsf-products/master/astra/changelog.txt" class="regular-text code" name="bsf_changelog_default_raw_url" value="<?php echo get_option( 'bsf_changelog_default_raw_url' ); ?>"/>
								<p class="description"> <em>
									<?php _e( 'This URL will be use to redirect users when click on "More Details".', 'bsf-changelog' ); ?>
								</em> </p>
								<p class="description"> <em>
									<?php echo sprintf( '%s <a href="%s">%s</a> %s', __( 'For multiple products', 'bsf-changelog' ), esc_url( admin_url( '/edit-tags.php?taxonomy=product&post_type=' . BSF_CHANGELOG_POST_TYPE ) ), __( 'Edit Product category', 'bsf-changelog' ), __( '& provide link there.', 'bsf-changelog' ) ) ?>
								</em> </p>
							</td>
						</tr>
					</table>
				<?php submit_button(); ?>
		</form>
	</div>
	<div class="bsf-shortcodes-wrap">

		<h2 class="title"><?php _e( 'Shortcodes', 'bsf-changelog' ); ?></h2>
		<p><?php _e( 'Copy below shortcode and paste it into your post, page, or text widget.', 'bsf-changelog' ); ?></p>

		<div class="bsf-shortcode-container">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e( 'Display Products List', 'bsf-changelog' ); ?></th>
				<td>
						<div class="bsf-shortcode-container wp-ui-text-highlight">
							[changelog_product_list]
						</div>
		</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php _e( 'Display Product Tabs', 'bsf-changelog' ); ?></th>
				<td>
						<div class="bsf-shortcode-container wp-ui-text-highlight">
							[changelog_product_tabs]
						</div>
						<p class="description">
							<?php _e( 'Shows the same product tabs available on the archive page, anywhere you place this shortcode. Optional attributes:', 'bsf-changelog' ); ?>
							<br />
							<code>products</code> &mdash; <?php _e( 'comma-separated product slugs to show and their order, e.g. products="product-one,product-two". Defaults to every product.', 'bsf-changelog' ); ?>
							<br />
							<code>default</code> &mdash; <?php _e( 'slug of the tab to show first, e.g. default="product-two". Defaults to the first tab.', 'bsf-changelog' ); ?>
							<br />
							<code>limit</code> &mdash; <?php _e( 'max versions shown per tab before a "View all" link takes over, e.g. limit="10". Defaults to 15.', 'bsf-changelog' ); ?>
						</p>
		</td>
				</tr>
			</table>
		</div>
	</div>
</div>

