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
        
        $phageGenus = $this->loadModel('genus');
        $adminList = $this->userModel->getAdmin();
        $genusList = $phageGenus->getGenusList();

    	require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/dashboard/dashboard.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addGenus(){
        if(isset($_REQUEST['newGenus'])){
            $phageGenus = $this->loadModel('genus');
            $phageGenus->addGenus($_REQUEST['newGenus']);
            header('location: /dashboard');
        }
    }

    public function fileupload()
    {
        $phages = array();
        if($this->checkAuthLevel(1)){


           // Helper::outputArray($_POST); 
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
                    //skips the first line of the file (colomn names)
                    if($count!=1){
                        //ignores blank phage names
                        if($line[0]!=''){
                            //if the cluster unclustered
                            if($line[1] == "Unclustered" || $line[1] == "unclustered" || $line[1] == "None" || $line[1] == "none" ){
                                $cluster = null;
                                $subcluster = null;
                            }else{
                                // do some magic to select letters then numbers !!!
                                preg_match('/[A-Za-z]+/', $line[1], $cluster);
                                preg_match('/\d+/', $line[1], $subcluster); 
                            }
                            $phages[$line[0]] = array($cluster[0],$subcluster[0]);
                        }
                    //print out our array for viewing pleasure.
                    //echo '(\'' .$line[0].'\',\''.$line[1].'\')'. "  cluster: ". $cluster[0] ."  subcluster:  ". $subcluster[0] ."<br/>";
                    }
                    
                }
                Helper::outputArray($phages);
                $phageModel = $this->loadModel('phage');
                //$phageModel->addShortPhage($phages,$_POST['genusName']);   
                }
            }
        }else{
            header('location: /Error/access');
        }

    }// end file upload

    public function shortMycoUpload(){

    }
    public function fullMycoUpload(){

    }
    public function short(){

    }
}