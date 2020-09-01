<?php

function passnado_set_cookie() {
	setcookie('passnado_key', get_option('passnado_key'), 0, "/");
}

function passnado_protection() {
	if(get_option( 'passnado_protect' )) {
		if( ! is_user_logged_in() ) {
			if ( get_option('passnado_redirect') !== 'false' ) {
				$redirectID = get_option('passnado_redirect');
				redirectToPage($redirectID);
			} else {
				passnado_message();
				die();
			}
		}
	}
}

function passnado_protection_with_key() {
	if(get_option( 'passnado_protect' )) {
		if($_COOKIE['passnado_key'] !== get_option('passnado_key')) {
			if( ! is_user_logged_in() ) {
				if($_GET['key'] !== get_option('passnado_key')) {
					if ( get_option('passnado_redirect') !== 'false' ) {
						$redirectID = get_option('passnado_redirect');
						redirectToPage($redirectID);
					} else {
						passnado_message();
						die();       
					}
				} else {
					passnado_set_cookie();
					maybe_set_user_cookie();
				}
			}
		}
	}
}

function passnado_update_login_logo($logoId) {
	add_filter( 'login_headerurl', 'passnado_custom_login_url' );
	function passnado_custom_login_url($url) {
	    return get_bloginfo('url');
	}

	function passnado_login_logo() { 
		$logoId = get_option('passnado_logo');
		$logoSrc = wp_get_attachment_image_src($logoId, 'full');
		$ratio = 150/$logoSrc[1];
		$w = ceil($logoSrc[1]*$ratio);
		$h = ceil($logoSrc[2]*$ratio);
		if (empty($logoSrc[0])) return '';
		?>
	    <style type="text/css">
	        #login h1 a, .login h1 a {
	            background-image: url(<?php echo $logoSrc[0]; ?>);
			height:<?php echo $h; ?>px;
			width:<?php echo $w; ?>px;
			background-size: <?php echo $w; ?>px <?php echo $h; ?>px;
			background-repeat: no-repeat;
	        	padding-bottom: 30px;
	        }
	    </style>
	<?php }
	add_action( 'login_enqueue_scripts', 'passnado_login_logo' );
}

function redirectToPage($redirectID) {
	$currentURL = get_the_permalink();
	$url = get_the_permalink($redirectID);
	if ( $currentURL != $url ) {
		header("HTTP/1.1 301 Moved Permanently");
		header('Location: '.$url);
		exit;
	}
}

if ( $GLOBALS['pagenow'] === 'wp-login.php' && ($logoId = get_option('passnado_logo'))) {
	passnado_update_login_logo($logoId);
}

if( get_option('passnado_key') ) {
	add_action( 'template_redirect', 'passnado_protection_with_key' ); 
} else {
	add_action( 'template_redirect', 'passnado_protection' ); 
}
