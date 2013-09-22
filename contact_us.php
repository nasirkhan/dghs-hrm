<!DOCTYPE html>
<html>
<html lang="en">   
<head> 
    <title>Contact Us</title>
	<meta charset="utf-8">    
<link href="assets/css/bootstrap.css" rel="stylesheet">  
<script type="text/javascript">
function validateForm()
{
var name=document.forms["form1"]["name"].value;
var email=document.forms["form1"]["email"].value;
var orgcode=document.forms["form1"]["orgcode"].value;
var x=document.forms["form1"]["subject"].value;
if (name==null || name=="")
  {
  alert("Name must be filled out");
  return false;
  }
  if (email==null || email=="")
  {
  alert("Email must be filled out");
  return false;
  }
  if (orgcode==null || orgcode=="")
  {
  alert("Organization Code must be filled out");
  return false;
  }
}

</script>
</head>
<body>
  <div class=”container”>
  <div class=”page-header”>
                <h1>Contact Us</h1>
            </div>
  <form class="form-horizontal" action="send_email.php" method="post" name="form1" id="form1" onSubmit="return validateForm()" >
                <div class=”control-group”>
                    <label class=”control-label” for=”input1?>To * </label>
                    <div class=”controls”>
					       <input type="text" id="mailto" name="mailto" size="80 px" />
					</div>
				</div>
				 <div class=”control-group”>
                    <label class=”control-label” for=”input2?>CC</label>
                    <div class=”controls”>
					      <input type="text" id="emailcc" name="emailcc" size="80 px"  />
						   
					</div>
				</div>
				
				 <div class=”control-group”>
                    <label class=”control-label” for=”input3?>From *</label>
                    <div class=”controls”>
					      <input type="text" id="email" name="email" size="80 px"  />
						   
					</div>
				</div>
				<div class=”control-group”>
                    <label class=”control-label” for=”input4?>Name *</label>
                    <div class=”controls”>
					      <input type="text" id="name" name="name" size="80 px" />
						   
					</div>
				</div>
				
				<div class=”control-group”>
                    <label class=”control-label” for=”input5?>Organization Name(Optional)</label>
                    <div class=”controls”>
					      <input type="text" id="orgname" name="orgname" size="80 px" />
						   
					</div>
				</div>
				
				<div class=”control-group”>
                    <label class=”control-label” for=”input6?>Organization Code *</label>
                    <div class=”controls”>
					      <input type="text" id="orgcode" name="orgcode" size="80 px" />
						   
					</div>
				</div>
				
				<div class=”control-group”>
                    <label class=”control-label” for=”input7?>Reason *</label>
                    <div class=”controls”>
					      <select id="reason" name="reason">
						  <option value="Login Problem">Login Problem</option>
							<option value="Complain">Complain</option>
							<option value="Suggestion">Suggestion</option>
							<option value="other">Other</option>  
						
						</select>
						   
					</div>
				</div>
				
				<div class=”control-group”>
                    <label class=”control-label” for=”input8?>Subject *</label>
                    <div class=”controls”>
					      <input type="text" id="subject" name="subject" size="80 px"  />
						   
					</div>
				</div>
				
				 <div class=”control-group”>
                    <label class=”control-label” for=”input9?>Message</label>
                    <div class=”controls”>
                        <textarea name=”message” id=”input3? rows="10"? cols="80"? class=”span5? ></textarea>
                    </div>
                </div>
				<div class=”form-actions”>
                    
                    <button type=”submit” class=”btn btn-primary”>Send</button>
                </div>
  
  </form>
  
  </div>

</body>
</html>