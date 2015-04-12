<div class="container">
    <h1>Account</h1>

    <div>
        <h2>Change Password:</h2>
        <form method="POST" action="">
    <table>
        <tr>
            <td>Enter your existing password:</td>
            <td><input type="password" size="16" name="password"></td>
        </tr>
        <tr>
            <td>Enter your new password:</td>
            <td><input type="password" size="16" name="newpassword"></td>
        </tr>
        <tr>
            <td>Re-enter your new password:</td>
            <td><input type="password" size="16" name="confirmnewpassword"></td>
        </tr>
    </table>
            <p><input type= "submit" value="Change Password"> 
        </form>
    </div>
    <div>
        <h2>Deactivate Account:</h2>
        <form method = "POST" action = "">
            Click here if you would like to deactivate your account.
            <br>
            <input name="Deactivate" type="submit" value="Deactivate"/> 
        </form>
    </div>

    <p>
        <u><bold>Features to be included:</bold></u></br>
        -Phage filtering mechanisms (cluster, sub-cluster, genus, …)</br>
        -Deactivation of accounts (not for admins, only super-admin can deactivate Admin.)</br>
    </p>
</div>