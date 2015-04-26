<div class="container">
	<h3>Please enter all required information.</h3>
	<form method='post' action='https://www.google.com/recaptcha/api/siteverify'><br>
		<table>

			<tr>
				<td>Your email</td>
				<td><input type="text" name="email"/></td>
				<?php if(isset($_SESSION['goodemail'])){ echo "<td class = 'ui-state-highlight'> ".$_SESSION['goodemail']." </td>";}else{echo "<td> </td>";} ?>
				<?php if(isset($_SESSION['bademail'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['bademail']." </td>";}else{echo "<td> </td>";} ?>
			</tr>
			<td> </td>
			<tr>
				<td>Enter a password</td>
				<td><input type="password" name="pass"/></td>

				<td>Re-enter your password</td>
				<td><input type="password" name="passconfirm"/></td>
				<?php if(isset($_SESSION['passmessage'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['passmessage']." </td>";}else{echo "<td> </td>";} ?>
			</tr>
		</table>
	<br>
	
	<div class="g-recaptcha" data-sitekey="6Ldg5AUTAAAAAGgnCFx4b7HPkuhYnbzjbLxuwIDt"></div>

	<input type="submit"/>
	</form>

</div>
<?php 
    unset($_SESSION['goodemail']);
    unset($_SESSION['bademail']);
    unset($_SESSION['passmessage']);
?>