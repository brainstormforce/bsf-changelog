<tr class="form-field term-group-wrap">
	<th scope="row">
		<label for="doc-changelog-file-url"><?php _e( 'Changelog Raw File URL', 'bsf-changelog' ); ?></label>
	</th>
	<td>
		<input type="text" placeholder="https://raw.githubusercontent.com/brainstormforce/bsf-products/master/astra/changelog.txt" name="term_meta[changelog-file-url]" class="doc-changelog-file-url" id="doc-changelog-file-url" value="<?php echo esc_url( $changelog_file_url ); ?>"/>
		<p class="description">
			<?php _e( 'This URL will be use to redirect users when click on "More Details".', 'bsf-changelog' ); ?>
		</p>
	</td>
</tr>
