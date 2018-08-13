<?php
/**
 * @package fabius
 */

function fabius_get_env() {
  $connection = @fsockopen('localhost', '8000');  // same port as webpack-dev-server
  if( is_resource( $connection) ) :
    return 'development';
  else :
    return 'production';
  endif;
}
