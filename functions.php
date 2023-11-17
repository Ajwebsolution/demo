<?php

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
	$parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
	$theme        = wp_get_theme();
	wp_enqueue_style( $parenthandle,
		get_template_directory_uri() . '/style.css',
		array(),  // If the parent theme code has a dependency, copy it to here.
		$theme->parent()->get( 'Version' )
	);
	wp_enqueue_style( 'child-style',
		get_stylesheet_uri(),
		array( $parenthandle ),
		//$theme->get( 'Version' ) // This only works if you have Version defined in the style header.
	);

	wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2');

    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), '4.5.2', true);
}


//Register theme custom post types
function register_custom_post_types() {

	register_post_type( 'articles', [
		'labels'    => [
			'name'          => __( 'News Articles' ),
			'singular_name' => __( 'News Article' ),
			'menu_name'     => __( 'News Articles' ),
		],
		'public'    => true,
		'menu_icon' => 'dashicons-welcome-widgets-menus',
		'rewrite'   => [ 'slug' => 'news' ],
		'supports'  => [ 'title','excerpt','editor', 'thumbnail' ]
	] );
}

add_action( 'init', 'register_custom_post_types' );

//register taxonomy
function register_taxonomies() {

	register_taxonomy( 'articles_cat', [ 'articles' ], [
		'labels'            => [
			'name'          => __( 'Categories' ),
			'singular_name' => __( 'Category' ),
			'menu_name'     => __( 'Categories' ),
		],
		'hierarchical'      => true,
		'show_admin_column' => true,
		'rewrite'           => [ 'slug' => 'cat' ]
	] );
}

add_action( 'init', 'register_taxonomies' );


function register_child_theme_menus() {
    register_nav_menus(
        array(
            'primary-menu' => esc_html__('Primary Menu', 'your-text-domain'),
        )
    );
}
add_action('after_setup_theme', 'register_child_theme_menus');