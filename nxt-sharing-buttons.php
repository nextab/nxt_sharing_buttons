<?php
/**
 * @package Sharing Buttons by nexTab
 * @version 0.9
 */
/*
Plugin Name: Sharing Buttons by nexTab
Plugin URI: https://nextab.de/
Description: Allows you to add sharing buttons anywhere on your site by using the shortcode [nxt_share]
Author: nexTab - Oliver Gehrmann
Version: 0.9
Text Domain: nxt-sharing-buttons
Author URI: http://nexTab.de/
*/

/* setting up internationalization */
function nxt_sharing_buttons_i18n() {
	load_plugin_textdomain( 'nxt-sharing-buttons', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/'  );
}
add_action( 'plugins_loaded', 'nxt_sharing_buttons_i18n' );

/* embed plugin styles */
function nxt_sharing_buttons_plugin_init() {
	// Register our style
	wp_register_style('nxt_sharing_buttons_style', plugins_url( '/css/nxt-sharing-button-styles.css', __FILE__ ));
	wp_enqueue_style('nxt_sharing_buttons_style');
}
add_action( 'wp_enqueue_scripts', 'nxt_sharing_buttons_plugin_init', 99);

#region Sharing Buttons Shortcode
function nxt_sharing_buttons_render($atts, $content = null) {
	$a = shortcode_atts( array(
		'title'				=> 'Teilen',
		'title_tag'			=> 'h5',
		'class'				=> '',
		'facebook_glyph'	=> '',
		'linkedin_glyph'	=> '',
		'twitter_glyph'		=> '',
		'pinterest_glyph'	=> '',
	), $atts );
	$permalink = get_the_permalink();
	$tw_hashtags = str_replace(" ", "", get_bloginfo('name'));
	$title = get_the_title();
	$fb_share_url = "https://www.facebook.com/sharer/sharer.php?u=" . str_replace("/","%2F",str_replace(":","%3A",$permalink));
	$tw_share_url = "https://twitter.com/intent/tweet?url=" . str_replace("/","%2F",str_replace(":","%3A",$permalink)) . "&text=" . str_replace(" ","%20",$title) . "&hashtags=" . $tw_hashtags;
	$li_share_url = "http://www.linkedin.com/shareArticle?mini=true&url=" . str_replace("/","%2F",str_replace(":","%3A",$permalink)) . "&title=" . str_replace(" ","%20",$title) . "&summary=&source=https%3A%2F%2Fstefanieadam.de";
	$pin_share_url = "https://pinterest.com/pin/create/button/?url=" . str_replace("/","%2F",str_replace(":","%3A",$permalink));
	$return_string = '<div class="nxt_sharing_buttons ' . $a["class"] . '"><' . $a["title_tag"] . ' class="sharing_buttons_header">' . $a["title"] . '</' . $a["title_tag"] . '><ul class="JvPeek">';
	$return_string .= '<li><a class="social_link social_facebook" target="_blank" href="' . $fb_share_url . '" title="' . $title . ' auf Facebook teilen">' . $a["facebook_glyph"] . '</a></li>';
	$return_string .= '<li><a class="social_link social_linkedin" target="_blank" href="' . $li_share_url . '" title="' . $title . ' auf LinkedIn teilen">' . $a["linkedin_glyph"] . '</a></li>';
	$return_string .= '<li><a class="social_link social_twitter" target="_blank" href="' . $tw_share_url . '" title="' . $title . ' auf Twitter teilen">' . $a["twitter_glyph"] . '</a></li>';
	$return_string .= '<li><a class="social_link social_pinterest" target="_blank" href="' . $pin_share_url . '" title="' . $title . ' auf Pinterest teilen">' . $a["pinterest_glyph"] . '</a></li>';
	$return_string .= '</ul></div>';
	return $return_string;
}
add_shortcode('nxt_share', 'nxt_sharing_buttons_render');
#endregion