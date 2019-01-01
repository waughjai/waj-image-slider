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

		use WaughJ\HTMLImageSlider\HTMLImageSlider;
		use WaughJ\WPUploadImage\WPUploadImage;
		use WaughJ\WPUploadPicture\WPUploadPicture;
		use function WaughJ\TestHashItem\TestHashItemString;
		use function WaughJ\TestHashItem\TestHashItemIsTrue;

		add_action
		(
			'wp_enqueue_scripts',
			function()
			{
				wp_enqueue_style( 'waj-slider', plugins_url( '', __FILE__ ) . '/vendor/waughj/html-image-slider/css/slider.min.css', [], null );
			}
		);

		add_shortcode
		(
			'waj-image-slider',
			function( $atts )
			{
				$image_attr = TestHashItemString( $atts, 'images', null );
				if ( $image_attr !== null )
				{
					$images = [];
					$image_ids = explode( ',', $image_attr );
					foreach ( $image_ids as $image_id )
					{
						$images[] = new WPUploadPicture( $image_id );
					}

					add_action
					(
						'wp_footer',
						function()
						{
							wp_enqueue_script( 'waj-slider', plugins_url( '', __FILE__ ) . '/vendor/waughj/html-image-slider/js/slider.min.js', [], null );
						}
					);

					return new HTMLImageSlider( $images, TestHashItemIsTrue( $atts, 'zoom' ) );
				}
				return '';
			}
		);
	}
?>
