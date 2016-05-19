<?php

// [staff columns="4" position="myposition"] ...
function sbg_add_main_shortcode( $atts ) {

	ob_start();
	$atts = extract( shortcode_atts(
		array(
			'columns' => '4',
			'position' => '',
	        'posts' => 20,
	        'linkto' => 'lightbox',
	        'lightboxheight' => '300',
	        'lightboxwidth' => '600',
	        'displayposition' => 'true',
	        'order' => 'ASC',
	        'orderby' => 'title',
		),
		$atts
	) );

	// define query parameters based on attributes
	$options = array(
	    'post_type' => 'staff-member',
	    'order' => $order,
	    'orderby' => $orderby,
	    'posts_per_page' => $posts,
	    'staff-position' => $position,
	);

	$custom_query = new WP_Query( $options );

	$numberofcolumns = $columns;
	$column_classes = array( '', '', 'one-half', 'one-third', 'one-fourth', 'one-fifth', 'one-sixth' );
	$classes[] = $column_classes[$numberofcolumns];

	while( $custom_query->have_posts() ) {
		$custom_query->the_post();

		// add 'first' to the array containing the classes if this is the first item overall or if the current item number divided by the number of columns has a remainder of 0
		if ( 0 == $custom_query->current_post || 0 == $custom_query->current_post % $numberofcolumns ) {
			$classes[] = 'first';
		}

		// if the above condition isn't true, then we remove 'first' from the array of classes
		else {
			if ( ( $key = array_search( 'first', $classes ) ) !== false) {
			    unset( $classes[$key] );
			}
		}

		echo '<article ';
		post_class( $classes, $custom_query->post->ID);
		echo '>';

			echo '<div class="staff-featured-image">';
				add_thickbox();
				echo '<a title="' . get_the_title( $custom_query->post->ID ) . '"';

				// this is the default behavior, and it is also used if linkto="lightbox"
				if ( $linkto == 'lightbox') {
					echo 'class="thickbox" href="#TB_inline?height=' . $lightboxheight . '&width=' . $lightboxwidth . '&inlineId=thestaffcontent' . $custom_query->post->ID . '">';
				}

				// this is the behavior if linkto="single" (it links to the single version)
				elseif ( $linkto == 'single' ) {
					echo ' href="' . get_the_permalink( $custom_query->post->ID ) . '">';
				}

				// this is the behavior if linkto="none" (no link going anywhere)
				elseif ( $linkto == 'none') {
					echo ' href="#">';
				}

					// plugins_url( '/img/sampleimg.jpg', __FILE__ )
					if ( has_post_thumbnail( $custom_query->post->ID ) ) {
						echo get_the_post_thumbnail( $custom_query->post->ID, 'staff-member', '' );
					}
					else {
						echo '<img src="' . plugins_url( '/img/sampleimg.jpg', dirname( __FILE__ ) ) . '"/>';
					}

				echo '</a>';
			echo '</div>';

			echo '<div style="display:none;" id="thestaffcontent' . ($custom_query->post->ID) . '">';

				the_content( $custom_query->post->ID );

			echo '</div>';
			echo '<div class="title-meta">';
				echo '<h2 class="entry-title">';
					echo '<a title="' . get_the_title( $custom_query->post->ID ) . '"';

					// this is the default behavior, and it is also used if linkto="lightbox"
					if ( $linkto == 'lightbox') {
						echo 'class="thickbox" href="#TB_inline?height=' . $lightboxheight . '&width=' . $lightboxwidth . '&inlineId=thestaffcontent' . $custom_query->post->ID . '">';
					}

					// this is the behavior if linkto="single" (it links to the single version)
					elseif ( $linkto == 'single' ) {
						echo ' href="' . get_the_permalink( $custom_query->post->ID ) . '">';
					}

					// this is the behavior if linkto="none" (no link going anywhere)
					elseif ( $linkto == 'none') {
						echo ' href="#">';
					}
						the_title();
					echo '</a>';
				echo '</h2>';

				if ( $displayposition == 'true' ) {
					$terms = get_the_terms( $custom_query->post->ID, 'staff-position' );
					if ( !empty( $terms )) {
						foreach( $terms as $term ) {
							echo '<p class="entry-meta"><span class="entry_terms">', $term->name, '</span></p>';
						}
					}
				}

				if ( $displayposition == 'linked' )
				genesis_post_meta( $custom_query->post->ID );

				if ( $displayposition == 'false' ) {
					// silence is golden...
				}

				$text = get_post_meta( $custom_query->post->ID, '_sbg_phone', true );
				if ( !empty( $text ) ) {
					echo $text;
				}

			echo '</div>';

			echo '<div class="sbg_contactinfo">';
				$text = get_post_meta( $custom_query->post->ID, '_sbg_email', true );
				if ( !empty( $text ) ) {
					$link = '<a href="mailto:' . $text . '">' . '<span class="genericon genericon-mail"></span>' . '</a>';
					echo $link;
				}

				$text = get_post_meta( $custom_query->post->ID, '_sbg_facebook', true );
				if ( !empty( $text ) ) {
					$link = '<a target="_blank" href="' . $text . '">' . '<span class="genericon genericon-facebook"></span>' . '</a>';
					echo $link;
				}

				$text = get_post_meta( $custom_query->post->ID, '_sbg_twitter', true );
				if ( !empty( $text ) ) {
					$link = '<a target="_blank" href="' . $text . '">' . '<span class="genericon genericon-twitter"></span>' . '</a>';
					echo $link;
				}
			echo '</div>';

			edit_post_link();

		echo '</article>';

	}

	echo '<div class="sbg_clear"></div>';

	wp_reset_postdata();
	wp_reset_query();

    $theshortcode = ob_get_clean();
    $theshortcode = do_shortcode($theshortcode);
    return $theshortcode;
}
add_shortcode( 'staff', 'sbg_add_main_shortcode' );
