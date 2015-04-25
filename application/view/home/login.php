<div class="container"> 
	<h1>Please enter your username and password.</h1>
	<form method='post' action=''>
		<?php if(isset($_SESSION['accountSucc'])){ echo "<div class = 'ui-state-highlight'> ".$_SESSION['accountSucc']." </div>";}else{echo "<div> </div>";} ?>
    	<p>Email Address: </br><input name="Email"></br></p>
    	<p>Password: </br><input type='password' name='Password'></p>
    	<input type='submit'> 
    	<div><?php if(isset($_SESSION['errorMessage'])){ echo "<div class = 'ui-state-error'> ".$_SESSION['errorMessage']." </div>";}else{echo "<div> </div>";} ?>  </div>
    	<p> <a href="<?php echo URL?>home/signup">Click here to sign up for an account!</a></p>
    	<p> <a href="<?php echo URL?>home/reactivate">Click here to reactivate account!</a></p>
	</form>
</div>
<?php
	unset($_SESSION['accountSucc']);
	unset($_SESSION['errorMessage']);
?>
