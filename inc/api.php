<?php
/**
 * @package fabius
 */

class FabiusAPI {
  /**
   * Start up
   */
  public function __construct() {
    add_action( 'rest_api_init', function() {
      register_rest_route( 'fabius/v1', '/hello/(?P<name>\w+)', array(
        'methods' => 'GET',
        'callback' => array( $this, 'fabius_hello_callback' ),
      ) );
    } );
  }

  public function fabius_hello_callback( WP_REST_Request $request ) {
    $params = $request->get_params();
    $name = $params['name'];
    return "hello {$name}";
  }
}

$api = new FabiusAPI();
