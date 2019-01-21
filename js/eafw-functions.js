

var theForm = document.getElementById( 'evnt-attnd-form' );

function getForm(e){
	var add = '', remove='',resultMessage='', isTrue=false;

	switch(e.id){
		case "signInBtn":
			add = '#signUp';
			remove = '#login';
			isTrue = true;
			break;

		case "signUpBtn":
			add = '#login';
			remove = '#signUp' ;
			isTrue = true;
			break;

		default:
			isTrue = false;
			break;
	}

	if(isTrue){
		$(add).addClass('hide' );
		$(remove).removeClass('hide');
		$(remove).addClass('ea-current' );
		$('.next').addClass('show' );
		$('.error-message' ).removeClass('show' );
	}
}



$('button.next').click( function( ev ) {
	ev.preventDefault();
	onSubmit();
});


function onSubmit(){
	
	var status = '';
	var currentEl = $('.ea-current').attr('id');
	var isFilled =false;

	// clear any previous error messages
	clearError();

	if(currentEl =="user"){
		if($("input[name='toggle']:checked").val() == 'signIn'){
			status ='signIn';
			
			if( !validate("login") ) {
				return false;
			}
		}
		else if($("input[name='toggle']:checked").val() == 'signUp'){
			status ='signUp';

			if( !validate("signUp") ) {
				return false;
			}
		}
		isFilled = true;
		
	}
	
	if( isFilled ) {
	
		if(status=="signIn"){
			submit('login_query');
		}
		else if(status=="signUp"){
			submit('signUp_query');
		}else{
		// error
		}
	}	


}

function submit (validation) {
	if(!$('#evnt-attnd-form').hasClass('hide')){
		$('#evnt-attnd-form').addClass('hide' );
	}		
	validateForm( theForm, validation );
}

function clearError() {
	$('span.error-message').removeClass('show');
}

function showError( err ) {
	
	var message = '';
	switch( err ) {
		case 'EMPTYSTR' :
			message = 'Please fill in all fields before continuing';
			break;
		case 'INVALIDEMAIL' :
			message = 'Please fill a valid email address';
			break;
		case 'INVALIDPHONE' :
			message = 'Please fill a valid phone number 123-456-7890';
			break;
		case 'INVALIDOPTION' :
			message = 'Please select an option from above';
			break;
		
		default: 
			break;
	};


	$('span.error-message').text(message);

	if(!$('span.error-message').hasClass('show')){
		$('span.error-message').addClass('show' );
	}
}

function validate (questionID) {
	// current question´s input

	var input = $("#"+ questionID +' input' );
	var val ='', inputType='';
	

	for (var i = 0; i < input.length; i++) {

		val = input[i].value;
		// alert(val);
		if( val === '' ) {
			showError( 'EMPTYSTR' );
			return false;
		}
		//If button = email
		inputType = input[i].type;

		if(inputType == "email" && !validateEmail(val) ) {
			showError( 'INVALIDEMAIL' );
			return false;
		}
		//If button = phone
		if(inputType == "tel" && !validatePhone(val) ) {
			showError( 'INVALIDPHONE' );
			return false;
		}
	}
		return true;

}
	

	
function validateEmail (email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validatePhone(phone) {
	var re = /^\(?([2-9][0-8][0-9])\)?[-.●]?([2-9][0-9]{2})[-.●]?([0-9]{4})$/;
	return re.test(phone);
}



















