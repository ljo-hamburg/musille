/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
(function($) {
	'use strict';

	wp.customize('lc_customize[second_color]', function(value) {
		value.bind(function(newval) {
			/*text color*/
			$('a:hover, .vibrant_hover:hover, .vibrant_hover a:hover, .lc_vibrant_color, #recentcomments a:hover').css('color', newval);
			$('.widget_meta a:hover, .widget_pages a:hover, .widget_categories a:hover, .widget_recent_entries a:hover').css('color', newval);
			$('.widget_archive a:hover, .lc_copy_area a:hover, .lc_swp_content a:hover, .lc_sharing_icons a:hover').css('color', newval);
			$('.lc_post_meta a:hover, .post_item.no_thumbnail .lc_post_meta a:hover, .post_item:hover > .post_item_details a h2, .lc_blog_masonry_brick.has_thumbnail .lc_post_meta a:hover ').css('color', newval);
			$('.lucille_cf_error, .woocommerce ul.products li.product .price').css('color', newval);
			$('.woocommerce div.product p.price, .woocommerce div.product span.price, .single_video_item:hover h3, .goto_next_section').css('color', newval);

			/*background*/
			$('.lc_swp_vibrant_bgc, .cart-contents-count, #recentcomments li:before, .lc_button:hover, ').css('background-color', newval);
			$('.lc_blog_masonry_brick:hover > .post_item_details .lc_button, .woocommerce span.onsale ').css('background-color', newval);
			$('.woocommerce #respond input#submit ').css('background-color', newval);

			/*border-color*/
			$('.lc_button:hover, .lc_blog_masonry_brick:hover > .post_item_details .lc_button, .woocommerce button.button.alt:hover').css("border-color", newval);
			$('.woocommerce button.button.alt').css("border-color", newval);
		});
	});

	wp.customize('lc_customize[menu_bar_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.header_inner').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[menu_sticky_bar_bg_color]', function(value) {
		value.bind(function(newval) {
			$('header.sticky_enabled .header_inner').css('background-color', newval);
		});
	});	

	wp.customize('lc_customize[menu_mobile_bg_color]', function(value) {
		value.bind(function(newval) {
			$('.header_inner.lc_mobile_menu, .mobile_navigation_container').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[mobile_border_bottom_color]', function(value) {
		value.bind(function(newval) {
			$('.mobile_navigation ul li').css('border-bottom-color', newval);
		});
	});	

	wp.customize('lc_customize[menu_text_color]', function(value) {
		value.bind(function(newval) {
			$('ul.menu').children().children('a').css('color', newval);
			$('#logo a, .classic_header_icon, .classic_header_icon a').css('color', newval);
		});
	});

	wp.customize('lc_customize[menu_text_hover_color]', function(value) {
		var oldVal = $('ul.menu').children().children('a').css('color');
		value.bind(function(newval) {
			$('ul.menu').children().children('a').hover(function(){
			    $(this).css("color", newval);
			    }, function(){
			    $(this).css("color", oldVal);
			});
		});
	});

	wp.customize('lc_customize[submenu_text_color]', function(value) {
		value.bind(function(newval) {
			$('ul.sub-menu li.menu-item a').css('color', newval);
			$('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color', newval);
		});
	});

	wp.customize('lc_customize[submenu_text_hover_color]', function(value) {
		var oldVal = $("ul.sub-menu li.menu-item a").css('color');
		var oldBeforeEltVal = $('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color');

		value.bind(function(newval) {
			$("ul.sub-menu li.menu-item a").hover(function(){
			    $(this).css("color", newval);
			}, function(){
			    $(this).css("color", oldVal);
			});

			$(".creative_menu ul.sub-menu li.menu-item-has-children").hover(function() {
			    $('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color', newval);
			}, function(){
				$('.creative_menu ul.sub-menu li.menu-item-has-children::before').css('border-left-color', oldBeforeEltVal);
			});			
		});
	});

	wp.customize('lc_customize[current_menu_item_text_color]', function(value) {
		value.bind(function(newval) {
			$('li.current-menu-item a, li.current-menu-parent a, li.current-menu-ancestor a').css('color', newval);
		});
	});	

	wp.customize('lc_customize[submenu_bg_color]', function(value) {
		value.bind(function(newval) {
			$('ul.sub-menu li').css('background-color', newval);
		});
	});	
	
	wp.customize('lc_customize[creative_menu_overlay_bg]', function(value) {
		value.bind(function(newval) {
			$('.nav_creative_container').css('background-color', newval);
		});
	});

	wp.customize('lc_customize[creative_icons_color]', function(value) {
		var second_color = wp.customize.instance('lc_customize[lc_second_color]').get();

		value.bind(function(newval) {
			$('.creative_header_icon, .creative_header_icon a').css('color', newval);
			$('.hmb_line').css('background-color', newval);

			$(".creative_header_icon.lc_social_icon").hover(function(){
				$(this).css("color", second_color);
			}, function(){
				$(this).css("color", newval);
			});

			$(".creative_header_icon.lc_social_icon a").hover(function(){
				$(this).css("color", second_color);
			}, function(){
				$(this).css("color", newval);
			});			
		});
	});

	wp.customize('lc_customize[lc_blog_no_thumb_color]', function(value) {
		value.bind(function(newval) {
			$('.post_item.lc_blog_masonry_brick.no_thumbnail, .gallery_brick_overlay').css('background-color', newval);
		});
	});	

})(jQuery);