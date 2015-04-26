<div class="container">

	<h3> Please input the email and password for the account you are trying to reactivate. <h3>
	<form method = 'post' action=''>
		<table>

			<tr>
				<td>Email:</td>
				<td><input type='text' name='oldemail'/></td>
				<?php if(isset($_SESSION['bademail'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['bademail']." </td>";}else{echo "<td> </td>";} ?>
			</tr>
			<td> </td>
			<tr>
				<td>Password:</td>
				<td><input type='password' name='oldpass'/></td>
				<?php if(isset($_SESSION['passerror'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['passerror']." </td>";}else{echo "<td> </td>";} ?>
			</tr>
			<td> </td>
		</table>
		<input type= 'submit'/>
	</form>

</div>
<?php 
    unset($_SESSION['bademail']);
    unset($_SESSION['passerror']);
?>