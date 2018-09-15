jQuery(document).ready(function($){

	// upload product cover image
	var frame;
	var uploadCoverBTN 		= $('#wpdb_pro_cover_img #upload_cover_img_btn'),
		coverImgContainer 	= $('#wpdb_pro_cover_img #product_cover_image_container'),
		coverImgURL			= $('#wpdb_pro_cover_img #product_cover_img_url'),
		removeCoverImg		= $('#wpdb_pro_cover_img #remove_cover_img');

	uploadCoverBTN.on( 'click', function(e){
		e.preventDefault();
		
		if( frame ){
			frame.open();
			return;
		}

		frame = wp.media({
			title : 'Choose/Upload Product Cover Image',
			button : {
				text: 'Use this image'
			},
			multiple : false
		});

		frame.on( 'select', function(){
			// get selection
			var attachment = frame.state().get('selection').first().toJSON();
			// append image preview
			coverImgContainer.html( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );
			// update hidden input
			coverImgURL.val( attachment.url );
			// hide updload button
			uploadCoverBTN.addClass('hidden');
			// show remove image link
			removeCoverImg.removeClass('hidden');
		} );

		frame.open();

	} );

	// remove product cover image
	removeCoverImg.on( 'click', function(e){
		e.preventDefault();
		coverImgContainer.html('');
		coverImgURL.val('');
		$(this).addClass('hidden');
		uploadCoverBTN.removeClass('hidden');
	} );

});