;(function($){
	$( '#sortable' ).sortable();
	
	function fs_reset_names() {
		$( '#sortable li input' ).each( function( index ) {
			$(this).attr( 'name', 'fs_images['+index+'][url]' );
		});
	}

	$( '#sortable' ).on( 'sortupdate', function( event, ui ) {
		fs_reset_names();
	} );

	$( '#sortable' ).on( 'click', '.remove-slide', function(evt){
	  evt.preventDefault();
		var message = 'Are you sure you want to remove this slide?'
		if (confirm(message)) {
			$(this).parent().remove();
			fs_reset_names();
		}
	});

	$( '#sortable' ).on( 'click', '.add-image', function(evt){
		evt.preventDefault();
		var item = $(this).parent().find('input.url');
		fs_add_image( item );
	});

	function fs_add_image( item ){
		var fs_image_upload;

    // If the media frame already exists, reopen it.
    if ( fs_image_upload ) {
            fs_image_upload.open();
            return;
    }
		
		// Create the media frame.
    fs_image_upload = wp.media.frames.fs_image_upload = wp.media({
			frame: 'post',
			state: 'insert',
			title: 'Upload your csv file',
			button: {
				text: 'Upload'
			},
			multiple: false
		});

		fs_image_upload.on( 'menu:render:default', function(view) {
			// Store our views in an object.
			var views = {};

			// Unset default menu items
			view.unset('library-separator');
			view.unset('gallery');
			view.unset('featured-image');
			view.unset('embed');
			view.unset('attachments-browser');


			// Initialize the views in our view object.
			view.set(views);

		});

		// If nothing is selected reset the fields
		fs_image_upload.on( 'close', function() {
		   // do nothing for now
		})

		// When an image is selected, run a callback.
		fs_image_upload.on( 'insert', function() {
			var selection = fs_image_upload.state().get('selection');
			selection.each( function( attachment, index ) {
			        attachment = attachment.toJSON();
			        if(index == 0){
								item.val(attachment.url);
			        } else{
			                // do nothing
			        }
			});
		});

		// Finally, open the modal
		fs_image_upload.open();

	}

	$( '#submit' ).click(function(evt){
		$( '#sortable input' ).each(function(){
			if ( $(this).val() === '' ) {
				$(this).parent().remove();
			}
		});
	});

	$( '#add-slide' ).click(function(evt){
		evt.preventDefault();
		var clone = $('.slide-placeholder').html();
		$( '#sortable' ).append(clone);
		fs_reset_names();
	});

})(jQuery);