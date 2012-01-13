<?php
/*
Plugin Name: Piecemaker for Theme Blvd Themes
Description: This plugin adds the Piecemaker 3D Flash slider to the slider types included with the Theme Blvd theme framework. Note that your theme must be running Theme Blvd framework version 2.0.4+ for this plugin to work properly.
Version: 0.2
Author: Jason Bobich
Author URI: http://jasonbobich.com
License: GPL2
*/

/*
Copyright 2012 JASON BOBICH

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*-----------------------------------------------------------------------------------*/
/* Setup
/*-----------------------------------------------------------------------------------*/

/* Define Constants */

function themeblvd_piecemaker_setup() {
	global $_wp_additional_image_sizes;
	define( 'TB_PIECEMAKER_IMAGE_SIZE', 'slider-large' );
	define( 'TB_PIECEMAKER_IMAGE_WIDTH', $_wp_additional_image_sizes[TB_PIECEMAKER_IMAGE_SIZE]['width'] );
	define( 'TB_PIECEMAKER_IMAGE_HEIGHT', $_wp_additional_image_sizes[TB_PIECEMAKER_IMAGE_SIZE]['height'] );
}
add_action( 'after_setup_theme', 'themeblvd_piecemaker_setup', 999 );

/* Add Scripts */

function themeblvd_piecemaker_scripts() {
   wp_enqueue_script( 'swfobject' );
}
add_action( 'wp_enqueue_scripts', 'themeblvd_piecemaker_scripts' );

/* Add CSS */

function themeblvd_piecemaker_css () {
	wp_register_style( 'themeblvd_piecemaker_styles', plugins_url( 'assets/style.css' , __FILE__ ), false, '1.0' );
	wp_enqueue_style( 'themeblvd_piecemaker_styles' );
}
add_action( 'wp_print_styles', 'themeblvd_piecemaker_css' );

/*-----------------------------------------------------------------------------------*/
/* Admin Processses
/*-----------------------------------------------------------------------------------*/

/* Add to Slider Builder admin interface */

function slider_blvd_piecemaker_slider( $sliders ) {
	// Slide types
	$types = array(
		'image' => array(
			'name' => __( 'Image Slide', TB_GETTEXT_DOMAIN ),
			'main_title' => __( 'Setup Image', TB_GETTEXT_DOMAIN )
		)
	);
	// Options
	$options = array(
		array(
			'id'		=> 'autoplay_duration',
			'name'		=> __( 'Autoplay Duration', TB_GETTEXT_DOMAIN ),
			'desc' 		=> __( 'Enter the time you would like in between transitions in seconds.', TB_GETTEXT_DOMAIN ),
			'std'		=> '5',
			'type'		=> 'text'
		),
		array(
			'id'		=> 'pieces',
			'name'		=> __( 'Pieces', TB_GETTEXT_DOMAIN ),
			'desc' 		=> __( 'This is the amount of pieces that the images will break into upon transitioning. Keep in mind that this theme is setup to compensate for a confined area. So, the more pieces your break the images into, the farther back the slideshow will go upon rotation.', TB_GETTEXT_DOMAIN ),
			'std'		=> '15',
			'type'		=> 'text'
		),
		array(
			'id'		=> 'transition_speed',
			'name'		=> __( 'Transition Speed', TB_GETTEXT_DOMAIN ),
			'desc' 		=> __( 'Enter the amount of time in seconds you\'d like for each transition to take place. This will effect the speed at which the pieces rotate.', TB_GETTEXT_DOMAIN ),
			'std'		=> '2',
			'type'		=> 'text'
		)
	);
	// Put it all together
	$sliders['piecemaker'] = array(
		'name' 		=> 'Piecemaker 3D',
		'id'		=> 'piecemaker',
		'types'		=> $types,
		'positions'	=> array('full' => 'Full-Size'),
		'elements'	=> array('image_link', 'headline', 'description'),
		'options'	=> $options
	);
	return $sliders;
}
add_filter( 'slider_blvd_recognized_sliders', 'slider_blvd_piecemaker_slider' );

/* Create XML file when user saves slider */

function themeblvd_piecemaker_save( $slider_id, $slides, $settings ) {
	
	// Grab data
	$post = get_post( $slider_id );
	$slider_name = $post->post_name;
	$slides = get_post_meta( $slider_id, 'slides', true );
	$options = get_post_meta( $slider_id, 'settings', true );

	// Setup images for slider
	$images = '';
	$num = count($slides);
	$counter = 1;
	foreach( $slides as $slide ) {
		// Setup elements
		$elements = array( 'image_link' => '', 'headline' => '', 'description' => '' );
		if( isset( $slide['elements']['include'] ) ) {
			// Link
			if( in_array( 'image_link', $slide['elements']['include'] ) )
				if( isset( $slide['elements']['image_link']['url'] ) )
					$elements['image_link'] = $slide['elements']['image_link']['url'];
			// Headline
			if( in_array( 'headline', $slide['elements']['include'] ) )
				if( isset( $slide['elements']['headline'] ) )
					$elements['headline'] = $slide['elements']['headline'];
			// Description
			if( in_array( 'description', $slide['elements']['include'] ) )
				if( isset( $slide['elements']['description'] ) )
					$elements['description'] = $slide['elements']['description'];
		}
		// Start output
		if( $counter != 1 ) $images .= "		";
		$image_url = wp_get_attachment_image_src( $slide['image']['id'], TB_PIECEMAKER_IMAGE_SIZE );
		// Start Image tag
		$images .= '<Image Source="'.$image_url[0].'"';
		// Headline
		if( isset( $slide['elements']['include'] ) && in_array( 'headline', $slide['elements']['include'] ) )
			if( isset( $slide['elements']['headline'] ) )
				$images .= ' Title="'.$slide['elements']['headline'].'"';
		// Finish opening Image tag
		$images .= '>';
		// Text
		if( $elements['description'] ) {
			$images .= '<Text>';
			// Headline of Text section
			if( $elements['headline'] )
				$images .= '&lt;h1&gt;'.$elements['headline'].'&lt;/h1&gt;';
			// Description of Text section
			if( $elements['description'] )
				$images .= '&lt;p&gt;'.$elements['description'].'&lt;/p&gt;';
			$images .= '</Text>';
		}
		// Hyperlink
		if( $elements['image_link'] ) {
			$target = $slide['elements']['image_link']['target'];
			if( $elements['image_link'] == 'lightbox' )
				$target = '_blank';
			$images .= '<Hyperlink URL="'.$elements['image_link'].'" Target="'.$target.'" />';
		}
		$images .= '</Image>';
		if( $counter != $num ) $images .= "\n";
		$counter++;
	}
	
	// Setup piecemaker settings
	$half_width = TB_PIECEMAKER_IMAGE_WIDTH / 2;
	$settings = '<Settings ImageWidth="'.TB_PIECEMAKER_IMAGE_WIDTH.'" ImageHeight="'.TB_PIECEMAKER_IMAGE_HEIGHT.'" LoaderColor="0x333333" InnerSideColor="0x222222" SideShadowAlpha="0.8" DropShadowAlpha="0.7" DropShadowDistance="25" DropShadowScale="0.95" DropShadowBlurX="40" DropShadowBlurY="4" MenuDistanceX="20" MenuDistanceY="50" MenuColor1="0x999999" MenuColor2="0x333333" MenuColor3="0xFFFFFF" ControlSize="100" ControlDistance="20" ControlColor1="0x222222" ControlColor2="0xFFFFFF" ControlAlpha="0.8" ControlAlphaOver="0.95" ControlsX="'.$half_width.'" ControlsY="280&#xD;&#xA;" ControlsAlign="center" TooltipHeight="30" TooltipColor="0x222222" TooltipTextY="5" TooltipTextStyle="P-Italic" TooltipTextColor="0xFFFFFF" TooltipMarginLeft="5" TooltipMarginRight="7" TooltipTextSharpness="50" TooltipTextThickness="-100" InfoWidth="400" InfoBackground="0xffffff" InfoBackgroundAlpha="0.95" InfoMargin="15" InfoSharpness="0" InfoThickness="0" Autoplay="'.$options['autoplay_duration'].'" FieldOfView="45"></Settings>';
	
	// Setup transitions for slider
	$transitions = '<Transition Pieces="'.$options['pieces'].'" Time="'.$options['transition_speed'].'" Transition="easeInOutElastic" Delay="0.03" DepthOffset="300" CubeDistance="10"></Transition>';
	
	// Generate all XML to write to file
	$xml = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Piecemaker>
	<Contents>
		$images
	</Contents>
$settings
	<Transitions>
		$transitions
	</Transitions>
</Piecemaker>
XML;
	
	$xml_file = dirname(__FILE__).'/xml/'.$slider_name.'.xml';
	$config_file = @fopen($xml_file, 'w+');
    fwrite( $config_file, $xml );
}
add_action( 'themeblvd_save_slider_piecemaker', 'themeblvd_piecemaker_save', 10, 3 );

/*-----------------------------------------------------------------------------------*/
/* Frontend Display
/*-----------------------------------------------------------------------------------*/

/* Display slider on frontend */

function themeblvd_piecemaker_sider_display( $slider, $settings, $slides ) {			
	$height = TB_PIECEMAKER_IMAGE_HEIGHT + 75;
	?>
	<script>
      var flashvars = {};
      flashvars.cssSource = "<?php echo plugins_url( 'assets/piecemaker.css' , __FILE__ ); ?>";
      flashvars.xmlSource = "<?php echo plugins_url( 'xml/'.$slider.'.xml', __FILE__ ); ?>";
      var params = {};
	  params.play = "true";
	  params.menu = "false";
	  params.scale = "showall";
	  params.wmode = "transparent";
	  params.allowfullscreen = "true";
	  params.allowscriptaccess = "always";
	  params.allownetworking = "all";
	  swfobject.embedSWF('<?php echo plugins_url( 'assets/piecemaker.swf' , __FILE__ ); ?>', 'piecemaker-<?php echo $slider; ?>', '100%', '<?php echo $height; ?>', '10', null, flashvars, params, null);
    </script>
	
	<div class="themeblvd-piecemaker-wrapper">
		<div class="themeblvd-piecemaker">
			<div id="piecemaker-<?php echo $slider; ?>">
				<!-- Flash Inserted Here -->
			</div><!-- #piecemaker-<?php echo $slider; ?> (end) -->
		</div><!-- .themeblvd-piecemaker (end) -->
		<div class="themeblvd-piecemaker-fallback">
			<ul>
				<?php if( $slides ) : ?>
					<?php foreach( $slides as $slide ) : ?>
						<li>
							<?php $image_url = wp_get_attachment_image_src( $slide['image']['id'], TB_PIECEMAKER_IMAGE_SIZE ); ?>
							<img src="<?php echo $image_url[0]; ?>" />
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
			</ul>
		</div><!-- .themeblvd-piecemaker-fallback (end) -->
	</div><!-- .themeblvd-piecemaker-wrapper (end) -->
	<?php
}
add_action( 'themeblvd_piecemaker_slider', 'themeblvd_piecemaker_sider_display', 10, 3 );