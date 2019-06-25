
//add this snippet to child theme functions or core plugin

//use regular genesis post meta filter
add_filter( 'genesis_post_meta', 'wpb_post_meta_filter' );
function wpb_post_meta_filter( $post_meta ) {

	$category = get_the_category( $post );
	$primary_category = array();
	
	if ($category){
		$category_display = '';
		$category_slug = '';
		$category_link = '';
	
		if ( class_exists('WPSEO_Primary_Term') )
		{
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', $post );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) {
				// If error, use first category
				$category_display = $category[0]->name;
				$category_slug = $category[0]->slug;
				$category_link = get_category_link( $category[0]->term_id );
			} else {
				// Yoast Primary category
				$category_display = $term->name;
				$category_slug = $term->slug;
				$category_link = get_category_link( $term->term_id );
			}
		}
		else {
			// Default, display the first category in WP's list of assigned categories
			$category_display = $category[0]->name;
			$category_slug = $category[0]->slug;
			$category_link = get_category_link( $category[0]->term_id );
		}
		$primary_category['url'] = $category_link;
		$primary_category['slug'] = $category_slug;
		$primary_category['title'] = $category_display;
	}
	//display linked category name
    $post_meta = '<a href="' . $category_link;
    $post_meta .= '" title= "' . $category_display;
    $post_meta .= '">' . $category_display;
    $post_meta .='</a>';
	return $post_meta;   
}
