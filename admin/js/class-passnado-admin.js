jQuery(document).ready(function() {
	generateKeyTrigger();
	copyPreviewURL();
});

function generateKey(length) {
	var result           = '';
	var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var charactersLength = characters.length;
	for ( var i = 0; i < length; i++ ) {
		result += characters.charAt(Math.floor(Math.random() * charactersLength));
	}
	return result;
}

function generateKeyTrigger() {
	jQuery('.passnado-generate-key').on('click', function() {
		 jQuery(this).prev().val(generateKey(20));
	})
}

function copyPreviewURL() {
	jQuery('.passnado-copy-key-url').on('click', function() {
		var siteURL = jQuery(this).attr('data-site-url');
		var key = jQuery('#passnado_key').val();
		var previewURL = siteURL + '?key=' + key;
		copyToClipboard(previewURL);
	});
}

function copyToClipboard(text) {
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}

//https://wordpress.stackexchange.com/questions/228085/how-to-upload-an-image-in-the-plugins-options-page
jQuery(document).ready(function($){

	var custom_uploader
	  , click_elem = $('.passnado-logo-upload')
	  , target = $('#passnado_logo')
	  , clear_elem = $('.passnado-logo-clear') 
	  , preview_box = $('#passnado-logo-preview')

	$(document)
	.on('click', '.passnado-logo-clear', function(e) {
			 e.preventDefault()
			 clear_elem.addClass('hidden');
			 preview_box.addClass('hidden');
			 target.val('')
	});

	click_elem.click(function(e) {
		 e.preventDefault();
		 //If the uploader object has already been created, reopen the dialog
		 if (custom_uploader) {
			  custom_uploader.open();
			  return;
		 }
		 //Extend the wp.media object
		 custom_uploader = wp.media.frames.file_frame = wp.media({
			  title: 'Choose Image',
			  button: {
					text: 'Choose Image'
			  },
			  multiple: false
		 });
		 //When a file is selected, grab the URL and set it as the text field's value
		 custom_uploader.on('select', function() {
			  attachment = custom_uploader.state().get('selection').first().toJSON();
			  target.val(attachment.id);
			  preview_box.removeClass('hidden').html('<img src="' + attachment.url +'" alt="Logo preview image" />');
			  clear_elem.removeClass('hidden');
		 });
		 //Open the uploader dialog
		 custom_uploader.open();
	});      
});