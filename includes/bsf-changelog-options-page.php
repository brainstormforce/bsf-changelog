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
			</table>
		</div>
	</div>
</div>

