<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

 <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/3.6.0/css/font-awesome.css" rel="stylesheet">
  <link rel="shortcut icon" href="../favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/component.css" />
    <script src="js/modernizr.custom.js"></script>
</head>
<body>

<div class="container">
  <h2>Modal Example</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <!-- <div class="modal-dialog"> -->
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h3> Welcome To Today's BOEN Event </h3>
        </div>
        <div class="modal-body">
          <section id="b-sign-in">
          <form id="theForm" class="simform" autocomplete="off">
            <div class="simform-inner">
              <ol class="questions">
                <li class="current">
                 
                  <span><label for="q1">Sign In With Your Email Or Phone</label></span>
                  
                  <div id="q1_container" style="display:flex;width:100%;background-color: rgba(0,0,0,0.1);margin-top: 20px;height: 75px; vertical-align: middle">
                    <button class="b-btn" id="q1_email" type="button" name="q1_btn1" onclick="signInAs()"> Email </button>
                    <button class="b-btn"  id="q1_phone" type="button" name="q1_btn1" onclick="signInAs()"> Phone </button>
                    <input id="q1" name="q1" type="email" style="
        width: 600px;
        border: 2px solid #336f4c;
        margin: auto 5px;
        height: 35px;
        box-shadow: 0 3px #336f4c;

        color: inherit;
        " />
                  </div>
            
                </li> 
                <li >
                 
                  <span><label for="q1">Sign In With Your Email Or Phone</label></span>
                  
                  <div id="q1_container" style="display:flex;width:100%;background-color: rgba(0,0,0,0.1);margin-top: 20px;height: 75px; vertical-align: middle">
                    <button class="b-btn" id="q1_email" type="button" name="q1_btn1" onclick="signInAs()"> Email </button>
                    <button class="b-btn"  id="q1_phone" type="button" name="q1_btn1" onclick="signInAs()"> Phone </button>
                    <input id="q1" name="q1" type="email" style="
        width: 600px;
        border: 2px solid #336f4c;
        margin: auto 5px;
        height: 35px;
        box-shadow: 0 3px #336f4c;

        color: inherit;
        " />
                  </div>
            
                </li> 
<!--               <li>
                <span><label for="q2">First Time Signing Into BOEN Event?</label></span>
              
                <div id="q2_container" style="width:100%;background-color: rgba(0,0,0,0.1);margin-top: 20px;">
                <div id="q2_container" style="display:flex; justify-content: space-around; width:50%; margin: 0 auto; height: 75px;">
                  <input style="width:20%; background-color:#006400; border:4px solid black;" id="q1_btn1" name="q1_btn1" type="button" value="Email"/>
                  <button class="btn"  id="q2_yes" type="button" name="q1_btn1" onclick="signInAs()"> Yes </button>
                  <button class="btn"  id="q2_no" type="button" name="q1_btn1" onclick="signInAs()"> No </button>
                  
                </div>
              </li> -->
              <!-- <li>
                <span><label for="q3">What time do you got to work?</label></span>
                <input id="q3" name="q3" type="text">
              </li>
              <li>
                <span><label for="q4">How do you like your veggies?</label></span>
                <input id="q4" name="q4" type="text">
              </li>
              <li>
                <span><label for="q5">What book inspires you?</label></span>
                <input id="q5" name="q5" type="text">
              </li>
              <li>
                <span><label for="q6">What's your profession?</label></span>
                <input id="q6" name="q6" type="text">
              </li> -->
              </ol><!-- /questions -->
              <!-- <button class="submit" type="submit">Send answers</button> -->
              <div class="controls">
                <button class="prev show"></button>
                <button class="next show"></button>
                <div class="progress"></div>
                <span class="number">
                  <span class="number-current">1</span>
                  <span class="number-total">6</span>
                </span>
                <span class="error-message"></span>
              </div><!-- / controls -->
            </div><!-- /simform-inner -->
            <span class="final-message"></span>
          </form><!-- /simform -->      
        </section>
      
      
      <script src="js/classie.js"></script>
      <script src="js/stepsForm.js"></script>
      <script type="text/javascript" src="js/stepsForm2.js"></script>
        
      </script>
        <!-- </div> -->
       
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>