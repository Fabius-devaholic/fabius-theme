<?php
/**
 * @package fabius
 */

class FabiusCustomTaxonomy {
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $taxonomies = array();

  /**
   * Start up
   */
  public function __construct() {
    $this->create_taxonomies();
    add_action( 'init', array( $this, 'register_taxonomies' ) );
  }

  public function create_taxonomies() {
    $this->taxonomies = [
      'event_type' => [
        'object_type'           => 'event', // Post type
        'labels'                => [
          'name'              => _x( 'Event Types', 'taxonomy general name', 'fabius' ),
          'singular_name'     => _x( 'Event Type', 'taxonomy singular name', 'fabius' ),
          'search_items'      => __( 'Search Event Types', 'fabius' ),
          'all_items'         => __( 'All Event Types', 'fabius' ),
          'parent_item'       => __( 'Parent Type', 'fabius' ),
          'parent_item_colon' => __( 'Parent Type:', 'fabius' ),
          'edit_item'         => __( 'Edit Type', 'fabius' ),
          'update_item'       => __( 'Update Type', 'fabius' ),
          'add_new_item'      => __( 'Add New Type', 'fabius' ),
          'new_item_name'     => __( 'New type Name', 'fabius' ),
          'menu_name'         => __( 'Event Types', 'fabius' ),
        ],
        'hierarchical'          => true,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'event_type' ),
        'show_in_rest'          => true,
        'rest_base'             => 'event_type',
        'rest_controller_class' => 'WP_REST_Terms_Controller',
      ],

    ];
  }

  public function register_taxonomies() {
    foreach( $this->taxonomies as $tax => $args ) {
      register_taxonomy( $tax, $args['object_type'], $args );
    }
  }

}

$custom_taxonomy = new FabiusCustomTaxonomy();
