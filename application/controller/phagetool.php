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
        if(isset($_REQUEST['postCheck'])){
            $this->phylip();
            exit;
        }
        
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

                        $outputNames = array();
                        $cutBucketStrings;
                        $bucketCounter = -1;
                        $enzymeNames = array();

                        //loop threw known cut data
                        foreach ($cutdata as $key => $value) {
                            //if the cluster is not null
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
                                $enzymeNames[] = $value['EnzymeName'];
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
                                $enzymeNames[] = $value['EnzymeName'];
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
                        if(isset($_REQUEST['postCheck'])){
                            $outputNames[] = substr($_REQUEST['unknownName'], 0,10);
                            $enzymeNames = array_unique($enzymeNames);
                            $enzymeMapNametoID = $this->buildEnzymeMapNametoID();
                            $bucketCounter+=1;
                            $cutBucketStrings[$bucketCounter] ='';
                            foreach ($enzymeNames as $key => $value) {
                                $currID = $enzymeMapNametoID[$value];
                                switch ($_POST[$currID]) {
                                    case 0:
                                        $cutBucketStrings[$bucketCounter] .= "N";
                                        break;
                                    case 1:
                                        $cutBucketStrings[$bucketCounter] .= "F";
                                        
                                        break;
                                    case 2:
                                        $cutBucketStrings[$bucketCounter] .= "S";
                                        break;
                                    case 3:
                                        $cutBucketStrings[$bucketCounter] .= "M";
                                        break;
                                    case 4:
                                        $cutBucketStrings[$bucketCounter] .= "A";
                                        break;                            
                                    default:
                                        # code...
                                        break;
                                }
                            }
                            

                        }
                        //Helper::outputArray($cutdata);
			$uniqueOutputNames = array_unique($outputNames);
                        //Helper::outputArray($outputNames);
                        //Helper::outputArray($cutBucketStrings);
			unset($outputNames);
			foreach($uniqueOutputNames as $key=>$value){
				$outputNames[] = $value;
			}

                        //Write data to fileObject
                        $fileNameDate = date('U');
                        $filename = 'Infile_' . $fileNameDate;
                        if($datafile = fopen(PHYLIP_DATA.$filename, 'w')){
                            fwrite($datafile, count($outputNames) . " " . strlen($cutBucketStrings[0]) ."\n");
                            foreach ($outputNames as $key => $value) {
                                //var_dump($value);
                                fwrite($datafile, $value);
                                if(strlen($value) < 10 ){
                                    $whitespacearray = array_fill(0, 10-strlen($value), " ");
                                    $whiteSpaceString = implode("", $whitespacearray);
                                    fwrite($datafile, $whiteSpaceString);
                                }
                                fwrite($datafile, $cutBucketStrings[$key] . "\n");
                            }
                        }else{
                            echo "Filed to open " . $filename . " For Write Operation";
                        }

                        $configfilename = "parsIn_" . $fileNameDate;
                        //build config file for pars
			if($configfile = fopen(PHYLIP_DATA.$configfilename, 'w')){
                                fwrite($configfile, PHYLIP_DATA.$filename."\n");
                                fwrite($configfile, "F\n".
                                    PHYLIP_DATA."parsOutFile_".$fileNameDate."\n".
                                    "V\n".
                                    "100\n".
                                    "J\n");
                                while (($seed = rand())%2 == 0){}
                                fwrite($configfile, $seed ."\n");
                                fwrite($configfile, "10\n");
                                fwrite($configfile, "Y\nF\n".PHYLIP_DATA."parsOutTree_".$fileNameDate);
                        }
                        //passfile object to 1st command
                        $consenseConfigName = "consenseIN_" . $fileNameDate;
			if($consenseConfigFile = fopen(PHYLIP_DATA.$consenseConfigName, 'w')){
				fwrite($consenseConfigFile, PHYLIP_DATA."parsOutTree_".$fileNameDate);
				fwrite($consenseConfigFile, "\nF\n" . PHYLIP_DATA."consenseOutFile_".$fileNameDate."\nC\nY\nF\n".PHYLIP_DATA."consenseOutTree_".$fileNameDate);
			}
			$drawgramConfigName = "drawgramIn_". $fileNameDate;
			if($drawgramConfigFile = fopen(PHYLIP_DATA.$drawgramConfigName, 'w')){
				fwrite($drawgramConfigFile, PHYLIP_DATA."consenseOutTree_".$fileNameDate."\n");
				fwrite($drawgramConfigFile, "/usr/local/src/exe/font1\n");
				fwrite($drawgramConfigFile, "P\nL\nV\n\N\nY\nF\n");
				fwrite($drawgramConfigFile, PHYLIP_DATA . "plotfileDrawGram_".$fileNameDate);
			}
			//complete command list
                        //return a beautiful PDF
			//echo exec("whoami");
                        $commandString = "/usr/local/src/exe/pars < ". PHYLIP_DATA . $configfilename . " > /dev/null 2>&1";
			//echo $commandString;
                         exec($commandString);
                        $commandString = "/usr/local/src/exe/consense < ". PHYLIP_DATA . $consenseConfigName. " > /dev/null 2>&1";
                        exec($commandString);
                        $commandString = "/usr/local/src/exe/drawgram < ". PHYLIP_DATA . $drawgramConfigName. " > /dev/null 2>&1";
                        exec($commandString);
			$commandString = "/usr/bin/ps2pdf13 " .PHYLIP_DATA."plotfileDrawGram_".$fileNameDate." " .PHYLIP_DATA."phagePDF_".$fileNameDate;
                        exec($commandString);
			
			if(!isset($_REQUEST['unknownName'])){
				header("Content-Type: application/pdf");
				header("Content-Disposition: inline; filename= phageTree.pdf");
				header("Content-Transfer-Encodeing: binary");
				header("Content-Length: " . filesize(PHYLIP_DATA . "phagePDF_".$fileNameDate));
				//fopen(PHYLIP_DATA.)
				readfile(PHYLIP_DATA . "phagePDF_".$fileNameDate);
				//echo "<embed width='100%' height='100%' src=".URL . "phylip_data/phagePDF_".$fileNameDate." type='application/pdf'>";
                    	}else{
				echo "phagePDF_".$fileNameDate;
			}
		   }else{
                        echo "Failed To Open Phylip Data Directory";
                    }
                }else{
                    echo "Failed To Open Phylip Directory";
                }

            }else{
                echo PHYLIP_DATA . "Is not a  Directory";
            }
        }else{
            echo PHYLIP_FOLDER . " Is not a Directory";
        }


    }
    public function test(){
        //Helper::outputArray($_SERVER);
        echo PHYLIP_FOLDER . '<BR>';
        echo PHYLIP_DATA . "<BR>";
        echo "URL SUB " . URL_SUB_FOLDER . "<BR>";
        phpinfo();
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
        private function buildEnzymeMapNametoID(){
        $enzymes = $this->enzymeModel->getEnzymeNamesAndID();
        foreach ($enzymes as $key => $value) {
            $enzymeMap[$value['EnzymeName']] = $value['EnzymeID'];
        }
        return $enzymeMap;
    }
}
