function ValidateForm(query_nonce_value) {	
	
	jQuery("#evnt-attnd-form").hide();
	jQuery("#eawp-loading-icon").show();
	
	var alldata = {
		'action': 'submit_user_query',
		'formsdata': jQuery("#evnt-attnd-form").serialize() + '&security=' + query_nonce_value,
	};

	jQuery.post(eafw_ajax.ajaxurl, alldata, function(response) {
		jQuery("#eawp-loading-icon").hide();
		jQuery("#ea-form-result").show();
		jQuery("#ea-form-result").text(response.substring(0, response.indexOf('0')));		
	});
}