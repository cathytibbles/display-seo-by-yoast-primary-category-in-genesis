<?php
/**
 * Primary Category Shortcode
 *
 * @package      Child Theme Core Plugin
 * @author       Cathy Tibbles
 * @since        1.0.0
 * @license      GPL-2.0+
 * use shortcode [primary_category], no attributes yet
 *
**/


add_shortcode( 'primary_category', 'wpb_primary_category' );

function wpb_primary_category() {
	$category = get_the_category( $post );
	$primary_category = array();
	
	if ($category){
		$category_display = '';
		$category_slug = '';
		$category_link = '';
	
		if ( class_exists('WPSEO_Primary_Term') )
		{
			// show primary category, if one exists
			$wpseo_primary_term = new WPSEO_Primary_Term( 'category', $post );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			if (is_wp_error($term)) {
				// if error, return first category
				$category_display = $category[0]->name;
				$category_slug = $category[0]->slug;
				$category_link = get_category_link( $category[0]->term_id );
			} else {
				// else Yoast Primary category
				$category_display = $term->name;
				$category_slug = $term->slug;
				$category_link = get_category_link( $term->term_id );
			}
		}
		else {
			// if no primary terms available, show first category
			$category_display = $category[0]->name;
			$category_slug = $category[0]->slug;
			$category_link = get_category_link( $category[0]->term_id );
		}
		$primary_category['url'] = $category_link;
		$primary_category['slug'] = $category_slug;
		$primary_category['title'] = $category_display;
	}
	
  //display linked category name
    $prim_cat = '<a href="' . $category_link;
    $prim_cat .= '" title= "' . $category_display;
    $prim_cat .= '">' . $category_display;
    $prim_cat .='</a>';
	
	return $prim_cat;   
}
