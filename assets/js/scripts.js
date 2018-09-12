(function( $ ){

	$('#zhivo-contact-form').submit(function(e){
		e.preventDefault();
		var submitVal = $('#zhivo-contact-form .form-submit-btn').val();
		$('#zhivo-contact-form .form-submit-btn').val(zObj.loading);
		$.post( zObj.ajaxUrl, $(this).serialize() )
			.done(function( data ) {
				$('#zhivo-contact-form .form-submit-btn').val(submitVal);
				$('#contact-form .success,#contact-form .error').remove();
				$('#contact-form #zhivo-contact-form').before( '<div class="success">'+zObj.contactSuccess+'</div>' );
				$('#zhivo-contact-form')[0].reset();
			})
			.fail(function( data ) {
				$('#zhivo-contact-form .form-submit-btn').val(submitVal);
				$('#contact-form .success,#contact-form .error').remove();
				$('#contact-form #zhivo-contact-form').before( '<div class="error">'+zObj.contactError+'</div>' );
				$('html,body').animate({scrollTop:$('#contact-form').offset().top},'slow');
			});
	});

})( jQuery );
