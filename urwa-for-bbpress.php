<?php

/*
Plugin Name: URWA For bbPress
Description: Selectively display widgets to logged in users based on standard bbPress user roles.
Version: 1.0
Requires at least: 3.9
Tested up to: 4.3.1
Stable Tag: 1.0
Author: Rob Smelik
Author URI: http://www.robsmelik.com
License: GPLv2
Copyright: Rob Smelik
*/
 
// SECURITY: This line exists for security reasons to keep things locked down.
 
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// REGISTER SIDEBARS (AKA Widget Areas)
 
function register_bbpress_user_sidebars(){
		
		
		// Register bbPress Spectator sidebar

		register_sidebar(array(
			'name' => 'Users - bbPress Spectator',
			'id'   => 'urwa-bbpress-spectator-widgets',
			'description'   => __( 'Widgets placed in this widget area only visible to bbPress Spectators who are logged in.' ),
			'before_widget' => '<div id="urwa-bbpress-spectator" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register bbPress Participant sidebar

		register_sidebar(array(
			'name' => 'Users - bbPress Participant',
			'id'   => 'urwa-bbpress-participant-widgets',
			'description'   => __( 'Widgets placed in this widget area only visible to bbPress Participants who are logged in.' ),
			'before_widget' => '<div id="urwa-bbpress-participant" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register bbPress Moderator sidebar

		register_sidebar(array(
			'name' => 'Users - bbPress Moderator',
			'id'   => 'urwa-bbpress-moderator-widgets',
			'description'   => __( 'Widgets placed in this widget area only visible to bbPress Moderators who are logged in.' ),
			'before_widget' => '<div id="urwa-bbpress-moderator" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
		// Register bbPress Keymaster sidebar 

		register_sidebar(array(
			'name' => 'Users - bbPress Keymaster',
			'id'   => 'urwa-bbpress-keymaster-widgets',
			'description'   => __( 'Widgets placed in this widget area only visible to bbPress Keymasters who are logged in.' ),
			'before_widget' => '<div id="urwa-bbpress-keymaster" class="widget">',
			'after_widget'  => '</div>',
			'before_title' => '<h3 class="widgettitle">', 
			'after_title' => '</h3>', 
		));
		
}

add_action( 'widgets_init', 'register_bbpress_user_sidebars' );


// REGISTER SHORTCODES

// Display sidebars based on Specific bbPress user roles

add_shortcode('bbpress-user-role-widget-areas', 'shortcode_bbpress_user_role_widget_areas');

// Creates the front-end display of the bbPress User Role Widget Areas
// This is where the magic happens

function shortcode_bbpress_user_role_widget_areas(  ) {

if ( current_user_can( 'delete_forums' ) ) { //only bbPress Keymasters can see this
   if ( is_active_sidebar( 'urwa-bbpress-keymaster-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-keymaster-widgets' );
   }
} 
elseif ( current_user_can( 'publish_forums' ) ) { //only bbPress Moderators can see this
   if ( is_active_sidebar( 'urwa-bbpress-moderator-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-moderator-widgets' );
   }
} 
elseif ( current_user_can( 'read_private_forums' ) ) { //only bbPress Participants can see this
   if ( is_active_sidebar( 'urwa-bbpress-participant-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-participant-widgets' );
   }
} 
elseif ( current_user_can( 'spectate' ) ) { //only bbPress Spectators can see this
   if ( is_active_sidebar( 'urwa-bbpress-spectator-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-spectator-widgets' );
   }
} 
else {  //returns no widget content if none of the contitions above are met
	echo ''; 
}
}

add_filter('widget_text', 'do_shortcode');


// REGISTER WIDGET

// Display sidebars based on bbPress user roles

class urwa_bbpress_widget extends WP_Widget {
	
function __construct() {
parent::__construct(
// Base ID of the widget
'urwa_bbpress_widget', 

// Widget name as it appears in the UI
__('bbPress Users by Role', 'urwa_bbpress_widget_domain'), 

// Widget description
array( 'description' => __( 'Place this widget in any existing NON-USER widget area to display bbPress user role widget areas.', 'urwa_widget_domain' ), ) 
);
}

// Creates the front-end display of the bbPress User Role Widget Areas
// This is where the magic happens

public function widget(  ) {
	
// bbPress Support

if ( current_user_can( 'delete_forums' ) ) { //only bbPress Keymasters can see this
   if ( is_active_sidebar( 'urwa-bbpress-keymaster-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-keymaster-widgets' );
   }
} 
elseif ( current_user_can( 'publish_forums' ) ) { //only bbPress Moderators can see this
   if ( is_active_sidebar( 'urwa-bbpress-moderator-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-moderator-widgets' );
   }
} 
elseif ( current_user_can( 'read_private_forums' ) ) { //only bbPress Participants can see this
   if ( is_active_sidebar( 'urwa-bbpress-participant-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-participant-widgets' );
   }
} 
elseif ( current_user_can( 'spectate' ) ) { //only bbPress Spectators can see this
   if ( is_active_sidebar( 'urwa-bbpress-spectator-widgets' ) ) {
   dynamic_sidebar( 'urwa-bbpress-spectator-widgets' );
   }
} 
else {  //returns no widget content if none of the contitions above are met
	echo ''; 
}
}
		
} // Class urwa_bbpress_widget ends here

// Register and load the widget

function urwa_load_bbpress_widget() {
	register_widget( 'urwa_bbpress_widget' );
}
add_action( 'widgets_init', 'urwa_load_bbpress_widget' );




