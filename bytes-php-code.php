<?php
/**
 *  @package bytes-php-code
 *  @version 0.1
 */
/*
 * Plugin Name: Byte's PHP Code Widget Plugin  
 * Description: A widget that allows the mixing of PHP and html with before and after post support.  
 * Version: 0.1 
 * Author: ByteEnable
 * Author URI:
 */

// Create the widget
// The class name looks convoluted to avoid any possible conflicts
class wp_vxBEyz_code_widget extends WP_Widget {
	function __construct() {
		parent::__construct ( 
				// Base ID of the widget
				'wp_vxBEyz_code_widget', 
				
				// Widget name will appear in UI
				__ ( 'Byte\'s PHP Code Widget', 'wp_vxBEyz_code_widget_domain' ), 
				
				// Widget description
				array (
						'description' => __ ( 'Puts custom code in the sidebar', 'wp_vxBEyz_code_widget_domain' ) 
				) );
	}
	
	// Creating the widget front-end
	// This is the function where the actual work takes place.
	public function widget($args, $instance) {
		$title = apply_filters ( 'widget_title', $instance ['title'] );
		$regularCode = apply_filters ( 'widget_regularCode', $instance ['regularCode'] );
		$afterPostBool = apply_filters ( 'widget_afterPostBool', $instance ['afterPostBool'] );
		$beforePostBool = apply_filters ( 'widget_beforePostBool', $instance ['beforePostBool'] );
		$showTitle = apply_filters ( 'widget_showTitle', $instance ['showTitle'] );
		// Before and after widget arguments are defined by themes.
		echo $args ['before_widget'];
		
		// Output the title name if one exists.
		if (! empty ( $title ) && $showTitle ) {
			echo $args ['before_title'] . $title . $args ['after_title'];
		}
		
		// Initialize the adsense variable
		$myMobileAdsenseCode = "";
		
		// This is where the code is evaluted and or executed with the result printed.
		// Evalute $regularCode variable
		
		ob_start ();
		eval ( '?>' . $regularCode );
		// Get the result of $regularCode execution;
		$regularCode = ob_get_contents ();
		ob_end_clean ();
		if (wp_is_mobile () && ! empty ( $myMobileAdsenseCode )) {
			include_once "inc/adsense-support.php";
			$regularCode = google_mobile_ad ( $myMobileAdsenseCode );
		}
		if ( ! empty( $showTitle ) ) {
			$regularCode = $showTitle . $regularCode;
		}
		if ( ! wp_is_mobile() ) {
			echo __ ( $regularCode, 'wp_vxBEyz_code_widget_domain' );
		}
		
		echo $args ['after_widget'];
	}
	
	// Widget Backend - process the form data
	public function form($instance) {
		if (isset ( $instance ['title'] )) {
			$title = $instance ['title'];
		}
		if (isset ( $instance ['regularCode'] )) {
			$regularCode = $instance ['regularCode'];
		} else { // Clear it.
			$regularCode = __ ( '', 'wp_vxBEyz_code_widget_domain' );
		}
		if (isset ( $instance ['beforePostBool'] )) {
			$beforePostBool = $instance ['beforePostBool'];
		} else { // Clear it.
			$beforePostBool = __ ( '', 'wp_vxBEyz_code_widget_domain' );
		}
		if (isset ( $instance ['afterPostBool'] )) {
			$afterPostBool = $instance ['afterPostBool'];
		} else { // Clear it.
			$afterPostBool = __ ( '', 'wp_vxBEyz_code_widget_domain' );
		}
		if (isset ( $instance ['showTitle'] )) {
			$showTitle = $instance ['showTitle'];
		} else { // Clear it.
			$showTitle = __ ( '', 'wp_vxBEyz_code_widget_domain' );
		}
		// Widget admin form
		?>
<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
	<input class="widefat"
		id="<?php echo $this->get_field_id( 'title' ); ?>"
		name="<?php echo $this->get_field_name( 'title' ); ?>" type="text"
		value="<?php echo esc_attr( $title ); ?>" /> <label
		for="<?php echo $this->get_field_id( 'Code' ); ?>"><?php _e( 'Code:' ); ?></label>
	<textarea class="widefat" rows="5"
		id="<?php echo $this->get_field_id( 'regularCode' ); ?>"
		name="<?php echo $this->get_field_name( 'regularCode' ); ?>"><?php echo esc_attr( $regularCode ); ?></textarea>

	<label for="<?php echo $this->get_field_id( 'beforePostBool' ); ?>">Before
		Post Insertion:</label> <input class="checkbox" type="checkbox"
		<?php checked( $instance['beforePostBool'], 'on' ); ?>
		id="<?php echo $this->get_field_id( 'beforePostBool' ); ?>"
		name="<?php echo $this->get_field_name( 'beforePostBool' ); ?>" /> <br>
		
	<label for="<?php echo $this->get_field_id( 'afterPostBool' ); ?>">After
		Post Insertion:&nbsp;&nbsp;</label> <input class="checkbox"
		type="checkbox" <?php checked( $instance['afterPostBool'], 'on' ); ?>
		id="<?php echo $this->get_field_id( 'afterPostBool' ); ?>"
		name="<?php echo $this->get_field_name( 'afterPostBool' ); ?>" /> <br>
		
	<label for="<?php echo $this->get_field_id( 'showTitle' ); ?>">Show
		title in ouput:&nbsp;&nbsp;</label> <input class="checkbox"
		type="checkbox" <?php checked( $instance['showTitle'], 'on' ); ?>
		id="<?php echo $this->get_field_id( 'showTitle' ); ?>"
		name="<?php echo $this->get_field_name( 'showTitle' ); ?>" />
</p>
<?php
	}
	
	// Updating widget replacing old instances with new
	public function update($new_instance, $old_instance) {
		$instance = array ();
		// Clean title for grins. The plugin by default can be hazardous.
		$instance ['title'] = (! empty ( $new_instance ['title'] )) ? strip_tags ( $new_instance ['title'] ) : '';
		// Only authorized user can insert code.
		if (current_user_can ( 'unfiltered_html' )) {
			$instance ['regularCode'] = $new_instance ['regularCode'];
			$instance ['beforePostBool'] = $new_instance ['beforePostBool'];
			$instance ['afterPostBool'] = $new_instance ['afterPostBool'];
			$instance ['showTitle'] = $new_instance ['showTitle'];
		} 		// Non authorized user has his or her input cleaned (stripped of any php or html).
		else {
			$instance ['regularCode'] = stripslashes ( wp_filter_post_kses ( addslashes ( $new_instance ['regularCode'] ) ) );
			$instance ['beforePostBool'] = $new_instance ['beforePostBool'];
			$instance ['afterPostBool'] = $new_instance ['afterPostBool'];
			$instance ['showTitle'] = $new_instance ['showTitle'];
		}
		// User in after post.
		update_option ( 'bytes_post_code', $instance ['regularCode'] );
		update_option ( 'bytes_before_post_bool', $instance ['beforePostBool'] );
		update_option ( 'bytes_after_post_bool', $instance ['afterPostBool'] );
		return $instance;
	}
} // class wp_vxBEyz_code_widget ends here
  
// Register and load the widget
function wp_vxBEyz_code_load_widget() {
	register_widget ( 'wp_vxBEyz_code_widget' );
}
add_action ( 'widgets_init', 'wp_vxBEyz_code_load_widget' );

// After the post code
// Add database code to store widget data

// What to do when the plugin is activated?

register_activation_hook ( __FILE__, 'bytes_php_code_install' );

// What to do when the plugin is deactivated? */

register_deactivation_hook ( __FILE__, 'bytes_php_code_remove' );

// Delete all the settings added.
function bytes_php_code_remove() {
	delete_option ( 'bytes_post_code' );
	delete_option ( 'bytes_before_post_bool' );
	delete_option ( 'bytes_after_post_bool' );
}
function bytes_php_code_install() {
	add_option ( 'bytes_post_code', '' );
	add_option ( 'bytes_after_post_bool', '' );
	add_option ( 'bytes_before_post_bool', '' );
}
function custom_content_after_post($content) {
	// Initialize the adsense variable
	$myMobileAdsenseCode = "";
	
	if (is_single () && (get_option ( 'bytes_after_post_bool' ) || get_option ( 'bytes_before_post_bool' ))) {
		// This is where the code is evaluted and or executed with the result printed.
		// Evalute the bytes_post_code variable
		
		ob_start ();
		eval ( '?>' . get_option ( 'bytes_post_code' ) );
		// Get the result of $regularCode execution;
		$regularCode = ob_get_contents ();
		ob_end_clean ();
		if (wp_is_mobile () && ! empty ( $myMobileAdsenseCode )) {
			include_once "inc/adsense-support.php";
			if (get_option ( 'bytes_before_post_bool' )) {
				$content = google_mobile_ad ( $myMobileAdsenseCode ) . $content;
			} elseif (get_option ( 'bytes_after_post_bool' )) {
				$content .= google_mobile_ad ( $myMobileAdsenseCode );
			}
		} else {
			if (get_option ( 'bytes_before_post_bool' )) {
				$content = get_option ( 'bytes_post_code' ) . $content;
			}
			if (get_option ( 'bytes_after_post_bool' )) {
				$content .= get_option ( 'bytes_post_code' );
			}
		}
	}
	return $content;
}
add_filter ( "the_content", "custom_content_after_post" );
?>
