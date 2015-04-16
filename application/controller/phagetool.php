<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class PhageTool extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {

        $genusModel = $this->loadModel('genus');
        $phageModel = $this->loadModel('phage');
        $clusterModel = $this->loadModel('cluster');
        $enzymeModel = $this->loadModel('enzyme');
        //$phageList = $phageModel->getPhageNamesAndID();
        //$subClusterAssociations = $phageModel->getSubClusterAssociations();
        //$clusterList = $clusterModel->getClusterList();
        //$enzymeList = $enzymeModel->getEnzymeNamesAndID();
        //$genusList = $genusModel->getGenusList();
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/phagetool/phagetool.php';
        require APP . 'view/_templates/footer.php';
        //Helper::outputArray($subClusterAssociations);
    }

    public function phylip(){
    	Helper::outputArray($_POST);
    	$commandString = "/usr/local/src/phylip-3.69/exe/pars< ". $file_parsIn . " > /dev/null 2>&1";
    	//exec($commandString);
    	$commandString = "/";
    	//exec($commandString)
    	$commandString = "";
    	$commandString = "";
    	$commandString = "";
    	$commandString = "";
    	$commandString = "";
    }
}
