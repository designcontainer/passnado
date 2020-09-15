<?php 

add_action('wp_dashboard_setup', 'passnado_dashboard_widgets');
  
function passnado_dashboard_widgets() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('passnado_widget', 'Passnado password protection', 'passnado_dashboard_widget_content');
}
 
function passnado_dashboard_widget_content() {
	echo '
	<style>
		.passnado-status {
			border-radius: 2px;
			padding: 20px 12px !important;
			margin: -12px -12px 20px -12px !important;
		}
		.passnado-status.active {
			background-color: #5ed569;
		}
		.passnado-status.not-active {
			background-color: #ffba00;
		}
		.passnado-settings-btn {
			margin-top: 20px !important;
		}
	</style>
	';

	$active_class = get_option( 'passnado_protect' ) ? 'active' : 'not-active';
	echo '<h3 class="passnado-status '.$active_class.'">Password protection is '; 
	echo get_option( 'passnado_protect' ) ? 'currently <b>active on this page!</b>' : '<b>not active on this page!</b>';
	echo '</h3>';

	if ( get_option('passnado_key') && get_option( 'passnado_protect' ) ) {
		echo '
		<h3>Passnado backdoor key is currently enabled</h3>
		<input type="text" style="width:100%" disabled="disabled" value="'.home_url().'?key='.get_option( 'passnado_key' ).'" />
		';
	}

	echo '<div><a href="'.admin_url().'options-general.php?page=passnado" class="passnado-settings-btn button button-primary" aria-label="Open passnado password settings"><span class="text">Open Passnado settings</span></a></div>';
}