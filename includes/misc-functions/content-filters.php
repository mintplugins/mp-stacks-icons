<?php 
/**
 * This file contains the function which hooks to a brick's content output
 *
 * @since 1.0.0
 *
 * @package    MP Stacks Icons
 * @subpackage Functions
 *
 * @copyright  Copyright (c) 2015, Mint Plugins
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @author     Philip Johnston
 */

/**
 * This function hooks to the brick css output. If it is supposed to be a 'icon', then it will add the css for those icons to the brick's css
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_css_icons( $css_output, $post_id, $first_content_type, $second_content_type ){

	if ( $first_content_type != 'icons' && $second_content_type != 'icons' ){
		return $css_output;	
	}
	
	//Enqueue Font Awesome CSS
	wp_enqueue_style( 'fontawesome', plugins_url( '/fonts/font-awesome-4.0.3/css/font-awesome.css', dirname( __FILE__ ) ) );
		
	//Enqueue icons CSS
	wp_enqueue_style( 'mp_stacks_icons_css', plugins_url( 'css/icons.css', dirname( __FILE__ ) ) );
	
	//Get the icon we want to use
	$mp_stacks_icon_itself = mp_core_get_post_meta( $post_id, 'mp_stacks_icon_itself' );
	
	//Icons size
	$mp_stacks_icon_size = mp_core_get_post_meta($post_id, 'mp_stacks_icon_size', '100%');
			
	//Icon text color:
	$mp_stacks_icon_color = mp_core_get_post_meta($post_id, 'mp_stacks_icon_color', '#ffffff');
			
	//Get the stroke css
	$shadow_css = NULL;
	if ( mp_core_get_post_meta_checkbox($post_id, 'icon_shadow_on', false) ){
		$shadow_css = mp_core_drop_shadow_css( $post_id, 'icon_' );
	}
		
	//Get Icons Output
	$css_icons_output = '
		#mp-brick-' . $post_id . ' .mp-stacks-icon{ 
			text-align: middle;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-icon{ 
			color:' . $mp_stacks_icon_color . ';
			text-align: middle;
			padding: 50px;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-icon a,
		#mp-brick-' . $post_id . ' .mp-stacks-icon a:hover
		{ 
			color:' . $mp_stacks_icon_size . ';
		}
		#mp-brick-' . $post_id . ' .mp-stacks-icons-icon-container{
			width:' . $mp_stacks_icon_size . 'px;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-icons-icon {
			width: ' . $mp_stacks_icon_size . 'px;
		}
		#mp-brick-' . $post_id . ' .mp-stacks-icons-icon:before {' . 
			$shadow_css . '
			font-size:' . $mp_stacks_icon_size . 'px;
			box-sizing: border-box;
		}
		@media screen and (max-width: 600px){
			#mp-brick-' . $post_id . ' .mp-stacks-icon{ 
				width:' . '100%;
			}
		}';
		
	return $css_icons_output . $css_output;
		
}
add_filter('mp_brick_additional_css', 'mp_stacks_brick_content_output_css_icons', 10, 4);


/**
 * This function hooks to the brick output. If it is supposed to be a 'icon', then it will output the icon
 *
 * @access   public
 * @since    1.0.0
 * @return   void
 */
function mp_stacks_brick_content_output_icons($default_content_output, $mp_stacks_content_type, $post_id){
	
	//If this stack content type is set to be an image	
	if ($mp_stacks_content_type == 'icons'){
		
		//Set default value for $content_output to NULL
		$content_output = NULL;	
		
		//Get the icon we want to use
		$mp_stacks_icon_itself = mp_core_get_post_meta( $post_id, 'mp_stacks_icon_itself' );
		
		//Icons size
		$mp_stacks_icon_size = mp_core_get_post_meta($post_id, 'mp_stacks_icon_size', '100%');
		
		//Icons Link
		$mp_stacks_icon_link = mp_core_get_post_meta($post_id, 'mp_stacks_icon_link' );
		
		//Get Icons Output
		$icons_output = '<div class="mp-stacks-icon">';
					
			$icons_output .= '<div class="mp-stacks-icon-inner">';

				//If the user has saved an open type
				if ( !empty($icons_repeater['icon_link_type'])){
					
					//Set Image Open Type for Lightbox
					if ( $icons_repeater['icon_link_type'] == 'lightbox'){
						$class_name = ' mp-stacks-lightbox-link'; 
						$target = '';
					}
					else if($icons_repeater['icon_link_type'] == 'blank'){
						$target = '_blank';
						$class_name = '';	
					}
					else{
						$class_name = '';	
						$target = '_parent';	
					}
				}
				//If they haven't saved an open type
				else{
					$class_name = '';	
					$target = '_parent';
				}
											
				$icons_output .= '<div class="mp-stacks-icons-icon-container">';
					
					$icons_output .= !empty($mp_stacks_icon_link) ? '<a href="' . $mp_stacks_icon_link . '" class="mp-stacks-icons-icon-link ' . $class_name . '" target="' . $target . '">' : NULL;
																
							$icons_output .= '<div class="mp-stacks-icons-icon ' . $mp_stacks_icon_itself . '">';
							
								$icons_output .= '<div class="mp-stacks-icons-icon-title">' . $mp_stacks_icon_itself . '</div>';
							
							$icons_output .= '</div>';						
					
					$icons_output .= !empty($mp_stacks_icon_link) ? '</a>' : NULL;
				
				$icons_output .= '</div>';
		
			$icons_output .= '</div>';
			
		$icons_output .= '</div>';
							
		//Content output
		$content_output .= $icons_output;
		
		//Return
		return $content_output;
	}
	else{
		//Return
		return $default_content_output;
	}
}
add_filter('mp_stacks_brick_content_output', 'mp_stacks_brick_content_output_icons', 10, 3);