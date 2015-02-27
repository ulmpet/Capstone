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
        $this->message = 'Please enter your username and password.';
        //load the user model to check login
        $userModel = $this->loadModel('user');
        //Helper::outputArray($userModel->selectAllUsers(),true);
        //if the http request contains information from a feild called Email attempt a login
        if(isset($_REQUEST['Email'])){
            $userSalt = $userModel->getSalt($_REQUEST['Email']);
            $userEmail = $_REQUEST['Email'];
            $userPassword = hash('sha512',$_REQUEST['Password'].$userSalt);
            //echo count($userModel->checkLogin($userEmail,$userPassword));
            //request user from database with entered credientials
            $userInformation = $userModel->checkLogin($userEmail,$userPassword);
            // if there is such a user
            if(count($userInformation) == 1){
            
                //set the session verables and redirect to News Page
                $_SESSION['UID'] = $userInformation[0]['UserID'];
                //Helper::outputArray($_SESSION);
                header('location: /news');
            //else login failed
            }else{
                $this->message = 'Login Failed';
            }
    }
        // load views
        require APP . 'view/_templates/header.php';
        
        require APP . 'view/home/login.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
    *   Function to preform sighnup on the web app. If the signup form as been posted
    *
    *
    */
    public function signup()
    {
        $this->message = 'Please Enter all required information.';
        if(isset($_REQUEST['email'])){
            //create a random salt to add to password
            $salt = bin2hex(openssl_random_pseudo_bytes(64));
            // add the salt to the password and hash useing sah512 creating a 128 charicter password
            $password = hash('sha512',$_REQUEST['pass'].$salt);
            //add all user signup data to the array 
            $info = array($_REQUEST['email'], $password, 0, null, $_SERVER['REMOTE_ADDR'], $_REQUEST['organization'],$salt,1);
            //load the user model
            $userModel = $this->loadModel('user');

            //insert the data to the database and return to home on success
            if($userModel->SelectUserByEmail($_REQUEST['email'])==0){
                $userModel->addUser($info);
                header('location: /');
            }else{
                $this->message = 'This Account Email Address already Exists.';
            }   
         }

        // load views
        require APP . 'view/_templates/header.php';
        
        require APP . 'view/home/signup.php';
        require APP . 'view/_templates/footer.php';
    }


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
    
    public function testPage(){
        $userModel = $this->loadModel('user');
        echo $Testmessage;
        echo $userModel->SelectUserByEmail('admin');
        echo Helper::outputArray($_SESSION);
        //echo Helper::outputArray($userModel->checkAuth($_SESSION['UID']));


    }//end test page

    public function redirectTest(){
        $this->Testmessage = 'Succes 10100101!!';
        $this->testPage();
        die();
    }

}// end class
