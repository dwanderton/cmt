<?php
// Load external file to add support for MultiPostThumbnails. Allows you to set more than one "feature image" per post.
require_once(get_template_directory() . '/assets/multi-post-thumbnails.php');
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


//================== 1. DATA SETUP ==================// 

//----- 1a. Custom Post Types -----//

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

//----- 1b. Custom Taxonomies -----//

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



//================== 2. FORMS MODIFICATION ==================// 

//----- 2a. Add feature image(s) to a Custom Post Type -----//

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



//----- 2b. Add an image upload control to a Custom Taxonomy -----//
/**
  * @param stromg: this is to specify where you are adding this field - the add form or the edit form?
  * @param object: the term object 
  * @param string: $POST_data_field is the name of the POST id to assign to image control you are creating
  */
function image_control($type, $term,  $POST_data_field) {

  //This is used if the upload link needs to be changed
  $upload_link = '#';

  //If user is editing a taxonomy then you need to see if there is already an image term meta for a specific term (assigned to the taxonomy) 
  if ($type === "edit") {

    // put the term ID into a variable
    $t_id = $term->term_id;
   
    // retrieve the existing value(s) for this meta field. This returns an array
    $your_img_src = $term_meta = get_term_meta($t_id, 'image', false);

    //checks if there is an image returned 
    $you_have_img = (is_array( $your_img_src ) && count($your_img_src) > 0 ) ? true : false;

    //If user is adding a new taxonomy then there is no image term assigned to that taxonmy  
  } else if ($type === "add") {

    $you_have_img = false;

  }
  ?>
    <div class="image-control-add">

      <div class="form-field">
      
          <!-- invisible input field which stores image src link. we assign POST values to this field so that it is saved to database -->
          <input type="text" name='<?php echo $POST_data_field ?>' id='<?php echo $POST_data_field ?>' value='<?php echo ( $you_have_img === true ) ? $your_img_src[0] : ''; ?>'>
        
          <!-- image container, which can be manipulated with js -->
          <div class="custom-img-container">
              <?php if ( $you_have_img ) : ?>
                  <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;" />
              <?php endif; ?>
          </div>

          <!-- add & remove image links -->
          <p class="hide-if-no-js">
            <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
               href="<?php echo $upload_link ?>">
                <?php _e('Set custom image') ?>
            </a>
            <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
              href="#">
                <?php _e('Remove this image') ?>
            </a>
          </p>
      </div>
    </div>
    <script>
      jQuery(function($){
        // Set all variables to be used in scope
        var frame,
            metaBox = $('.image-control-add'), // Your meta box id here
            addImgLink = metaBox.find('.upload-custom-img'),
            delImgLink = metaBox.find( '.delete-custom-img'),
            imgContainer = metaBox.find( '.custom-img-container'),
            imgIdInput = metaBox.find( '.custom-img-id' );
        
        // ADD IMAGE LINK
        addImgLink.on( 'click', function( event ){
          
          event.preventDefault();
          
          // If the media frame already exists, reopen it.
          if ( frame ) {
            frame.open();
            return;
          }
          
          // Create a new media frame
          frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
              text: 'Use this media'
            },
            multiple: false  // Set to true to allow multiple files to be selected
          });

          
          // When an image is selected in the media frame...
          frame.on( 'select', function() {
            
            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            //assign src of image selected to invisible POST input field
            jQuery('#<?php echo $POST_data_field ?>')[0].value = attachment.url;

            // Send the attachment URL to our custom image input field.
            imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

            // Send the attachment id to our hidden input
            imgIdInput.val( attachment.id );

            // Hide the add image link
            addImgLink.addClass( 'hidden' );

            // Unhide the remove image link
            delImgLink.removeClass( 'hidden' );
          });

          // Finally, open the modal on click
          frame.open();
        });

        // DELETE IMAGE LINK
        delImgLink.on( 'click', function( event ){

          event.preventDefault();

          // Clear out the preview image
          imgContainer.html( '' );

        //clear value of POST input field
          jQuery('#<?php echo $POST_data_field ?>')[0].value = "";

          // Un-hide the add image link
          addImgLink.removeClass( 'hidden' );

          // Hide the delete image link
          delImgLink.addClass( 'hidden' );

          // Delete the image id from the hidden input
          imgIdInput.val( '' );

        });
        
      });
    </script>
  </div>
<?php
}



//----- 2c. Save meta data of a term -----//
/**
  * @param number: term_id is is the id of the term passed when you call edited_{$taxonomy} or created_{$taxonomy} action hook
  * @param string: $POST_field_name is the name of the POST id assigned to term field (e.g. image control)
  * @param number: term_key is used so to tell the update_term_meta function the key value you are saving to
  */
function save_term_data( $term_id , $POST_field_name, $term_key) {
  if ( isset( $_POST[$POST_field_name] ) ) {
    $term_value = $_POST[$POST_field_name];
    if( $term_value ) {
      update_term_meta( $term_id, $term_key, $term_value );
    } else {
      delete_term_meta( $term_id, $term_key );
    }
  }
}  



//================== 3. HELPER FUNCTIONS ==================// 

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
  
  $desc = '<div class="col-md-7"><h2>'. $title . '</h2><p>' . $content . '</p></div>';  
  
  //this checks if $key is odd or even
  //if even, the image is shown on the right and description on the left
  if ($key % 2 == 0) {
    return $img . $desc;
  } //otherwise the image is on the left and the description is on the right
  return $desc . $img;
}


//================== 4. SPECIFIC FUNCTIONS ==================// 

//----- 4a. Add image control field to "Add New Language Taxonomy" form ----//
function add_language_form_fields() {
  image_control('add', null, 'language_image');
}
add_action( 'language_add_form_fields', 'add_language_form_fields', 10, 2 );

//----- 4b. Add image control field to "Edit Language Taxonomy" form ----//
function edit_language_meta_field($term) {
  image_control('edit', $term, 'language_image');
}
add_action( 'language_edit_form_fields', 'edit_language_meta_field', 10, 2 );

//----- 4c. save image control field to Add/Edit Language Taxonomy form -----//
function save_language_image( $term_id ){
  save_term_data($term_id, 'language_image', 'image' );
}
add_action( 'edited_language', 'save_language_image', 10, 2 );  
add_action( 'create_language', 'save_language_image', 10, 2 );

?>
