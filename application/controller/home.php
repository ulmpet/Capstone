<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{

    var $Testmessage;
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index 
     * This is the login handler and landing page for all users coming to the site. 
     */
    public function index()
    {
        //check for validation of passwords!
        //make sure that they are entering an email address.
        //make it so view says enter username and passwords -- message system Sam built to show errors. 
        //REGEX for email 

        //Helper::outputArray($userModel->selectAllUsers(),true);
        //if the http request contains information from a field called Email attempt a login
        if(isset($_REQUEST['Email'])){
            $userSalt = $this->userModel->getSalt($_REQUEST['Email']);
            $userEmail = $_REQUEST['Email'];
            $userPassword = hash('sha512',$_REQUEST['Password'].$userSalt);
            //request user from database with entered credientials
            $userInformation = $this->userModel->checkLogin($userEmail,$userPassword);
            // if there is such a user
            if(count($userInformation) == 1){
            
                //set the session verables and redirect to News Page
                $_SESSION['UID'] = $userInformation[0]['UserID'];
                //Helper::outputArray($_SESSION);
                header('location: /phagetool');
            //else login failed
            }else{
                $_SESSION['errorMessage'] = 'Login Failed. Invalid email or password.';
            }
    }
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/login.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
    *   Function to preform sighnup on the web app. If the signup form as been opsted
    *
    *
    */
    public function signup()
    {
        //stringcmp for passwords
        //message system for feedback
        //make sure emails are emails. REGEX from index().
        $this->message = 'Please Enter all required information.';

            if(isset($_REQUEST['email'])){

            $newUserEmail = $_REQUEST['email'];

            if(!filter_var($newUserEmail, FILTER_VALIDATE_EMAIL)){

                $_SESSION['bademail'] = "This is not a valid email. Please try again.";
            }

            $passcheck = strcmp($_REQUEST['pass'],$_REQUEST['passconfirm']);
                  
            if($passcheck != 0){

                $_SESSION['passmessage'] = "The new passwords do not match.";
                

            } //end of nested if
            if (empty($_REQUEST['pass']))
            {
                $_SESSION['passmessage'] = "The new passwords cannot be blank";
            }
            else if (empty($_REQUEST['passconfirm'])){

                $_SESSION['passmessage'] = "The new passwords cannot be blank";
            }

                //create a random salt to add to password
                $salt = bin2hex(openssl_random_pseudo_bytes(64));
                $password = hash('sha512',$_REQUEST['passconfirm'].$salt);
                //add all user signup data to the array 
                $info = array($_REQUEST['email'], $password, 0, null, $_SERVER['REMOTE_ADDR'], $_REQUEST['organization'],$salt,1,date(MYSQL_DATE_FORMAT));

            //insert the data to the database and return to home on success
            if($this->userModel->SelectUserByEmail($_REQUEST['email'])==0){
                $this->userModel->addUser($info);
                $_SESSION['accountSucc'] = "Success! You're now a user!";
                header("Location: /login");
            
            }else{
                $_SESSION['bademail'] = 'This Account Email Address already Exists.';
            }   
                
            }//end checks

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/home/signup.php';
            require APP . 'view/_templates/footer.php';

    } //end of function
    /**
    * This function will handle a user trying to reactivate their account. FIX THIS SHIT!
    *
    */
    public function reactivate(){

        if(isset($_REQUEST['oldemail'])){

            if (empty($_REQUEST['oldpass']) || empty($_REQUEST['oldemail']))
            {
                $_SESSION['passerror'] = "The password or email cannot be blank.";
            }
            //store the email the user is attempting to send.
            $username = $_REQUEST['oldemail'];
            //check for a valid email.
            if(!filter_var($username, FILTER_VALIDATE_EMAIL)){

                $_SESSION['bademail'] = "This is not a valid email. Please try again.";
            }
            //get the userID for the email entered, for password checking and final steps.
            $userID = $this->userModel->getUserIdByEmail($username);
            //gets the salt for the current user.
            $userSalt = $this->userModel->getSalt($username);
            //hash and salt the password.
            $password = hash('sha512',$_REQUEST['oldpass'].$userSalt);

            if($this->userModel->checkPassword($userID,$password) != 1){
                $_SESSION['passerror'] = "Incorrect password";
            }
            $Inactive = $this->userModel->checkInactive($username, $password);
            
            
            if(count($Inactive) > 0){

                //something is not right in this method....
                $this->userModel->reactivateUser($userID);
                $_SESSION['accountSucc'] = "Success! You have been reactivated!";
                header("Location: /login");

            } 
            else{
                //maybe not here?
                $_SESSION['alreadyact'] = "This account is already active.";
            }
        }//end of isset if

            require APP . 'view/_templates/header.php';
            require APP . 'view/home/reactivate.php';
            require APP . 'view/_templates/footer.php';
    }//end of reactivate. 

    

    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function logOut(){

        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        header('location: /home');
    }//end logout

    public function output(){
        Helper::outputArray($_POST);
    }

    public function redirectTest(){
        Helper::outputArray($_SESSION);
    }

}// end class
