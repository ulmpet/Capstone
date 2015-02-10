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
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function fileupload()
    {
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
            
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/example_one.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: exampletwo
     * This method handles what happens when you move to http://yourproject/home/exampletwo
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function login()
    {
        $this->message = 'Please enter your username and password.';
        //is the http request contains information from a feild called VARIABLEAMEFOREMAIL
        $userModel = $this->loadModel('user');
        //Helper::outputArray($userModel->selectAllUsers(),true);

        if(isset($_REQUEST['Email'])){
        $userEmail = $_REQUEST['Email'];
        $userPassword = $_REQUEST['password'];
        //echo count($userModel->checkLogin($userEmail,$userPassword));
        $userInformation = $userModel->checkLogin($userEmail,$userPassword);
        if(count($userInformation) == 1){
            
            //Helper::outputArray($userInformation);
            $_SESSION['UID'] = $userInformation[0]['UserID'];
            $_SESSION['ACCESS'] = $userInformation[0]['Root'];
            Helper::outputArray($_SESSION);
            //header('location: /Home/fileupload');
        }else{
            $this->message = 'Login Failed';
        }
    }
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/example_two.php';
        require APP . 'view/_templates/footer.php';
    }
}
