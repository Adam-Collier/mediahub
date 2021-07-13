<?php
/**
 * mediahub functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mediahub
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'mediahub_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mediahub_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on mediahub, use a find and replace
		 * to change 'mediahub' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mediahub', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'mediahub' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'mediahub_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'mediahub_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mediahub_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mediahub_content_width', 640 );
}
add_action( 'after_setup_theme', 'mediahub_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mediahub_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'mediahub' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'mediahub' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mediahub_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mediahub_scripts() {
	wp_enqueue_style( 'mediahub-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'mediahub-style', 'rtl', 'replace' );

	wp_enqueue_script( 'mediahub-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mediahub_scripts' );

/**
 * Add editor styles
 */
add_theme_support( 'editor-styles' );
add_editor_style('editor-styles.css');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Add the copyToClipboard script for all of the posts
 */

if ( is_singular() ) {
	// $modifiedDate  = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'js/copy-to-clipboard.js' ));
}

function copy_to_clipboard_script () {
	wp_enqueue_script( 'copy-to-clipboard', get_template_directory_uri() . '/js/copy-to-clipboard.js', array(), "1.0.0", true );
}

add_action( 'wp_enqueue_scripts', 'copy_to_clipboard_script' );

/**
 * Add a custom handelbars helper
 */
function if_equals_handlebars_helper ( $handlebars ) {
    $handlebars->registerHelper( 'ifEq', function( $arg1, $arg2, $options ) {
        return ($arg1 === $arg2) ? $options['fn']() : $options['inverse']();
    });
}

add_action( 'lzb/handlebars/object', 'if_equals_handlebars_helper' );

/**
 * Add a custom handelbars helper to display territories
 * The general idea is taken from this example: https://github.com/XaminProject/handlebars.php/blob/master/src/Handlebars/Helper/EachHelper.php
 */

function terr_handlebars_helper ( $handlebars ) {
    $handlebars->registerHelper( 'terr', function( $arg1, $options ) {
		// all of the territories we want to show
		$territories = ["AU", "DE", "ES", "EU", "FR", "IE", "PL", "UK", "US"];

		$buffer = "";

		$context = $options['context'];
		$template = $options['template'];

		foreach($territories as $territory) {
			if(in_array($territory, $arg1)){
				$context->push(array("territory" => $territory, "active" => true));
			} else {
				$context->push(array("territory" => $territory, "active" => false));
			}

			$buffer .= $template->render($context);
		}

		return $buffer;
    });
}

add_action( 'lzb/handlebars/object', 'terr_handlebars_helper' );

function modified_handlebars_helper ( $handlebars ) {
    $handlebars->registerHelper( 'modified', function( $options ) {

		$buffer = "";

		$context = $options['context'];
		$template = $options['template'];

		$author = get_the_modified_author();
		$date = get_the_modified_date();

		$context->push(array("author" => $author, "date" => $date));

		$buffer .= $template->render($context);

		return $buffer;
    });
}

add_action( 'lzb/handlebars/object', 'modified_handlebars_helper' );

function copy_handlebars_helper ( $handlebars ) {
    $handlebars->registerHelper( 'copy', function( $options ) {
		$html = '<svg onClick="copyToClipboard(this)" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-copy"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>';

		return new \Handlebars\SafeString($html);
    });
}

add_action( 'lzb/handlebars/object', 'copy_handlebars_helper' );

/**
 * Add more images sizes to we can create some responsive images
 */

 function add_image_sizes() {
	add_image_size( 'campaign-0.5x', 165, 186.5 );
    add_image_size( 'campaign', 330, 373 );
	add_image_size( 'campaign-1.5x', 495, 559.5 );	
	add_image_size( 'campaign-2x', 660, 746 );
}
add_action( 'after_setup_theme', 'add_image_sizes' );