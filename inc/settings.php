<?php
/**
 * @package fabius
 */

class FabiusThemeSettingsPage {
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $options;
  private $page_title = 'Theme Settings';
  private $menu_title = 'Theme Settings';
  private $capability = 'manage_options';
  private $menu_slug = 'theme_settings_page';
  private $icon_url = 'dashicons-tickets';
  private $theme_settings_page_position = null;
  private $theme_option_name = 'theme_option';
  private $theme_setting_admin = 'theme-setting-admin';
  private $settings = [
    'general' => [
      'id'    => 'theme_setting_section_general',  // ID
      'title' => 'General', // Title
      'fields' => [
        'logo' => [
          'id'        => 'general_logo',  // ID
          'title'     => 'Logo',  // Title
          'callback'  => 'general_logo_callback', // Callback
          'type'      => 'file' // Field type, use in sanitize function
        ]
      ]
    ],
    'social' => [
      'id'    => 'theme_setting_section_social', // ID
      'title' => 'Social Sharing',  // Title
      'fields' => [
        'facebook' => [
          'id'        => 'social_facebook', // ID
          'title'     => 'Facebook URL',  // Title
          'callback'  => 'social_facebook_callback',  // Callback
          'type'      => 'text' // Field type, use in sanitize function
        ],
        'twitter' => [
          'id'        => 'social_twitter', // ID
          'title'     => 'Twitter URL',  // Title
          'callback'  => 'social_twitter_callback',  // Callback
          'type'      => 'text' // Field type, use in sanitize function
        ]
      ]
    ]
  ];

  /**
   * Start up
   */
  public function __construct() {
    add_action( 'admin_menu', array( $this, 'theme_settings_page' ) );
    add_action( 'admin_init', array( $this, 'page_init' ) );
    add_action( 'admin_footer', array( $this, 'media_selector_print_scripts' ) );
  }

  /**
   * Add admin page
   */
  public function theme_settings_page() {
    // This page will be above "Collapse menu"
//    add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array($this, 'page_callback'), $this->icon_url, $this->theme_settings_page_position );
    
    // This page will be under "Settings"
    add_options_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array($this, 'page_callback') );
  }

  /**
   * Admin page callback
   */
  public function page_callback() {
    // Set class property
    $this->options = get_option( $this->theme_option_name );
    ?>
    <div class="wrap">
      <h1>Theme Settings</h1>
      <form method="post" action="options.php">
        <?php
        // This prints out all hidden setting fields
        settings_fields( 'theme_option_group' );
        do_settings_sections( $this->theme_setting_admin );
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Register and add settings
   */
  public function page_init() {
    register_setting(
      'theme_option_group', // Option group
      $this->theme_option_name, // Option name
      array( $this, 'sanitize' ) // Sanitize
    );

    foreach( $this->settings as $section ) {
//      add section
      add_settings_section(
        $section['id'], // ID
        $section['title'], // Title
        null, // Callback
        $this->theme_setting_admin // Page
      );

      foreach( $section['fields'] as $field ) {
//        add fields
        add_settings_field(
          $field['id'], // ID
          $field['title'], // Title
          array( $this, $field['callback'] ), // Callback
          $this->theme_setting_admin, // Page
          $section['id'] // Section
        );
      }
    }

  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  public function sanitize( $input ) {
    $new_input = array();
    foreach( $this->settings as $section ) {
      foreach( $section['fields'] as $field ) {
        if( isset( $input[$field['id']] ) ) {
          switch( $field['type'] ) {
            case 'text':
              $new_input[$field['id']] = sanitize_text_field( $input[$field['id']] );
              break;
            case 'file':
              $new_input[$field['id']] = absint( $input[$field['id']] );
              break;
            default:
              break;
          }
        }
      }
    }

    return $new_input;
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function general_logo_callback() {
    wp_enqueue_media();
    printf(
      '<img id="image-preview" src="%s" width="200" height="100" />',
      isset( $this->options['general_logo'] ) ? esc_attr( wp_get_attachment_url( $this->options['general_logo'] ) ) : ''
    );
    printf(
      '<input id="upload_image_button" type="button" class="button" value="%s" />',
      __( 'Choose image', 'fabius' )
    );
    printf(
      '<input type="hidden" name="theme_option[general_logo]" id="image_attachment_id" value="">'
    );
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function social_facebook_callback() {
    printf(
      '<input type="text" id="social_facebook" name="theme_option[social_facebook]" value="%s" />',
      isset( $this->options['social_facebook'] ) ? esc_attr( $this->options['social_facebook']) : ''
    );
  }

  /**
   * Get the settings option array and print one of its values
   */
  public function social_twitter_callback() {
    printf(
      '<input type="text" id="social_twitter" name="theme_option[social_twitter]" value="%s" />',
      isset( $this->options['social_twitter'] ) ? esc_attr( $this->options['social_twitter']) : ''
    );
  }

  /**
   * jQuery scripts
   */
  public function media_selector_print_scripts() {
    $saved_attachment_post_id = isset( $this->options['general_logo'] ) ? $this->options['general_logo'] : 0;
    ?>
    <script type='text/javascript'>
      jQuery( document ).ready( function( $ ) {
        // Uploading files
        var file_frame;
        var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
        var set_to_post_id = <?php echo $saved_attachment_post_id; ?>; // Set this
        jQuery('#upload_image_button').on('click', function( event ){
          event.preventDefault();
          // If the media frame already exists, reopen it.
          if ( file_frame ) {
            // Set the post ID to what we want
            file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            file_frame.open();
            return;
          } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            wp.media.model.settings.post.id = set_to_post_id;
          }
          // Create the media frame.
          file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
              text: 'Use this image',
            },
            multiple: false	// Set to true to allow multiple files to be selected
          });
          // When an image is selected, run a callback.
          file_frame.on( 'select', function() {
            // We set multiple to false so only get one image from the uploader
            attachment = file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
            $( '#image_attachment_id' ).val( attachment.id );
            // Restore the main post ID
            wp.media.model.settings.post.id = wp_media_post_id;
          });
          // Finally, open the modal
          file_frame.open();
        });
        // Restore the main ID when the add media button is pressed
        jQuery( 'a.add_media' ).on( 'click', function() {
          wp.media.model.settings.post.id = wp_media_post_id;
        });
      });
    </script>
  <?php
  }

}

if( is_admin() )
  $theme_settings_page = new FabiusThemeSettingsPage();
