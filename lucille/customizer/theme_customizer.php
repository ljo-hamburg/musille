<?php

/*
	Theme Customiser Functionality
	Contains methods for customizing the theme customization screen.
*/

class LUCILLE_SWP_Customize {
	//This hooks into 'customize_register' (available as of WP 3.4)
	public static function register($wp_customize) 
	{
		require_once(get_template_directory()."/customizer/alpha-color-picker-customizer.php");

		if (!isset($lc_customize['menu_mobile_bg_color'])) {
			$lc_customize['menu_mobile_bg_color'] = 'rgba(35, 35, 35, 1)';
		}
		if (!isset($lc_customize['mobile_border_bottom_color'])) {
			$lc_customize['mobile_border_bottom_color'] = '#333333';
		}


		//Define a new section (if desired) to the Theme Customizer
		$wp_customize->add_section( 'lc_second_color', 
			array(
				'title' => esc_html__('Vibrant Color', 'lucille'), 				//Visible title of section
				'priority' => 1, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => esc_html__('Choose the link color', 'lucille'), //Descriptive tooltip
			)
		);

		//Register new settings to the WP database...
		$wp_customize->add_setting( 'lc_customize[lc_second_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#18aebf', 										//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		//Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new WP_Customize_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_second_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Secondary Color', 'lucille'), //Admin-visible name of the control
										'section' => 'lc_second_color', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_second_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										) 
		));

		/*
			MENU OPTIONS
		*/
		$wp_customize->add_section('lc_menu_options', 
			array(
				'title' => esc_html__('Menu Colors', 'lucille'), 				//Visible title of section
				'priority' => 2, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => esc_html__('Choose menu colors', 'lucille'), //Descriptive tooltip
			)
		);

		/*menu bar color*/
		$wp_customize->add_setting('lc_customize[menu_bar_bg_color]',
			array(
				'default' => 'rgba(255, 255, 255, 0)', 												//Default setting/value to save
				'sanitize_callback' => 'LUCILLE_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'menu_bar_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Menu Bar Background Color', 'lucille'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_bar_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		/*sticky menu bar color*/
		$wp_customize->add_setting('lc_customize[menu_sticky_bar_bg_color]',
			array(
				'default' => 'rgba(35, 35, 35, 1)', 												//Default setting/value to save
				'sanitize_callback' => 'LUCILLE_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'menu_sticky_bar_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Sticky Menu Bar Background Color', 'lucille'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_sticky_bar_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		/*mobile menu bar color*/
		$wp_customize->add_setting('lc_customize[menu_mobile_bg_color]',
			array(
				'default' => 'rgba(35, 35, 35, 1)', 												//Default setting/value to save
				'sanitize_callback' => 'LUCILLE_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'menu_mobile_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Mobile Menu Background Color', 'lucille'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_mobile_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));

		/*mobile menu border bottom color*/
		$wp_customize->add_setting('lc_customize[mobile_border_bottom_color]',
			array(
				'default' => 'rgba(51, 51, 51, 1)', 												//Default setting/value to save
				'sanitize_callback' => 'LUCILLE_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'mobile_border_bottom_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Mobile Menu Border Bottom Color', 'lucille'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[mobile_border_bottom_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 1															//Determines the order this control appears in for the specified section
				)
		));		

		/*menu text color*/
		$wp_customize->add_setting('lc_customize[menu_text_color]',
			array(
				'default' => '#ffffff', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_menu_text_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Menu Text Color', 'lucille'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_text_color]',
				'priority' => 2,
			) 
		));

		/*menu text hover color*/
		$wp_customize->add_setting('lc_customize[menu_text_hover_color]',
			array(
				'default' => '#ffffff', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_menu_text_hover_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Menu Text Color on Hover', 'lucille'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[menu_text_hover_color]',
				'priority' => 3,
			) 
		));

		/*sub menu text color*/
		$wp_customize->add_setting('lc_customize[submenu_text_color]',
			array(
				'default' => '#828282', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_submenu_text_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Sub Menu Text Color', 'lucille'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[submenu_text_color]',
				'priority' => 4,
			)
		));

		/*submenu text hover color*/
		$wp_customize->add_setting('lc_customize[submenu_text_hover_color]',
			array(
				'default' => '#d2d2d2',													//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_submenu_text_hover_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Sub Menu Text Color on Hover', 'lucille'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[submenu_text_hover_color]',
				'priority' => 5,
			)
		));

		/*current menu item text color*/
		$wp_customize->add_setting('lc_customize[current_menu_item_text_color]',
			array(
				'default' => '#18aebf',													//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_current_menu_item_text_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Current Menu Item Text Color', 'lucille'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[current_menu_item_text_color]',
				'priority' => 5,
			)
		));

		/*sub menu bg color*/
		$wp_customize->add_setting('lc_customize[submenu_bg_color]',
			array(
				'default' => 'rgba(255, 255, 255, 0)', 												//Default setting/value to save
				'sanitize_callback' => 'LUCILLE_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'submenu_bg_color', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Sub Menu Background Color', 'lucille'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[submenu_bg_color]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 6															//Determines the order this control appears in for the specified section
				)
		));

		/*creative menu overlay color*/
		$wp_customize->add_setting('lc_customize[creative_menu_overlay_bg]',
			array(
				'default' => 'rgba(0, 0, 0, 0.9)', 												//Default setting/value to save
				'sanitize_callback' => 'LUCILLE_SWP_sanitize_rgba_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);
		$wp_customize->add_control(
			new Customize_Alpha_Color_Control( 												//Instantiate the color control class
				$wp_customize, 																//Pass the $wp_customize object (required)
				'creative_menu_overlay_bg', 														//Set a unique ID for the control
				array(
				'label' => esc_html__('Creative Menu Overlay Color', 'lucille'), 							//Admin-visible name of the control
				'section' => 'lc_menu_options', 								// ID of the section this control should render in (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[creative_menu_overlay_bg]', 						//Which setting to load and manipulate (serialized is okay)
				'priority' => 7															//Determines the order this control appears in for the specified section
				)
		));

		/*top icons on creative menu*/
		$wp_customize->add_setting('lc_customize[creative_icons_color]',
			array(
				'default' => '#ffffff', 												//Default setting/value to save
				'sanitize_callback' => 'sanitize_hex_color',							//Sanitizer
				'type' => 'option', 													//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 									//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage' 											//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'lc_creative_icons_color',	 			//Set a unique ID for the control
				array(
				'label' => esc_html__('Top Icons Color For Creative Menu. Also, the color for mobile menu icons, menu icon and search icon.', 'lucille'),
				'section' => 'lc_menu_options',	//ID of the section (can be one of yours, or a WordPress default section)
				'settings' => 'lc_customize[creative_icons_color]',
				'priority' => 8
			)
		));

		/*Various Colors*/
		$wp_customize->add_section( 'lc_various_colors', 
			array(
				'title' => esc_html__('Various Colors', 'lucille'), 				//Visible title of section
				'priority' => 3, 											//Determines what order this appears in
				'capability' => 'edit_theme_options', 						//Capability needed to tweak
				'description' => esc_html__('Choose various colors', 'lucille'), //Descriptive tooltip
			)
		);

		//Register new settings to the WP database...
		$wp_customize->add_setting( 'lc_customize[lc_blog_no_thumb_color]', 	//Give it a SERIALIZED name (so all theme settings can live under one db record)
			array(
				'default' => '#1d1d1d', 										//Default setting/value to save
				'sanitize_callback' => 'LUCILLE_SWP_sanitize_rgba_color',					//Sanitizer
				'type' => 'option', 											//Is this an 'option' or a 'theme_mod'?
				'capability' => 'edit_theme_options', 							//Optional. Special permissions for accessing this setting.
				'transport' => 'postMessage', 									//What triggers a refresh of the setting? 'refresh' or 'postMessage' (instant)?
			) 
		);

		//Finally, we define the control itself (which links a setting to a section and renders the HTML controls)...
		$wp_customize->add_control( new Customize_Alpha_Color_Control( //Instantiate the color control class
										$wp_customize, 				//Pass the $wp_customize object (required)
										'lc_blog_no_thumb_color', 			//Set a unique ID for the control
										array(
										'label' => esc_html__('Background color for masonry bricks with no thumbnail', 'lucille'), //Admin-visible name of the control
										'section' => 'lc_various_colors', //ID of the section (can be one of yours, or a WordPress default section)
										'settings' => 'lc_customize[lc_blog_no_thumb_color]', //Which setting to load and manipulate (serialized is okay)
										'priority' => 1, //Determines the order this control appears in for the specified section
										) 
		));		

	}

	/**
	* This outputs the javascript needed to automate the live settings preview.
	* keep 'transport'=>'postMessage' instead of the default 'transport' => 'refresh'
	* Used by hook: 'customize_preview_init'
	*/
	public static function live_preview() 
	{
		wp_enqueue_script( 
	       'lucille-themecustomizer', 										// Give the script a unique ID
	       get_template_directory_uri().'/customizer/js/theme_customizer.js', 	// Define the path to the JS file
	       array('jquery', 'customize-preview'),				 				// Define dependencies
	       rand(5, 100), 																	// Define a version (optional) 
	       true 																// Specify whether to put in footer (leave this true)
		);


	}

   /**
    * This will output the custom WordPress settings to the live theme's WP head.
    * Used by hook: 'wp_head'
    * add_action('wp_head',$func)
    */
	public static function header_output()
	{
		$lc_customize = get_option('lc_customize');

		if (!isset($lc_customize['lc_second_color'])) {
			$lc_customize['lc_second_color'] = '#18aebf';
		}
		if (!isset($lc_customize['menu_bar_bg_color'])) {
			$lc_customize['menu_bar_bg_color'] = 'rgba(255, 255, 255, 0)';
		}
		if (!isset($lc_customize['menu_sticky_bar_bg_color'])) {
			$lc_customize['menu_sticky_bar_bg_color'] = 'rgba(35, 35, 35, 1)';
		}
		if (!isset($lc_customize['menu_text_color'])) {
			$lc_customize['menu_text_color'] = '#ffffff';
		}
		if (!isset($lc_customize['menu_text_hover_color'])) {
			$lc_customize['menu_text_hover_color'] = '#18aebf';
		}

		if (!isset($lc_customize['submenu_text_color'])) {
			$lc_customize['submenu_text_color'] = '#828282';
		}
		if (!isset($lc_customize['submenu_text_hover_color'])) {
			$lc_customize['submenu_text_hover_color'] = '#d2d2d2';
		}
		if (!isset($lc_customize['submenu_bg_color'])) {
			$lc_customize['submenu_bg_color'] = 'rgba(255, 255, 255, 0)';
		}
		if (!isset($lc_customize['creative_menu_overlay_bg'])) {
			$lc_customize['creative_menu_overlay_bg'] = 'rgba(0, 0, 0, 0.9)';
		}
		if (!isset($lc_customize['creative_icons_color'])) {
			$lc_customize['creative_icons_color'] = '#ffffff';
		}
		if (!isset($lc_customize['menu_mobile_bg_color'])) {
			$lc_customize['menu_mobile_bg_color'] = "rgba(35, 35, 35, 1)";
		}
		if (!isset($lc_customize['mobile_border_bottom_color'])) {
			$lc_customize['mobile_border_bottom_color'] = '#333333';
		}
		if (!isset($lc_customize['current_menu_item_text_color'])) {
			$lc_customize['current_menu_item_text_color'] = '#18aebf';	
		}
		/*Various colors*/
		if (!isset($lc_customize['lc_blog_no_thumb_color'])) {
			$lc_customize['lc_blog_no_thumb_color'] = '#1d1d1d';	
		}

		?>
		<!--Customizer CSS-->
		<style type="text/css">
			<?php

			/*vibrant color as text color*/
			$vibrant_color_as_text = 'a:hover, .vibrant_hover:hover, .vibrant_hover a:hover, .lc_vibrant_color, .black_on_white .lc_vibrant_color,  #recentcomments a:hover, .tagcloud a:hover, ';
			$vibrant_color_as_text .= '.widget_meta a:hover, .widget_pages a:hover, .widget_categories a:hover, .widget_recent_entries a:hover, ';
			$vibrant_color_as_text .= '.widget_archive a:hover, .lc_copy_area a:hover, .lc_swp_content a:hover, .lc_sharing_icons a:hover, ';
			$vibrant_color_as_text .= '.lc_post_meta a:hover, .post_item:hover > .post_item_details a h2, .lc_blog_masonry_brick.has_thumbnail .lc_post_meta a:hover, ';
			$vibrant_color_as_text .= '.post_item.no_thumbnail .lc_post_meta a:hover, .post_item:hover > a h2, .lucille_cf_error, ';
			$vibrant_color_as_text .= '.woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product span.price, ';
			$vibrant_color_as_text .= '.woocommerce-message:before, .woocommerce a.remove, .woocommerce-info:before, .woocommerce form .form-row .required, ';
			$vibrant_color_as_text .= '.woocommerce form .form-row.woocommerce-invalid label, a.about_paypal, .single_video_item:hover h3, .goto_next_section, ';
			$vibrant_color_as_text .= '.swp_single_artist:hover .artist_name, .single_artist_item .artist_title:hover, .woocommerce-MyAccount-navigation-link.is-active a ';
			echo $vibrant_color_as_text.' { color: '.$lc_customize['lc_second_color'].'; }';
			
			/*vibrant color as background*/	
			$vibrant_color_as_bgc = '.lc_swp_vibrant_bgc, .cart-contents-count, #recentcomments li:before, .lc_button:hover, .woocommerce a.button:hover,  ';
			$vibrant_color_as_bgc .= '#commentform input#submit:hover,';
			$vibrant_color_as_bgc .= '.single_track .mejs-controls .mejs-time-rail .mejs-time-current, ';
			$vibrant_color_as_bgc .= '.lc_blog_masonry_brick:hover > .post_item_details .lc_button, .woocommerce span.onsale, ';
			$vibrant_color_as_bgc .= '.woocommerce ul.products li.product:hover > a.button, ';
			$vibrant_color_as_bgc .= '.woocommerce #respond input#submit:hover, .woocommerce input.button:hover, input.button:hover, .woocommerce a.button.alt:hover, ';
			$vibrant_color_as_bgc .= '.woocommerce a.remove:hover, .woocommerce input.button.alt, .woocommerce input.button.alt:hover, ';
			$vibrant_color_as_bgc .= '.unslider-nav ol li.unslider-active, input[type="submit"]:hover, .woocommerce button.button.alt, .woocommerce button.button, ';
			$vibrant_color_as_bgc .= '.swp_events_subscribe a:hover';
			echo $vibrant_color_as_bgc.' { background-color: '.$lc_customize['lc_second_color'].'; }';

			/*vibrant color as border color*/
			$vibrant_as_border_color = '.lc_button:hover, input[type="submit"]:hover, .woocommerce a.button:hover, .lc_blog_masonry_brick:hover > .post_item_details .lc_button, ';
			$vibrant_as_border_color .= '.woocommerce ul.products li.product:hover > a.button, .woocommerce button.button.alt:hover, ';
			$vibrant_as_border_color .= '.woocommerce #respond input#submit:hover, input.button:hover, .woocommerce input.button:hover,  ';
			$vibrant_as_border_color .= '.woocommerce .shop_table_responsive input.button, .white_on_black .woocommerce a.button.alt:hover, .woocommerce-info, ';
			$vibrant_as_border_color .= '.woocommerce form .form-row.woocommerce-invalid input.input-text, .unslider-nav ol li.unslider-active, ';
			$vibrant_as_border_color .= 'input.lucille_cf_input:focus, textarea.lucille_cf_input:focus, .woocommerce button.button.alt, .woocommerce button.button, ';
			$vibrant_as_border_color .= '.wpcf7-form-control-wrap input:focus, .wpcf7-form-control-wrap textarea:focus, .swp_events_subscribe a';
			echo $vibrant_as_border_color.' { border-color: '.$lc_customize['lc_second_color'].' !important; }';


			 /*menu bar background color*/
			$menu_bar_bg_color = ' #lc_page_header ';
			$menu_bar_bg_color .= '{ background-color: '.$lc_customize['menu_bar_bg_color'].'; }';
			echo $menu_bar_bg_color;

			/*sticky menu bar background color*/
			$sticky_menu_bar_bg_color = ' header.sticky_enabled .header_inner';
			$sticky_menu_bar_bg_color .= '{ background-color: '.$lc_customize['menu_sticky_bar_bg_color'].'; }';
			echo $sticky_menu_bar_bg_color;

			/*mobile_menu background color*/
			$mobile_menu_bg_color = ' .header_inner.lc_mobile_menu, .mobile_navigation_container ';
			$mobile_menu_bg_color .= '{ background-color: '.$lc_customize['menu_mobile_bg_color'].'; }';
			echo $mobile_menu_bg_color;

			/*mobile menu subitem border bottom color*/
			echo '.mobile_navigation ul li { border-bottom-color: '.$lc_customize['mobile_border_bottom_color'].';} ';
			

			/*menu top text color*/
			/*removed .cart-contents-count, from the list*/
			$menu_text_color = ' li.menu-item a, #logo a, .classic_header_icon, .classic_header_icon a,  ';
			$menu_text_color .= '.classic_header_icon:hover, .classic_header_icon a:hover';
			$menu_text_color .= '{ color: '.$lc_customize['menu_text_color'].'; }';
			echo $menu_text_color;

			/*menu top text hover color*/
			$menu_text_hover_color = ' li.menu-item a:hover ';
			$menu_text_hover_color .= '{ color: '.$lc_customize['menu_text_hover_color'].'; }';
			echo $menu_text_hover_color;

			/*sub menu text color*/
			$submenu_text_color = 'ul.sub-menu li.menu-item a  ';
			$submenu_text_color .= '{ color: '.$lc_customize['submenu_text_color'].'; }';
			echo $submenu_text_color;
			echo '.creative_menu ul.sub-menu li.menu-item-has-children::before { border-left-color: '.$lc_customize['submenu_text_color'].'; }';

			/*sub menu hover text color*/
			$submenu_text_hover_color = ' ul.sub-menu li.menu-item a:hover ';
			$submenu_text_hover_color .= '{ color: '.$lc_customize['submenu_text_hover_color'].'; }';
			echo $submenu_text_hover_color;
			echo '.creative_menu ul.sub-menu li.menu-item-has-children:hover::before { border-left-color: '.$lc_customize['submenu_text_hover_color'].'; }';

			/*current menu item text color*/
			$current_menu_item_text_color = 'li.current-menu-item a, li.current-menu-parent a, li.current-menu-ancestor a';
			$current_menu_item_text_color .= '{ color: '.$lc_customize['current_menu_item_text_color'].'; }';
			echo $current_menu_item_text_color;

			/*sub menu background color*/
			$submenu_bg_color = ' ul.sub-menu li ';
			$submenu_bg_color .= '{ background-color: '.$lc_customize['submenu_bg_color'].'; }';
			echo $submenu_bg_color;

			/*creative menu overlay bagckground*/
			echo '.nav_creative_container { background-color: '.$lc_customize['creative_menu_overlay_bg'].'; }';

			/*creative icons color*/
			$creative_icons_color = '.creative_header_icon, .creative_header_icon a, .creative_header_icon a.cart-contents:hover ';
			$creative_icons_color .= '{ color: '.$lc_customize['creative_icons_color'].'; }';
			echo $creative_icons_color;

			/*take care of hover*/
			$creative_icons_color_hover = '.creative_header_icon.lc_social_icon:hover, .creative_header_icon.lc_social_icon a:hover ';
			$creative_icons_color_hover .= '{ color: '.$lc_customize['lc_second_color'].'; }';
			echo $creative_icons_color_hover;			

			echo '.hmb_line { background-color: '.$lc_customize['creative_icons_color'].'; }';
			
			/*no thumbnail bg color for masonry items*/
			$blog_no_thumb_color = '.post_item.lc_blog_masonry_brick.no_thumbnail, .gallery_brick_overlay ';
			$blog_no_thumb_color .= '{ background-color: '.$lc_customize['lc_blog_no_thumb_color'].'; }';
			echo $blog_no_thumb_color;
			?>

			

		</style>
		<?php
	}

 	/**
     * This will generate a line of CSS for use in header output. 
     * 
     * @uses get_theme_mod()
     * @param string $selector CSS selector
     * @param string $style The name of the CSS *property* to modify
     * @param string $mod_name The name of the 'theme_mod' option to fetch
     */
	public static function generate_css($selector, $style, $mod_name, $preval, $postval)
	{
		@ $option = $themeOptions[$mod_name];
	
		if (!empty($option)) {
			$return_css = sprintf('%s { %s:%s; }',
							$selector,
							$style,
							$preval.' '.$option.' '.$postval
							);
							
			echo $return_css;
		}
		
		return $return_css;
	}
}

/*
	sanitize rgba colors
*/
function LUCILLE_SWP_sanitize_rgba_color($color) {
	if ('' === $color ) {
		return '';
	}

	return esc_attr($color);
}

?>