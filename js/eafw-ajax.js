
function validateForm(form, query_nonce_value) {

	// jQuery("#evnt-attnd-form").hide();
	$("#eawp-loading-icon").show();


	var alldata = {
		'action': query_nonce_value,
		'formsdata': $("#evnt-attnd-form").serialize() + '&security=' + query_nonce_value,
	};



	jQuery.post(eafw_ajax.ajaxurl, alldata, function(response) {
		
		var filterResponse = response.substring(0, response.indexOf('0'));
		$("#eawp-loading-icon").hide();
		var message ='';
		// alert(filterResponse);
		if(filterResponse==="NOUSER" || filterResponse==="ADDINGERROR" || filterResponse==="FOUNDUSER"  ){
					// jQuery("#evnt-attnd-form").show();
						
					 
					// form.querySelector( 'button.prev' ).click();
					message = showMessage(form,filterResponse );

					if(message[0]){
						var resultMessage = $('span.error-message' );
					
						
						resultMessage.text( message[1]);
						resultMessage.addClass( 'show' );
						if($('#evnt-attnd-form').hasClass('hide')){
							$('#evnt-attnd-form').removeClass('hide' );
						}	
					}

					
				
		}
		else if(filterResponse==="SIGNEDIN" || filterResponse==="ALREADYIN" || "ADDEDTODB" ){
		
			message = showMessage(form,filterResponse);
			
			if(!message[0]){
				
				$("#ea-form-result").text(message[1]);
				$("#ea-form-result-container").show();
				
				
			}
		}
			
	return 0;
	});
}
function showMessage ( form, err ) {
		var message = '';
		var message2 = '';
		var el = '';
		var isError = false;
		var isError2 = false;
		switch( err ) {
			case 'NOUSER':
				message = "Sorry user not found, please try again...";
				message2 = "First Time signing in"
				isError = true;
				isError2 = true;
				break;
			case 'ADDINGERROR':
				message = 'There was an problem adding your information. Please try again...';
				isError = true;
				el = 'span.error-message';
				break;
			case 'FOUNDUSER':
				message = 'User Already Used, Please Try Another Username...';
				isError = true;
				el = 'span.error-message';
				break;
			case 'SIGNEDIN' :
			case 'ADDEDTODB' :
				el = 'ea-form-result';
				message = 'Thank you, you have been signed in...';
				break;
			case 'ALREADYIN' :
				message = 'You have already signed in today... Thank You...';
				break;
		
			
			default: break;
			
		};
		
		
		return [isError,message,isError2,message2];
	}
	