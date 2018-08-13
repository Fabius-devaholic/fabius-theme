<?php
/**
 * name: String
 * title: String
 */

_e( '<p>A get_template_part is called, let see variable passing</p>', 'faibus' );
printf(
  __( 'name: %s<br>title: %ss', 'fabius' ),
  isset($name) ? $name : '', isset($title) ? $title : ''
);
