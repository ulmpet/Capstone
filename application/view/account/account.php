<div class="container">
    <h1>Account</h1>

    <div class="headings">
        <h2>Change Password:</h2>
        <form method="POST" action="/account/changepassword">
    <table>
        <tr>
            <td>Enter your existing password:</td>
            <td><input type="password"  name="password"></td>
        </tr>
        <tr>
            <td>Enter your new password:</td>
            <td><input type="password"  name="newpassword"></td>
        </tr>
        <tr>
            <td>Re-enter your new password:</td>
            <td><input type="password"  name="confirmnewpassword"></td>
        </tr>
    </table>
            <p><input type= "submit" value="Change Password"> 
        </form>
    </div>
    <div class="headings">
        <!--<h2>Deactivate Account:</h2>-->
        <form method = "POST" action = "">
            <h2>Deactivate account:</h2> <input name="Deactivate" type="submit" value="click here"/> 
        </form>
    </div>

    <!--<p>
        <u><bold>Features to be included:</bold></u></br>
        -Phage filtering mechanisms (cluster, sub-cluster, genus, …)</br>
        -Deactivation of accounts (not for admins, only super-admin can deactivate Admin.)</br>
    </p>-->
</div>