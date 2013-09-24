<!DOCTYPE html>
<html>
<html lang="en">   
<head> 
    <title>Contact Us</title>
	<meta charset="utf-8">    
	<meta name="description" content="Twitter Bootstrap Version2.0 default form layout example from w3resource.com.">   
<link href="assets/bootstrap3/css/bootstrap.css" rel="stylesheet" media="screen"> 

 <script src="assets/js/jquery.js"></script>
 <script src="assets/js/bootstrap.min.js"></script>
 
 <script src="assets/jquery Validation/dist/jquery.validate.js"></script>
 
</head>
<body>

    <div class="container">
    <div class="page-header" >
                <h1>Contact Us</h1>
            </div>
  <form class="form-horizontal" action="send_email.php" method="post" name="form1" id="form1" >
                <fieldset >
                    <div style=" alignment-adjust: central;">
                    <label class="control-label" for="input1" >To <font color="red"> * </font> </label>
                    <div class="controls" >
					    <input type="text" id="mailto" name="mailto" class="form-control" required />
					</div>
				</div>
				
				 <div class="control-group">
                    <label class="control-label" for="input2">CC</label>
                    <div class="controls">
					      <input type="text" id="emailcc" name="emailcc" class="form-control"  />
						   
					</div>
				</div>
				
				 <div class="control-group">
                    <label class="control-label" for="input3">From <font color="red"> * </font> </label>
                    <div class="controls">
					      <input type="text" id="email" name="email" class="form-control" required />
						   
					</div>
				</div>
				<div class="control-group">
                    <label class="control-label" for="input4">Name <font color="red"> * </font></label>
                    <div class="controls">
					      <input type="text" id="name" name="name" class="form-control" required />
						   
					</div>
				</div>
				
				<div class="control-group">
                    <label class="control-label" for="input5">Organization Name(Optional)</label>
                    <div class="controls">
					      <input type="text" id="orgname" name="orgname" class="form-control"/>
						   
					</div>
				</div>
				
				<div class="control-group">
                    <label class="control-label" for="input6">Organization Code <font color="red"> * </font> </label>
                    <div class="controls">
					      <input type="text" id="orgcode" name="orgcode"  class="form-control" required/>
						   
					</div>
				</div>
				
				<div class="control-group">
                    <label class="control-label" for="input7">Reason <font color="red"> * </font></label>
                    <div class="controls">
					      <select id="reason" name="reason" class="form-control" required>
						  <option value="Login Problem">Login Problem</option>
							<option value="Complain">Complain</option>
							<option value="Suggestion">Suggestion</option>
							<option value="other">Other</option>  
						
						</select>
						   
					</div>
				</div>
				
				<div class="control-group">
                    <label class="control-label" for="input8">Subject <font color="red"> * </font></label>
                    <div class="controls">
					      <input type="text" id="subject" name="subject" class="form-control" required="Please enter" />
						   
					</div>
				</div>
				
				 <div class="control-group">
                    <label class="control-label" for="input9">Message <font color="red"> * </font> </label>
                    <div class="controls">
                        <textarea name="message" id="input3" rows="10"? cols="58" class="form-control" required ></textarea>
                    </div>
                </div>
				<p>
				<div class="form-actions">      
                    <button type="submit" class="btn btn-primary btn-large" >Send</button>
				</p>
                </div>

  </form>
 
  </fieldset>
  </div>


</body>
</html>