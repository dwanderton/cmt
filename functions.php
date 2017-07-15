<?php
// Load external file to add support for MultiPostThumbnails. Allows you to set more than one "feature image" per post.
require_once('/assets/multi-post-thumbnails.php');
add_theme_support( 'post-thumbnails' );
wp_enqueue_media();

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

/* hard code disable related posts */
function jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'jetpackme_remove_rp', 20 );

add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
function theme_name_scripts() {
   wp_enqueue_style( 'style-name', get_stylesheet_uri() );
}

// Create a single function to initialize all the different custom post types
function create_custom_post_types() {	
  register_post_type( 'industry',
    array(
    	'supports' => array(
    		'title', 'editor', 'thumbnail'
    		),
      	'labels' => array(
        'name' => __( 'Industries' ),
        'singular_name' => __( 'Industry' )
      ),
    'public' => true,
    'has_archive' => true,
    )
  );
  register_post_type( 'service',
    array(
      'labels' => array(
        'name' => __( 'Services' ),
        'singular_name' => __( 'Service' )
      ),
    'public' => true,
    'has_archive' => true,
    )
  );
}

// add the create custom post types funtion to the intialize action list
add_action( 'init', 'create_custom_post_types' );



//Create a single function to initialize all the different taxonomies
function create_taxonomies() {

	//Language taxonomy - to be used by Services Post
	register_taxonomy(
		'language',
		'service',
		array(
			'label' => 'Languages',
			'hierarchical' => true,
		)
	);
}

add_action( 'init', 'create_taxonomies' );


//function used to add extra feature images to posts
function add_feature_image_controls_to_posts() {
	// Add Custom image sizes
	// Note: 'true' enables hard cropping so each image is exactly those dimensions and automatically cropped
	add_image_size( 'feature-image', 960, 500, true ); 
	add_image_size( 'medium-thumb', 300, 156, true );
	add_image_size( 'small-thumb', 75, 75, true );

	// Define additional "post thumbnails" for the Industry Custom Post Type. Relies on MultiPostThumbnails to work
	if (class_exists('MultiPostThumbnails')) {
	    new MultiPostThumbnails(array(
	        'label' => 'Slider Image',
	        'id' => 'industry-slider-image',
	        'post_type' => 'industry'
	        )
	    );   
	};
}
add_feature_image_controls_to_posts();


//helper function to return image source of feature-images added by the MultiPostThumbnail class
/**
 *
 * @param string $thumbnail_name: the id of the MultiPostThumbnails object
 * @param obj $post: the post data
 * @param string $post_type: the post type, this allows you to specify custom post types 
 * @param string $img_size: the id of the image size (when you used "add_image_size()")  
 *e.g multipost_get_img_src('industry-slider-image', $industry, 'industry', 'feature-image')
 *
 **/
function multipost_get_img_src($thumbnail_name, $post, $post_type, $img_size) {
    $img_id= MultiPostThumbnails::get_post_thumbnail_id($post_type,$thumbnail_name,$post->ID ); 
    $img_src_url = wp_get_attachment_image_src($img_id, $img_size);
    return $img_src_url[0];
}

//function to generate each industry post on index.php
//We use a PHP function because the HTML layout needs to change on every other post
/**
 *
 * @param wp post type object: the current wp-post object
 * @param number: the key value used to indicate the current order of the wp-post object we are looking at
 *
 */
function generate_industries($industry, $key) {
  $title_link = get_permalink($industry);
  $title = $industry->post_title;
  $content = $industry->post_content;
  $img_url = get_the_post_thumbnail_url($industry);

  $img = '<div class="col-md-5"><img src="' . $img_url . '"></div>';
  
  $desc = '<div class="col-md-7"><h2><a href="' . $title_link . '">' . $title . '</a></h2><p>' . $content . '</p></div>';  
  
  //this checks if $key is odd or even
  //if even, the image is shown on the right and description on the left
  if ($key % 2 == 0) {
    return $img . $desc;
  } //otherwise the image is on the left and the description is on the right
  return $desc . $img;
}














/* Add Image Upload to Series Taxonomy */

// Add Upload fields to "Add New Taxonomy" form
function add_language_form_fields() {
  // this will add the custom meta field to the add new term page
  ?>
  <div class="form-field">
    <label for="series_image"><?php _e( 'Series Image:', 'journey' ); ?></label>
    <input type="text" name="series_image[image]" id="series_image[image]" class="series-image" value="<?php echo $seriesimage; ?>">
    <input class="upload_image_button button" name="_add_series_image" id="_add_series_image" type="button" value="Select/Upload Image" />
    <script>
      jQuery(document).ready(function() {
        jQuery('#_add_series_image').click(function() {
          wp.media.editor.send.attachment = function(props, attachment) {
            jQuery('.series-image').val(attachment.url);
          }
          wp.media.editor.open(this);
          return false;
        });
      });
    </script>
  </div>
<?php
}
add_action( 'language_add_form_fields', 'add_language_form_fields', 10, 2 );

// Add Upload fields to "Edit Taxonomy" form
function journey_series_edit_meta_field($term) {
 
  // put the term ID into a variable
  $t_id = $term->term_id;
 
  // retrieve the existing value(s) for this meta field. This returns an array
  $term_meta = get_option( "weekend-series_$t_id" ); ?>
  
  <tr class="form-field">
  <th scope="row" valign="top"><label for="_series_image"><?php _e( 'Series Image', 'journey' ); ?></label></th>
    <td>
      <?php
        $seriesimage = esc_attr( $term_meta['image'] ) ? esc_attr( $term_meta['image'] ) : ''; 
        ?>
      <input type="text" name="series_image[image]" id="series_image[image]" class="series-image" value="<?php echo $seriesimage; ?>">
      <input class="upload_image_button button" name="_series_image" id="_series_image" type="button" value="Select/Upload Image" />
    </td>
  </tr>
  <tr class="form-field">
  <th scope="row" valign="top"></th>
    <td style="height: 150px;">
      <style>
        div.img-wrap {
          background: url('http://placehold.it/960x300') no-repeat center; 
          background-size:contain; 
          max-width: 450px; 
          max-height: 150px; 
          width: 100%; 
          height: 100%; 
          overflow:hidden; 
        }
        div.img-wrap img {
          max-width: 450px;
        }
      </style>
      <div class="img-wrap">
        <img src="<?php echo $seriesimage; ?>" id="series-img">
      </div>
      <script>
      jQuery(document).ready(function() {
        jQuery('#_series_image').click(function() {
          wp.media.editor.send.attachment = function(props, attachment) {
            jQuery('#series-img').attr("src",attachment.url)
            jQuery('.series-image').val(attachment.url)
          }
          wp.media.editor.open(this);
          return false;
        });
      });
      </script>
    </td>
  </tr>
<?php
}
add_action( 'language_edit_form_fields', 'journey_series_edit_meta_field', 10, 2 );

// Save Taxonomy Image fields callback function.
function save_series_custom_meta( $term_id ) {
  if ( isset( $_POST['series_image'] ) ) {
    $t_id = $term_id;
    $term_meta = get_option( "weekend-series_$t_id" );
    $cat_keys = array_keys( $_POST['series_image'] );
    foreach ( $cat_keys as $key ) {
      if ( isset ( $_POST['series_image'][$key] ) ) {
        $term_meta[$key] = $_POST['series_image'][$key];
      }
    }
    // Save the option array.
    update_option( "weekend-series_$t_id", $term_meta );
  }
}  
add_action( 'edited_language', 'save_series_custom_meta', 10, 2 );  
add_action( 'create_language', 'save_series_custom_meta', 10, 2 );


?>
