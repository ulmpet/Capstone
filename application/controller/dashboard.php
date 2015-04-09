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
    private $clusterModel;
    private $genusModel;
    private $phageModel;


    public function __construct(){
        parent::__construct();
        $this->genusModel = $this->loadModel('genus');
        $this->clusterModel = $this->loadModel('cluster');
        $this->phageModel = $this->loadModel('phage');
        $this->enzymeModel = $this->loadModel('enzyme');
        $this->cutModel = $this->loadModel('cut');
    }
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function index()
    {
        
        
        $adminList = $this->userModel->getAdmin();
        $genusList = $this->genusModel->getGenusList();
        $phageList = $this->phageModel->getPhageNamesAndID();


    	require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/nav.php';
        require APP . 'view/dashboard/dashboard.php';
        require APP . 'view/_templates/footer.php';
    }

    public function addGenus(){
        if(isset($_REQUEST['newGenus'])){
            $this->genusModel->addGenus($_REQUEST['newGenus']);
            header('location: /dashboard');
        }
    }

    public function addCluster($newCluster){
        $this->clusterModel->addCluster($newCluster);
    }

    public function fileupload()
    {
        
            Helper::outputArray($_POST);
            if($_POST['filetype'] == 0){
                if($_POST['genusName'] !== "null"){
                    $this->shortUpload($_POST['genusName']);
                }else{
                    echo "no genus selected";
                }
            }elseif($_POST['filetype'] == 1){
                if($_POST['genusName'] !== "null"){
                    $this->fullUpload($_POST['genusName']);
                }else{
                    echo "no genus selected";
                }
                //echo "do long csv";
            }elseif($_POST['filetype'] == 2){
                $this->fastaUpload();
                //echo "do fasfa";
            }elseif($_POST['filetype'] == 3){
                $this->nebUpload();
                header("location: /dashboard");
            }

    }// end file upload

    private function shortUpload($genusName){
        $phages = array();
        $clusterMap = $this->generateClusterMap();
        //Check to see the the SuperGlobal Variable $_FILES has data
        if(isset($_FILES['userfile']['name'])){
            //print_r($_FILES);
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
                                $cluster[0] = null;
                                $subcluster[0] = 'None';
                            }else{
                            // do some magic to select letters then numbers !!!
                                preg_match('/[A-Za-z]+/', $line[1], $cluster);
                                preg_match('/\d+/', $line[1], $subcluster);
                                if(!isset($subcluster[0])){
                                    $subcluster[0] = 'None';
                                }
                            }
                            if(!array_key_exists($cluster[0], $clusterMap)){
                                $this->addCluster($cluster[0]);
                                $clusterMap = $this->generateClusterMap();
                            }
                        $phages[$line[0]] = array($clusterMap[$cluster[0]],$subcluster[0]);
                        }
                    }   
                }
                $phages = $this->buildPhageValues($phages,$genusName);
                $this->phageModel->addShortPhage($phages);   
            }
        }
    }//end short upload

    public function fullUpload($genusName){
        ini_set("memory_limit","1024M");
        set_time_limit (0);
        if(isset($_FILES['userfile']['name'])){
            //print_r($_FILES);
            //CHeck for file upload error resulting in null file
            if($_FILES['userfile']['name']!=null){
                //open the uploaded file for reading
                $file = fopen($_FILES['userfile']['tmp_name'], 'r');
                $cutData = array();
                $enzymeOrder = array();
                $count =0;
                $enzymeIndexMap = $this->buildEnzymeIndexMap();
                $enzymeIndexMap['Mycobacteriophage'] = 'PhageName';
                $enzymeIndexMap['Arthrobacter '] = 'PhageName';
                $enzymeIndexMap['Streptomyces '] = 'PhageName';
                $enzymeIndexMap['Bacillus '] = 'PhageName';
                $phages = $this->buildPhageIndexMap();
                //while not end of file loop get line as an array
                //Helper::outputArray($phages);
                while(!feof($file)){
                    $line = fgetcsv($file,0,",");
                    //Helper::outputArray($line);
                    if($count ==0 ){
                        $enzymeOrder = $line;
                        $count++;
                    }else{
                        if(!is_array($line)){
                            //var_dump($line);
                            //echo $count;
                        }else{
                        foreach ($line as $key => $value) {
                            if($key == 0){
                                
                                if(isset($phages[$value])){
                                    //echo $phages[$value];
                                    $cutData[$count][$enzymeIndexMap[$enzymeOrder[$key]]] = $phages[$value];
                                }else{
                                    continue;
                                }
                            }else{
                                if(isset($cutData[$count]['PhageName'])){
                                    $cutData[$count][$enzymeIndexMap[$enzymeOrder[$key]]] = $value;
                                }else{
                                    continue;
                                }
                            }
                            //$cutData[$count][$enzymeIndexMap[$enzymeOrder[$key]]] = $value;
                        }
                        $count++;
                    }
                    }

                }
                //Helper::outputArray($cutData);
                $this->cutModel->insertMassCuts($cutData);
            }
        }

    }

    public function fastaUpload(){
        ini_set("memory_limit","1024M");
        set_time_limit (0);
        $allPhages = $this->phageModel->getPhageNames();
        $allPhages = $this->buildPhageMap($allPhages);
        
        if(isset($_FILES['userfile']['name'])){
            //print_r($_FILES);
            //CHeck for file upload error resulting in null file
            if($_FILES['userfile']['name']!=null){
                //open the uploaded file for reading
                $file = fopen($_FILES['userfile']['tmp_name'], 'r');
                while(!feof($file)){
                    $lines[] = fgets($file);
                    }
                }
                foreach ($lines as $key => $value) {
                    if (substr($value, 0, 1) == '>') {
                        //echo $value . "<br/>";
                        preg_match_all("/[a-zA-Z0-9]+/", $value, $matches);
                        //Helper::outputArray($matches);
                        $matchCount =0;
                        foreach($matches[0] as $key => $word){
                            if(array_key_exists($word, $allPhages)){
                                $currentPhage = $word;
                                $matchCount +=1;
                                if($matchCount > 1){
                                    break;
                                }
                            }
                        }
                    }else{
                        if($matchCount>1){
                            continue;
                        }elseif(array_key_exists($currentPhage, $allPhages)){
                            $allPhages[$currentPhage] .= trim($value);
                        }
                    }
                }
                //Helper::outputArray($allPhages);
                foreach ($allPhages as $key => $value) {
                    if(isset($value)){
                        $sequencedPhages[$key] = $value; 
                    }
                }
                
                //Helper::outputArray($sequencedPhages);
                $this->phageModel->inputGenome($sequencedPhages);
        }
    }

    //makes a assosiatce array maping cluster names to their databse id's
    private function generateClusterMap(){
        $allClusters = $this->clusterModel->getClusterList();
        $clusterMap = array();
        foreach($allClusters as $clusterData){
            $clusterMap[$clusterData['Cluster']] = $clusterData['ClusterID'];
        }
        return $clusterMap;
    }

    // formats phage information for insertion to the database
    public function buildPhageValues($phages,$genusName){
        $phageValueOutputArray = array();
        foreach ($phages as $key => $value) {
            $phageValueOutputArray[] = array($key, $genusName, $value[0], $value[1], date(MYSQL_DATE_FORMAT));
        }
        return $phageValueOutputArray;
    }

    public function buildCutValues($cutData,$phage){
        $phageMap = $this->buildPhageIndexMap();
        $enzymeMap = $this->buildEnzymeIndexMap();
        foreach($cutData as $key => $value){
            $outputArray[] = array($phageMap[$phage],$enzymeMap[$key],$value,null);
        }
        return $outputArray;
    }

    public function buildPhageIndexMap(){
        $phagearray = $this->phageModel->getPhageNamesAndID();
        foreach ($phagearray as $key => $value) {
            $outputArray[$value['PhageName']] = $value['PhageID'];
        }
        return $outputArray;
    }

    public function buildEnzymeCutMap(){
        $enzymeArray = $this->enzymeModel->getEnzymeNames();
        foreach ($enzymeArray as $key => $value) {
            $outputArray[$value['EnzymeName']] = 0;
        }
        return $outputArray;
    }

    public function buildEnzymeIndexMap(){
        $enzymeArray = $this->enzymeModel->getEnzymeNamesAndID();
        foreach ($enzymeArray as $key => $value) {
            $outputArray[$value['EnzymeName']] = $value['EnzymeID'];
        }
        return $outputArray;
    }

    //makes an assosiative array with phage names from the database as keys
    public function buildPhageMap($phageNames){
        //Helper::outputArray($phageNames);
        foreach($phageNames as $index => $phage){
            $phageMap[$phage['PhageName']] = null;
        }
        return $phageMap;
    }

    private function enzymeCutter($sequence){
        $enzymesArray = $this->enzymeModel->getEnzymesForCutting();

        foreach ($enzymesArray as $key => $value) {
            $enzymes_array[$value['EnzymeName']] = array($value['SamePatternEnzymes'],$value['RecognitionPattern'],$value['RecognitionforComputing'],$value['RecognitionPatternLength'],$value['CleavagePositionUpper'],$value['CleavagePositionLower']);
        }

        foreach ($enzymes_array as $enzyme => $val){
        // this is to put together results for IIb endonucleases, which are computed as "enzyme_name" and "enzyme_name@"
        $enzyme2=str_replace("@","",$enzyme);

        // split sequence based on pattern from restriction enzyme
        $fragments = preg_split("/".$enzymes_array[$enzyme][2]."/", $sequence,-1,PREG_SPLIT_DELIM_CAPTURE);
        reset ($fragments);
        $maxfragments=sizeof($fragments);
        // when sequence is cleaved ($maxfragments>1) start further calculations
        if ($maxfragments>1){
                $recognitionposition=strlen($fragments[0]);
                $counter_cleavages=0;
                $list_of_cleavages="";
                // for each frament generated, calculate cleavage position,
                //    add it to a list, and add 1 to counter
                for ($i=2;$i<$maxfragments; $i+=2){
                        $cleavageposition=$recognitionposition+$enzymes_array[$enzyme][4];
                        $digestion[$enzyme2]["cuts"][$cleavageposition]="";
                                // As overlapping may occur for many endonucleases,
                                //   a subsequence starting in position 2 of fragment is calculate
                                $subsequence=substr($fragments[$i-1],1).$fragments[$i].substr($fragments[$i+1],0,40);
                                $subsequence=substr($subsequence,0,2*$enzymes_array[$enzyme][3]-2);
                                //Previous process is repeated
                                // split subsequence based on pattern from restriction enzyme
                                $fragments_subsequence = preg_split($enzymes_array[$enzyme][2],$subsequence);
                                // when subsequence is cleaved start further calculations
                                if (sizeof($fragments_subsequence)>1){
                                        // for each fragment of subsequence, calculate overlapping cleavage position,
                                        //    add it to a list, and add 1 to counter
                                        $overlapped_cleavage=$recognitionposition+1+strlen($fragments_subsequence[0])+$enzymes_array[$enzyme][4];
                                        $digestion[$enzyme2]["cuts"][$overlapped_cleavage]="";
                                }
                        // this is a counter for position
                        $recognitionposition+=strlen($fragments[$i-1])+strlen($fragments[$i]);
                }
        }
    }
    return $digestion;
  }  

  public function simpleDigestion($genome){

  }

  public function cutGenome($phageID){
    $genome = $this->phageModel->getPhageGenome($phageID); 
    Helper::outputArray($genome);     
    $cutdata = $this->enzymeCutter($genome[0]['Gnome']);
    foreach ($cutdata as $key => $value) {
        echo $key ."   " . count($value['cuts']) . "</br>";
        $cutCountdata[$key] = count($value['cuts']);
    }

    $finalCutCountData = $this->buildCutValues($cutCountdata,$phageID);
    Helper::outputArray($finalCutCountData);
    $this->cutModel->insertCuts($finalCutCountData);
                
  }


  public function nebUpload(){
        //Check to see the the SuperGlobal Variable $_FILES has data
        if(isset($_FILES['userfile']['name'])){
            //print_r($_FILES);
            //CHeck for file upload error resulting in null file
            if($_FILES['userfile']['name']!=null){
                //open the uploaded file for reading
                $file = fopen($_FILES['userfile']['tmp_name'], 'r');
                $count =0;
                //while not end of file loop get line as an array
                while(!feof($file)){
                    $line[] = fgets($file);
                }
                $enzymeIndexMap = $this->buildEnzymeIndexMap();
                $enzymeCutMap = $this->buildEnzymeCutMap();
                $missingEnzymes = array();
                $totalEnzymes = array();
                foreach ($line as $key => $value) {
                    $lineArray = preg_split("/(\W)+/", $value);
                    
                    if (isset($lineArray[1]) && is_numeric($lineArray[1])){
                        //echo $lineArray[1] ."<br>";
                        if(!in_array($lineArray[2], $totalEnzymes)){
                                $totalEnzymes[] = $lineArray[2];
                            }
                        if(array_key_exists($lineArray[2], $enzymeCutMap)){
                            $enzymeCutMap[$lineArray[2]] += 1;
                        }else{
                            if(!in_array($lineArray[2], $missingEnzymes)){
                                $missingEnzymes[] = $lineArray[2];
                            }
                        }


                        
                    }else{
                        echo "NAN <br>";
                    }

                }
                foreach ($enzymeCutMap as $key => $value) {
                    $enzymeIDCutMap[$enzymeIndexMap[$key]] = $value;
                }

                $this->cutModel->insertNebCuts($enzymeIDCutMap, $_POST['phageName']);

                //Helper::outputArray($enzymeIDCutMap);
                //Helper::outputArray($missingEnzymes);
                //Helper::outputArray($submission);
            }
        }
  }
}