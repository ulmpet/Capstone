<div class="container"> 
	<?php echo $this->message;?>
	<form method='post' action=''>
    	<p>Email Address: </br><input name="Email"></br></p>
    	<p>Password: </br><input type='password' name='Password'></p>
    	<input type='submit'>
    	<p> <a href="<?php echo URL?>home/signup">Click here to sign up for an account!</a></p>
	</form>
</div>