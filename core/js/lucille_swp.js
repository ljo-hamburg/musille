jQuery(document).ready(function($) {
	'use strict';

	handleCoverBgImage($);
	logoInTheMiddle($);
	handleBgColor($);
	setTransitionForCreativeTopItems($, 0);
	handleHmbMenu($);
	handleQuotes($);
	runMasonryGallery($);
	runMasonryBlog($);
	runMasonryBlog($);
	stickyMenu($);
	backToTop($);
	clickOnSearchIcon($);
	handleMobile($);
	handleVideoImageContainer($);
	handleAlbumImageContainer($);
	handleArtistImageContainer($);
	justifiedGallery($);
	ajaxVcCfResponsive($);
	runUnslider($);
	handleParallax($);
	handleGoToNextSection($);
	hanldeJsLinks($);
	imageOverText($);
	setTimeout(function(){
		setContentHeight($);	
	}, 800);
	wavePlayer($);
	customPageMenuStyle($);
	wooImageGallery($);
	eventsScdCat($);


	$(window).scroll(function() {
		stickyMenu($);
		customPageMenuStyle($);
    });

    $('.vc_tta-panel-heading').click(function(){
		setTimeout(function(){
			handleVideoImageContainer($);
		}, 400);
    });

	$(window).on("debouncedresize", function(event) {
		runMasonryGallery($);
		runMasonryBlog($);
		handleVideoImageContainer($);
		handleAlbumImageContainer($);
		ajaxVcCfResponsive($);
		setTimeout(function(){
			setContentHeight($);	
		}, 400);
		handleCenteredMenu($);
		handleArtistImageContainer($);
	});
});

function runMasonryGallery($) {
	if (!$('.lc_masonry_container').length) {
		return;
	}

	var $grid = $('.lc_masonry_container').imagesLoaded( function() {

		$grid.find('.lc_single_gallery_brick').each(function(){
            var brick_height = Math.ceil($(this).find('img').height());
            if ($(this).hasClass("swp_equal_height_style")) {
                 var brick_height = parseFloat(Math.ceil($(this).find('img').width()) / 1.9);
            }
			$(this).css("height", brick_height);
		});

		$grid.masonry({
			itemSelector: '.lc_masonry_brick',
			percentPosition: true,
			columnWidth: '.brick-size',
		}); 
	});
}

function runMasonryBlog($) {
	if (!$('.lc_blog_masonry_container').length) {
		return;
	}

	var $grid = $('.lc_blog_masonry_container').imagesLoaded( function() {
		var default_width = $('.blog-brick-size').width();
		var default_height = 3/4 * default_width;
		var is_grid_layout = false;
		var no_portrait_allowed = false;
		var fixed_content_height_mobile = 1.6;

		if ($grid.hasClass("grid_container")) {
			is_grid_layout = true;
		}

		if (default_width < 300) {
			if ($('.blog-brick-size').parent().width() > 550) {
				$('.blog-brick-size').removeClass('brick3');
				$('.blog-brick-size').addClass('brick2');
				default_width = $('.blog-brick-size').width();
			} else {
				default_width = $('.blog-brick-size').parent().width();
			}
			default_height = 3/4 * default_width;
		}

		if ((2 * default_width - $grid.width()) > 1) {
			no_portrait_allowed = true;
		}

		$('.lc_blog_masonry_brick').each(function(){
			
				if ($(this).hasClass('has_thumbnail')) {
					
					var $image = $(this).find('img.lc_masonry_thumbnail_image');
					var img_src = $image.attr("src");

					var $cover_div = $(this).find(".brick_cover_bg_image");
					$cover_div.addClass("lc_cover_bg");
					$cover_div.css("background-image", "url("+img_src+")");
					
					var imageObj = new Image();
					imageObj.src = $image.attr("src");

					if (is_grid_layout || no_portrait_allowed) {
						$(this).css("width", default_width);
						$(this).css("height", default_height);
						if (default_width < 380) {
							$(this).css("height", fixed_content_height_mobile * default_height);
						}
					} else {
						if (imageObj.naturalWidth / imageObj.naturalHeight >= 1.6) {
							$(this).addClass("landscape_brick");
							$(this).css("width", 2*default_width);
							$(this).css("height", default_height);
						} else if (imageObj.naturalHeight / imageObj.naturalWidth >= 1.5) {
							$(this).addClass("portrait_brick");
							$(this).css("width", default_width);
							$(this).css("height", 2*default_height);
						} else {
							$(this).css("width", default_width);
							$(this).css("height", default_height);
						}
					}
				} else {
						$(this).css("width", default_width);
						$(this).css("height", default_height);
						if (default_width < 380) {
							$(this).css("height", fixed_content_height_mobile * default_height);
						}
				}
		});


		$grid.masonry({
			itemSelector: '.lc_blog_masonry_brick',
			percentPosition: true,
			columnWidth: '.blog-brick-size',
		});
		$grid.fadeTo("400", 1);
	});
}

function handleQuotes($) {
	$('blockquote').each(function(){
		$(this).prepend($('<i class="fa fa-quote-right" aria-hidden="true"></i>'));
	});
}

function handleCoverBgImage($) {
	$( ".lc_swp_background_image" ).each(function() {
		var imgSrc = $(this).data("bgimage");
		var bg_position = "center center";

		if ($(this).hasClass('swp_align_bg_img')) {
			bg_position = "center " + $(this).data('valign');
		}

		$(this).css("background-image", "url("+imgSrc+")");
		$(this).css("background-position", bg_position);
		$(this).css("background-repeat", "no-repeat");
		$(this).css("background-size","cover");
	});
}

function handleBgColor($) {
	$( ".lc_swp_overlay" ).each(function() {
		var bgColor = $(this).data("color");
		
		$(this).parent().css("position", "relative");
		
		$(this).css({
			"background-color" : bgColor,
			"position" : "absolute"
		});
	});

	$( ".lc_swp_bg_color" ).each(function() {
		var bgColor = $(this).data("color");
		$(this).css("background-color", bgColor)
	});
}

function handleHmbMenu($) {
	$( ".hmb_menu" ).hover(
		function() {
			$(this).find('.hmb_line').addClass('hover');
		}, function() {
			$(this).find('.hmb_line').removeClass('hover');
		}
	);

	$('.hmb_menu').click(function() {
		$(this).find('.hmb_line').toggleClass('click');

		if ($(this).hasClass('hmb_creative')) {
			$('.nav_creative_container').toggleClass('visible_container');

			var resetValues = $('.nav_creative_container .creative_menu ul.menu > li').hasClass('menu_item_visible') ? 1 : 0;
			setTransitionForCreativeTopItems($, resetValues);
			$('.nav_creative_container .creative_menu ul.menu > li').toggleClass('menu_item_visible');
		}

		if ($(this).hasClass('hmb_mobile')) {
				if ($('header').hasClass('sticky_enabled')) {
					$("body").animate({ scrollTop: 0 }, 400, function(){
							showMobileMenuContainer($);
					});
				} else {
					showMobileMenuContainer($);
				}
			}		
	});

	/*close creative on click on menu item*/
	$('nav.creative_menu.close_on_click').find('a').click(function() {
		$('.nav_creative_container').toggleClass('visible_container');
		var resetValues = $('.nav_creative_container .creative_menu ul.menu > li').hasClass('menu_item_visible') ? 1 : 0;
		setTransitionForCreativeTopItems($, resetValues);
		$('.nav_creative_container .creative_menu ul.menu > li').toggleClass('menu_item_visible');
		$('.hmb_line.click').removeClass('click');
	});
}

var setTransitionForCreativeTopItems = function($, resetValues) {
	if (!$(".nav_creative_container").length) {
		return;
	}

	if (resetValues == 1) {
		$('.nav_creative_container .creative_menu ul.menu > li').each(function(){
			$(this).css({
				"-webkit-transition-delay"	: "0s",
				"-moz-transition-delay"		: "0s",
				"transition-delay"			: "0s"
			});
		})

		return;
	}

	var start_delay = 2;
	var elt_duration = "";
	$('.nav_creative_container .creative_menu ul.menu > li').each(function(){
		start_delay += 1;
		if (start_delay < 10) {
			elt_duration = "0."+start_delay+"s";
		} else {
			elt_duration = start_delay/10+"s";
		}

		$(this).css({
			"-webkit-transition-delay"	: elt_duration,
			"-moz-transition-delay"		: elt_duration,
			"transition-delay"			: elt_duration
		});
	});
}

var showMobileMenuContainer = function($) {
	$('.mobile_navigation_container').toggle();
	$('.mobile_navigation_container').toggleClass('mobile_menu_opened');	
}

function setContentHeight($) {
	if (!$('#lc_swp_content').length) {
		return;
	}
    if ($('body').hasClass('page-template-template-visual-composer')) {
		if ($('.lc_copy_area').length) {
				$('.lc_copy_area').css("opacity", "1");
		}
        return;
    }	
	$('#lc_swp_content').css("min-height", "");

	var totalHeight = $('#lc_swp_wrapper').height();
	if ($('#heading_area').length > 0) {
		totalHeight -= $('#heading_area').height();
	}
	if ($('#footer_sidebars').length) {
		totalHeight -= $('#footer_sidebars').height();
	}

	if ($('.lc_copy_area ').length) {
		totalHeight -= $('.lc_copy_area').height();
	}

	var minContentHeight = $('#lc_swp_content').data("minheight");
	if ($('#lc_swp_content').length) {
		if (totalHeight > minContentHeight) {
			$('#lc_swp_content').css('min-height', totalHeight);
		}
	}

	if ($('.lc_copy_area').length) {
		$('.lc_copy_area').css("opacity", "1");
	}
}

function stickyMenu($) {
	if (!$('header').hasClass('lc_sticky_menu')) {
		return;
	}
	if ($('.mobile_navigation_container').hasClass('mobile_menu_opened')) {
		return;
	}

	var triggerSticky = 10;
	if ($(window).scrollTop() > triggerSticky) {
		enableSticky($);
	} else {
		disableSticky($);
	}
}

var enableSticky = function($) {
	if ($('header').hasClass('sticky_enabled')) {
		return;
	}

	//$('header').css("visibility", "hidden")
	$('header').addClass('sticky_enabled');
	$('header').css("visibility", "visible");
}

var disableSticky = function($) {
	var element = $('header');
	if ($(element).hasClass('sticky_enabled')) {
			$(element).removeClass('sticky_enabled');

			if(0 == $(element).attr("class").length) {
				$(element).removeAttr("class");
			}
	}
}

var backToTop = function($) {
	if (!$('.lc_back_to_top_btn').length) {
		return;
	}

	var backToTopEl = $('.lc_back_to_top_btn');
	$(backToTopEl).click(function(){
		$("html, body").animate({ scrollTop: 0 }, "slow");
	});

	$(window).scroll(function() {
		if ($(window).scrollTop() < 200) {
			$(backToTopEl).hide();
		} else {
			$(backToTopEl).show('slow');
		}
	});	
}

var clickOnSearchIcon = function($) {
	$('.trigger_global_search').click(function(){
		$('#lc_global_search').show();
		$('#lc_global_search').find('input').focus();
	});

	$('.close_search_form').click(function(){
		$('#lc_global_search').hide();
	});

	$(document).keyup(function(e) {
		/* escape key maps to keycode `27`*/
	    if (e.keyCode == 27) { 
			$('#lc_global_search').hide();
	    }
	});	
}

var handleMobile = function($) {
	$('nav.mobile_navigation').find('ul li.menu-item-has-children > a').click(function(event){
		var links_to = $(this).attr("href");
		var elt_fin = $(this).offset().left + $(this).width() + parseInt($(this).css("padding-right")) + parseInt($(this).css("padding-left"));
		var AFTER_WIDTH = 100;

		if ((event.offsetX > elt_fin - AFTER_WIDTH) ||
			("#" == links_to)) {
			event.preventDefault();
			$(this).parent().find('> ul').toggle('300');
		}
	});
	/*close menu on anchor links*/
	$('nav.mobile_navigation').find("a").click(function(){
		var links_to = $(this).attr("href");
		if ((links_to.indexOf("#") > -1) && (("#" != links_to)) ) { 
			$('.hmb_menu.hmb_mobile').trigger("click");
		}
	});
	$('nav.creative_menu').find("a").click(function(){
		var links_to = $(this).attr("href");
		if ((links_to.indexOf("#") > -1) && (("#" != links_to)) ) { 
			$('.hmb_menu.hmb_creative').trigger("click");
		}
	});
}

var handleVideoImageContainer = function($) {
	if (!$('.video_image_container').length) {
		return;
	}

	$('.video_image_container').each(function() {
		var no_px_width = parseFloat($(this).css('width'));
		$(this).css("height", no_px_width * 9/16);
		$(this).parent().parent().css("opacity", 1);
	});
}

var handleAlbumImageContainer = function($) {
	if (!$('.album_image_container').length) {
		return;
	}

	$('.album_image_container').each(function() {
		var no_px_width = parseFloat($(this).css('width'));
		$(this).css("height", no_px_width);
		$(this).parent().parent().css("opacity", 1);
	});

	$('.single_album_item').each(function(){
		var album_title = $(this).find('.album_title');
		var distance = album_title.innerHeight() + 39 - parseInt(album_title.css("padding-bottom"));
		album_title.css("padding-bottom", distance);
	});
}

function handleArtistImageContainer($) {
	$('.artist_img_container').each(function() {
		var no_px_width = parseFloat($(this).css('width'));
		//$(this).css("height", no_px_width * 5/4);
		$(this).css("height", no_px_width * 1.1);
		$(this).parent().parent().css("opacity", 1);
	});
}

var justifiedGallery = function($) {
	if (!$('.lc_swp_justified_gallery').length) {
		return;
	}

	$(".lc_swp_justified_gallery").each(function() {
		var rowHeight = $(this).data("rheight");
		if (!$.isNumeric(rowHeight)) {
			rowHeight = 180;
		}

		$(this).justifiedGallery({
			rowHeight: rowHeight,
			lastRow: 'justify',
			margins: 0,
			captions: false,
			imagesAnimationDuration: 400
		});

		$(this).find("img").fadeTo("600", 0.6);
		$(this).parent().find('.view_more_justified_gallery').fadeTo("400", 1);
	});

	setTimeout(function(){
		$('.img_box').find("img").addClass("transition4");
	}, 600);

}

var ajaxVcCfResponsive = function($) {
	if (!$(".vc_lc_contactform").length) {
		return;
	}

	var containerWidth = $(".vc_lc_contactform").width();
	if (containerWidth <= 768) {
		$(".vc_lc_contactform").find(".vc_lc_element").removeClass("three_on_row");
	} else {
		$(".vc_lc_contactform").find(".three_on_row_layout").addClass("three_on_row");
	}
}

var runUnslider = function($) {
	$('.lc_reviews_slider').each(function(){
		var slide_speed = 400;
		var slide_delay = 4000;

		if (typeof $(this).parent().data('slidespeed') !== 'undefined') {
			slide_speed = $(this).parent().data('slidespeed');
		}
		if (typeof $(this).parent().data('slidedelay') !== 'undefined') {
			slide_delay = $(this).parent().data('slidedelay');
		}		

		$(this).unslider({
			arrows: {
				prev: '<a class="unslider-arrow prev"><i class="fa fa-angle-left" aria-hidden="true"></i></a>',
				next: '<a class="unslider-arrow next"><i class="fa fa-angle-right" aria-hidden="true"></i></a>',
			},
			autoplay: true,
			delay: slide_delay,
			speed: slide_speed
		});		
	});


}

var handleParallax = function($) {
	$( ".lc_swp_parallax" ).each(function() {
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			$(this).addClass("ai_swp_no_scroll");
		} else {
			$(this).css("background-position", "50% 0");
			var $parallaxObject = $(this);
			
			$(window).scroll(function() {
				var yPos = -($(window).scrollTop() / $parallaxObject.data("pspeed")); 
				var newCoord = '50% '+ yPos + 'px';
				
				$parallaxObject.css("background-position", newCoord);
			});
		}
	});	
}

var  handleGoToNextSection = function($) {
	if (!$('.goto_next_section').length) {
		return;
	}

	var animateIcon = function(targetElement, speed){
	    $(targetElement).css({'padding-top':'0px'});
	    $(targetElement).css({'opacity':'1'});
	    $(targetElement).animate(
	        {
	        	'padding-top'	: "25px",
	        	"opacity"		: "0"
	    	},
	        {
	        duration: speed,
	        complete: function(){
	            animateIcon($('.goto_next_section i'), speed);
	            }
	        }
	    );
	};
	setTimeout(function(){
		animateIcon($('.goto_next_section i'), 2000);
	}, 3000);
	
	$('.goto_next_section').click(function(){
		var $nextRow = $(this).parents('.vc_row').next();
		if($nextRow.length) {
			$('html, body').animate({
        		scrollTop: $nextRow.offset().top
    		}, 1200);
		}
	});

}

var hanldeJsLinks = function($) {
	if (!$('.lc_js_link').length) {
		return;
	}

	$('.lc_js_link').click(function(event) {
		event.preventDefault();
		var newLocation = $(this).data("href");
		var newWin = '';
		if ($(this).data("target")) {
			newWin = $(this).data("target");
		}
		window.open(newLocation, newWin);
	});
}

var logoInTheMiddle = function($) {
	if (!$('.centered_menu').length) {
		return;
	}

	var middleMenuPosition = Math.ceil($(".header_inner.centered_menu ul.menu > li").length / 2);
	$(".header_inner.centered_menu ul.menu > li:nth-child(" + middleMenuPosition + ")").after('<li class="logo_menu_item"></li>');	
	$('#logo').detach().appendTo('li.logo_menu_item');
	$('#logo').css("opacity", "1");
	$(".header_inner.centered_menu").animate({ opacity: 1 }, "slow");

	/*center menu to the screen*/
	handleCenteredMenu($);
}

var handleCenteredMenu = function($) {
	if (!$('nav.centered_menu').length) {
		return;
	}

	/* recalculate based on items length [[[ */
	var leftWidth =0;
    var rightWidth =0;
    var logoMenuItem = $( 'nav.centered_menu .logo_menu_item' );
    logoMenuItem.prevAll( '.menu-item' ).each( function() {
        leftWidth += $( this ).width();
    } );
    logoMenuItem.nextAll('.menu-item').each(function(){
        rightWidth += $(this).width();
    });
    $( 'nav.centered_menu').css('margin-left', rightWidth - leftWidth);
    /* ]]] */

	var classic_icons_correnction = 0 - $('.classic_header_icons.centered_menu').outerWidth();
	$('.classic_header_icons.centered_menu').css("margin-right", classic_icons_correnction);
}

function imageOverText($) {
    if (!$('.swp_image_over_text').length) {
        return;
    }

    $('.swp_image_over_text').each(function() {
        var databg = $(this).data("bgimage");
        $(this).css("background", "url(" + databg + ") center center no-repeat");
        $(this).css("-webkit-background-clip", "text");
        $(this).css("-webkit-text-fill-color", "transparent");
    } );
}

function wavePlayer($) {
	$('.lc_wave_player_container').each(function(){
		var $player = $(this);
		var $play_btn = $player.find('.fa-play-circle');
		var $pause_btn = $player.find('.fa-pause-circle');
		var $fwd_btn = $player.find('.fa-step-forward');
		var $bkw_btn = $player.find('.fa-step-backward');
		var $progress_bar = $player.find('.progress_bar');
		var $first_song = $player.find('.wave_player_entry').first();
		var $last_song = $player.find('.wave_player_entry').last();
		var wave_col = $player.data('wavecol');
		var wave_prog_col = $player.data('waveprogcol');

		var wave_id = $player.find('.lc_waveform').attr('id');

		/*set the colors*/
		$progress_bar.css("background-color", wave_col);

		var wavesurfer = WaveSurfer.create({
			container: '#' + wave_id,
			hideScrollbar : true,
			normalize : false,
			waveColor : wave_col,
			progressColor: wave_prog_col,
			cursorColor: "transparent",
			pixelRatio : 1,
			minPxPerSec: 50,
			barWidth: 1,
			height: 50
		});


		/*load the 1st song*/
		wavesurfer.load($first_song.data('mediafile'));
		$first_song.addClass("loaded_for_play");
		wavesurfer.on('ready', function () {
			$progress_bar.hide();
		});
		
		wavesurfer.on('loading', function(progress_amount) {
			if ("none" == $progress_bar.css("display")) {
				$progress_bar.show();	
			}
			$progress_bar.css("width", progress_amount + "%");
		});

		$play_btn.click(function() {
			if ($player.find('.wave_player_entry.loaded_for_play').length) {
				$first_song.removeClass("loaded_for_play");
				$first_song.addClass("now_playing");
				wavesurfer.play();
				$progress_bar.hide();
				$play_btn.hide();
				$pause_btn.show();    			
			}

			$play_btn.hide();
			$pause_btn.show();
			wavesurfer.play();
		});
		$pause_btn.click(function() {
			$play_btn.show();
			$pause_btn.hide();
			wavesurfer.pause();
		});
		$fwd_btn.click(function() {
			var $crt_elt = $player.find('.wave_player_entry.now_playing');
			var $next_elt = $crt_elt.next();
			if (!$next_elt.length) {
				$next_elt = $first_song;
			}			
			$crt_elt.removeClass('now_playing');
			$next_elt.addClass('now_playing');
			wavesurfer.load($next_elt.data('mediafile'));
			playOnReady();
		});
		$bkw_btn.click(function() {
			var $crt_elt = $player.find('.wave_player_entry.now_playing');
			var $prev_elt = $crt_elt.prev();
			if (!$prev_elt.length) {
				$prev_elt = $last_song;
			}
			$crt_elt.removeClass('now_playing');
			$prev_elt.addClass('now_playing');
			wavesurfer.load($prev_elt.data('mediafile'));
			playOnReady();
		});			
		
		wavesurfer.on('finish', function () {
			/*play next song*/
			var $crt_elt = $player.find('.wave_player_entry.now_playing');
			var $next_elt = $crt_elt.next();
			if (!$next_elt.length) {
				$next_elt = $first_song;
			}			
			$crt_elt.removeClass('now_playing');
			$next_elt.addClass('now_playing');
			wavesurfer.load($next_elt.data('mediafile'));
			playOnReady();
		});		

		function playOnReady() {
			wavesurfer.on('ready', function () {
				$progress_bar.hide();
    			wavesurfer.play();
				$play_btn.hide();
				$pause_btn.show();    			
			});
		}

		/*progressColor, waveColor, maxCanvasWidth, hideScrollbar*/
		$player.find('.wave_song_details').click(function(){
			if (wavesurfer.isPlaying()) {
				wavesurfer.stop();
				/*wavesurfer.empty();*/
			}
			wavesurfer.load($(this).parent().data('mediafile'));
			$player.find('.wave_player_entry.now_playing').removeClass('now_playing');
			$(this).parent().addClass('now_playing');

			wavesurfer.on('ready', function () {
    			wavesurfer.play();
				$play_btn.hide();
				$pause_btn.show();    			
			});
		});
	});
}

function customPageMenuStyle($) {
    /*no custom styling on sticky menu*/
    if ($('header#lc_page_header').hasClass('sticky_enabled')) {
    	/*logo*/
        if ($('#logo').find('.cust_page_logo').length) {
            $('#logo').find('.cust_page_logo').hide();
            $('#logo').find('.global_logo').show();
        }

         if ($('header#lc_page_header').hasClass('cust_page_menu_style')) {
            $('header#lc_page_header').removeAttr("style");

			/*creative*/
			$('header#lc_page_header').find(".hmb_line").removeAttr("style");
			$('header#lc_page_header').find(".creative_header_icon > a").removeAttr("style");
			$('header#lc_page_header').find(".creative_header_icon > .lnr-magnifier").removeAttr("style");

            /*classic*/
            $('header#lc_page_header').find(".classic_header_icon > a").removeAttr("style");
            $('header#lc_page_header').find(".classic_header_icon > .lnr-magnifier").removeAttr("style");
            $('header#lc_page_header').find(".classic_menu > ul > li:not(.current-menu-parent):not(.current-menu-item) > a").removeAttr("style");

            /*centered*/
            $('header#lc_page_header').find(".lc_social_profile > a").removeAttr("style");
         }

        return;
    }

    if ($('#logo').find('.cust_page_logo').length) {
        $('#logo').find('.cust_page_logo').css("display", "block");
        $('#logo').find('.global_logo').hide();
    }

	if ($('header#lc_page_header').hasClass('cust_page_menu_style')) {
		var menu_bg = $('header#lc_page_header').data("menubg");
        var menu_col = $('header#lc_page_header').data("menucol");
        
        if (menu_bg && (menu_bg != "")) {
            $('header#lc_page_header').css("background-color", menu_bg);
        }
        if (menu_col && (menu_col != "")) {
            /*creative*/
            $('header#lc_page_header').find(".hmb_line").not('.mobile_hmb_line').css("background-color", menu_col);
            $('header#lc_page_header').find(".creative_header_icon > a").not('.mobile_menu_icon').css("color", menu_col);
            $('header#lc_page_header').find(".creative_header_icon > .lnr-magnifier").not('.lnr_mobile').css("color", menu_col);

            /*classic*/
            $('header#lc_page_header').find(".classic_header_icon > a").css("color", menu_col);
            $('header#lc_page_header').find(".classic_header_icon > .lnr-magnifier").not('.lnr_mobile').css("color", menu_col);
            $('header#lc_page_header').find(".classic_menu > ul > li:not(.current-menu-parent):not(.current-menu-item) > a").css("color", menu_col);              

            /*centered*/
            $('header#lc_page_header').find(".lc_social_profile > a").css("color", menu_col);
        }
	}
}

function wooImageGallery($) {
	$('.woocommerce-product-gallery').find('a').attr("data-lightbox", "swp_product_gallery");
}

function eventsScdCat($) {
	$('ul.events_list.vc_events_element.show_cat_on_top').each(function(){
		var parent = $(this).parent();
		var term_container = parent.find('.swp_events_scd_cat');

		var terms = [];
		$(this).find('li.single_event_list').each(function(){
			var newel = $(this).data("terms");
			var term_arr = newel.split("|");

			term_arr.forEach(function(single_term) {
				single_term = single_term.trim();
				if (($.inArray(single_term, terms) == -1) && (single_term != "")) {
					terms.push(single_term);
				}
			});
		});

		terms.forEach(function(single_term) {
			term_container.append('<span class="swp_event_scd_single_cat">' + single_term +'</span>');
		});

	    $('.swp_event_scd_single_cat').click(function() {
	    	if ($(this).hasClass("swp_event_scd_cat_all")) {
	    		parent.find('li.single_event_list').show();
	    	} else {
		    	var cat_val = $(this).text();
		    	parent.find('li.single_event_list').hide();

		    	parent.find('.single_event_list').each(function(){
		    		var el_terms = $(this).data("terms");
		    		if (-1 != el_terms.search(cat_val)) {
		    			$(this).show();
		    		}
		    	});
	    	}
	    });
	});
}