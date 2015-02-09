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
        //Check to see the the SuperGlobal Variable $_FILES has data
        if(isset($_FILES['userfile']['name'])){
            //CHeck for file upload error resulting in null file
            if($_FILES['userfile']['name']!=null){
            //open the uploaded file for reading
            $file = fopen($_FILES['userfile']['tmp_name'], 'r');
            $count =0;
            while(!feof($file)){
                $count += 1;
                $line = fgetcsv($file,0,"\t") ;
                if($count!=1){
                
                echo '(\'' .$line[0].'\',\''.$line[1].'\')'. "<br>";
            }
            //while not end of file loop get line as an array
            while(!feof($file)){
                //print out our array for viewing pleasure.
                echo print_r(fgetcsv($file,0,"\t")) . "<br>";

            }
            fclose($file);
            }
        }
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/example_one.php';
        require APP . 'view/_templates/footer.php';
    }
}
    /**
     * PAGE: exampletwo
     * This method handles what happens when you move to http://yourproject/home/exampletwo
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    public function login()
    {
        //is the http request contains information from a feild called VARIABLEAMEFOREMAIL
        if(isset($_REQUEST['VARIABLENAMEFOREMAIL'])){
        $user = $this->loadModel('user');
        $userEmail = $_REQUEST['VARIABLENAMEFOREMAIL'];
        $userPassword = $_REQUEST['VARIABLENAMEFORPASSOWRD'];
        // load views
        if($user->checkLogin($userEmail,$userPassword)){
            session_start();
            header('location: /information');
        }
    }
        require APP . 'view/_templates/header.php';
        require APP . 'view/home/example_two.php';
        require APP . 'view/_templates/footer.php';
    }
}
