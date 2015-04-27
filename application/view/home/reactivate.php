<div class="container">

	<h3> Please input the email and password for the account you are trying to reactivate. <h3>
	<form method='POST' action=''>
		<table>

			<tr>
				<td>Email:</td>
				<td><input type="text" name='oldemail'/></td>
				<?php if(isset($_SESSION['bademail'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['bademail']." </td>";}else{echo "<td> </td>";} ?>
			</tr>
			<td> </td>
			<tr>
				<td>Password:</td>
				<td><input type="password" name='oldpass'/>  <input type="submit"/></td>
				<?php if(isset($_SESSION['passerror'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['passerror']." </td>";}else{echo "<td> </td>";} ?>
				<?php if(isset($_SESSION['alreadyact'])){ echo "<td class = 'ui-state-highlight'> ".$_SESSION['alreadyact']." </td>";}else{echo "<td> </td>";} ?>
			</tr>
			<td> </td>
			</tr>
		</table>
	</form>

</div>
<?php 
    unset($_SESSION['goodemail']);
    unset($_SESSION['bademail']);
    unset($_SESSION['passerror']);
    unset($_SESSION['alreadyact']);
?>