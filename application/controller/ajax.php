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
    private $clusterModel;
    private $genusModel;
    private $phageModel;

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
        echo json_encode($phageOutput);

    }

    public function getGenusNames(){
        $GenusNames = $this->genusModel->getGenusList()
        foreach($GenusNames as $row => $data){
            $genusOutput[$data['GenusID']] = $data['Genus'];
        }
        echo json_encode($genusOutput);
    }

    public function getClusterNames(){
        $ClusterNames = $this->clusterModel->getClusterList()
        foreach($ClusterNames as $row => $data){
            $clusterOutput[$data['ClusterID']] = $data['Cluster'];
        }
        echo json_encode($clusterOutput);
    }
    public function 
}