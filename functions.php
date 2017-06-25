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


//Function for creating the Industries Taxonomy
function create_industries_taxonomy() {
	register_taxonomy(
		'Industries',
		'post',
		array(
			'label' => 'Industries',
			'hierarchical' => false,
		)
	);
}
//Action to call the function which creates the Industries Taxonomy
add_action( 'init', 'create_industries_taxonomy' );


?>