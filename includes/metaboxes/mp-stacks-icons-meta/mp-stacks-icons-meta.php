<?php
/**
 * This page contains functions for modifying the metabox for icons as a media type
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package    MP Stacks Icons
 * @subpackage Functions
 *
 * @copyright   Copyright (c) 2015, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */
 
/**
 * Add Icons as a Media Type to the dropdown
 *
 * @since    1.0.0
 * @link     http://mintplugins.com/doc/
 * @param    array $args See link for description.
 * @return   void
 */
function mp_stacks_icons_create_meta_box(){
	
	/**
	 * Array which stores all info about the new metabox
	 *
	 */
	$mp_stacks_icons_add_meta_box = array(
		'metabox_id' => 'mp_stacks_icons_metabox', 
		'metabox_title' => __( '"Icons" Content-Type', 'mp_stacks_icons'), 
		'metabox_posttype' => 'mp_brick', 
		'metabox_context' => 'advanced', 
		'metabox_priority' => 'low' ,
		'metabox_content_via_ajax' => true,
	);
	
	//If a stack id has been passed to the URL
	if ( isset( $_GET['mp_stack_id'] ) ){
				
		//Get all the brick titles in this stack
		$brick_titles_in_stack = mp_stacks_get_brick_titles_in_stack( $_GET['mp_stack_id'] );
		
	}
	else{
		
		$brick_titles_in_stack = array();
	}	
	
	/**
	 * Array which stores all info about the options within the metabox
	 *
	 */
	$mp_stacks_icons_items_array = array(
		
		array(
			'field_id'			=> 'mp_stacks_icon_itself',
			'field_title' 	=> __( 'Choose Icon', 'mp_stacks_icons'),
			'field_description' 	=> __( 'Select the icon you wish to use', 'mp_stacks_icons' ),
			'field_type' 	=> 'iconfontpicker',
			'field_value' => '',
			'field_select_values' => mp_stacks_icons_get_font_awesome_icons(),
		),
		
		array(
			'field_id'			=> 'mp_stacks_icon_color',
			'field_title' 	=> __( 'Choose Icon Color', 'mp_stacks_icons'),
			'field_description' 	=> __( 'Select the color you wish the icon to be', 'mp_stacks_icons' ),
			'field_type' 	=> 'colorpicker',
			'field_value' => '#ffffff',
		),
		
		array(
			'field_id'			=> 'mp_stacks_icon_size',
			'field_title' 	=> __( 'Choose Icon Size', 'mp_stacks_icons'),
			'field_description' 	=> __( 'Select the size icon you wish to use', 'mp_stacks_icons' ),
			'field_type' 	=> 'number',
			'field_value' => '200',
		),
		
	);
	
	
	/**
	 * Custom filter to allow for add-on plugins to hook in their own data for add_meta_box array
	 */
	$mp_stacks_icons_add_meta_box = has_filter('mp_stacks_icons_meta_box_array') ? apply_filters( 'mp_stacks_icons_meta_box_array', $mp_stacks_icons_add_meta_box) : $mp_stacks_icons_add_meta_box;
	
	//Globalize the and populate mp_stacks_icons_items_array (do this before filter hooks are run)
	global $global_mp_stacks_icons_items_array;
	$global_mp_stacks_icons_items_array = $mp_stacks_icons_items_array;
	
	/**
	 * Custom filter to allow for add on plugins to hook in their own extra fields 
	 */
	$mp_stacks_icons_items_array = has_filter('mp_stacks_icons_items_array') ? apply_filters( 'mp_stacks_icons_items_array', $mp_stacks_icons_items_array) : $mp_stacks_icons_items_array;
	
	/**
	 * Create Metabox class
	 */
	global $mp_stacks_icons_meta_box;
	$mp_stacks_icons_meta_box = new MP_CORE_Metabox($mp_stacks_icons_add_meta_box, $mp_stacks_icons_items_array);
}
add_action('mp_brick_ajax_metabox', 'mp_stacks_icons_create_meta_box');
add_action('wp_ajax_mp_stacks_icons_metabox_content', 'mp_stacks_icons_create_meta_box');