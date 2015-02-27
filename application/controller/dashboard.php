<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Dashboard extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
    	require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/dashboard/dashboard.php';
        require APP . 'view/_templates/footer.php';
    }

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

    }// end file upload
}