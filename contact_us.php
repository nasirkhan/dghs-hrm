<!DOCTYPE html>
<html>
<html lang="en">   
<head> 
    <title>Contact Us</title>
	<meta charset="utf-8">    
<meta name="description" content="Twitter Bootstrap Version2.0 default form layout example from w3resource.com.">   
<link href="assets/css/bootstrap.css" rel="stylesheet">  

</head>
<body>
<div align ="center" style=" margin:auto"><H2><strong>Contact Us</strong></h2></div>
<form class="well" action="send_email.php" method="post" name="form1" id="form1">
	        <table class='table' align ="center">
	            <tr>
	                <td>
	                    To:
	                </td>
	                <td>
	                    <input type="text" id="mailto" name="mailto" size="80 px"/>
	                </td>
	            </tr>
				<tr>
	                <td>
	                    CC:
	                </td>
	                <td>
	                    <input type="text" id="emailcc" name="emailcc" size="80 px"/>
	                </td>
	            </tr>
				<tr>
	                <td>
	                    From:
	                </td>
	                <td>
	                    <input type="text" id="email" name="email" size="80 px"/>
	                </td>
	            </tr>
				<tr>
	                <td>
	                    Name:
	                </td>
	                <td>
	                    <input type="text" id="name" name="name" size="80 px"/>
	                </td>
	            </tr>
				<tr>
	                <td>
	                   Organization Name (Optional):
	                </td>
	                <td>
	                    <input type="text" id="orgname" name="orgname" size="80 px"/>
	                </td>
	            </tr>
				<tr>
	                <td>
	                   Organization Code:
	                </td>
	                <td>
	                    <input type="text" id="orgcode" name="orgcode" size="80 px"/>
	                </td>
	            </tr>
				<tr>
	                <td>
	                   Reason:
	                </td>
	                <td>
	                    <select>
						  <option value="login">Login Problem</option>
							<option value="complain">Complain</option>
							<option value="suggestion">Suggestion</option>
							<option value="other">Other</option>  
						
						</select>
	                </td>
	            </tr>
                    <tr>
	                <td>
	                   Mobile:
                        </td>
	                <td>
	                    <input type="text" id="mobile" name="mobile" size="80 px" />
	                </td>
	            </tr>
				 <tr>
	                <td>
	                   Subject:
                        </td>
	                <td>
	                    <input type="text" id="subject" name="subject" size="80 px" />
	                </td>
	            </tr>
	            
                    <tr>
	                <td>
	                    Message:
	                </td>
	                <td>
	                    <textarea rows="8" cols="80" id="message" name="message"> </textarea> 
	                </td>
	            </tr>
				<tr>
	                <td>
	                    Capcha:
	                </td>
	                <td>
	                    <input type="text" id="subject" name="subject" size="80 px" />
	                </td>
	            </tr>
	           
	            <tr>
				<td></td>
	                <td colspan="2" style="text-align: left;">
                           <input type="submit" id="submit" value="Send" />

	                </td>
					<td></td>
					
	            </tr>
	        </table>
</form>
 

</body>
</html>