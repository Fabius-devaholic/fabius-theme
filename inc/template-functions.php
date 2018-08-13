<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package fabius
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function fabius_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'fabius_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function fabius_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'fabius_pingback_header' );

/**
 * function get_template_part() passing variable
 */
function fabius_get_template_part( $template_name, $args = array(), $template_path = 'template-parts/' ) {
  if ( ! empty( $args ) && is_array( $args ) ) {
    extract( $args );
  }
  $template_name = $template_path . $template_name . '.php';
  $located = locate_template( $template_name );

  if ( !$located ) {
    _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_name ), '1.0' );
    return;
  }
  include( $located );
}
