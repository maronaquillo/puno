jQuery(document).ready(function($){

	/* Change price range to selected variation price */
	if( $('.et_pb_woopro_price.change_to_variation_price').length > 0 ){
		var variations_price_range		= $('.et_pb_woopro_price.change_to_variation_price .price'),
			selected_variation_price 	= $('.et_pb_woopro_price.change_to_variation_price .wcpb_selected_variation_price'),
			variations_form				= $('.woo_product_divi_layout .variations_form');


	    variations_form.on( 'show_variation', function( event, variation ) {
			if( typeof variation !== 'undefined' && variation.is_purchasable === true && variation.price_html !== "" ){
	    		variations_price_range.hide();
	    		selected_variation_price.html( variation.price_html );
				selected_variation_price.show();
			}else{
				variations_price_range.show();
				selected_variation_price.hide();
			}

	    }); 

	    variations_form.on( 'reset_data', function(){
			variations_price_range.show();
			selected_variation_price.hide();    	
	    } );		
	}


    // gallery shortcode lightbox
    $('.wcpb_gallery_shortcode.lightbox .gallery-icon').addClass( 'et_pb_gallery_image' );

    // fix reviews rating issue if the module used twice or more
    if( $('.woo_product_divi_layout select[id="rating"]').length > 1 ){
		// Star ratings for comments
		$( 'select[name="rating"]' ).each(function(index){

			// to fix the repeated stars p for the first module
			if(index==0){
				var starsP = $(this).siblings('p.stars');
				if(starsP.length > 1){
					starsP.not(starsP[0]).remove();
				};
			}
			if(index > 0){
				$(this).hide().before( '<p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p>' );
			}
		});
    }	
});