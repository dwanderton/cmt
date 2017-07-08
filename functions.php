<?php

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



//create a single function to add all metaboxes to their respective posts
function add_metaboxes() {
	
	//Callback to add media uploader control to industry meta box
	function industry_meta_cb($post) {
		global $content_width, $_wp_additional_image_sizes;
		$image_id = get_post_meta( $post->ID, '_listing_image_id', true );
		$old_content_width = $content_width;
		$content_width = 254;
		if ( $image_id && get_post( $image_id ) ) {
			if ( ! isset( $_wp_additional_image_sizes['post-thumbnail'] ) ) {
				$thumbnail_html = wp_get_attachment_image( $image_id, array( $content_width, $content_width ) );
			} else {
				$thumbnail_html = wp_get_attachment_image( $image_id, 'post-thumbnail' );
			}
			if ( ! empty( $thumbnail_html ) ) {
				$content = $thumbnail_html;
				$content .= '<p class="hide-if-no-js"><a href="javascript:;" id="remove_listing_image_button" >' . esc_html__( 'Remove listing image', 'text-domain' ) . '</a></p>';
				$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="' . esc_attr( $image_id ) . '" />';
			}
			$content_width = $old_content_width;
		} else {
			$content = '<img src="" style="width:' . esc_attr( $content_width ) . 'px;height:auto;border:0;display:none;" />';
			$content .= '<p class="hide-if-no-js"><a title="' . esc_attr__( 'Set listing image', 'text-domain' ) . '" href="javascript:;" id="upload_listing_image_button" id="set-listing-image" data-uploader_title="' . esc_attr__( 'Choose an image', 'text-domain' ) . '" data-uploader_button_text="' . esc_attr__( 'Set listing image', 'text-domain' ) . '">' . esc_html__( 'Set listing image', 'text-domain' ) . '</a></p>';
			$content .= '<input type="hidden" id="upload_listing_image" name="_listing_cover_image" value="" />';
		}
		echo $content;    
	}
	add_meta_box("industry-meta", "Slider Image", "industry_meta_cb", "industry", "side", "low");

}
add_action( 'add_meta_boxes', 'add_metaboxes' );

function wpse_cpt_enqueue( $hook_suffix ){
    $cpt = 'industry';

    if( in_array($hook_suffix, array('post.php', 'post-new.php') ) ){
        $screen = get_current_screen();

        if( is_object( $screen ) && $cpt == $screen->post_type ){

        	wp_enqueue_script( 'script', get_stylesheet_directory_uri() . '/assets/js/script.js' );
            // Register, enqueue scripts and styles here

        }
    }
}

add_action( 'admin_enqueue_scripts', 'wpse_cpt_enqueue');


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
add_theme_support( 'post-thumbnails' );

?>
