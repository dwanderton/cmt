<?php
// Load external file to add support for MultiPostThumbnails. Allows you to set more than one "feature image" per post.
require_once('/assets/multi-post-thumbnails.php');
add_theme_support( 'post-thumbnails' );

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


//function used to add feature images to posts
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
 * @param string $thumbnail_name: the id of the MultiPostThumbnails object
 * @param obj $post: the post data
 * @param string $post_type: the post type, this allows you to specify custom post types 
 * @param string $img_size: the id of the image size (when you used "add_image_size()")  
 **/
function multipost_get_img_src($thumbnail_name, $post, $post_type, $img_size) {
    $img_id= MultiPostThumbnails::get_post_thumbnail_id($post_type,$thumbnail_name,$post->ID ); 
    $img_src_url = wp_get_attachment_image_src($img_id, $img_size);
    return $img_src_url[0];
}
?>
