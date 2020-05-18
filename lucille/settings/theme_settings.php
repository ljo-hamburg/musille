<?php

define("LC_SWP_PRINT_SETTINGS", false);

function LUCILLE_SWP_setup_admin_menus()
{

	add_theme_page(
        'Lucille Theme Settings', /* page title*/
		'Lucille Settings',  /* menu title */
		'administrator',    /*capability*/
        'lucille_menu_page',  /*menu_slug*/
		'LUCILLE_SWP_option_page_settings',  /*function */
		2
		);		
}
add_action("admin_menu", "LUCILLE_SWP_setup_admin_menus");

function LUCILLE_SWP_option_page_settings()
{
?>  
	<!-- Create a header in the default WordPress 'wrap' container -->  
    <div class="wrap swp-settings-wrap">  
        <div id="icon-themes" class="icon32"></div>  
        <h2>Lucille Music Theme Settings</h2>
       	<div class="swp-settings-intro">
			<a href="https://themeforest.net/item/lucille-music-wordpress-theme/19078867/comments" class="button helper-quick-link  button-primary" target="_blank">
				<?php echo esc_html__("Have A Question", "slide"); ?>
			</a>
			<a href="<?php echo admin_url( 'options-general.php?page=Lucille-Post-Types-Settings'); ?>" class="button helper-quick-link  button-primary" target="_blank">
				<?php echo esc_html__("Music Core Settings", "slide"); ?>
			</a>
       	</div>

  
        <!-- Make a call to the WordPress function for rendering errors when settings are saved. -->  
        <?php settings_errors(); ?> 
		
		<?php  
		if(isset($_GET['tab'])) {
			$active_tab = $_GET['tab'];  
		} else {
		    $active_tab = 'general_options';
		}
		?>  		
		
		<h2 class="nav-tab-wrapper">
			<?php
				$general_options_class = $active_tab == 'general_options' ? 'nav-tab-active' : '';
				$social_options_class = $active_tab == 'social_options' ? 'nav-tab-active' : '';
				$footer_options_class = $active_tab == 'footer_options' ? 'nav-tab-active' : '';
				$fonts_options_class = $active_tab == 'fonts_options' ? 'nav-tab-active' : '';
			?>
			<a href="?page=lucille_menu_page&tab=general_options" class="nav-tab <?php echo esc_attr($general_options_class); ?>">General Options</a>
			<a href="?page=lucille_menu_page&tab=social_options" class="nav-tab <?php echo esc_attr($social_options_class); ?>">Social Options</a>  
			<a href="?page=lucille_menu_page&tab=footer_options" class="nav-tab <?php echo esc_attr($footer_options_class); ?>">Footer Options</a>  
			<a href="?page=lucille_menu_page&tab=fonts_options" class="nav-tab <?php echo esc_attr($fonts_options_class); ?>">Fonts</a>
		</h2> 		
  
        <!-- Create the form that will be used to render our options -->  
        <form method="post" action="options.php" class="active-tab-<?php echo esc_attr($active_tab); ?> swp-settings-form"> 
			<?php
				if ($active_tab == 'general_options') {
					settings_fields( 'lucille_theme_general_options'); 
					do_settings_sections( 'lucille_theme_general_options');
				} elseif ($active_tab == 'social_options') {
					settings_fields( 'lucille_theme_social_options'); 
					do_settings_sections( 'lucille_theme_social_options');
				} elseif ($active_tab == 'footer_options') {
					settings_fields( 'lucille_theme_footer_options'); 
					do_settings_sections( 'lucille_theme_footer_options');
				} elseif ($active_tab == 'fonts_options') {
					settings_fields( 'lucille_theme_fonts_options'); 
					do_settings_sections( 'lucille_theme_fonts_options');
				}
				
				submit_button();
			?>  
        </form>  
    </div><!-- /.wrap -->  
<?php 
}



/*
	Initialize theme options
*/
add_action('admin_init', 'LUCILLE_SWP_initialize_theme_options');
function LUCILLE_SWP_initialize_theme_options() {
	$crt_theme = wp_get_theme();

	$lc_swp_available_theme_options = array (
		array (
			'option_name'		=> 'lucille_theme_general_options',
			'section_id'		=> 'lucille_general_settings_section',
			'title'				=> esc_html__('General Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_general_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_general_options'
		),
		array (
			'option_name'		=> 'lucille_theme_social_options',
			'section_id'		=> 'lucille_social_settings_section',
			'title'				=> esc_html__('Social Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_social_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_social_options'
		),
		array (
			'option_name'		=> 'lucille_theme_footer_options',
			'section_id'		=> 'lucille_footer_settings_section',
			'title'				=> esc_html__('Footer Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_footer_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_footer_options'
		),
		array (
			'option_name'		=> 'lucille_theme_fonts_options',
			'section_id'		=> 'lucille_fonts_settings_section',
			'title'				=> esc_html__('Fonts Options', 'lucille'),
			'callback'			=> 'LUCILLE_SWP_fonts_options_callback',
			'sanitize_callback'	=> 'LUCILLE_SWP_sanitize_fonts_options'
		)		
	);

	foreach($lc_swp_available_theme_options as $theme_option) {
		/*
			Add available options
		*/
		if (false == get_option($theme_option['option_name'])) {
			add_option($theme_option['option_name']);
		}

		/*
			Add setting sections
		*/
		add_settings_section (
			$theme_option['section_id'],		// ID used to identify this section and with which to register options
			$theme_option['title'],				// Title to be displayed on the administration page
			$theme_option['callback'],			// Callback used to render the description of the section
			$theme_option['option_name']		// Page on which to add this section of options
		);
	}

	/*
		call add_settings_field to add theme options
	*/
	LUCILLE_SWP_add_settings_fields();

	/*
		Register settings
	*/
	foreach($lc_swp_available_theme_options as $theme_option) {
		register_setting(
			//option group - A settings group name. Must exist prior to the register_setting call. This must match the group name in settings_fields()
			$theme_option['option_name'],
			// option_name -  The name of an option to sanitize and save. 
			$theme_option['option_name'],
			//  $sanitize_callback (callback) (optional) A callback function that sanitizes the option's value
			$theme_option['sanitize_callback']  	
		);
	}
}

function LUCILLE_SWP_general_options_callback() {
	?>
    <p>
		<?php echo esc_html__('Setup custom logo and favicon.', 'lucille'); ?>
    </p>
	<?php
	/*print theme settings*/
	if (LC_SWP_PRINT_SETTINGS) {
		$general = get_option('lucille_theme_general_options');

		?>
        <pre>lucille_theme_general_options:
			<?php echo (json_encode($general)); ?>
		</pre>
		<?php
	}
}
 
function LUCILLE_SWP_social_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Provide the URL to the social profiles you would like to display.', 'lucille'); ?>
	</p>
	<?php	
}

function LUCILLE_SWP_footer_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Setup footer text for the copyright area, footer text URL and other footer related options. Also setup the footer widget area.', 'lucille'); ?>
	</p>
	<?php
}

function LUCILLE_SWP_fonts_options_callback() {
	?>
	<p>
		<?php echo esc_html__('Please choose the fonts.', 'lucille'); ?>
	</p>
	<?php
}

/*
	Add setting fields
*/
function LUCILLE_SWP_add_settings_fields() {
	/*general options array*/
	$general_settings = array (
		array (
			'id'		=> 'lc_custom_logo',
			'label'		=> esc_html__('Upload logo image', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_logo_select_cbk'
		),
		array (
			'id'		=> 'lc_custom_innner_bg_image',
			'label'		=> esc_html__('Upload custom background image', 'lucille'),
			'callback'	=> 'Lucille_SWP_innner_bg_image_select_cbk'
		),
		array (
			'id'		=> 'lc_menu_style',
			'label'		=> esc_html__('Choose menu style', 'lucille'),
			'callback'	=> 'Lucille_SWP_menu_style_cbk'
		),
		array (
			'id'		=> 'lc_menu_creative_close',
			'label'		=> esc_html__('Close creative menu on click', 'lucille'),
			'callback'	=> 'Lucille_SWP_menu_creative_close_cbk'
		),
		array (
			'id'		=> 'lc_enable_sticky_menu',
			'label'		=> esc_html__('Enable sticky menu', 'lucille'),
			'callback'	=> 'Lucille_SWP_enable_sticky_menu_cbk'
		),		
		array (
			'id'		=> 'lc_header_footer_width',
			'label'		=> esc_html__('Choose header/footer width', 'lucille'),
			'callback'	=> 'Lucille_SWP_header_footer_width_cbk'
		),
		array (
			'id'		=> 'lc_default_color_scheme',
			'label'		=> esc_html__('Choose default color scheme', 'lucille'),
			'callback'	=> 'Lucille_SWP_default_colorscheme_cbk'
		),
		array (
			'id'		=> 'lc_back_to_top',
			'label'		=> esc_html__('Enable back to top button', 'lucille'),
			'callback'	=> 'Lucille_SWP_back_to_top_cbk'
		),
		array (
			'id'		=> 'lc_hide_search_icon',
			'label'		=> esc_html__('Hide search icon', 'lucille'),
			'callback'	=> 'Lucille_SWP_hide_search_icon_cbk'
		),
		array (
			'id'		=> 'lc_show_title_event_list',
			'label'		=> esc_html__('Show event title on list', 'lucille'),
			'callback'	=> 'Lucille_SWP_show_title_event_list_cbk'
		),
		array (
			'id'		=> 'lc_hide_sharing_icons',
			'label'		=> esc_html__('Hide sharing icons', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_hide_sharing_icons_cbk'
		),
		array (
			'id'		=> 'lc_auto_featured_image',
			'label'		=> esc_html__('Auto featured image', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_auto_featured_image_cbk'
		),
		array (
			'id'		=> 'lc_remove_singlepost_sidebar',
			'label'		=> esc_html__('Remove sidebar on single post', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_remove_singlepost_sidebar_cbk'
		),
		array (
			'id'		=> 'lc_remove_blog_post_meta',
			'label'		=> esc_html__('Remove posts meta from blog page', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_remove_blog_post_meta_cbk'
		),
		array (
			'id'		=> 'lc_remove_single_blog_post_meta',
			'label'		=> esc_html__('Remove posts meta from single post', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_remove_single_blog_post_meta_cbk'
		),		
		array (
			'id'		=> 'lc_shop_has_sidebar',
			'label'		=> esc_html__('Shop pages have sidebar', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_shop_has_sidebar_cbk'
		),
		array (
			'id'		=> 'lc_show_img_captions',
			'label'		=> esc_html__('Show image caption on hover', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_show_img_captions_cbk'
		),
		array (
			'id'		=> 'lc_show_cpt_tax',
			'label'		=> esc_html__('Show custom post types categories', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_show_cpt_tax_cbk'
		),
		array (
			'id'		=> 'lc_show_album_date',
			'label'		=> esc_html__('Show music album date as', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_show_album_date_cbk'
		),
		array (
			'id'		=> 'swp_show_download_button',
			'label'		=> esc_html__('Show download button in picture preview', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_swp_show_download_button_cbk'
		)			
	);

	foreach($general_settings as $general_setting) {
	    add_settings_field(   
	        $general_setting['id'],         		// ID used to identify the field throughout the theme                
	        $general_setting['label'],              // The label to the left of the option interface element            
	        $general_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_general_options',   		// The page on which this option will be displayed  
	        'lucille_general_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*social options array*/
	$social_settings = array(
		array (
			'id'		=> 'lc_fb_url',
			'label'		=> esc_html__('Facebook URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_fb_url_cbk'			
		),
		array (
			'id'		=> 'lc_twitter_url',
			'label'		=> esc_html__('Twitter URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_twitter_url_cbk'			
		),
		/*YouTube, Vimeo, SoundCloud, Myspace, Pinterest, iTunes*/
		array (
			'id'		=> 'lc_youtube_url',
			'label'		=> esc_html__('YouTube URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_youtube_url_cbk'			
		),
		array (
			'id'		=> 'lc_soundcloud_url',
			'label'		=> esc_html__('SoundCloud URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_soundcloud_url_cbk'			
		),
		/*no font awesome icon for myspace*/
		array (
			'id'		=> 'lc_itunes_url',
			'label'		=> esc_html__('iTunes URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_itunes_url_cbk'			
		),
		array (
			'id'		=> 'lc_pinterest_url',
			'label'		=> esc_html__('Pinterest URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_pinterest_url_cbk'			
		),
		array (
			'id'		=> 'lc_instagram_url',
			'label'		=> esc_html__('Instagram URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_instagram_url_cbk'			
		),
		array (
			'id'		=> 'lc_snapchat_url',
			'label'		=> esc_html__('Snapchat URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_snapchat_url_cbk'			
		),
		array (
			'id'		=> 'lc_gplay_url',
			'label'		=> esc_html__('Google Play URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_gplay_url_cbk'			
		),
		array (
			'id'		=> 'lc_linkedin_url',
			'label'		=> esc_html__('LinkedIn URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_linkedin_url_cbk'			
		),
		array (
			'id'		=> 'lc_spotify_url',
			'label'		=> esc_html__('Spotify URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_spotify_url_cbk'			
		),
		array (
			'id'		=> 'lc_imdb_url',
			'label'		=> esc_html__('IMDB URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_imdb_url_cbk'			
		),
		array (
			'id'		=> 'lc_vimeo_url',
			'label'		=> esc_html__('Vimeo URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_vimeo_url_cbk'			
		),
		array (
			'id'		=> 'lc_vk_url',
			'label'		=> esc_html__('VK URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_vk_url_cbk'			
		),
		array (
			'id'		=> 'lc_amazon_music_url',
			'label'		=> esc_html__('Amazon Music URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_amazon_music_url_cbk'			
		),
		array (
			'id'		=> 'lc_bandcamp_url',
			'label'		=> esc_html__('Bandcamp URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_bandcamp_url_cbk'			
		)
	);

	foreach($social_settings as $social_setting) {
	    add_settings_field(   
	        $social_setting['id'],         		// ID used to identify the field throughout the theme                
	        $social_setting['label'],              // The label to the left of the option interface element            
	        $social_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_social_options',   		// The page on which this option will be displayed  
	        'lucille_social_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*footer options array*/
	$footer_settings = array(
		array(
			'id'		=> 'lc_footer_widgets_color_scheme',
			'label'		=> esc_html__('Footer widgets color scheme', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_footer_widget_cs_cbk'		
		),
		array(
			'id'		=> 'lc_footer_widgets_background_image',
			'label'		=> esc_html__('Footer widgets Background Image', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_footer_widget_bgimg_cbk'		
		),
		array(
			'id'		=> 'lc_footer_widgets_background_color',
			'label'		=> esc_html__('Footer widgets color overlay', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_footer_widget_bgcolor_cbk'		
		),		
		array(
			'id'		=> 'lc_copyright_text',
			'label'		=> esc_html__('Copyright text', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_text_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_url',
			'label'		=> esc_html__('Copyrigth URL', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_url_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_text_color',
			'label'		=> esc_html__('Copyrigth Text Color Scheme', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_cs_cbk'		
		),
		array(
			'id'		=> 'lc_copyright_text_bg_color',
			'label'		=> esc_html__('Copyrigth Text Background Color', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_copyright_bgc_cbk'		
		)
	);
	foreach($footer_settings as $footer_setting) {
	    add_settings_field(   
	        $footer_setting['id'],         		// ID used to identify the field throughout the theme                
	        $footer_setting['label'],              // The label to the left of the option interface element            
	        $footer_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_footer_options',   		// The page on which this option will be displayed  
	        'lucille_footer_settings_section'    	// The name of the section to which this field belongs  
	    );
	}

	/*fonts options array*/
	$fonts_settings = array(
		array(
			'id'		=> 'lc_fonts_custom_default',
			'label'		=> esc_html__('Fonts in use', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_fonts_custom_default_cbk'		
		),
		array(
			'id'		=> 'lc_primary_font',
			'label'		=> esc_html__('Primary font', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_primary_font_cbk'
		),
		array(
			'id'		=> 'lc_secondary_font',
			'label'		=> esc_html__('Secondary font', 'lucille'),
			'callback'	=> 'LUCILLE_SWP_lc_secondary_font_cbk'		
		)
	);

	foreach($fonts_settings as $font_setting) {
	    add_settings_field(   
	        $font_setting['id'],         		// ID used to identify the field throughout the theme                
	        $font_setting['label'],              // The label to the left of the option interface element            
	        $font_setting['callback'], 			// The name of the function responsible for rendering the option interface
	        'lucille_theme_fonts_options',   		// The page on which this option will be displayed  
	        'lucille_fonts_settings_section'    	// The name of the section to which this field belongs  
	    );
	}	
}



/*
	Sanitize Functions
*/
function  LUCILLE_SWP_sanitize_general_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			if ($key == 'lc_custom_logo') {
				$output[$key] = esc_url_raw(trim( $input[$key] ) );
			} else {
				$output[$key] =  esc_html(trim($input[$key])) ;	
			}
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_general_options', $output, $input);
}

function LUCILLE_SWP_sanitize_social_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			$output[$key] =  esc_url_raw(trim($input[$key])) ;
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_social_options', $output, $input);
}

function LUCILLE_SWP_sanitize_footer_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			switch($key) {
				case 'lc_copyright_url':
				case 'lc_footer_widgets_background_image':
					$output[$key] =  esc_url_raw(trim($input[$key]));
					break;
				case 'lc_copyright_text':
					$allowed_html = array(
						'a'	=> array(
							"href"		=> array(),
							"target"	=> array()
							)
					);
					$output[$key] =  wp_kses(trim($input[$key]), $allowed_html);
				default:
					$output[$key] =  esc_html(trim($input[$key]));
					break;
			}
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_footer_options', $output, $input);
}

function LUCILLE_SWP_sanitize_fonts_options($input) {
	$output = array();

	foreach($input as $key => $val) {
		if(isset($input[$key])) {
			$output[$key] =  esc_html(trim($input[$key]));	
		}
	}

	return apply_filters('LUCILLE_SWP_sanitize_fonts_options', $output, $input);
}

/*
	CALLBACKS FOR SETTINGS FIELDS
*/
function LUCILLE_SWP_logo_select_cbk() {
	$logo_url = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_logo');

?>
	<input id="lc_swp_logo_upload_value" type="text" name="lucille_theme_general_options[lc_custom_logo]" size="150" value="<?php echo esc_url($logo_url); ?>"/>
	<input id="lc_swp_upload_logo_button" type="button" class="button" value="<?php echo esc_html__('Upload Logo', 'lucille'); ?>" />
	<input id="lc_swp_remove_logo_button" type="button" class="button" value="<?php echo esc_html__('Remove Logo', 'lucille'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom logo image.', 'lucille'); ?>
	</p>

	<div id="lc_logo_image_preview">
		<img class="lc_swp_setting_preview_logo" src="<?php echo esc_url($logo_url); ?>">
	</div>

<?php
}

function Lucille_SWP_innner_bg_image_select_cbk() {
	$inner_bg_img_url = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_custom_innner_bg_image');
?>

	<input id="lc_swp_innner_bg_image_upload_value" type="text" name="lucille_theme_general_options[lc_custom_innner_bg_image]" size="150" value="<?php echo esc_url($inner_bg_img_url); ?>"/>
	<input id="lc_swp_upload_innner_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Upload Image', 'lucille'); ?>" />
	<input id="lc_swp_remove_innner_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Remove Image', 'lucille'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom background image for inner pages.', 'lucille'); ?>
	</p>

	<div id="lc_innner_bg_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($inner_bg_img_url); ?>">
	</div>	
<?php	
}

function Lucille_SWP_menu_style_cbk() {
	$menu_style = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_menu_style');
	if (empty($menu_style)) {
		$menu_style = 'creative_menu';
	}

	$menu_options = array(
		esc_html__('Creative Menu', 'lucille')					=> 'creative_menu',
		esc_html__('Classic Menu', 'lucille')					=> 'classic_menu',		
		esc_html__('Centered Menu', 'lucille')					=> 'centered_menu',
		esc_html__('Centered Menu With Logo Left', 'lucille')	=> 'centered_menu_logo_left'
	);
?>

	<select id="lc_menu_style" name="lucille_theme_general_options[lc_menu_style]" class="swp_new_settings_section">
		<?php LUCILLE_SWP_render_select_options($menu_options, $menu_style); ?>
	</select>
<?php	
}

function Lucille_SWP_menu_creative_close_cbk() {
	$close_menu = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_menu_creative_close');

	if (empty($close_menu)) {
		$close_menu = 'disabled';
	}

	$close_options = array(
		esc_html__('Disabled', 'lucille')					=> 'disabled',
		esc_html__('Enabled', 'lucille')					=> 'enabled'
	);
?>

	<select id="lc_menu_creative_close" name="lucille_theme_general_options[lc_menu_creative_close]">
		<?php LUCILLE_SWP_render_select_options($close_options, $close_menu); ?>
	</select>
	<p class="description">
		<?php echo esc_html('When enabled, the creative menu container is closed after you click on a menu item. Works with CREATIVE MENU only.', 'lucille'); ?>
	</p>
<?php	
}

function Lucille_SWP_header_footer_width_cbk() {
	$header_width = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_header_footer_width');
	if (empty($header_width)) {
		$header_width = 'full';
	}

	$width_options = array(
		'Full Width'	=> 'full',
		'Boxed Width'	=> 'boxed'
	);
?>
	<select id="lc_header_footer_width" name="lucille_theme_general_options[lc_header_footer_width]" class="swp_new_settings_section">
		<?php LUCILLE_SWP_render_select_options($width_options, $header_width); ?>
	</select>
<?php
}

function Lucille_SWP_default_colorscheme_cbk() {
	$color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_default_color_scheme');
	if (empty($color_scheme)) {
		$color_scheme = 'white_on_black';
	}

	$color_schemes = array(
		esc_html__('White On Black', 'lucille')	=> 'white_on_black',
		esc_html__('Black on White', 'lucille')	=> 'black_on_white'
	);
?>

	<select id="lc_default_color_scheme" name="lucille_theme_general_options[lc_default_color_scheme]">
		<?php LUCILLE_SWP_render_select_options($color_schemes, $color_scheme); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Default color scheme used for the website content.', 'lucille').'<br>'; ?>
		<?php echo esc_html__('Black On White - black text on white background.', 'lucille'); ?>
		<?php echo esc_html__('White On Black - white text on black background.', 'lucille').'<br>'; ?>
		<?php echo esc_html__('If you change this value, you might need to change the background color or image for your website according to the color scheme.', 'lucille'); ?>
		<?php echo esc_html__('You can change the background color for your website from Appearance - Customize - Colors.', 'lucille'); ?>
	</p>
<?php	
}

function LUCILLE_SWP_enable_sticky_menu_cbk() {
	$sticky_menu = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_enable_sticky_menu');

	if (empty($sticky_menu)) {
		$sticky_menu = 'enabled';
	}

	$sticky_options = array(
		esc_html__('Enabled', 'lucille')	=> 'enabled',
		esc_html__('Disabled', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_enable_sticky_menu" name="lucille_theme_general_options[lc_enable_sticky_menu]">
		<?php LUCILLE_SWP_render_select_options($sticky_options, $sticky_menu); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Enable or disable sticky menu bar. If enabled, menu will stay on top whyle the user moves the scrollbar.', 'lucille'); ?>
	</p>
<?php
}


function Lucille_SWP_back_to_top_cbk() {
	$back_to_top = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_back_to_top');

	if (empty($back_to_top)) {
		$back_to_top = 'disabled';
	}

	$sticky_options = array(
		esc_html__('Enabled', 'lucille')	=> 'enabled',
		esc_html__('Disabled', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_back_to_top" name="lucille_theme_general_options[lc_back_to_top]">
		<?php LUCILLE_SWP_render_select_options($sticky_options, $back_to_top); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Enable or disable back to top button.', 'lucille'); ?>
	</p>
<?php
}

function Lucille_SWP_hide_search_icon_cbk() {
	$hide_icon = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_hide_search_icon');

	if (empty($hide_icon)) {
		$hide_icon = 'disabled';
	}

	$hide_options = array(
		esc_html__('Enabled - Hide Icon', 'lucille')	=> 'enabled',
		esc_html__('Disabled - Keep Icon', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_hide_search_icon" name="lucille_theme_general_options[lc_hide_search_icon]">
		<?php LUCILLE_SWP_render_select_options($hide_options, $hide_icon); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Hide search icon on menu.', 'lucille'); ?>
	</p>
<?php
}

function Lucille_SWP_show_title_event_list_cbk() {
	$show_event_title = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_show_title_event_list');

	if (empty($show_event_title)) {
		$show_event_title = 'disabled';
	}

	$show_title_options = array(
		esc_html__('Enabled - Show Event Title', 'lucille')	=> 'enabled',
		esc_html__('Disabled - Do Not Show Event Title', 'lucille')	=> 'disabled'
	);
?>
	<select id="lc_show_title_event_list" name="lucille_theme_general_options[lc_show_title_event_list]">
		<?php LUCILLE_SWP_render_select_options($show_title_options, $show_event_title); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Show event title on event list pages - Events - Past Events - All Events.', 'lucille'); ?>
		<?php echo esc_html__('By default, only event date, location and venue are shown.', 'lucille'); ?>
	</p>
<?php	
}

function LUCILLE_SWP_hide_sharing_icons_cbk() {
	$hide_sharing_icons = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_hide_sharing_icons');

	if (empty($hide_sharing_icons)) {
		$hide_sharing_icons = 'disabled';
	}

	$show_sharing_options = array(
		esc_html__('Disabled - Show Icons', 'lucille')	=> 'disabled',
		esc_html__('Enabled - Hide Icons', 'lucille')	=> 'enabled'
	);
?>
	<select id="lc_hide_sharing_icons" name="lucille_theme_general_options[lc_hide_sharing_icons]">
		<?php LUCILLE_SWP_render_select_options($show_sharing_options, $hide_sharing_icons); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Hide sharing icons at the end of the page/post.', 'lucille'); ?>
	</p>
<?php		
}

function LUCILLE_SWP_auto_featured_image_cbk() {
	$auto_featured_image = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_auto_featured_image');

	if (empty($auto_featured_image)) {
		$auto_featured_image = 'enabled';
	}

	$auto_featured_options = array(
		esc_html__('Enabled - Auto Featured Image', 'lucille')	=> 'enabled',
		esc_html__('Disabled - Manually Featured Image', 'lucille')	=> 'disabled'
		
	);
?>
	<select id="lc_auto_featured_image" name="lucille_theme_general_options[lc_auto_featured_image]">
		<?php LUCILLE_SWP_render_select_options($auto_featured_options, $auto_featured_image); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Automatically show featured image at the beginning of the single post content.', 'lucille'); ?>
	</p>
<?php	
}

function LUCILLE_SWP_remove_singlepost_sidebar_cbk() {
	$remove_singlepost_sidebar = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_remove_singlepost_sidebar');

	if (empty($remove_singlepost_sidebar)) {
		$remove_singlepost_sidebar = 'disabled';
	}

	$remove_sidebar_options = array(
		esc_html__('Disabled - Keep Sidebar', 'lucille')	=> 'disabled',
		esc_html__('Enabled - Remove Sidebar', 'lucille')	=> 'enabled'
	);
?>
	<select id="lc_remove_singlepost_sidebar" name="lucille_theme_general_options[lc_remove_singlepost_sidebar]">
		<?php LUCILLE_SWP_render_select_options($remove_sidebar_options, $remove_singlepost_sidebar); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Choose to remove sidebar on single post.', 'lucille'); ?>
	</p>
<?php
}

function LUCILLE_SWP_remove_blog_post_meta_cbk() {
	$remove_blog_post_meta = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_remove_blog_post_meta');

	if (empty($remove_blog_post_meta)) {
		$remove_blog_post_meta = 'disabled';
	}

	$remove_meta_options = array(
		esc_html__('Disabled - Keep Posts Meta', 'lucille')	=> 'disabled',
		esc_html__('Enabled - Remove Posts Meta', 'lucille')	=> 'enabled'
	);
?>
	<select id="lc_remove_blog_post_meta" name="lucille_theme_general_options[lc_remove_blog_post_meta]">
		<?php LUCILLE_SWP_render_select_options($remove_meta_options, $remove_blog_post_meta); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Choose to remove post meta from posts on blog page template and on visual composer blog element.', 'lucille'); ?>
		<?php echo esc_html__('Elements removed are: post author, post date and post category.', 'lucille'); ?>
	</p>
<?php
}

function LUCILLE_SWP_remove_single_blog_post_meta_cbk() {
	$remove_single_blog_post_meta = LUCILLE_SWP_get_theme_option('lucille_theme_general_options', 'lc_remove_single_blog_post_meta');

	if (empty($remove_single_blog_post_meta)) {
		$remove_single_blog_post_meta = 'disabled';
	}

	$remove_meta_options = array(
		esc_html__('Disabled - Keep Posts Meta', 'lucille')	=> 'disabled',
		esc_html__('Enabled - Remove Posts Meta', 'lucille')	=> 'enabled'
	);
?>
	<select id="lc_remove_single_blog_post_meta" name="lucille_theme_general_options[lc_remove_single_blog_post_meta]">
		<?php LUCILLE_SWP_render_select_options($remove_meta_options, $remove_single_blog_post_meta); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Choose to remove post meta from single posts.', 'lucille'); ?>
		<?php echo esc_html__('Elements removed are: post author, post date and post category.', 'lucille'); ?>
	</p>
<?php
}


/*
	Social Options
*/
function LUCILLE_SWP_fb_url_cbk() {
	$fb_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_fb_url');

?>
	<input id="lc_fb_url" type="text" name="lucille_theme_social_options[lc_fb_url]" size="150" value="<?php echo esc_url($fb_url); ?>"/>
<?php
}

function LUCILLE_SWP_twitter_url_cbk() {
	$twitter_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_twitter_url');

?>
	<input id="lc_twitter_url" type="text" name="lucille_theme_social_options[lc_twitter_url]" size="150" value="<?php echo esc_url($twitter_url); ?>"/>
<?php
}

function LUCILLE_SWP_youtube_url_cbk() {
	$youtube_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_youtube_url');

?>
	<input id="lc_youtube_url" type="text" name="lucille_theme_social_options[lc_youtube_url]" size="150" value="<?php echo esc_url($youtube_url); ?>"/>
<?php
}

function LUCILLE_SWP_soundcloud_url_cbk() {
	$soundcloud_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_soundcloud_url');

?>
	<input id="lc_soundcloud_url" type="text" name="lucille_theme_social_options[lc_soundcloud_url]" size="150" value="<?php echo esc_url($soundcloud_url); ?>"/>
<?php
}

function LUCILLE_SWP_myspace_url_cbk() {
	$myspace_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_myspace_url');

?>
	<input id="lc_myspace_url" type="text" name="lucille_theme_social_options[lc_myspace_url]" size="150" value="<?php echo esc_url($myspace_url); ?>"/>
<?php
}

function LUCILLE_SWP_itunes_url_cbk() {
	$itunes_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_itunes_url');

?>
	<input id="lc_itunes_url" type="text" name="lucille_theme_social_options[lc_itunes_url]" size="150" value="<?php echo esc_url($itunes_url); ?>"/>
<?php
}

function LUCILLE_SWP_pinterest_url_cbk() {
	$pinterest_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_pinterest_url');

?>
	<input id="lc_pinterest_url" type="text" name="lucille_theme_social_options[lc_pinterest_url]" size="150" value="<?php echo esc_url($pinterest_url); ?>"/>
<?php
}

function LUCILLE_SWP_instagram_url_cbk() {
	$instagram_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_instagram_url');

?>
	<input id="lc_instagram_url" type="text" name="lucille_theme_social_options[lc_instagram_url]" size="150" value="<?php echo esc_url($instagram_url); ?>"/>
<?php
}

function LUCILLE_SWP_snapchat_url_cbk() {
	$snapchat_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_snapchat_url');

?>
	<input id="lc_snapchat_url" type="text" name="lucille_theme_social_options[lc_snapchat_url]" size="150" value="<?php echo esc_url($snapchat_url); ?>"/>
<?php
}

function LUCILLE_SWP_gplay_url_cbk() {
	$gplay_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_gplay_url');

?>
	<input id="lc_gplay_url" type="text" name="lucille_theme_social_options[lc_gplay_url]" size="150" value="<?php echo esc_url($gplay_url); ?>"/>
<?php
}

function LUCILLE_SWP_linkedin_url_cbk() {
	$linkedin_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_linkedin_url');

?>
	<input id="lc_linkedin_url" type="text" name="lucille_theme_social_options[lc_linkedin_url]" size="150" value="<?php echo esc_url($linkedin_url); ?>"/>
<?php
}

function LUCILLE_SWP_spotify_url_cbk() {
	$spotify_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_spotify_url');

?>
	<input id="lc_spotify_url" type="text" name="lucille_theme_social_options[lc_spotify_url]" size="150" value="<?php echo esc_url($spotify_url); ?>"/>
<?php
}

function LUCILLE_SWP_imdb_url_cbk() {
	$imdb_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_imdb_url');

?>
	<input id="lc_imdb_url" type="text" name="lucille_theme_social_options[lc_imdb_url]" size="150" value="<?php echo esc_url($imdb_url); ?>"/>
<?php
}

function LUCILLE_SWP_vimeo_url_cbk() {
	$vimeo_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_vimeo_url');

?>
	<input id="lc_vimeo_url" type="text" name="lucille_theme_social_options[lc_vimeo_url]" size="150" value="<?php echo esc_url($vimeo_url); ?>"/>
<?php
}

function LUCILLE_SWP_vk_url_cbk() {
	$vk_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_vk_url');

?>
	<input id="lc_vk_url" type="text" name="lucille_theme_social_options[lc_vk_url]" size="150" value="<?php echo esc_url($vk_url); ?>"/>
<?php
}

function LUCILLE_SWP_amazon_music_url_cbk() {
	$amazon_music_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_amazon_music_url');

?>
	<input id="lc_amazon_music_url" type="text" name="lucille_theme_social_options[lc_amazon_music_url]" size="150" value="<?php echo esc_url($amazon_music_url); ?>"/>
<?php	
}

function LUCILLE_SWP_bandcamp_url_cbk() {
	$bandcamp_url = LUCILLE_SWP_get_theme_option('lucille_theme_social_options', 'lc_bandcamp_url');

?>
	<input id="lc_bandcamp_url" type="text" name="lucille_theme_social_options[lc_bandcamp_url]" size="150" value="<?php echo esc_url($bandcamp_url); ?>"/>
<?php	
}


/*
	Footer Options
*/

function LUCILLE_SWP_footer_widget_cs_cbk() {
	$footer_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_color_scheme');
	if (empty($footer_color_scheme)) {
		$footer_color_scheme = 'white_on_black';
	}

	$footer_color_schemes = array(
		esc_html__('White On Black', 'lucille')	=> 'white_on_black',
		esc_html__('Black on White', 'lucille')	=> 'black_on_white'
	);
?>

	<select id="lc_footer_widgets_color_scheme" name="lucille_theme_footer_options[lc_footer_widgets_color_scheme]">
		<?php LUCILLE_SWP_render_select_options($footer_color_schemes, $footer_color_scheme); ?>
	</select>
	<p class="description">
		<?php echo esc_html__('Color scheme used for footer widgets text.', 'lucille'); ?>
	</p>
<?php
}

function LUCILLE_SWP_footer_widget_bgimg_cbk() {
	$footer_bg_image = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_image');

?>
	<input id="lc_swp_footer_bg_image_upload_value" type="text" name="lucille_theme_footer_options[lc_footer_widgets_background_image]" size="150" value="<?php echo esc_url($footer_bg_image); ?>"/>
	<input id="lc_swp_upload_footer_widgets_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Upload Image', 'lucille'); ?>" />
	<input id="lc_swp_remove_footer_widgets_bg_image_button" type="button" class="button" value="<?php echo esc_html__('Remove Image', 'lucille'); ?>" />
	<p class="description">
		<?php echo esc_html__('Upload a custom background image for the footer widgets area.', 'lucille'); ?>
	</p>

	<div id="lc_footer_widgets_bg_image_preview">
		<img class="lc_swp_setting_preview_favicon" src="<?php echo esc_url($footer_bg_image); ?>">
	</div>
<?php
}

function LUCILLE_SWP_footer_widget_bgcolor_cbk() {
	$footer_background_color = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_footer_widgets_background_color');
	$default_bg_color = 'rgba(19, 19, 19, 1)';

	if ('' == $footer_background_color) {
		$footer_background_color = $default_bg_color;
	}
?>

	<input type="text" id="lc_footer_widgets_background_color" class="alpha-color-picker-settings" name="lucille_theme_footer_options[lc_footer_widgets_background_color]" value="<?php echo esc_attr($footer_background_color); ?>" data-default-color="rgba(19, 19, 19, 1)" data-show-opacity="true" />

	<p class="description">
		<?php echo esc_html__('Color overlay for the footer widgets area. Can be used as background color or as color over the background image.', 'lucille'); ?>
	</p>
<?php	
}

function LUCILLE_SWP_copyright_text_cbk() {
	$copyright_text = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text');
?>
	<textarea cols="147" rows="10" id="lc_copyright_text" name="lucille_theme_footer_options[lc_copyright_text]" class="swp_new_settings_section"><?php echo esc_html($copyright_text); ?></textarea>;
<?php
}

function LUCILLE_SWP_copyright_url_cbk() {
	$copyright_url = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_url');
?>
	<input type="text" size="147" id="lc_copyright_url" name="lucille_theme_footer_options[lc_copyright_url]" value="<?php echo esc_url_raw($copyright_url)?>"/>
<?php
}
/*
function LUCILLE_SWP_analytics_code_cbk() {
	$analytics_code = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_analytics_code');

?>
	<textarea  cols="147" rows="10" id="analytics_code" name="lucille_theme_footer_options[lc_analytics_code]" ><?php echo esc_html($analytics_code); ?></textarea>
<?php
}
*/

function LUCILLE_SWP_copyright_cs_cbk() {
	$copy_color_scheme = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_color');
	if (empty($copy_color_scheme)) {
		$copy_color_scheme = 'white_on_black';
	}

	$copy_color_schemes = array(
		esc_html__('White On Black', 'lucille')	=> 'white_on_black',
		esc_html__('Black on White', 'lucille')	=> 'black_on_white'
	);
?>

	<select id="lc_copyright_text_color" name="lucille_theme_footer_options[lc_copyright_text_color]">
		<?php LUCILLE_SWP_render_select_options($copy_color_schemes, $copy_color_scheme); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Color scheme used for footer copyrigth text.', 'lucille'); ?>
	</p>
<?php
}

function LUCILLE_SWP_copyright_bgc_cbk() {
	$copy_bgc = LUCILLE_SWP_get_theme_option('lucille_theme_footer_options', 'lc_copyright_text_bg_color');
	$default_copy_bgc = 'rgba(29, 29, 29, 1)';

	if ('' == $copy_bgc) {
		$copy_bgc = $default_copy_bgc;
	}
?>

	<input type="text" id="lc_copyright_text_bg_color" class="alpha-color-picker-settings" name="lucille_theme_footer_options[lc_copyright_text_bg_color]" value="<?php echo esc_html($copy_bgc); ?>" data-default-color="rgba(29, 29, 29, 1)" data-show-opacity="true" />

	<p class="description">
		<?php echo esc_html__('Background color for the copyright text area.', 'lucille'); ?>
	</p>
<?php	
}

/*
	Fonts Options
*/
function LUCILLE_SWP_lc_fonts_custom_default_cbk() {
	$fonts_custom_default = LUCILLE_SWP_get_theme_option('lucille_theme_fonts_options', 'lc_fonts_custom_default');
	if (empty($fonts_custom_default)) {
		$fonts_custom_default = 'use_defaults';
	}

	$fonts_usage = array(
		esc_html__('Use Theme Defaults', 'lucille')	=> 'use_defaults',
		esc_html__('Use Custom Fonts', 'lucille')	=> 'use_custom'
	);
?>

	<select id="lc_fonts_custom_default" name="lucille_theme_fonts_options[lc_fonts_custom_default]">
		<?php LUCILLE_SWP_render_select_options($fonts_usage, $fonts_custom_default); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose to use custom fonts for Lucille.', 'lucille'); ?>
	</p>

<?php
}

function LUCILLE_SWP_lc_primary_font_cbk() {
	$primary_font = LUCILLE_SWP_get_theme_option('lucille_theme_fonts_options', 'lc_primary_font');
	if (empty($primary_font)) {
		$primary_font = 'Open Sans';
	}

	$font_families = LUCILLE_SWP_get_google_fonts_array();

?>
	<select id="lc_primary_font" name="lucille_theme_fonts_options[lc_primary_font]">
		<?php LUCILLE_SWP_render_select_options($font_families, $primary_font); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose the primary font.', 'lucille'); ?>
	</p>	
<?php
}

function LUCILLE_SWP_lc_secondary_font_cbk() {
	$secondary_font = LUCILLE_SWP_get_theme_option('lucille_theme_fonts_options', 'lc_secondary_font');
	if (empty($secondary_font)) {
		$secondary_font = 'Oswald';
	}

	$font_families = LUCILLE_SWP_get_google_fonts_array();

?>
	<select id="lc_secondary_font" name="lucille_theme_fonts_options[lc_secondary_font]">
		<?php LUCILLE_SWP_render_select_options($font_families, $secondary_font); ?>
	</select>

	<p class="description">
		<?php echo esc_html__('Choose the secondary font.', 'lucille'); ?>
	</p>	
<?php	
}


/*
	UTILS FOR THEME SETTINGS
*/
function LUCILLE_SWP_get_theme_option($option_group, $option_name) 
{
	$options = get_option($option_group);

	if (isset($options[$option_name])) {
		return $options[$option_name];
	}

	return '';
}

function LUCILLE_SWP_render_select_options($options, $selected) {
	if (empty($selected)) {
		return;
	}

	foreach($options as $key => $value) {
		if ($value == $selected) {
			?>
			<option value="<?php echo esc_attr($value); ?>" selected="selected"> <?php echo esc_attr($key); ?> </option>
			<?php
		} else {
			?>
			<option value="<?php echo esc_attr($value); ?>"> <?php echo esc_attr($key); ?> </option>
			<?php
		}
	}
}

/*
	Get all google fonts and creates an array like: 
	 array(
		'Open Sans',	=> 'Open Sans'
	);
*/
function LUCILLE_SWP_get_google_fonts_array() {
	$str = file_get_contents(get_template_directory() . '/assets/google_fonts/fonts.json'); 
	$fonts_json = json_decode($str, true);

	$array_fonts = array();
	foreach($fonts_json as $font_json) {
		$array_fonts[$font_json['family']] = $font_json['family'];
	}

	return $array_fonts;
}

?>