<div class="wrap"> 
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<div class="myofs-layout" id="myofs-layout__notice-list"></div>
    <form method="POST" action="" name="license_key" id="myofs-activate-keys">
	    <div id="myofs-license-container">
            <h2><?php esc_html_e( 'Active License', 'my-online-fashion-store' ); ?></h2> 
        	<table class="form-table">  
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Email', 'my-online-fashion-store' ); ?></th>						
						<td><input type="text" name="activation_email" value=""></td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'License Key', 'my-online-fashion-store' ); ?></th>						
						<td><input type="text" name="activation_key" value=""></td>
					</tr>
					<tr>
						<th scope="row" colspan="3">
							<input type="hidden" name="action" value="myofs_activate_keys">
							<input type="submit" name="submit" value="Activate" class="button button-primary">
							<div class="spin_main" style="display: none">
								<div class="spin"></div>
							</div>
						</th>
					</tr>
				</tbody>
			</table>
	    </div>
    </form>
	<input value="<?php echo admin_url('admin-ajax.php'); ?>" id="admin-url" class="admin-url" type="hidden" />

</div><!-- .wrap -->
