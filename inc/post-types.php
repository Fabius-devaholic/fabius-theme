<?php
/**
 * @package fabius
 */

class FabiusCustomPostType {
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $post_types = array();

  /**
   * Start up
   */
  public function __construct() {
    $this->create_post_types();
    add_action( 'init', array( $this, 'register_post_type' ) );
  }

  public function create_post_types() {
    $this->post_types = [
      'event' => [
        'labels'                => [
          'name'               => _x( 'Events', 'post type general name', 'fabius' ),
          'singular_name'      => _x( 'Event', 'post type singular name', 'fabius' ),
          'menu_name'          => _x( 'Events', 'admin menu', 'fabius' ),
          'name_admin_bar'     => _x( 'Event', 'add new on admin bar', 'fabius' ),
          'add_new'            => __( 'Add New', 'Event', 'fabius' ),
          'add_new_item'       => __( 'Add New Event', 'fabius' ),
          'new_item'           => __( 'New Event', 'fabius' ),
          'edit_item'          => __( 'Edit Event', 'fabius' ),
          'view_item'          => __( 'View Event', 'fabius' ),
          'all_items'          => __( 'All Events', 'fabius' ),
          'search_items'       => __( 'Search Events', 'fabius' ),
          'parent_item_colon'  => __( 'Parent Events:', 'fabius' ),
          'not_found'          => __( 'No Events found.', 'fabius' ),
          'not_found_in_trash' => __( 'No Events found in Trash.', 'fabius' )
        ],
        'description'           => __( 'Description.', 'fabius' ),
        'public'                => false,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'show_in_rest'          => true,
        'rest_base'             => 'events',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'menu_icon'             => 'dashicons-megaphone',
        'supports'              => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ]
      ],
    ];
  }

  public function register_post_type() {
    foreach( $this->post_types as $type => $args ) {
      register_post_type( $type, $args );
    }
  }

}

$custom_post_type = new FabiusCustomPostType();
