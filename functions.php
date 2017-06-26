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

function create_custom_post_types() {
  register_post_type( 'industry',
    array(
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
  register_post_type( 'language',
    array(
      'labels' => array(
        'name' => __( 'Languages' ),
        'singular_name' => __( 'Language' )
      ),
    'public' => true,
    'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_custom_post_types' );

?>
