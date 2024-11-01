<div class="wrap">
<?php screen_icon() ?>
<h2><?php _e( 'Theme Bakery', $this->textdoamin ) ?></h2>
<form action="" method="POST" class="">
	<table class="form-table"><tbody>
	<tr valign="top">
		<th scope="row"><label><?php _e( 'Theme Name', $this->textdoamin ) ?></label></th>
		<td>
			<input type="text" name="themename" id="themename" class="required" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label><?php _e( 'Theme ID', $this->textdoamin ) ?></label></th>
		<td>
			<input type="text" name="themeid" id="themeid" class="required" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label><?php _e( 'Theme Author', $this->textdoamin ) ?></label></th>
		<td>
			<input type="text" name="themeauthor" id="themeauthor" class="" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label><?php _e( 'Author URI', $this->textdoamin ) ?></label></th>
		<td>
			<input type="text" name="themeauthoruri" id="themeauthoruri" class="" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label><?php _e( 'Custom Header', $this->textdoamin ) ?></label></th>
		<td>
			<label><input type="checkbox" name="customheader" id="customheader" class="" value="1" checked /> <?php _e( 'Enable Custom Headers?', $this->textdomain ) ?></label>
			
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label><?php _e( 'Tweaks', $this->textdoamin ) ?></label></th>
		<td>
			<label><input type="checkbox" name="tweaks" id="teaks" class="" value="1" checked /> <?php _e( 'Enable tweaks.php file?', $this->textdomain ) ?></label>
			<p class="description"><?php _e( 'Custom functions that act independently of the theme templates.', $this->textdomain ) ?></p>
		</td>
	</tr>
	</tbody></table>
	<?php submit_button( __( 'Bake me a new theme!', $this->textdomain ) ); ?>
</form>
</div><!-- .wrap -->