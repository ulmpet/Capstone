<div class="container">
    <div>
        Account Settings
        <form method="POST" action="">
            <p>&nbsp;&nbsp;<i>Change Password</i></p>
            <input type='text' style='display:none' name='changePasswordThing'>
            <table>
                <tr>
                    <td>Enter your existing password:</td>
                    <td><input type="password" size="16" name="password"></td>
                    <?php if(isset($_SESSION['message'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['message']." </td>";}else{echo "<td> </td>";} ?>
                </tr>
                <tr>
                    <td>Enter your new password:</td>
                    <td><input type="password" size="16" name="newpassword"></td>
                    <?php if(isset($_SESSION['message2'])){ echo "<td class = 'ui-state-error'> ".$_SESSION['message2']." </td>";}else{echo "<td> </td>";} ?>
                </tr>
                <tr>
                    <td>Re-enter your new password:</td>
                    <td><input type="password" size="16" name="confirmnewpassword"> <input type="submit" value="Submit"> </td>
                    <?php if(isset($_SESSION['success'])){ echo "<td class = 'ui-state-highlight'> ".$_SESSION['success']." </td>";}else{echo "<td> </td>";}?>
                </tr>
            </table>
        </form>
    </div>

    <div class="headings">
        <!--<h2>Deactivate Account:</h2>-->
        <form method = "POST" action = "">
            <input type='text' style='display:none' name='deactivateAccount'>
            <br>
            <p><i>&nbsp;&nbsp;Deactivate</i></br>&nbsp;&nbsp;<input name="Deactivate" type="submit" value="click here"/></p>
            <?php if(isset($_SESSION['badadmin'])){ echo "<div class = 'ui-state-error'> ".$_SESSION['badadmin']." </div>";}else{echo "<div> </div>";}?>
        </form>
    </div>

    <!--<p>
        <u><bold>Features to be included:</bold></u></br>
        -Phage filtering mechanisms (cluster, sub-cluster, genus, …)</br>
        -Deactivation of accounts (not for admins, only super-admin can deactivate Admin.)</br>
    </p>-->
</div>
<?php 
    unset($_SESSION['message']);
    unset($_SESSION['message2']);
    unset($_SESSION['success']);
    unset($_SESSION['badadmin']);
?>