<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Ajax extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */

    public function __construct(){
        parent::__construct();
        $this->genusModel = $this->loadModel('genus');
        $this->clusterModel = $this->loadModel('cluster');
        $this->phageModel = $this->loadModel('phage');
    }


    public function getPhageNames(){
        $PhageNames = $this->phageModel->getPhageNames();
        foreach($PhageNames as $row => $data){
            $phageOutput[$data['PhageID']] = $data['PhageName'];
        }
        //json encode the array
        //return it
    }

    public function getGenusNames(){
        $genusNames = $this->genusModel->getGenusList()
        foreach($genusNames as $row => $data){
            $genusOutput[$data['GenusID']] = $data['Genus'];
        }
        echo json_encode($genusOutput);
    }
}