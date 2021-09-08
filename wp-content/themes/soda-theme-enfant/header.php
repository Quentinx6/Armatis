<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BuddyBoss_Theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php wp_head(); ?>
	</head>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Comfortaa&display=swap');
		@import url('https://fonts.googleapis.com/css?family=Pacifico&display=swap');

		loader
		{
			position: fixed;
			width: 100%;
			height: 100%;
			background: #F2F8FD;
			z-index: 1236;
			display: flex;
			justify-content: center;
			align-items: center;
			transition: .5s;
			top: 0; 
			left: 0;
		}

		.loaderFinished
		{
			opacity: 0;
		}

		.soda
		{
			position: relative;
			width: 200px;
			height: 200px;
			background: #3C4042;
			border-radius: 50%;
			box-shadow: inset 0 0 50px #00000080;
			overflow: hidden;
		}

		.soda p
		{
			position: absolute;
    	top: 50%;
			left: 50%;
			z-index: 12;
			color: white;
			transform: translate(-50%, -50%);
			font-size: 34px;
			font-weight: 200;
			font-family: sans-serif;
			font-family: "Comfortaa";
		}

		.soda p span
		{
			width: 100px;
			font-size: 12px;
			position: absolute;
			bottom: -70%;
			left: 25%;
			font-family: "Pacifico";
		}

		.soda::before
		{
			content: '';
			position: absolute;
			/* top: -30%; */
			left: 50%;
			width: 300px;
			height: 300px;
			border-radius: 40%;
			background: #F2F8FD;
			transform: translate(-50%, -50%);
			opacity: .6;
			animation: liquid1 2s linear alternate infinite;
		}

		.soda::after
		{
			content: '';
			position: absolute;
			/* top: -30%; */
			left: 50%;
			width: 300px;
			height: 300px;
			border-radius: 40%;
			background: #F2F8FD;
			transform: translate(-50%, -50%);
			opacity: .3;
			animation: liquid2 2s linear alternate infinite;
		}

		
		@keyframes liquid1
		{
			0%
			{
				top: 40%;
				transform: translate(-50%, -50%) rotate(0deg);
			}
			100%
			{
				top: -90%;
				transform: translate(-50%, -50%) rotate(360deg);
			}
		}

		@keyframes liquid2
		{
			0%
			{
				top: 40%;
				transform: translate(-50%, -50%) rotate(360deg);
			}
			100%
			{
				top: -90%;
				transform: translate(-50%, -50%) rotate(0deg);
			}
		}
	</style>

	<body <?php body_class(); ?>>

		<loader>
      <div class="soda">
        <p>Soda<span>Weez me UP</span></p>
      </div>
		</loader>

		<?php if (!is_singular('llms_my_certificate')):
		 
			do_action( THEME_HOOK_PREFIX . 'before_page' ); 
	
		endif; ?>

		<div id="page" class="site">

			<?php do_action( THEME_HOOK_PREFIX . 'before_header' ); ?>

			<header id="masthead" class="<?php echo apply_filters( 'buddyboss_site_header_class', 'site-header' ); ?>">
				<?php do_action( THEME_HOOK_PREFIX . 'header' ); ?>
			</header>

			<?php do_action( THEME_HOOK_PREFIX . 'after_header' ); ?>

			<?php do_action( THEME_HOOK_PREFIX . 'before_content' ); ?>

			<div id="content" class="site-content">

				<?php do_action( THEME_HOOK_PREFIX . 'begin_content' ); ?>

				<div class="container">
					<div class="<?php echo apply_filters( 'buddyboss_site_content_grid_class', 'bb-grid site-content-grid' ); ?>">
