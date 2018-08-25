<?php
/**
 * Zhivo functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Zhivo
 */

if ( ! function_exists( 'zhivo_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function zhivo_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Zhivo, use a find and replace
		 * to change 'zhivo' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'zhivo', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Setup images sizes.
		add_image_size( 'zhivo-admin-thumb', 50, 50, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'zhivo' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'zhivo_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function zhivo_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'zhivo_content_width', 640 );
}
add_action( 'after_setup_theme', 'zhivo_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function zhivo_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'zhivo' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'zhivo' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'zhivo_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function zhivo_scripts() {
	wp_enqueue_style( 'zhivo-styles', get_template_directory_uri() . '/assets/css/styles.css' );

	wp_enqueue_script( 'zhivo-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'zhivo_scripts' );

function zhivo_admin_scripts( $hook ) {
	//wp_die( $hook );
	if ( $hook != 'edit.php' ) {
		return;
	}
	wp_enqueue_style( 'zhivo-admin-styles', get_template_directory_uri() . '/assets/css/admin-styles.css' );
	wp_enqueue_script( 'zhivo-admin-scripts', get_template_directory_uri() . '/assets/js/admin-scripts.js', array('jquery'), false, true );
}
add_action( 'admin_enqueue_scripts', 'zhivo_admin_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Custom theme functions.
 */
require get_template_directory() . '/inc/zhivo-functions.php';

/**
 * Carbon fields framework.
 */
function zhivo_crb_load() {
	load_template( get_template_directory() . '/libs/carbon-fields/vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'zhivo_crb_load' );

/**
 * Theme settings.
 */
require get_template_directory() . '/inc/theme-settings/settings.php';

/**
 * Register taxonomies.
 */
require get_template_directory() . '/inc/taxonomies/product-taxonomies.php';

/**
 * Register custom post types.
 */
require get_template_directory() . '/inc/custom-post-types/team-post-type.php';
require get_template_directory() . '/inc/custom-post-types/product-post-type.php';

/**
 * Register metaboxes.
 */
require get_template_directory() . '/inc/metaboxes/team-metaboxes.php';
require get_template_directory() . '/inc/metaboxes/product-metaboxes.php';

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
