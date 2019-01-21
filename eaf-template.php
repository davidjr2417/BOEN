<section id="b-sign-in">
	<form id="evnt-attnd-form" class="eaform" >
    	<div class="eaform-inner">
      		<ol class="questions">
				<!--Initial Screen -->
				<li id="user" class="ea-current">
					<div class="row">
						<div class="col col-xs-8 col-sm-8 " id="imgContainer">
    						<div>
								<img src="http://brotherhoodofelders.net/wp-content/uploads/2018/04/BOEN_Logofinal-copy-3-e1524494517414.png">
							</div>
						</div>
						<div class="col col-xs-3 col-sm-4" id="optContainer">
							<div id="optInsideContainer">
								<div class="col col-xs-12 sign-btn" >
									<div class="sign-center">
    									<div id="signInOpt">
											<input class="sign-in-as toggle event-names" id="q2_volunteer" type="radio" name="toggle" value="signIn">
											<label class="btn user-opt" id="signInBtn" for="q2_volunteer" onclick="getForm(this)">Sign In</label>
										</div>
									</div>
								</div>
								<div class="col col-xs-12 sign-btn">
									<div  class="sign-center">
										<div id="signUpOpt">
											<input class="sign-in-as toggle" id="q2_guest" type="radio" name="toggle" value="signUp"  >
											<label class="btn user-opt" for="q2_guest" id="signUpBtn" onclick="getForm(this)">Sign Up</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li> 
				<li id="login" class="hide row" >
	        		<div class="col-xs-12">
	        			<div class="col-xs-12 col-sm-12 fieldInput" >
	        			<h5>
	                		<label >Sign In Below:</label>
	                	</h5>
	                </div>
	              	</div>
	              	<div class="col-xs-12">
	              		<div class="col-xs-12 col-sm-12 fieldInput" >
	              			<input class="b-info event-names"  id="q3" type="text" name="sign-in" placeholder="Username Or Email"  >
	              	</div>
	               	</div>
              	</li> 
              	<li id="signUp"  class="hide row">
              		<div class="col-xs-12">
	        			<h5>
	                		<label>Personal Information</label>
	                	</h5>
	              	</div>
	              	<div class="col-xs-12 ">
						<div class="col-xs-12 col-sm-3  fieldLabel"  >
							<label class="input-label" autocomplete="on"  class="input-label">  First Name:</label>
						</div>
						<div class="col-xs-12 col-sm-9 fieldInput" >
							<input type="text" autocomplete="on" name="fname" placeholder="John" required/>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="col-xs-12 col-sm-3 fieldLabel" >
							<label   class="input-label">   Last Name:</label>
						</div>
						<div class="col-xs-12 col-sm-9 fieldInput" >
							<input type="text" name="lname" placeholder="Doe" required/>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="col-xs-12 col-sm-3 fieldLabel"  >
							<label   class="input-label" >    Username:</label>
						</div>
						<div class="col-xs-12 col-sm-9 fieldInput"  >
							<input type="text" name="username" placeholder="johnDoe1234"  required/>
						</div>
					</div>

						<div class="col-xs-12">
							<div class="col-xs-12 col-sm-3 fieldLabel"  >
								<label   class="input-label" >    Email:</label>
							</div>
							<div class="col-xs-12 col-sm-9 fieldInput"  >
								<input type="email" name="email" placeholder="doe@brotherhoodofelders.net"  required/>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="col-xs-12 col-sm-3 fieldLabel"  >
								<label   class="input-label" >   Phone:</label>
							</div>
							<div class="col-xs-12 col-sm-9 fieldInput"  >
								<input type="tel" name="phone" placeholder="123-456-7890"  />
							</div>
						</div>


						<div class="col-xs-12">
							<div class="col-xs-12 col-sm-3 fieldLabel"  >
								<label   class="input-label" >  Age Range:</label>
							</div>
							<div class="col-xs-12 col-sm-9 fieldInput"  >
								<select class="col-sm-3 " name="age_range">
									<option name="age" value="warriors" checked> 17 - 30</option>
									<option name="age" value="brothermen"> 30 - 50</option>
									<option name="age" value="elders"> 50+</option>

								</select>
							</div>
						</div>

						<div class="col-xs-12">
							<div class="col-xs-12 col-sm-3 fieldLabel"  >
								<label   class="input-label" class="text-sm-left" >   Invited By: </label>
							</div>
							<div class="col-xs-12 col-sm-9 fieldInput"  >
								<input type="text" name="invited_by" autocomplete="off" placeholder="John Roe"  required/>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="col-xs-12" >
									<label  class="input-label" >  What Brings You Here:</label>
								</div>
							<div class="col-xs-12" >
								<textarea spellcheck="true" name="purpose" rows="4"  placeholder="(1-2 Sentences)"  required ></textarea>
							</div>
						</div>
						<div class="col-xs-12">
							<div class="col-xs-1" >
									<input type="checkbox" id="subscribe" name="subscribe"  />
								</div>
							<div class="col-xs-10" >
								<label   class="input-label" for="subscribe">Subscribe To Newsletter</label>
							</div>
						</div>
						
					</div>
				</li>
			</ol>
          	<div class="controls">
           		<button class="next " type="button">Submit</button>
            	<div class="progress"></div>
            	<span class="number">
             		<span class="number-current">1</span>
             	 	<span class="number-total">6</span>
            	</span>
            	<span class="error-message">aa</span>
          	</div><!-- / controls -->
        </div><!-- /eaform-inner -->
        <span class="final-message"></span>
    </form><!-- /eaform -->
</section>

<!--loading icon-->
<div id="eawp-loading-icon" class="text-center" style="display: none;">
	<div class="svg-container">
		<div id="preloader">
  			<div id="loader"></div>
		</div>
	</div>
	<br>
	Saving Your Information. Please Wait.
</div>

<!--Ajax result-->
<div id="ea-form-result-container" style="display: none;">
	<div class=" row" id="imgContainer" style="width: 100%;">
		<div   style=" width: 50%; margin:0 auto;    float: none !important;">
			<img src="http://brotherhoodofelders.net/wp-content/uploads/2018/04/BOEN_Logofinal-copy-3-e1524494517414.png">
		</div>
	</div>
	<div class ="row">
		<div  id="ea-form-result"  class="col col-xs-12 col-sm-12" style="text-align: center"></div>
	</div>
</div>

     
              	

              

		