/**
 * stepsForm.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
;( function( window ) {

	'use strict';

	var transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = { transitions : Modernizr.csstransitions };

	function extend( a, b ) {
		for( var key in b ) {
			if( b.hasOwnProperty( key ) ) {
				a[key] = b[key];
			}
		}
		return a;
	}

	function stepsForm( el, options ) {
		this.el = el;
		this.options = extend( {}, this.options );
  		extend( this.options, options );
  		this._init();
	}
	stepsForm.getSum = function(){
		return "sum";
	}

	stepsForm.prototype.options = {
		onSubmit : function() {

			return false;
		}
	};

	stepsForm.prototype._init = function() {
		// current question
		this.current = 0;

		// questions
		this.questions = [].slice.call( this.el.querySelectorAll( 'ol.questions > li' ) );
		// total questions

		this.questionsCount = this.questions.length;

		// show first question
		classie.addClass( this.questions[0], 'ea-current' );

		// next question control
		this.ctrlNext = this.el.querySelector( 'button.next' );
		this.ctrlShow = this.el.querySelector( 'button.show' );
		// sign in buttons
		 // this.ctrlNextSignIn = this.el.querySelectorAll( 'input.sign-in-as' );

//alert(	this.ctrlNextSignIn.length)
		// prev question control
		this.ctrlPrev = this.el.querySelector( 'button.prev' );

		// progress bar
		this.progress = this.el.querySelector( 'div.progress' );

		// question number status
		this.questionStatus = this.el.querySelector( 'span.number' );

		// current question placeholder
		this.currentNum = this.questionStatus.querySelector( 'span.number-current' );
		this.currentNum.innerHTML = Number( this.current + 1 );

		// total questions placeholder
		this.totalQuestionNum = this.questionStatus.querySelector( 'span.number-total' );
		this.totalQuestionNum.innerHTML = this.questionsCount;

		// error message
		this.error = this.el.querySelector( 'span.error-message' );

		// init events
		this._initEvents();
	};

	stepsForm.prototype._initEvents = function() {
		var self = this,
			// first input
			firstElInput = this.questions[ this.current ].getElementsByClassName( 'event-names' )[0],
			// focus
			onFocusStartFn = function() {
				firstElInput.removeEventListener( 'focus', onFocusStartFn );
				classie.addClass( self.ctrlNext, 'show' );

			};
			// alert('a');

		// show the next question control first time the input gets focused
		firstElInput.addEventListener( 'focus', onFocusStartFn );
// this.ctrlNextSignIn[0].addEventListener( 'click', function( ev ) {
//
// 	ev.preventDefault();
// 	self._nextQuestion();
// } );
// this.ctrlNextSignIn[1].addEventListener( 'click', function( ev ) {
//
// 	ev.preventDefault();
// 	self._nextQuestion();
// } );

		// show next question
		this.ctrlNext.addEventListener( 'click', function( ev ) {

			ev.preventDefault();
			self._nextQuestion();
		} );

		// show prev question
		this.ctrlPrev.addEventListener( 'click', function( ev ) {
			ev.preventDefault();
			self._prevQuestion();
		} );

		// pressing enter will jump to next question
		document.addEventListener( 'keydown', function( ev ) {
			var keyCode = ev.keyCode || ev.which;
			// enter
			if( keyCode === 13 ) {
				ev.preventDefault();
				self._nextQuestion();
			}
		} );

     
	};

	stepsForm.prototype._nextQuestion = function() {
		var status = '';
		var currentEl = document.getElementsByClassName('ea-current')[0].id;
		this.isFilled =false;
		alert(currentEl +" " +this.current);
		// alert(this.current.id);
		if(currentEl =="user"){
			this.current = 0;
		}else if(currentEl =="login" && this.current===undefined ){
			// if(this.current===3){alert(3);this.addEventListener( transEndEventName, onEndTransitionFn );alert(4);}
			alert('nextquestion adfdjsk');
			this.current = 0;

			
		}else if(currentEl =="login" && this.current===3 ){
			// if(this.current===3){alert(3);this.addEventListener( transEndEventName, onEndTransitionFn );alert(4);}
			
			this.current = 1;

			
		}else if(currentEl =="signUp"){
			// if(this.current===3){}
			this.current = 2;
		}

		// clear any previous error messages
		this._clearError();

		// current question
		var currentQuestion = this.questions[ this.current ];


		// check if form is filled
		// if( currentQuestion.id === this.questions[this.questionsCount - 1].id ) {
		// 	this.isFilled = true;
		// }
		
	
		if( currentQuestion.id =="user"){
		
			if(!document.querySelector("input[name='toggle']:checked")){
					//Send Error Message To Make A Choice
					// alert('Must Choice Option');
					status ='INVALIDOPTION';
					this._showError(status);
					
					return false;		
				}else if(document.querySelector("input[name='toggle']:checked").value == 'Guest'){
				//	alert("Guest");
						status ='guest';
						// alert(currentQuestion.id)
						this.current = 1;// Number for the sign up form for right now
						//= this.current;

				}
			else if(document.querySelector("input[name='toggle']:checked").value == 'Returning Volunteer'){
					//alert("Returning");
						status ='volunteer';


				}

			}else if(currentQuestion.id =="login"){
				//var inputs = this.el.querySelectorAll("#signUp input")
			//	alert(inputs.length)
			// var inputs = document.querySelectorAll("age");
			// 	alert(inputs.checked.value());

				if( !this._validade("login") ) {
					return false;
				}
				// alert('login');
				this.current =2	;
				this.isFilled = true;

			}else if(currentQuestion.id =="signUp"){
				//var inputs = this.el.querySelectorAll("#signUp input")
			//	alert(inputs.length)
			// var inputs = document.querySelectorAll("age");
			// 	alert(inputs.checked.value());

				if( !this._validade("signUp") ) {
					return false;
				}

			}
++this.current;

// {
// 	alert('a');
// }


		// increment current question iterator

		if( this.current <=0 ) {
			classie.removeClass( this.ctrlPrev, 'show' );
		}
		else if (!this.ctrlPrev.classList.contains('show'))  {
				classie.addClass( this.ctrlPrev, 'show' );
			}
		// update progress bar
		this._progress();

		if( !this.isFilled ) {
			// change the current question number/status
			this._updateNextQuestionNumber();

			// add class "show-next" to form element (start animations)
			classie.addClass( this.el, 'show-next' );

			// remove class "current" from current question and add it to the next one
			// current question

			var nextQuestion = this.questions[ this.current ];
			classie.removeClass( currentQuestion, 'ea-current' );
			currentQuestion.style.display ="none";
			nextQuestion.style.display ="block";
			classie.addClass( nextQuestion, 'ea-current' );
			// if( this.current === 1 ) {
			// 	// hide elements
			// 		classie.removeClass( this.ctrlNext, 'show' );
			// }
			// else if (!this.ctrlNext.classList.contains('show')) {
			// 	classie.addClass( this.ctrlNext, 'show' );
			// }
		}

		// after animation ends, remove class "show-next" from form element and change current question placeholder
		var self = this,
			onEndTransitionFn = function( ev ) {
			
				if( support.transitions ) {
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}
				if( self.isFilled ) {
					
					if(currentQuestion.id =="login"){
						alert('login-submit');
						self._submit('login_query');
					}
					else{
						self._submit('signUp_query');
					}
				}
				else {
					classie.removeClass( self.el, 'show-next' );
					self.currentNum.innerHTML = self.nextQuestionNum.innerHTML;
					self.questionStatus.removeChild( self.nextQuestionNum );
					// force the focus on the next input
					// nextQuestion.querySelector( 'input' ).focus();
				}
			};

		if( support.transitions ) {
			// alert('transitions');
			this.progress.addEventListener( transEndEventName, onEndTransitionFn );
		}
		else {
			
						onEndTransitionFn();
		}
	}





stepsForm.prototype._prevQuestion = function() {
	// check if form is filled

		if( this.current <=0 ) {
			this.isEmpty = true;
			classie.removeClass( this.ctrlPrev, 'show' );
		}
		else{
		 	this.isEmpty = false;
		}


		if(!this.isEmpty){

			// alert(this.current);
			// clear any previous error messages
			this._clearError();

			if (this.current <=1) {
				classie.removeClass( this.ctrlPrev, 'show' );
			}else if( !this.ctrlPrev.classList.contains('show')){
				classie.addClass( this.ctrlPrev, 'show' );
			}



			// current question
			var currentQuestion = this.questions[ this.current ];
			--this.current;
			// decrement current question iterator
			if(currentQuestion.id =="signUp"){
				//var inputs = this.el.querySelectorAll("#signUp input")
			//	alert(inputs.length)
			// var inputs = document.querySelectorAll("age");
			// 	alert(inputs.checked.value());

			this.current=0;
			this.isEmpty = true;
			classie.removeClass( this.ctrlPrev, 'show' );
			
		 	}	
				



			// update progress bar
			this._progress();


			// change the current question number/status
			this._updateNextQuestionNumber();

			// add class "show-next" to form element (start animations)
			// classie.addClass( this.el, 'show-next' );

			// remove class "current" from current question and add it to the next one
			// current question



			// current question
			// var nextQuestion = this.questions[ this.current ];
			// classie.removeClass( currentQuestion, 'ea-current' );
			// currentQuestion.style.display ="none";
			// classie.addClass( nextQuestion, 'ea-current' );


			var prevQuestion = this.questions[ this.current ];
			currentQuestion.style.display ="none";
			classie.removeClass( currentQuestion, 'ea-current' );


			classie.addClass( prevQuestion, 'ea-current' );
			prevQuestion.style.display ="block";
			// setTimeout(function(){classie.addClass( prevQuestion, 'ea-current' );}, 500);

		}

			//self.isFilled = true;
			if( self.isEmpty ) {
				return;
			}
			// after animation ends, remove class "show-next" from form element and change current question placeholder
			// var self = this,
			// 	onEndTransitionFn = function( ev ) {
			// 		if( support.transitions ) {
			// 			this.removeEventListener( transEndEventName, onEndTransitionFn );
			// 		}
			// 		if( self.isEmpty ) {
			// 			return;
			// 		}
			// 		else {
			// 			// classie.removeClass( self.el, 'show-next' );
			// 			self.currentNum.innerHTML = self.prevQuestionNum.innerHTML;
			// 			self.questionStatus.removeChild( self.prevQuestionNum );
			// 			// force the focus on the next input
			// 			// prevQuestion.querySelector( 'input' ).focus();
			// 		}
			// 	};
			//
			// if( support.transitions ) {
			// 	this.progress.addEventListener( transEndEventName, onEndTransitionFn );
			// }
			// else {
			// 	onEndTransitionFn();
			// }

		}

	// updates the progress bar by setting its width
	stepsForm.prototype._progress = function() {
		this.progress.style.width = this.current * ( 100 / this.questionsCount ) + '%';
	}

	// changes the current question number
	stepsForm.prototype._updateNextQuestionNumber = function() {
		// first, create next question number placeholder
		this.nextQuestionNum = document.createElement( 'span' );
		// if()
		this.nextQuestionNum.className = 'number-next';
		this.nextQuestionNum.innerHTML = Number( this.current + 1 );
		// insert it in the DOM
		this.questionStatus.appendChild( this.nextQuestionNum );
	}

	// changes the current question number
	stepsForm.prototype._updatePrevQuestionNumber = function() {
		// first, create next question number placeholder
		this.prevQuestionNum = document.createElement( 'span' );
		this.nextQuestionNum.className
		this.prevQuestionNum.className = 'number-next';
		this.prevQuestionNum.innerHTML = Number( this.current - 1 );
		// insert it in the DOM
		this.questionStatus.appendChild( this.prevQuestionNum );
	}

	// submits the form
	stepsForm.prototype._submit = function(validation) {

		this.options.onSubmit( this.el, validation );
	}

// var forEach = function (array, callback, scope) {
//   for (var i = 0; i < array.length; i++) {
//     callback.call(scope, i, array[i]); // passes back stuff we need
//   }
// };
	// TODO (next version..)
	// the validation function
	stepsForm.prototype._validade = function(questionID) {
		// current question´s input

		var input = this.questions[ this.current ].querySelectorAll("#"+ questionID +' input' );
		var val;
for (var i = 0; i < input.length; i++) {

		val = input[i].value;
		// alert(val);
		if( val === '' ) {
			this._showError( 'EMPTYSTR' );
			return false;
		}
		//If button = email
		var inputType = input[i].type;
		if(inputType == "email" && !this._validateEmail(val) ) {
			this._showError( 'INVALIDEMAIL' );
			return false;
		}
		//If button = phone
		if(inputType == "tel" && !this._validatePhone(val) ) {
			this._showError( 'INVALIDPHONE' );
			return false;
		}
		//If button = radio
	//	if(this.current)
		// if(!this._validateRadio(val) && inputType == "radio") {
		// 	this._showError( 'INVALIDRADIO' );
		// 	return false;
		// }

}
		return true;

	}
	stepsForm.prototype._validateEmail= function (email) {
	  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	  return re.test(email);
	}
	stepsForm.prototype._validatePhone= function (phone) {
	  var re = /^\(?([2-9][0-8][0-9])\)?[-.●]?([2-9][0-9]{2})[-.●]?([0-9]{4})$/;

	  return re.test(phone);
	}
		// stepsForm.prototype._validateRadio= function (phone) {
		// if(!document.querySelector("input[name='toggle']:checked")){
	// TODO (next version..)
	stepsForm.prototype._showError = function( err ) {
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
			
			default: break;
			// ...
		};
		this.error.innerHTML = message;
		classie.addClass( this.error, 'show' );
	}


	// clears/hides the current error message
	stepsForm.prototype._clearError = function() {
		classie.removeClass( this.error, 'show' );
	}

	// add to global namespace
	window.stepsForm = stepsForm;

})( window );
