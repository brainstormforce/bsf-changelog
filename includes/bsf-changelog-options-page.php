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

		<h1><?php esc_html_e( 'Changelogs Settings', 'bsf-changelogs' ); ?></h1>
		<form method="post" action="options.php"> 
					<?php settings_fields( 'bsf-changelogs-settings-group' ); ?>
					<?php do_settings_sections( 'bsf-changelogs-settings-group' ); ?>

					<table  class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e( 'Do You Have Multiple Products?', 'bsf-changelogs' ); ?></th>
							<td>
								<?php
								$checked = '';
								$bsf_changelog_category_template = get_option( 'bsf_changelog_category_template' );
								$checked = ( false === $bsf_changelog_category_template ) ? " checked='checked' " : ( ( 1 == $bsf_changelog_category_template ) ? " checked='checked' " : '' );
								?>
								<input type="checkbox" <?php echo $checked; ?> name="bsf_changelog_category_template" value="1" <?php echo checked( 1, $checked, false ); ?> />
							</td>
						</tr>	
						<tr valign="top">
							<th scope="row"><?php _e( 'Changelog Page Title', 'bsf-changelogs' ); ?></th>
							<td>
								<input type="text" class="regular-text code" name="bsf_changelog_title" value="<?php echo get_option( 'bsf_changelog_title' ); ?> "/>
							</td>
						</tr>	
						<tr valign="top">
							<th scope="row"><?php _e( 'Changelog Page Sub-Title', 'bsf-changelogs' ); ?></th>
							<td>
								<input type="text" class="regular-text code" name="bsf_changelog_sub_title" value="<?php echo get_option( 'bsf_changelog_sub_title' ); ?> "/>
							</td>
						</tr>	
					</table>
				
						<?php submit_button(); ?>
		</form>
	</div>
	<div class="bsf-shortcodes-wrap">

		<h2 class="title"><?php _e( 'Shortcodes', 'bsf-changelogs' ); ?></h2>
		<p><?php _e( 'Copy below shortcode and paste it into your post, page, or text widget.', 'bsf-changelogs' ); ?></p>

		<div class="bsf-shortcode-container">
			<table class="form-table">
				<tr valign="top">
					 <th scope="row"><?php _e( "Display Products List", 'bsf-changelogs' ); ?></th>
					<td>
						   <div class="bsf-shortcode-container wp-ui-text-highlight">
							   [changelog_wp_category_list]
						   </div>  
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

