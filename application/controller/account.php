<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Account extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        if(isset($_REQUEST['changePasswordThing'])){
        $this->changepassword();
        exit;
        }   
        
  		require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/account/account.php';
        require APP . 'view/_templates/footer.php';
    }
    /**
    *  This method is called upon the submit of a form in the Account.php View
    *  It checks the current passowrd with the help of account.php model and will change the password,
    *  with a new salted hash. This method is not quite complete because the message comfirming the change in passwords will not show for some reason. 
    *       
    */
    public function changePassword()
    {
        //Helper::outputArray($_REQUEST);
        //Helper::outputArray($_SESSION);
        //Helper::outputArray($passcheck);
        
        //will get the users Username by session ID
        $currentUser = $this->userModel->getUserByID($_SESSION['UID']);
        //gets the salt for the current user
        $userSalt = $this->userModel->getSalt($currentUser);
        //hash and salt the password.
        $password = hash('sha512',$_REQUEST['password'].$userSalt);
        //used to confirm password
        $passcheck = $this->userModel->checkPassword($_SESSION['UID'], $password);

        if(empty($_REQUEST['newpassword'])){

            $_SESSION['message2'] = "The new passwords cannot be blank";
            
        }
        else if(empty($_REQUEST['confirmnewpassword'])){

            $_SESSION['message2'] = "The new passwords cannot be blank";

        }
        else{


            if($passcheck == 1 ){

                $newcheck = strcmp($_REQUEST['newpassword'],$_REQUEST['confirmnewpassword']);
                  
                if($newcheck != 0){

                $_SESSION['message2'] = "The new passwords do not match.";

                } //end of nested if

                $_SESSION['success'] = "Your new password has been set.";
                //generate a new salt and use it with the hash of the new password
                $salt = bin2hex(openssl_random_pseudo_bytes(64));
                $password = hash('sha512',$_REQUEST['confirmnewpassword'].$salt);
                $this->userModel->changePassword($_SESSION['UID'], $password, $salt);
                

            }//end of first if
            else{
             $_SESSION['message'] = "Invalid Password"; 
            
            }//end of first else
        }

        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/account/account.php';
        require APP . 'view/_templates/footer.php';
        
    } //end of changePassword

    public function deactivateAccount(){

        $currentUser = $this->userModel->getUserByID($_SESSION['UID']);

    }
    

}