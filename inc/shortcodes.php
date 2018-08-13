<?php
/**
 * @package fabius
 */

class FabiusShortCode {
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $shortcodes = array(
    'msg' => 'msg_callback',
  );

  /**
   * Start up
   */
  public function __construct() {
    $this->register_shortcodes();
  }

  public function register_shortcodes() {
    foreach( $this->shortcodes as $shortcode => $callback ) {
      add_shortcode( $shortcode, array( $this, 'msg_callback' ) );
    }
//    add_shortcode( 'msg', array( $this, 'msg_callback' ) );
  }

  public function msg_callback( $atts, $content = null ) {
    $a = shortcode_atts( array(
      'sender'    => 'sender',
      'receiver'  => 'receiver'
    ), $atts );

    return "A message from {$a['sender']} sent to {$a['receiver']} is {$content}";
  }

}

$shortcodes = new FabiusShortCode();
