<?php
/*
 * Remove &nbsp dos posts;
*/
function remove_empty_lines( $content ){
    $content = preg_replace("/&nbsp;/", "", $content);
    return $content;
}
add_action('content_save_pre', 'remove_empty_lines');

/**
 * Thumbnails no wordpress
 */
add_theme_support( 'post-thumbnails' );
/**
 * Tamanhos das imagens para thumbs
 */
//add_image_size( 'thumb-card', 330, 248, true );

/**
 * Habilita o Title no wordpress
 */
add_theme_support( 'title-tag' );
/**
 * Remove scripts e estilos nativos do wordpress
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Adiciona os estilos e scripts do tema
 */
function add_estilos_e_scripts() {
	// Estilos
	wp_enqueue_style( 'css', get_template_directory_uri() . '/style.css');

	// Fontes
	wp_enqueue_style( 'fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700');

	// Scripts
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-3.3.1.min.js', array(), '3.3.1', true );
	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/scripts.js', array(), '', true );
}
add_action( 'wp_enqueue_scripts', 'add_estilos_e_scripts' );

/**
 * Adiciona div responsiva para oEmbeds
 */
function responsive_embed_html( $html, $url ) {
    if ( preg_match( '/youtube.com/', $url ) || preg_match( '/vimeo.com/', $url ) ) {
        return '<div class="videoWrapper">' . $html . '</div>';
    } else {
        return $html;
    }
}

add_filter( 'embed_oembed_html', 'responsive_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'responsive_embed_html' );

/**
 * Remove o meta generator do Wordpress
 */
remove_action('wp_head', 'wp_generator');

/**
 * Posições de Menu
function register_my_menu() {
	register_nav_menu('header-menu',__( 'Header Menu' ));
}
add_action( 'init', 'register_my_menu' ); */

/**
 * Ajustes do admin bar
 */
add_action('wp_footer', 'preferencias_admin_bar');
function preferencias_admin_bar() {
    $op = '
    <style type="text/css">
        html {margin-top: 0px !important;}
        @media (max-width: 400px) {
            html {margin-top: 0 !important;}
            #wpadminbar {top: 0}
        }
    </style> ';
    echo $op;
}