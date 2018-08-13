<?php
/**
 * Template Name: README
 *
 * @package fabius
 */

get_header();
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main">

<!--    theme options-->
    <h1>Theme Options</h1>
    <?php
    foreach( get_option('theme_option') as $opt => $value ) {
      _e( "<p>Theme Option <strong>{$opt}</strong>: {$value}</p>", 'fabius' );
    }
    ?>

<!--    custom post types + taxonomies-->
    <?php
    $events = new WP_Query( [
      'post_type'        => 'event',
    ] );

    _e( "<h1>Event Custom Post Type ({$events->post_count})</h1>", 'fabius' );

    if ( $events->have_posts() ) :
      while ( $events->have_posts() ) : $events->the_post();
        $terms = get_the_terms($events->post->ID, 'event_type');
        foreach( $terms as $term ) {
          $post_terms_name[] = $term->name;
        }
        printf(
          __( "<p><a href='%s'>%s</a> in taxonomy %s</p>" ),
          get_permalink(), get_the_title( $events->post->ID ), implode(', ', $post_terms_name)
        );
      endwhile;
      _e("<div class='pagination'>", 'fabius');
      echo paginate_links( array(
        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'total'        => $events->max_num_pages,
        'current'      => max( 1, get_query_var( 'paged' ) ),
        'format'       => '?paged=%#%',
        'show_all'     => false,
        'type'         => 'plain',
        'end_size'     => 2,
        'mid_size'     => 1,
        'prev_next'    => true,
        'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'text-domain' ) ),
        'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'text-domain' ) ),
        'add_args'     => false,
        'add_fragment' => '',
      ) );
      _e('</div>');
      // Restore original Post Data
      wp_reset_postdata();
    endif;
    ?>

<!--    api-->
    <?php
    _e('<h1>API Endpoint</h1>', 'fabius');
    _e('<p>Send a request to http(s)://yoursite/wp-json/fabius/v1/hello/hieu</p>');
    $response = Requests::get( home_url() . '/wp-json/fabius/v1/hello/hieu' );
    _e('response body: ' . json_decode($response->body), 'fabius' );
    ?>

<!--    shortcode-->
    <?php
    _e('<h1>Shortcode</h1>', 'fabius');
    _e( do_shortcode('<p>run shortcode [msg sender="me" receiver="you"]Call me by your name![/msg]</p>'), 'fabius' );
    ?>

<!--    template-part passing variables-->
    <?php
    $variables = array(
      'name' => 'hieu',
      'title' => 'full-stack web developer'
    );
    fabius_get_template_part( 'content-passing-variable', $variables );
    ?>

  </main><!-- #main -->
</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
