<?php
/**
 * set a fake logged-in user cookie to break out of
 * wpe's caching as needed. Is only set if no other
 * CMS logged-in-user cookie has been set already.
 *
 * @return boolean true if new cookie set. false otherwise
 */
function maybe_set_user_cookie() {

	$cookie_was_set = false;

	if ( false === ($cook = has_logged_in_user_cookie()) ) {
		$expire = 0;
		set_fake_user_logged_in_cookie($expire);
		$cookie_was_set = true;
	}

	return $cookie_was_set;

}

# unset fake CMS user cookie
function remove_user_cookie() {
	$expired = time()-3600;
	set_fake_user_logged_in_cookie($expired);
}

function set_fake_user_logged_in_cookie($expire=0) {
	$fake_user = '_fake_user_';
	$cookie = 'wordpress_logged_in_' . md5($fake_user);
	$value = md5($fake_user);
	setcookie($cookie, $value, $expire, '/');
}

# determine if logged-in cookie is already set
function has_logged_in_user_cookie() {
	$patt = 'wordpress_logged_in_';
	foreach($_COOKIE as $cook => $val) {
		if( 0 === strpos($cook, $patt) ) {
			return $cook;
		}
	}
	return FALSE;
}