
				var theForm = document.getElementById( 'evnt-attnd-form' );

				new stepsForm( theForm, {
					onSubmit : function( form ) {
						// hide form
						classie.addClass( theForm.querySelector( '.eaform-inner' ), 'hide' );

						/*
						form.submit()
						or
						AJAX request (maybe show loading indicator while we don't have an answer..)
						*/

						// let's just simulate something...
						var messageEl = theForm.querySelector( '.final-message' );
						messageEl.innerHTML = ' You have signed in to today\'s event <br /> Thank you!';
						classie.addClass( messageEl, 'show' );
						return ValidateForm('a');

					}
				} );
				
				function signInAs(){
					if(document.getElementById("q1_email").style.display==="none"){
						document.getElementById("q1_email").style.display="inline-block";
						document.getElementById("q1_phone").style.display="none";
						document.getElementById("q1").type="email";

					}
					else{
						document.getElementById("q1_email").style.display="none";
						document.getElementById("q1_phone").style.display="inline-block";
						document.getElementById("q1").type="tel";
					}
						
				}
	