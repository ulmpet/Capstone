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
            $userEmail = $_REQUEST['Email'];
            $userPassword = $_REQUEST['Password'];
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
    *   
    *
    *
    */
    public function signup()
    {
        if(isset($_REQUEST['email'])){
            Helper::outputArray($_REQUEST);
            $info = array($_REQUEST['email'], $_REQUEST['pass'], 0, null, $_SERVER['REMOTE_ADDR'], $_REQUEST['organization']);
            Helper::outputArray($info);
            $userModel = $this->loadModel('user');

            if($userModel->addUser($info)){
                header('location: /');
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
    public function fileupload()
    {
        if($this->checkAuthLevel(1)){
            Helper::outputArray($_SESSION); 
            //Check to see the the SuperGlobal Variable $_FILES has data
            if(isset($_FILES['userfile']['name'])){
                print_r($_FILES);
                //CHeck for file upload error resulting in null file
                if($_FILES['userfile']['name']!=null){
                //open the uploaded file for reading
                $file = fopen($_FILES['userfile']['tmp_name'], 'r');
                $count =0;
            //while not end of file loop get line as an array
                while(!feof($file)){
                    $count += 1;
                    $line = fgetcsv($file,0,"\t") ;
                    if($count!=1){
                    //print out our array for viewing pleasure.
                    echo '(\'' .$line[0].'\',\''.$line[1].'\')'. "<br>";
                    }
                }
                }
            }
        }else{
            header('location: /Error/access');
        }
            

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/home/example_one.php';
        require APP . 'view/_templates/footer.php';
    }// end file upload

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
    }//end logout
    
    public function testPage(){
        $userModel = $this->loadModel('user');
        echo Helper::outputArray($_SESSION);
        echo Helper::outputArray($userModel->checkAuth($_SESSION['UID']));


    }//end test page



}// end class
