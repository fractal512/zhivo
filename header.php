<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Zhivo
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'zhivo' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$zhivo_description = get_bloginfo( 'description', 'display' );
			if ( $zhivo_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $zhivo_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>
			
			<?php if ( carbon_get_theme_option( 'zhv_header_tagline' ) ) : ?>
				<p><?php echo carbon_get_theme_option( 'zhv_header_tagline' ); ?></p>
			<?php endif; ?>
			
			<?php
			$zhv_header_phones = carbon_get_theme_option( 'zhv_header_phones' );
			if( ! empty($zhv_header_phones) ):
			?>
			<ul class="header-phones">
			<?php
			$i = 0;
			foreach($zhv_header_phones as $zhv_header_phone):
			?>
				<li>
					<a class="phone icon" href="tel:<?php echo zhivo_sanitize_phone($zhv_header_phone['phone']); ?>"><?php echo $zhv_header_phone['phone']; ?></a>
				</li>
			<?php
			$i++;
			endforeach;
			?>
			</ul>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'zhivo' ); ?></button>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'menu-1',
				'menu_id'        => 'primary-menu',
			) );
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">