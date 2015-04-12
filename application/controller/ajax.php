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

        $enzymeNames = array();
        $phageNames = array();
        $lastPhageName= null;
        $message = null;

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
            $enzymeIDarray = $this->getEnzymeIDArray($_POST['selNeb']);
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
            $message ="Please select at least one enzyme.";
            
        }elseif(isset($enzymeIDarray)){
            $message = "Please select at least one phage.";
            
        }else{
            $message =  "Please select at least one Enzyme and One Phage";
            
        }
        
        if(is_null($message)){
            $enzymeCount = count($enzymeIDarray);


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
            foreach ($phageNames as $row => $valueArray) {
                foreach ($enzymeNames as $enzyme) {
                    if(!array_key_exists($enzyme, $valueArray)){
                        $phageNames[$row][$enzyme] = "No Data";
                        //Helper::outputArray($row);
                    }
                }
            }
            foreach ($phageNames as $key => $value) {
                $rowObjects[] = $value;
            }
            
            
            
            $JSONoutput = json_encode(array("columns"=>$headerObjects, "rows"=>$rowObjects, 'message' => $message));
        }else{
            $JSONoutput = json_encode(array("columns"=>null, "rows"=>null, 'message' => $message));
        }
        echo $JSONoutput;
    }

    public function getUnknownCutData(){
        $enzymeNames = array();
        $phageNames = array();
        $lastPhageName= null;
        $message = null;

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
            $enzymeIDarray = $this->getEnzymeIDArray($_POST['selNeb']);
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
            $message ="Please select at least one enzyme.";
            
        }elseif(isset($enzymeIDarray)){
            $message = "Please select at least one phage.";
            
        }else{
            $message =  "Please select at least one Enzyme and One Phage";
            
        }
        
        if(is_null($message)){
            $enzymeCount = count($enzymeIDarray);


            $headerObjects[] = array("data" => "Phage Name","title" => "Phage Name");
            $headerObjects[] = array("title"=> "Sim Score", "data"=>"simscore");
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
            foreach ($phageNames as $row => $valueArray) {
                foreach ($enzymeNames as $enzyme) {
                    if(!array_key_exists($enzyme, $valueArray)){
                        $phageNames[$row][$enzyme] = "No Data";
                        //Helper::outputArray($row);
                    }
                }
            }
            $enzymeMapNametoID = $this->buildEnzymeMapNametoID();
            foreach ($phageNames as $key => $valueArray) {
                $match =0;
                foreach ($enzymeNames as $enzyme) {
                    //calculate simscore here and add it the $valueArray
                    //get id of current enzyme
                    $currID = $enzymeMapNametoID[$enzyme];
                    //get value from post and set range variables
                    //echo "currID : " . $enzymeMapNametoID[$enzyme];
                    //echo "postData : " . $_POST[$currID];
                    switch ($_POST[$currID]) {
                        case 0:
                            $upperBound =0;
                            $lowerBound =0;
                            break;
                        case 1:
                            $lowerBound =1;
                            $upperBound =5;
                            
                            break;
                        case 2:
                            $lowerBound =5;
                            $upperBound =16;
                            break;
                        case 3:
                            $lowerBound =16;
                            $upperBound =41;
                            break;
                        case 4:
                            $lowerBound =41;
                            $upperBound =1000000;
                            break;                            
                        default:
                            # code...
                            break;
                    }
                    if ($valueArray[$enzyme] <= $upperBound && $valueArray[$enzyme] >= $lowerBound) {
                        $match++;
                    }
                    
                    
                    //check if cut count in range
                    //if in range match++
                }
                //echo "match count : " . $match;
                //echo count($enzymeNames);
                $phageNames[$key]['simscore'] = $match/count($enzymeNames);
            }
            foreach ($phageNames as $key => $value) {
                $rowObjects[] = $value;
            }
            
            
            
            $JSONoutput = json_encode(array("columns"=>$headerObjects, "rows"=>$rowObjects, 'message' => $message));
        }else{
            $JSONoutput = json_encode(array("columns"=>null, "rows"=>null, 'message' => $message));
        }
        echo $JSONoutput;
    }
    

    public function buildUknownModal(){
        $modalData = '<form id="unknownDataForm"><table><tr><td><label style="width:200px">Name for Unknown Phage:</label></td><td> <input type="text" name="unknownName"></td></tr>';
        if(isset($_POST['selNeb'])){
            $enzymeIds = $this->getEnzymeIDArray($_POST['selNeb']);
            $namesAndIds = $this->enzymeModel->getEnzymeNamesByID($enzymeIds);
            foreach ($namesAndIds as $key => $value) {
                 $modalData .= '<tr><td><label style="width:200px">' .$value['EnzymeName'] . '</label></td><td><select name="'. $value['EnzymeID'] .'"><option value="0">None (# of cuts = zero)</option>
                    <option value="1">Few (1 <= # of cuts <= 5)</option>
                    <option value="2">Some (5 <= # of cuts <= 16)</option>
                    <option value="3">Many (16 <= # of cuts <= 41)</option>
                    <option value="4">A lot (# of cuts >= 41)</option></select></td></tr>';
            }
            $modalData .= "</table></form>";
            echo $modalData;
        }
    }

    private function getEnzymeIDArray($data){
        foreach ($data as $key => $value) {
                if($value == 'all'){
                    $allEnzymeIDs = $this->enzymeModel->getAllEnzymeID();
                        foreach ($allEnzymeIDs as $k => $v) {
                            $enzymeIDarray[] = $v['EnzymeID'];
                        }
                }
                $enzymeIDarray[] = $value;
            }
            return $enzymeIDarray;
    }

    private function buildClusterMap(){
        $clusters = $this->clusterModel->getClusterList();
        foreach ($clusters as $key => $value) {
            $clusterMap[$value['Cluster']] = $value['ClusterID']; 
        }
        return $clusterMap;
    }

    private function buildEnzymeMapNametoID(){
        $enzymes = $this->enzymeModel->getEnzymeNamesAndID();
        foreach ($enzymes as $key => $value) {
            $enzymeMap[$value['EnzymeName']] = $value['EnzymeID'];
        }
        return $enzymeMap;
    }
}