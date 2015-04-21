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

    public function __construct(){
        parent::__construct();
        $this->genusModel = $this->loadModel('genus');
        $this->clusterModel = $this->loadModel('cluster');
        $this->phageModel = $this->loadModel('phage');
        $this->enzymeModel = $this->loadModel('enzyme');
        $this->cutsModel = $this->loadModel('cut');
    }
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/phagetool/phagetool.php';
        require APP . 'view/_templates/footer.php';
        //Helper::outputArray($subClusterAssociations);
    }

    public function phylip(){
        if (is_dir(PHYLIP_FOLDER)){
            if(is_dir(PHYLIP_DATA)){
                if($pf = opendir(PHYLIP_FOLDER)){
                    if($pd = opendir(PHYLIP_DATA)){
                        //now that all the nessisary directorys are tested and opened....
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

                        $outputNames[] = array();
                        $cutBucketStrings;
                        $bucketCounter = -1; 
                        foreach ($cutdata as $key => $value) {
                            if($value['Cluster'] != null){
                                if($value['Cluster'] == "Singleton"){
                                    $cluster = "Si";
                                }else{
                                    $cluster = $value['Cluster'];
                                }
                            }else{
                                $cluster = "";
                            }
                            if($value['Subcluster'] != "None"){
                                $subcluster = $value['Subcluster'];
                            }else{
                                $subcluster = "";
                            }
                            $clusterExtension = "-".$cluster.$subcluster;
                            if(strlen($value['PhageName'])>6){
                                $phylip_enzyme_name = substr($value['PhageName'], 0, 10-strlen($clusterExtension))  . $clusterExtension;
                            }else{
                                $phylip_enzyme_name = $value['PhageName'] . $clusterExtension;
                            }
                            if(!in_array($phylip_enzyme_name, $outputNames)){
                                $outputNames[] = $phylip_enzyme_name;
                                if($value['CutCount'] == 0){
                                    $bucketValue = "N";
                                }elseif( 1<= (integer)$value['CutCount'] && (integer)$value['CutCount'] < 5){
                                    $bucketValue = "F";
                                }elseif( 5<= (integer)$value['CutCount'] && (integer)$value['CutCount'] <16){
                                    $bucketValue = "S";
                                }elseif( 16<= (integer)$value['CutCount'] && (integer)$value['CutCount'] <41){
                                    $bucketValue = "M";
                                }elseif( (integer)$value['CutCount']>=41){
                                    $bucketValue = "A";
                                }else{
                                    echo $value['PhageName'] . ' / ' . $value['EnzymeName'] . " / ". $value['CutCount'];
                                }

                                $bucketCounter += 1;
                                $cutBucketStrings[$bucketCounter] = $bucketValue;
                            }else{
                                $outputNames[] = $phylip_enzyme_name;
                                if($value['CutCount'] == 0){
                                    $bucketValue = "N";
                                }elseif( 1<= (integer)$value['CutCount'] && (integer)$value['CutCount'] < 5){
                                    $bucketValue = "F";
                                }elseif( 5<= (integer)$value['CutCount'] && (integer)$value['CutCount'] <16){
                                    $bucketValue = "S";
                                }elseif( 16<= (integer)$value['CutCount'] && (integer)$value['CutCount'] <41){
                                    $bucketValue = "M";
                                }elseif((integer)$value['CutCount']>=41){
                                    $bucketValue = "A";
                                }else{
                                    echo $value['PhageName'] . ' / ' . $value['EnzymeName'] . " / ". $value['CutCount'];
                                }
                                $cutBucketStrings[$bucketCounter] .= $bucketValue;
                            }
                        }
                        //Helper::outputArray($cutdata);
                        //Helper::outputArray($outputNames);
                        //Helper::outputArray($cutBucketStrings);

                        //Write data to fileObject
                        //passfile object to 1st command
                        //complete command list
                        //return a beautiful PDF
                        $commandString = "/usr/local/src/phylip-3.69/exe/pars< ". $file_parsIn . " > /dev/null 2>&1";
                        //exec($commandString);
                        $commandString = "/";
                        //exec($commandString)
                        $commandString = "";
                        $commandString = "";
                        $commandString = "";
                        $commandString = "";
                        $commandString = "";
                    }else{
                        echo "Failed To Open Phylip Data Directory";
                    }
                }else{
                    echo "Failed To Open Phylip Directory";
                }
            
            }else{
                echo "Wrong Phylip Data Directory";
            }
        }else{
            echo "Wrong Phylip Folder Directory";
        }


    }
    public function test(){
        //Helper::outputArray($_SERVER);
        echo PHYLIP_FOLDER . '<BR>';
        echo PHYLIP_DATA . "<BR>";
    }

    private function buildClusterMap(){
        $clusters = $this->clusterModel->getClusterList();
        foreach ($clusters as $key => $value) {
            $clusterMap[$value['Cluster']] = $value['ClusterID']; 
        }
        return $clusterMap;
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
}
