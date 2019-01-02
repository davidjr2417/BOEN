function ValidateForm(theForm, query_nonce_value) {

	// jQuery("#evnt-attnd-form").hide();
	jQuery("#eawp-loading-icon").show();

// alert(query_nonce_value);
	var alldata = {
		'action': query_nonce_value,
		'formsdata': jQuery("#evnt-attnd-form").serialize() + '&security=' + query_nonce_value,
	};



	jQuery.post(eafw_ajax.ajaxurl, alldata, function(response) {
		// alert('a');
	// 	var filterResponse = response.substring(0, response.indexOf('0'));

	// 	if(showError(form,filterResponse )){
	// 				// jQuery("#evnt-attnd-form").show();
					jQuery("#eawp-loading-icon").hide();
			classie.removeClass( form.querySelector( '.eaform-inner' ), 'hide' );
			alert(theForm.getSum());
			// this._showError("INVALIDOPTION");
	// 	}
			
	

		// jQuery("#eawp-loading-icon").hide();
		// jQuery("#ea-form-result").show();

		// jQuery("#ea-form-result").text(response.substring(0, response.indexOf('0')));

	});
}
// function showError ( form, err ) {
// 		var message = '';
// 		var isError = false;
// 		switch( err ) {
// 			case 'NOUSER':
// 				message = 	"Sorry user not found, please try again...";
// 				isError = true;
// 				break;
// 			case 'INVALIDEMAIL':
// 				message = 'Please fill a valid email address';
// 				break;
// 			case 'INVALIDPHONE' :
// 				message = 'Please fill a valid phone number 123-456-7890';
// 				break;
// 			case 'INVALIDOPTION' :
// 				message = 'Please select an option from above';
// 				break;
			
// 			default: break;
			
// 		};
// 		var error = form.querySelector( 'span.error-message' );
// 		error.innerHTML = message;
// 		classie.addClass(error, 'show' );
// 		return isError;
// 	}


// 	// clears/hides the current error message
// 	stepsForm.prototype._clearError = function() {
// 		classie.removeClass( this.error, 'show' );
// 	}