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
    public function getSubClusters(){
        $SubClusterNames = $this->phageModel->getSubclusters();
        foreach($SubClusterNames as $key => $data){
            if($data['Subcluster'] != 'None'){
            $subclusterOutput[] = array( 'ID' => $data['Cluster'].$data['Subcluster'], 'name' => $data['Cluster'].$data['Subcluster']);
            }
        }
        echo json_encode($subclusterOutput);
    }



    public function getKnownCutData(){

        ini_set("memory_limit","1024M");
        if(isset($_POST['selPhage'])){
            foreach ($_POST['selPhage'] as $key => $value) {
                if($value == 'all'){
                    $allPhageIDs = $this->phageModel->getAllPhageID();
                    foreach ($allPhageIDs as $k => $v) {
                        $phageIDarray[] = $v['PhageID'];
                    }
                }
                $phageIDarray[] = $value;
            }
        }

        if(isset($_POST['selNeb'])){
            foreach ($_POST['selNeb'] as $key => $value) {
                if($value == 'all'){
                    $allEnzymeIDs = $this->enzymeModel->getAllEnzymeID();
                        foreach ($allEnzymeIDs as $k => $v) {
                            $enzymeIDarray[] = $v['EnzymeID'];
                        }
                }
                $enzymeIDarray[] = $value;
            }
        }


        if(isset($_POST['selCluster'])){
            if(in_array('all', $_POST['selCluster'])){
                $phageIdsByCluster = $this->phageModel->getAllPhageID();
            }else{
                $phageIdsByCluster = $this->phageModel->getPhageIDByCluster($_POST['selCluster']);
            }
            foreach ($phageIdsByCluster as $k => $v) {
                $phageIDarray[] = $v['PhageID'];
            }
        }

        if(isset($_POST['selSubCluster'])){
            $clusterMap = $this->buildClusterMap();
            if(in_array('all', $_POST['selSubCluster'])){
                $phageIdsBySubcluster = $this->phageModel->getAllPhageID();
            }else{
                //seporate clustes and subclusters
                foreach ($_POST['selSubCluster'] as $key => $value) {
                    preg_match('/[A-Za-z]+/', $value, $cluster);
                    preg_match('/\d+/', $value, $subcluster);
                    $subclusterSelectArray[] = array($clusterMap[$cluster[0]],$subcluster[0]);
                }
                //Helper::outputArray($subclusterSelectArray);
                $phageIdsBySubcluster = $this->phageModel->getPhageIDBySubCluster($subclusterSelectArray);
                foreach ($phageIdsBySubcluster as $k => $v) {
                    $phageIDarray[] = $v['PhageID'];
                }
            }
        }

        if(isset($_POST['selCuts'])){
            if(in_array(0, $_POST['selCuts'])){
                $ranges[] = array(0,0);
            }
            if(in_array(1, $_POST['selCuts'])){
                $ranges[] = array(1,5);
            }
            if(in_array(2, $_POST['selCuts'])){
                $ranges[] = array(5,16);
            }
            if(in_array(3, $_POST['selCuts'])){
                $ranges[] = array(16,41);
            }
            if(in_array(4, $_POST['selCuts'])){
                $ranges[] = array(41,10000000);
            }
        }else{
            $ranges = null;
        }

        if(isset($phageIDarray) && isset($enzymeIDarray)){
            $cutdata = $this->cutsModel->selectCuts($phageIDarray,$enzymeIDarray,$ranges);
        }elseif(isset($phageIDarray)){
            echo "Please select at least one enzyme.";
            exit;
        }elseif(isset($enzymeIDarray)){
            echo "Please select at least one phage.";
            exit;
        }else{
            echo "Please select at least one Enzyme and One Phage";
            exit;
        }
        
        $enzymeCount = count($enzymeIDarray);
        //$tableHeader = "<thead><tr><th>Phage Name</th><th>Genus</th><th>Cluster</th><th>Subcluster</th>";
        //$tableBody = "<tbody>";
        $enzymeNames = array();
        $phageNames = array();
        $lastPhageName= null;

        // foreach ($cutdata as $key => $value) {
        //     if(!in_array($value['EnzymeName'], $enzymeNames)){
        //         $tableHeader .= "<th>". $value['EnzymeName']."</th>";
        //         $enzymeNames[] = $value['EnzymeName'];
        //     }
        //     if($value['PhageName'] != $lastPhageName){
        //         if(!is_null($lastPhageName)){
        //         $tableBody .= '</tr>';
        //         }
        //         $tableBody.="<tr><td>".$value['PhageName']."</td><td>". $value['Genus']."</td><td>".$value['Cluster']."</td><td>".$value['Subcluster']."</td><td>".$value['CutCount']."</td>";
        //         $lastPhageName = $value['PhageName']; 
        //     }else{
        //         $tableBody.= "<td>". $value['CutCount'] . "</td>";
        //     }
        // }
        // $tableHeader .= '</tr></thead>';
        // $tableBody .= '</tbody>';

        $headerObjects[] = array("data" => "Phage Name","title" => "Phage Name");
        $headerObjects[] = array("title" => "Genus","data" => "Genus");
        $headerObjects[] = array("title" => "Cluster","data" => "Cluster");
        $headerObjects[] = array("title" => "Subcluster","data" => "Subcluster");
        foreach ($cutdata as $key => $value) {
            if(!in_array($value['EnzymeName'], $enzymeNames)){
                $headerObjects[] = array("title" => $value['EnzymeName'],"data" => $value['EnzymeName']);
                $enzymeNames[] = $value['EnzymeName'];
            }
            if(!array_key_exists($value['PhageName'], $phageNames)){
                $phageNames[$value['PhageName']] = array('Phage Name' => $value['PhageName'], 'Genus'=>$value['Genus'],'Cluster'=>$value['Cluster'],'Subcluster'=>$value['Subcluster'],$value['EnzymeName']=>$value['CutCount']);
            }else{
                $phageNames[$value['PhageName']][$value['EnzymeName']] = $value['CutCount'];
            }
        }
        foreach ($phageNames as $key => $value) {
            $rowObjects[] = $value;
        }
        $JSONoutput = json_encode(array("columns"=>$headerObjects, "rows"=>$rowObjects));
        echo $JSONoutput;
    }

    public function getUnknownCutData(){
        echo "UNKNOWN CUTS DATA";
    }

    private function buildClusterMap(){
        $clusters = $this->clusterModel->getClusterList();
        foreach ($clusters as $key => $value) {
            $clusterMap[$value['Cluster']] = $value['ClusterID']; 
        }
        return $clusterMap;
    }
}