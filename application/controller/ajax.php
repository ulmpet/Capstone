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
        $this->cutsModel = $this->loadModel('cut');
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

    public function getKnownCutData(){

        ini_set("memory_limit","1024M");
        foreach ($_POST['selPhage'] as $key => $value) {
            if($value == 'all'){
                $allPhageIDs = $this->phageModel->getAllPhageID();
                foreach ($allPhageIDs as $k => $v) {
                    $phageIDarray[] = $v['PhageID'];
                }
            }
            $phageIDarray[] = $value;
        }
        foreach ($_POST['selNeb'] as $key => $value) {
            $allEnzymeIDs = $this->enzymeModel->getAllEnzymeID();
                foreach ($allEnzymeIDs as $k => $v) {
                    $enzymeIDarray[] = $v['EnzymeID'];
                }
            $enzymeIDarray[] = $value;
        }
        $cutdata = $this->cutsModel->selectCuts($phageIDarray,$enzymeIDarray);
        
        $enzymeCount = count($enzymeIDarray);
        $tableHeader = "<thead><tr><th>Phage Name</th><th>Cluster</th><th>Subcluster</th>";
        $tableBody = "<tbody>";
        $enzymeNames = array();
        $lastPhageName= null;

        foreach ($cutdata as $key => $value) {
            if(!in_array($value['EnzymeName'], $enzymeNames)){
                $tableHeader .= "<th>". $value['EnzymeName']."</th>";
                $enzymeNames[] = $value['EnzymeName'];
            }
            if($value['PhageName'] != $lastPhageName){
                if(!is_null($lastPhageName)){
                $tableBody .= '</tr>';
                }
                $tableBody.="<tr><td>".$value['PhageName']."</td><td>".$value['Cluster']."</td><td>".$value['Subcluster']."</td><td>".$value['CutCount']."</td>";
                $lastPhageName = $value['PhageName']; 
            }else{
                $tableBody.= "<td>". $value['CutCount'] . "</td>";
            }
        }
        $tableHeader .= '</tr></thead>';
        $tableBody .= '</tbody>';
        echo $tableHeader . $tableBody;
    }

    public function getUnknownCutData(){
        echo "UNKNOWN CUTS DATA";
    }
}