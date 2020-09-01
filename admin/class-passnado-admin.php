<?php 

// Enqueue scripts
function passnado_scripts() {
    add_action('admin_head', function() { 
		?><style type="text/css">
			#passnado-logo-preview img {
				width: 150px; height: auto; display: block;
			}
			#passnado-logo-preview {
				margin-bottom: 10px;
			}
		</style><?php 
    }, 10);

    add_action('admin_enqueue_scripts', function(){
	    if( empty( $_GET['page'] ) || "passnado" !== $_GET['page'] ) { return; }
    	wp_enqueue_script('passnado-admin', plugin_dir_url(__FILE__) . '/js/class-passnado-admin.js');
	    wp_enqueue_media();
	});
}



// Registering settings
function passnado_register_settings() {
	register_setting( 'passnado_options_group', 'passnado_protect' );
	register_setting( 'passnado_options_group', 'passnado_key' );
	register_setting( 'passnado_options_group', 'passnado_logo' );
	register_setting( 'passnado_options_group', 'passnado_message_title' );
	register_setting( 'passnado_options_group', 'passnado_message_text' );
	register_setting( 'passnado_options_group', 'passnado_redirect' );
	register_setting( 'passnado_options_group', 'passnado_login_link_show' );
	register_setting( 'passnado_options_group', 'passnado_login_link_text' );
}

// Output options page
function passnado_options_page() { ?>
	<div class="wrap">
		<h1>Passnado settings</h1>
		<form method="post" action="options.php">
		<?php settings_fields( 'passnado_options_group' ); ?>
			<h2 class="title">Password protection</h2>
			<p>This will password protect the whole site.</p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">Enable password protection</th>
						<td>
							<fieldset>
								<input id="passnado_protect" name="passnado_protect" type="checkbox" value="1"<?php checked(get_option( 'passnado_protect' )); ?>>
								<label for="passnado_protect">Enable</label>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>
			<h2 class="title">Key parameter</h2>
			<p>Use this key to access site without having to log in. Leave this field blank if you don't wish to use this feature.</br>Example: <?php echo home_url(); ?>/?key=YOUR_KEY_HERE</p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">Key parameter code</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Key parameter code</span></legend> 
								<input class="regular-text code" id="passnado_key" value="<?php echo get_option('passnado_key'); ?>" min="0" name="passnado_key" type="text">
								<button type="button" class="button button-primary passnado-generate-key wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Generate key">
									<span class="dashicons dashicons-admin-network" aria-hidden="true"></span>
									<span class="text">Generate key</span>
								</button>
								<button type="button" class="button passnado-copy-key-url wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="Copy preview URL" data-site-url="<?php echo home_url(); ?>">
									<span class="text">Copy link</span>
								</button>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>

			<h2 class="title">Edit message</h2>
			<p>Edit these fields to replace the default login message.</p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">Title</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Title</span></legend> 
								<input placeholder="This website is protected" class="regular-text code" id="passnado_message_title" value="<?php echo get_option('passnado_message_title'); ?>" min="0" name="passnado_message_title" type="text">
								<br>
							</fieldset>
						</td>
					</tr>
					<tr>
						<th scope="row">Text</th>
						<td>
							<fieldset>
								<legend class="screen-reader-text"><span>Text</span></legend> 
								<input placeholder="Please login to view this website" class="regular-text code" id="passnado_message_text" value="<?php echo get_option('passnado_message_text'); ?>" min="0" name="passnado_message_text" type="text">
								<br>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>

			<h2 class="title">Redirect to a page</h2>
			<p>Get a custom greeting screen by redirecting to a page</p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr valign="top"><th scope="row">Choose a page</th>
						<td>
							<select name="passnado_redirect">
								<?php $pageID = get_option('passnado_redirect'); ?>
								<option value="false" <?php echo selected( $page->ID, $pageID, false ); ?>>Don't redirect</option>
								<?php if( $pages = get_pages() ){
									foreach( $pages as $page ){
										echo '<option value="' . $page->ID . '" ' . selected( $page->ID, $pageID, false ) . '>' . $page->post_title . '</option>';
									}
								} ?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>

			<h2 class="title">Login</h2>
			<p>Edit these fields to add a login link to the screen, as well as add a custom logo to the login page.</p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label for="passnado_login_link_show">Show login link</label></th>
						<td>
							<input id="passnado_login_link_show" name="passnado_login_link_show" type="checkbox" value="1"<?php checked(get_option( 'passnado_login_link_show' )); ?>>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="passnado_login_link_show">Login Link Text</label></th>
						<td>
							<input placeholder="Login" class="regular-text code" id="passnado_login_link_text" value="<?php echo get_option('passnado_login_link_text'); ?>" min="0" name="passnado_login_link_text" type="text">
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="passnado_logo">Custom Login Page Logo</label></th>
						<td>
							<fieldset>
								<?php $logoId = get_option('passnado_logo'); ?>
								<div id="passnado-logo-preview" class="<?php echo ((empty($logoId)) ? 'hidden' : ''); ?>">
									<?php if (!empty($logoId)) { 
										echo wp_get_attachment_image($logoId, 'full'); 
									} ?>
								</div>

								<input type="hidden" id="passnado_logo" name="passnado_logo" />
								<button class="button passnado-logo-upload">Upload</button>
								<a href="#" class="passnado-logo-clear <?php echo ((empty($logoId)) ? 'hidden' : ''); ?>">Clear</a>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>
		<?php submit_button(); ?>
		</form>
	</div>
<?php }

// Adding the options page
function passnado_register_options_page() {
	add_options_page('Passnado', 'Password protection', 'manage_options', 'passnado', 'passnado_options_page');
}


if (is_admin()) {
	add_action('admin_menu', 'passnado_register_options_page');
	add_action('admin_init', 'passnado_register_settings');
	add_action('admin_init', 'passnado_scripts'); 
}
