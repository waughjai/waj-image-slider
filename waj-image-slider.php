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
		require_once( 'vendor/autoload.php' );

		use WaughJ\HTMLImageSlider\HTMLImageSlider;
		use WaughJ\WPUploadImage\WPUploadImage;
		use WaughJ\WPUploadPicture\WPUploadPicture;
		use function WaughJ\TestHashItem\TestHashItemString;
		use function WaughJ\TestHashItem\TestHashItemIsTrue;
		use function WaughJ\PictureShortcodeToElementAttributes\TransformPictureShortcodeToElementAttributes;

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
				unset( $atts[ 'images' ] );
				$atts = TransformPictureShortcodeToElementAttributes( $atts );
				$picture_atts =
				[
					'img-attributes' => $atts[ 'img-attributes' ],
					'picture-attributes' => $atts[ 'picture-attributes' ],
					'source-attributes' => $atts[ 'source-attributes' ]
				];
				unset( $atts[ 'img-attributes' ], $atts[ 'picture-attributes' ], $atts[ 'source-attributes' ] );
				if ( $image_attr !== null )
				{
					$images = [];
					$image_ids = explode( ',', $image_attr );
					foreach ( $image_ids as $image_id )
					{
						$images[] = new WPUploadPicture( $image_id, $picture_atts );
					}

					add_action
					(
						'wp_footer',
						function()
						{
							wp_enqueue_script( 'waj-slider', plugins_url( '', __FILE__ ) . '/vendor/waughj/html-image-slider/js/slider.min.js', [], null );
						}
					);

					$zoom = TestHashItemIsTrue( $atts, 'zoom' );
					unset( $atts[ 'zoom' ] );
					return new HTMLImageSlider( $images, $zoom, $atts );
				}
				return '';
			}
		);
	}
?>
