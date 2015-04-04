<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="description" content="A virtual cookbook that allows user's to view, create and share recipes.">
		<meta name="keywords" content="recipe, cookbook, food, ingredients">
		<meta name="author" content="Cookbook Network Inc.">
		<link rel="stylesheet" type="text/css" href="page_style.css">
		<link href='http://fonts.googleapis.com/css?family=Tangerine:700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+Double+Pica' rel='stylesheet' type='text/css'>
	</head>
	
	<body>
		
		<div class="background-image"></div>

		<div class="navigation-bar">
			<table  class="navigation-bar-table">
				<tr>
					<td class="navigation-bar-table-left"><h1 class="navigation-bar-table-left-header">Cookbook Network</h1></td>
					<td class="navigation-bar-table-right">
						<ul class="upper-level-ul">		
							<li><a href="signup.php">Search Recipe</a></li>
							<li><a href="signup.php">Search Cookbook</a></li>
							<li><a href="signup.php">Log In</a></li>
							<li><a href="signup.php">Sign Up</a></li>
								
							
						</ul>
						
					</td>
				</tr>
			</table>
		</div>
		
		<div class="content">
			<h1 class="center">Create your Cookbook Network Account!</h1>
			<p class="center"><i>Share your recipes with others! It's fast and easy!</i></p>
			<br/>
			<form name="signup" method="post" onsubmit="return validateForm()">
			<table class="tableform">
				<tr>
					<td><h3>Choose your username:</h3><br/></td>
					<td><input type="text" name="username" size="35" required><br/><br/></td>
				</tr>
				<tr>
					<td><h3>Create a password: </h3><br/></td>
					<td><input type="password" name="password" size="35" required><br/><br/></td>
				</tr>
				<tr>
					<td><h3>Confirm your password: </h3><br/></td>
					<td><input type="password" name="pwconfirm" size="35" required><br/><br/></td>
				</tr>
				<tr>
					<td><h3>Enter your email address: </h3><br/></td>
					<td><input type="text" name="email" size="35" required><br/><br/></td>
				</tr>
			</table>
					<p class="center"><br/><br/> <input class="submitbutton" type="submit" value="Create My Account">&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" value="Cancel"></p>
				</form>

		
				<script>
					function validateForm() 
					{
    					var user = document.forms["signup"]["username"].value;
    					var pass = document.forms["signup"]["password"].value;
    					var pwc = document.forms["signup"]["pwconfirm"].value;
    					var email = document.forms["signup"]["email"].value;
    					
    					//Check for blank input
    					if (user == null || user == "" ||pass == null || pass == ""||pwc == null || pwc == ""
    							||email == null || email == "") 
    					{
        					alert("No inputs can be left blank.");
        					return false;
    					}

    					//Check for mismatch password
    					if (pass != pwc)
    					{
        					alert("Password does not match.");
        					return false;
    					}

    					//Check for password to be > 6 chars
    					if (pass.length < 6)
    					{
        					alert("Choose a different password. Password must be at least 6 characters long.");
        					return false;
    					}

    					//Check for correct email
   						arrobaIndex = email.indexOf("@");
  						periodIndex = email.lastIndexOf(".");
  						//email can't have "@" be first char or "@." be consecutive chars
					   	if (arrobaIndex == 0 || (periodIndex - arrobaIndex <= 1 )) 
					   	{
					    	alert("Invalid email. Please enter a correct email.");
					        return false;
					   	}
    					return true;	//pass all requirements, form has correct input
					}
				</script>
		</div>
		
		<div class="footer"><p>&#169; Cookbook Network, 2015. All Rights Reserved.</p></div>
		
	</body>
</html>
