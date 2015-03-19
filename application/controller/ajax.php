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
    private $enzymeModel;

    public function __construct(){
        parent::__construct();
        $this->genusModel = $this->loadModel('genus');
        $this->clusterModel = $this->loadModel('cluster');
        $this->phageModel = $this->loadModel('phage');
        $this->enzymeModel = $this->loadModel('enzyme');
    }


    public function getPhageNames(){
        $PhageNames = $this->phageModel->getPhageNamesAndID();
        foreach($PhageNames as $row => $data){
            $phageOutput[] = array( 'ID' => $data['PhageID'], 'name'=>$data['PhageName']);
        }
        echo json_encode($phageOutput);

    }

    public function getGenusNames(){

        $genusNames = $this->genusModel->getGenusList();
        foreach($genusNames as $row => $data){
            $genusOutput[] = json_encode(array( 'ID' => $data['GenusID'], 'name'=>$data['Genus']));
        }
        echo json_encode($genusOutput);
    }

    public function getClusterNames(){
        $ClusterNames = $this->clusterModel->getClusterList();
        foreach($ClusterNames as $row => $data){
            $clusterOutput[] = json_encode(array( 'ID' => $data['ClusterID'], 'name'=>$data['Cluster']));  
        }
        echo json_encode($clusterOutput);
    }

    public function getEnzymeNames(){
        $enzymeNames = $this->enzymeModel->getEnzymeNamesAndID();
        foreach($enzymeNames as $row => $data){
            $enzymeOutput[] = json_encode(array( 'ID' => $data['EnzymeID'], 'name'=>$data['EnzymeName']));
        }
    echo json_encode($enzymeOutput);

    }
}