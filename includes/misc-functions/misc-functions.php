<?php 
/**
 * Functions used to work with the MP Stacks Developer Plugin
 *
 * @link http://mintplugins.com/doc/
 * @since 1.0.0
 *
 * @package     MP Stacks + Icons
 * @subpackage  Functions
 *
 * @copyright   Copyright (c) 2015, Mint Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author      Philip Johnston
 */

/**
 * Function which returns an array of font awesome icons
 */
function mp_stacks_icons_get_font_awesome_icons(){
	
	//Get all font styles in the css document and put them in an array
	$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
	
	$args = array(
		'timeout'     => 5,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers'     => array(),
		'cookies'     => array(),
		'body'        => null,
		'compress'    => false,
		'decompress'  => true,
		'sslverify'   => false,
		'stream'      => false,
		'filename'    => null
	); 

	$response = wp_remote_retrieve_body( wp_remote_get( MP_STACKS_PLUGIN_URL . 'includes/fonts/font-awesome/css/font-awesome.css?ver=' . MP_STACKS_VERSION, $args ) );
	
	preg_match_all($pattern, $response, $matches, PREG_SET_ORDER);
	
	$icons = array();

	foreach($matches as $match){
		$icons[$match[1]] = $match[1];
	}
	
	return $icons;
}