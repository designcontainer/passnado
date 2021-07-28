<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link  https://designcontainer.no
 * @since 2.0.0
 *
 * @package    Passnado
 * @subpackage Passnado/public/partials
 */
?>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Protected webiste</title>
	<link rel="stylesheet" href="<?php echo plugin_dir_url(dirname(__DIR__)) . 'build/css/app.css'; ?>">
	<style>
		.passnado-message {
			--passnado-message-color: <?php echo get_option('passnado_message_color'); ?>;
		}
	</style>
</head>

<body class="passnado-message <?php printf('passnado-message--%s ', get_option('passnado_message_layout')); ?>">
	<div class="container">
		<header>
			<svg class="lock-icon" viewBox="0 0 24 24" width="48" height="48" fill="none" xmlns="http://www.w3.org/2000/svg">
				<style>
					@keyframes slide-top {
						0% {
							transform: translateY(0)
						}

						to {
							transform: translateY(1.5px)
						}
					}
				</style>
				<path d="M14.5 8V6a2.5 2.5 0 00-5 0v4c0 .356.074.694.208 1H8.126A4.007 4.007 0 018 10V6a4 4 0 118 0v2l-.083.051c-.44.272-.999.252-1.417-.051z" style="animation:slide-top 2s cubic-bezier(.74,-.11,0,1.36) infinite both alternate" />
				<path fill-rule="evenodd" clip-rule="evenodd" d="M8 10a3 3 0 00-3 3v5a3 3 0 003 3h8a3 3 0 003-3v-5a3 3 0 00-3-3H8zm4 4a1 1 0 00-1 1v1a1 1 0 102 0v-1a1 1 0 00-1-1z" />
			</svg>
		</header>
		<section class="content">
			<?php if ($title = get_option('passnado_message_title')) : ?>
				<h1><?php echo $title; ?></h1>
			<?php endif; ?>
			<?php if ($text = get_option('passnado_message_text')) : ?>
				<p><?php echo $text; ?></p>
			<?php endif; ?>
			<?php if ($login_label = get_option('passnado_login_link_text')) : ?>
				<a href="<?php echo wp_login_url(); ?>" class="button"><?php echo $login_label; ?></a>
			<?php endif; ?>
		</section>
	</div>
</body>

</html>