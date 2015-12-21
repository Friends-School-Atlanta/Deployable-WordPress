<?php
/*
Plugin Name: Genesis Optimized Social Share
Version: 1.2.1
Plugin URI: http://www.scorpiongodlair.com/genesis-optimized-social-share-wp-plugin/
Description: Genesis Optimized Social Share loads Most Popular Counter Share buttons - FB, G+, Twitter, Pinterest - Asynchronously. This makes your website much Faster means Less Loading Time & High PageSpeed Score.
Author: ScorpionGod Lair
Author URI: http://www.scorpiongodlair.com
License: GPL2

Genesis Optimized Social Share Plugin
Copyright (C) 2013, Shyam Chathuranga - shyam@scorpiongodlair.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//* Genesis Framework CheckUp
register_activation_hook( __FILE__, 'activation_hook' );
function activation_hook() {
	$latest = '1.7.1';
	$theme_info = get_theme_data( TEMPLATEPATH . '/style.css' );
		if ( 'genesis' != basename( TEMPLATEPATH ) ) {
	        deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			wp_die( sprintf( __( 'Sorry, you can\'t activate unless you have installed <a href="%s">Genesis Framework</a>', 'apl' ), 'http://www.scorpiongodlair.com/genesis' ) );
		}
		if ( version_compare( $theme_info['Version'], $latest, '<' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) ); /** Deactivate ourself */
			wp_die( sprintf( __( 'Sorry, you cannot activate without <a href="%s">Genesis %s</a> or greater', 'apl' ), 'http://www.scorpiongodlair.com/genesis', $latest ) );
		}
}

//* Outputting the Styles for better display
add_action('wp_head', 'optimized_styles', 99 );
function optimized_styles() {
	echo '<style type="text/css">#optimizedsocial{height: 60px; margin: 15px 0;} .pinterest{margin-top: 40px !important;} #optimizedsocial .socialbox{min-width: 48px; margin: 0 10px 0 0;float: left;} .clear{clear:both}</style>';
}

//* Check for Genesis HTML5
$genesis_html5_check = ( function_exists( 'genesis_html5' ) && genesis_html5() ) ? 'html5-' : '';

//* Display Optimized Social Share Counters HTML-5 Themes
if ( $genesis_html5_check = true ) {
	add_action( 'genesis_entry_footer', 'optimized_counters_html5', 1 );
	function optimized_counters_html5() {
		if ( is_single() ) {
			echo '<!-- Counters by Genesis Optimized Social Share Plugin -->';
			echo '<div id="optimizedsocial">';
			echo '<div class="socialbox">';
			echo '<div class="fb-like" data-href="' . get_permalink( $post->ID ) . '" data-send="false" data-layout="box_count" data-show-faces="false"></div></div>';
			echo '<div class="socialbox"><a rel="nofollow" href="http://twitter.com/share" data-url="' . get_permalink( $post->ID ) . '" data-text="' . urlencode( strip_tags( get_the_title( $post->ID ) ) ) . '" data-count="vertical" class="twitter-share-button">Tweet</a></div>';
			echo '<div class="socialbox"><div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div></div>';
			echo '<div class="socialbox pinterest"><a class="pin" href="http://www.pinterest.com/pin/create/button/?url=' . get_permalink( $post->ID ) . '&description=' . urlencode( strip_tags( get_the_title( $post->ID ) ) ) . '" data-pin-do="buttonPin" count-layout="vertical" data-pin-config="above">PinIt</a></div>';
			echo '<div class="clear"></div>';
			echo '</div>';
			echo '<!-- Counters by Genesis Optimized Social Share Plugin End -->';
		}
	}
}

//* XHTML Genesis Theme Support
add_action( 'genesis_after_post', 'optimized_counters', 1 );
function optimized_counters() {
if ( is_single() ) {
	echo '<!-- Counters by Optimized Social Share Plugin -->';
	echo '<div id="optimizedsocial">';
	echo '<div class="socialbox">';
	echo '<div class="fb-like" data-href="' . get_permalink( $post->ID ) . '" data-send="false" data-layout="box_count" data-show-faces="false"></div></div>';
	echo '<div class="socialbox"><a rel="nofollow" href="http://twitter.com/share" data-url="' . get_permalink( $post->ID ) . '" data-text="' . urlencode( strip_tags( get_the_title( $post->ID ) ) ) . '" data-count="vertical" class="twitter-share-button">Tweet</a></div>';
	echo '<div class="socialbox"><div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-height="60"></div></div>';
	echo '<div class="socialbox pinterest"><a class="pin" href="http://www.pinterest.com/pin/create/button/?url=' . get_permalink( $post->ID ) . '&description=' . urlencode( strip_tags( get_the_title( $post->ID ) ) ) . '" data-pin-do="buttonPin" count-layout="vertical" data-pin-config="above">PinIt</a></div>';
	echo '<div class="clear"></div>';
	echo '</div>';
	echo '<!-- Counters by Optimized Social Share Plugin End -->';
}
}

//* Outputting 4 Social Scripts Asynchronously
add_action( 'genesis_after', 'social_counter_scripts' );
function social_counter_scripts() { ?>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() { FB.init({appId: '', status: true, cookie: true, xfbml: true}); };
(function() { var e = document.createElement('script'); e.async = true; e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js'; document.getElementById('fb-root').appendChild(e); }());
</script>
<script type="text/javascript">
(function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true; po.src = 'https://apis.google.com/js/plusone.js?onload=onLoadCallback'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s); })();
</script>
<script type="text/javascript">
(function(d){ var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT'); p.type = 'text/javascript'; p.async = true; p.src = '//platform.twitter.com/widgets.js'; f.parentNode.insertBefore(p, f); }(document));
</script>
<script type="text/javascript">
(function(d){ var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT'); p.type = 'text/javascript'; p.async = true; p.src = '//assets.pinterest.com/js/pinit.js'; f.parentNode.insertBefore(p, f); }(document));
</script>
<?php }
?>