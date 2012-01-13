<?php
// Kill it if no slider ID is passed in
//if( ! isset( $_GET['slider_id'] ) )
	//die( 'No slider ID has been specified.' );

// Setup URL to WordPres
$absolute_path = __FILE__;
$path_to_wp = explode( 'wp-content', $absolute_path );
$wp_url = $path_to_wp[0];

// Access WordPress
require_once( $wp_url.'/wp-load.php' );

global $_themeblvd_config;
echo '<pre>'; print_r($_themeblvd_config); echo "</pre>";

// Get slider info
$post_id = themeblvd_post_id_by_name( $_GET['slider_id'], 'tb_slider' );


//$post_id = themeblvd_post_id_by_name( 'asdasd', 'tb_slider' );
$settings = get_post_meta( $post_id, 'settings', true );
$slides = get_post_meta( $post_id, 'slides', true );


//echo '<pre>'; print_r($slides); echo '</pre>';
//echo '<pre>'; print_r($settings); echo '</pre>';

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
?>
<Piecemaker>
	<Contents>
		<?php foreach( $slides as $slide ) : ?>
			<Image Source="<?php echo $slide['image']['url']; ?>"></Image>
		<?php endforeach; ?>
	</Contents>

	<Settings ImageWidth="940" ImageHeight="350" LoaderColor="0x333333" InnerSideColor="0x222222" SideShadowAlpha="0.8" DropShadowAlpha="0.7" DropShadowDistance="25" DropShadowScale="0.95" DropShadowBlurX="40" DropShadowBlurY="4" MenuDistanceX="20" MenuDistanceY="50" MenuColor1="0x999999" MenuColor2="0x333333" MenuColor3="0xFFFFFF" ControlSize="100" ControlDistance="20" ControlColor1="0x222222" ControlColor2="0xFFFFFF" ControlAlpha="0.8" ControlAlphaOver="0.95" ControlsX="450" ControlsY="280&#xD;&#xA;" ControlsAlign="center" TooltipHeight="30" TooltipColor="0x222222" TooltipTextY="5" TooltipTextStyle="P-Italic" TooltipTextColor="0xFFFFFF" TooltipMarginLeft="5" TooltipMarginRight="7" TooltipTextSharpness="50" TooltipTextThickness="-100" InfoWidth="400" InfoBackground="0x000000" InfoBackgroundAlpha="0.95" InfoMargin="15" InfoSharpness="0" InfoThickness="0" Autoplay="5" FieldOfView="45"></Settings>
	<Transitions>
		<Transition Pieces="15" Time="2" Transition="easeInOutElastic" Delay="0.03" DepthOffset="300" CubeDistance="10"></Transition>
	</Transitions>
</Piecemaker>



