<?php
	/*
	Plugin Name:  WAJ Image Slider
	Plugin URI:   https://github.com/waughjai/waj-image-slider
	Description:  Plugin that creates shortcode for easy creation o' image sliders.
	Version:      1.0.0
	Author:       Jaimeson Waugh
	Author URI:   https://www.jaimeson-waugh.com
	License:      GPL2
	License URI:  https://www.gnu.org/licenses/gpl-2.0.html
	Text Domain:  waj-image-slider
	*/

	namespace WaughJ\WPImageSlider
	{
		error_reporting( E_ALL );
		ini_set( 'display_errors', 1 );
		require_once( 'vendor/autoload.php' );
		use function WaughJ\TestHashItem\TestHashItemString;

		add_shortcode
		(
			'waj-image-slider',
			function( $atts )
			{
				$image_attr = TestHashItemString( $atts, 'images', null );
				if ( $image_attr !== null )
				{
					$image_ids = explode( ',', $image_attr );
				}
				return '';
			}
		);
	}
?>
