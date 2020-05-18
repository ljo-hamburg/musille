jQuery(document).ready(function($){
	"use strict";
 
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame;
 
    // Runs when the image button is clicked.
    $('#js_swp_meta_bg_image-button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#js_swp_meta_bg_image', '#custom_bg_meta_preview img');
    });
	
	$('#js_swp_meta_bg_image-buttondelete').click(function(){
		$('#custom_bg_meta_preview img').attr('src', '');
		$('#js_swp_meta_bg_image').val('');
	});
	
	$('#lc_swp_meta_head_bg_image-button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#lc_swp_meta_heading_bg_image', '#custom_head_bg_meta_preview img');
    });
	
	$('#lc_swp_meta_head_bg_image-buttondelete').click(function(){
		$('#custom_head_bg_meta_preview img').attr('src', '');
		$('#lc_swp_meta_heading_bg_image').val('');
	});

	/*page specific menu logo*/
	$('#lc_swp_meta_page_logo_image-button').click(function(e) {
        e.preventDefault();
 		openAndHandleMedia($, meta_image_frame, '#lc_swp_meta_page_logo', '#custom_head_page_logo_meta_preview img');
    });
	
	$('#lc_swp_meta_page_logo-buttondelete').click(function(){
		$('#custom_head_page_logo_meta_preview img').attr('src', '');
		$('#lc_swp_meta_page_logo').val('');
	});	
	
	/*alpha color picker*/
	$('input.alpha-color-picker').alphaColorPicker();
});

function openAndHandleMedia($, meta_image_frame, inputId, pathToImgId) {
	// If the frame already exists, re-open it.
	if ( meta_image_frame ) {
		meta_image_frame.open();
		return;
	}

	// Sets up the media library frame
	meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
		title: "Choose Custom Background Image",
		button: { text:  "Use this image as background" },
		library: { type: 'image' }
	});

	// Runs when an image is selected.
	meta_image_frame.on('select', function(){

		// Grabs the attachment selection and creates a JSON representation of the model.
		var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

		// Sends the attachment URL to our custom image input field.
		$(inputId).val(media_attachment.url);
		$(pathToImgId).attr('src', media_attachment.url);
	});

	// Opens the media library frame.
	meta_image_frame.open();
}