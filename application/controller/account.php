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
  		require APP . 'view/_templates/header.php';
  		require APP . 'view/_templates/nav.php';
        require APP . 'view/account/account.php';
        require APP . 'view/_templates/footer.php';
    }
    /**
    *  Step 1) check that the user is logged in and if the password entered is the correct password.
    *          - Stored in $_REQUEST['password'] 
    *       2) check new password and newconfirmed password are the same. If not return error. 
    *       3) Generate new salt, hash the new password. Update DB with new hashed password and Salt.
    */
    public function changePassword()
    {
        Helper::outputArray($_REQUEST);
        
        $this->message = "Create your new password now.";
        $salt = bin2hex(openssl_random_pseudo_bytes(64));

        $password = hash('sha512',$_REQUEST['confirmnewpassword'].$salt);


        //$this->userModel->updatePassword($password,$salt){

    }
}