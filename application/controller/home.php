<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home extends Controller
{

    var $Testmessage;
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index 
     * This is the login handler and landing page for all users coming to the site. 
     */
    public function index()
    {
        $this->message = 'Please enter your username and password.';
        //Helper::outputArray($userModel->selectAllUsers(),true);
        //if the http request contains information from a feild called Email attempt a login
        if(isset($_REQUEST['Email'])){
            $userSalt = $this->userModel->getSalt($_REQUEST['Email']);
            $userEmail = $_REQUEST['Email'];
            $userPassword = hash('sha512',$_REQUEST['Password'].$userSalt);
            //echo count($userModel->checkLogin($userEmail,$userPassword));
            //request user from database with entered credientials
            $userInformation = $this->userModel->checkLogin($userEmail,$userPassword);
            // if there is such a user
            if(count($userInformation) == 1){
            
                //set the session verables and redirect to News Page
                $_SESSION['UID'] = $userInformation[0]['UserID'];
                //Helper::outputArray($_SESSION);
                header('location: /news');
            //else login failed
            }else{
                $this->message = 'Login Failed';
            }
    }
        // load views
        require APP . 'view/_templates/header.php';
        
        require APP . 'view/home/login.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
    *   Function to preform sighnup on the web app. If the signup form as been posted
    *
    *
    */
    public function signup()
    {
        $this->message = 'Please Enter all required information.';
        if(isset($_REQUEST['email'])){
            //create a random salt to add to password
            $salt = bin2hex(openssl_random_pseudo_bytes(64));
            // add the salt to the password and hash useing sah512 creating a 128 charicter password
            $password = hash('sha512',$_REQUEST['pass'].$salt);
            //add all user signup data to the array 
            $info = array($_REQUEST['email'], $password, 0, null, $_SERVER['REMOTE_ADDR'], $_REQUEST['organization'],$salt,1);

            //insert the data to the database and return to home on success
            if($this->userModel->SelectUserByEmail($_REQUEST['email'])==0){
                $this->userModel->addUser($info);
                header('location: /');
            }else{
                $this->message = 'This Account Email Address already Exists.';
            }   
         }

        // load views
        require APP . 'view/_templates/header.php';
        
        require APP . 'view/home/signup.php';
        require APP . 'view/_templates/footer.php';
    }


    /**
     * PAGE: exampleone
     * This method handles what happens when you move to http://yourproject/home/exampleone
     * The camelCase writing is just for better readability. The method name is case-insensitive.
     */
    

    public function logOut(){
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        header('location: /home');
    }//end logout
    
    public function testPage(){
        $count;
        $enzymeModel = $this->loadModel('enzyme');
        $enzymes_array = Array(
"AasI" => array("AasI,DrdI,DseDI","GACNN_NN'NNGTC","(GAC......GTC)",12,7,-2,6),
"AatI" => array("AatI,Eco147I,PceI,SseBI,StuI","AGG'CCT","(AGGCCT)",6,3,0,6),
"AatII" => array("AatII","G_ACGT'C","(GACGTC)",6,5,-4,6),
"AbsI" => array("AbsI","CC'TCGA_GG","(CCTCGAGG)",8,6,-4,8),
"Acc16I" => array("Acc16I,AviII,FspI,NsbI","TGC'GCA","(TGCGCA)",6,3,0,6),
"Acc65I" => array("Acc65I,Asp718I","G'GTAC_C","(GGTACC)",6,1,4,6),
"AccB1I" => array("AccB1I,BanI,BshNI,BspT107I","G'GYRC_C","(GGCACC|GGCGCC|GGTACC|GGTGCC)",6,1,4,6),
"AccB7I" => array("AccB7I,BasI,PflMI,Van91I","CCAN_NNN'NTGG","(CCA.....TGG)",11,7,-3,6),
"AccBSI" => array("AccBSI,BsrBI,MbiI","CCG'CTC","(CCGCTC|GAGCGG)",6,3,0,6),
"AccI" => array("AccI,FblI,XmiI","GT'MK_AC","(GTCTAC|GTCGAC|GTATAC|GTAGAC)",6,2,2,6),
"AccII" => array("AccII,Bsh1236I,BspFNI,BstFNI,BstUI,MvnI","CG'CG","(CGCG)",4,2,0,4),
"AccIII" => array("AccIII,Aor13HI,BlfI,BseAI,Bsp13I,BspEI,Kpn2I,MroI","T'CCGG_A","(TCCGGA)",6,1,4,6),
"AciI" => array("AciI,BspACI,SsiI","C'CG_C or G'CG_G","(CCGC|GCGG)",4,1,2,4),
"AclI" => array("AclI,Psp1406I","AA'CG_TT","(AACGTT)",6,2,2,6),
"AcoI" => array("AcoI","Y'CCGG_R","(CCCGGA|CCCGGG|TCCGGA|TCCGGG)",6,1,4,6),
"AcsI" => array("AcsI,ApoI,XapI","R'AATT_Y","(AAATTC|AAATTT|GAATTC|GAATTT)",6,1,4,6),
"AcvI" => array("AcvI,BbrPI,Eco72I,PmaCI,PmlI,PspCI","CAC'GTG","(CACGTG)",6,3,0,6),
"AcyI" => array("AcyI,BsaHI,BssNI,BstACI,Hin1I,Hsp92I","GR'CG_YC","(GACGCC|GACGTC|GGCGCC|GGCGTC)",6,2,2,6),
"AdeI" => array("AdeI,DraIII","CAC_NNN'GTG","(CAC...GTG)",9,6,-3,6),
"AfaI" => array("AfaI,RsaI","GT'AC","(GTAC)",4,2,0,4),
"AfeI" => array("AfeI,Aor51HI,Eco47III","AGC'GCT","(AGCGCT)",6,3,0,6),
"AfiI" => array("AfiI,Bsc4I,BseLI,BsiYI,BslI","CCNN_NNN'NNGG","(CC.......GG)",11,7,-3,4),
"AflII" => array("AflII,BfrI,BspTI,Bst98I,BstAFI,MspCI,Vha464I","C'TTAA_G","(CTTAAG)",6,1,4,6),
"AflIII" => array("AflIII","A'CRYG_T","(ACACGT|ACATGT|ACGCGT|ACGTGT)",6,1,4,6),
"AgSI" => array("AgSI","TT_S'AA","(TTGAA|TTCAA)",5,3,-1,5),
"AgeI" => array("AgeI,AsiGI,BshTI,CspAI,PinAI","A'CCGG_T","(ACCGGT)",6,1,4,6),
"AhdI" => array("AhdI,AspEI,BmeRI,DriI,Eam1105I,EclHKI","GACNN_N'NNGTC","(GAC.....GTC)",11,6,-1,6),
"AhlI" => array("AhlI,BcuI,SpeI","A'CTAG_T","(ACTAGT)",6,1,4,6),
"AjiI" => array("AjiI,BmgBI,BtrI","CAC'GTC","(CACGTC|GACGTG)",6,3,0,6),
"AjnI" => array("AjnI,EcoRII,Psp6I,PspGI","'CCWGG_","(CCAGG|CCTGG)",5,0,5,5),
"AleI" => array("AleI,OliI","CACNN'NNGTG","(CAC....GTG)",10,5,0,6),
"AluI" => array("AluI,AluBI","AG'CT","(AGCT)",4,2,0,4),
"Alw21I" => array("Alw21I,BsiHKAI,Bbv12I","G_WGCW'C","(GAGCAC|GAGCTC|GTGCAC|GTGCTC)",6,5,-4,6),
"Alw44I" => array("Alw44I,ApaLI,VneI","G'TGCA_C","(GTGCAC)",6,1,4,6),
"AlwNI" => array("AlwNI,CaiI,PstNI","CAG_NNN'CTG","(CAG...CTG)",9,6,-3,6),
"Ama87I" => array("Ama87I,AvaI,BmeT110I,BsiHKCI,BsoBI,Eco88I","C'YCGR_G","(CCCGAG|CCCGGG|CTCGAG|CTCGGG)",6,1,4,6),
"ApaI" => array("ApaI","G_GGCC'C","(GGGCCC)",6,5,-4,6),
"ApeKI" => array("ApeKI,TseI","G'CWG_C","(GCAGC|GCTGC)",5,1,3,5),
"AscI" => array("AscI,PalAI,SgsI","GG'CGCG_CC","(GGCGCGCC)",8,2,4,8),
"AseI" => array("AseI,PshBI,VspI","AT'TA_AT","(ATTAAT)",6,2,2,6),
"AsiSI" => array("AsiSI,RgaI,SfaAI,SgfI","GCG_AT'CGC","(GCGATCGC)",8,5,-2,8),
"Asp700I" => array("Asp700I,MroXI,PdmI,XmnI","GAANN'NNTTC","(GAA....TTC)",10,5,0,6),
"AspA2I" => array("AspA2I,AvrII,BlnI,XmaJI","C'CTAG_G","(CCTAGG)",6,1,4,6),
"AspI" => array("AspI,PflFI,PsyI,Tth111I","GACN'N_NGTC","(GAC...GTC)",9,4,1,6),
"AspLEI" => array("AspLEI,BstHHI,CfoI,HhaI","G_CG'C","(GCGC)",4,3,-2,4),
"AspS9I" => array("AspS9I,BmgT120I,Cfr13I,PspPI,Sau96I","G'GNC_C","(GG.CC)",5,1,3,4),
"AssI" => array("AssI,BmcAI,ScaI,ZrmI","AGT'ACT","(AGTACT)",6,3,0,6),
"AsuC2I" => array("AsuC2I,BcnI,BpuMI,NciI","CC'S_GG","(CCGGG|CCCGG)",5,2,1,5),
"AsuII" => array("AsuII,Bpu14I,Bsp119I,BspT104I,BstBI,Csp45I,NspV,SfuI","TT'CG_AA","(TTCGAA)",6,2,2,6),
"AsuNHI" => array("AsuNHI,BspOI,NheI","G'CTAG_C","(GCTAGC)",6,1,4,6),
"AvaII" => array("AvaII,Bme18I,Eco47I,SinI,VpaK11BI","G'GWC_C","(GGACC|GGTCC)",5,1,3,5),
"AxyI" => array("AxyI,Bse21I,Bsu36I,Eco81I","CC'TNA_GG","(CCT.AGG)",7,2,3,6),
"BaeGI" => array("BaeGI,BseSI,BstSLI","G_KGCM'C","(GGGCAC|GGGCCC|GTGCAC|GTGCCC)",6,5,-4,6),
"BalI" => array("BalI,MlsI,MluNI,MscI,Msp20I","TGG'CCA","(TGGCCA)",6,3,0,6),
"BamHI" => array("BamHI","G'GATC_C","(GGATCC)",6,1,4,6),
"BanII" => array("BanII,Eco24I,EcoT38I,FriOI","G_RGCY'C","(GAGCCC|GAGCTC|GGGCCC|GGGCTC)",6,5,-4,6),
"BanIII" => array("BanIII,Bsa29I,BseCI,BshVI,BspDI,BspXI,Bsu15I,BsuTUI,ClaI","AT'CG_AT","(ATCGAT)",6,2,2,6),
"BauI" => array("BauI","C'ACGA_G","(CACGAG)",6,1,4,6),
"BbeI" => array("BbeI,PluTI","G_GCGC'C","(GGCGCC)",6,5,-4,6),
"BbuI" => array("BbuI,PaeI,SphI","G_CATG'C","(GCATGC)",6,5,-4,6),
"BbvCI" => array("BbvCI","CC'TCA_GC or  GC'TGA_GG","(CCTCAGC|GCTGAGG)",7,2,3,7),
"BciT130I" => array("BciT130I,BseBI,BstNI,BstOI,Bst2UI,MvaI","CC'W_GG","(CCAGG|CCTGG)",5,2,1,5),
"BclI" => array("BclI,FbaI,Ksp22I","T'GATC_A","(TGATCA)",6,1,4,6),
"BfaI" => array("BfaI,FspBI,MaeI,XspI","C'TA_G","(CTAG)",4,1,2,4),
"BfmI" => array("BfmI,BpcI,BstSFI,SfcI","C'TRYA_G","(CTACAG|CTATAG|CTGCAG|CTGTAG)",6,1,4,6),
"BfoI" => array("BfoI,BstH2I,HaeII","R_GCGC'Y","(AGCGCC|AGCGCT|GGCGCC|GGCGCT)",6,5,-4,6),
"BfuCI" => array("BfuCI,Bsp143I,BssMI,BstMBI,DpnII,Kzo9I,MboI,NdeII,Sau3AI","'GATC_","(GATC)",4,0,4,4),
"BglI" => array("BglI","GCCN_NNN'NGGC","(GCC.....GGC)",11,7,-3,6),
"BglII" => array("BglII","A'GATC_T","(AGATCT)",6,1,4,6),
"BisI" => array("BisI,BlsI,Fnu4HI,Fsp4HI,GluI,ItaI,SatI","GC'N_GC","(GC.GC)",5,2,1,4),
"BlpI" => array("BlpI,Bpu1102I,Bsp1720I,CelII","GC'TNA_GC","(GCT.AGC)",7,2,3,6),
"Bme1390I" => array("Bme1390I,MspR9I,ScrFI","CC'N_GG","(CC.GG)",5,2,1,4),
"BmiI" => array("BmiI,BspLI,NlaIV,PspN4I","GGN'NCC","(GG..CC)",6,3,0,4),
"BmrFI" => array("BmrFI,BssKI,BstSCI,StyD4I","'CCNGG_","(CC.GG)",5,0,5,4),
"BmtI" => array("BmtI","G_CTAG'C","(GCTAGC)",6,5,-4,6),
"BoxI" => array("BoxI,PshAI,BstPAI","GACNN'NNGTC","(GAC....GTC)",10,5,0,6),
"BptI" => array("BptI","CC'W_GG","(CCAGG|CCTGG)",5,2,1,5),
"Bpu10I" => array("Bpu10I","CC'TNA_GC","(CCT.AGC|GCT.AGG)",7,2,3,6),
"BpvUI" => array("BpvUI,MvrI,PvuI,Ple19I","CG_AT'CG","(CGATCG)",6,4,-2,6),
"BsaAI" => array("BsaAI,BstBAI,Ppu21I","YAC'GTR","(CACGTA|CACGTG|TACGTA|TACGTG)",6,3,0,6),
"BsaBI" => array("BsaBI,Bse8I,BseJI,MamI","GATNN'NNATC","(GAT....ATC)",10,5,0,6),
"BsaJI" => array("BsaJI,BseDI,BssECI","C'CNNG_G","(CC..GG)",6,1,4,4),
"BsaWI" => array("BsaWI","W'CCGG_W","(ACCGGA|ACCGGT|TCCGGA|TCCGGT)",6,1,4,6),
"Bse118I" => array("Bse118I,BsrFI,BssAI,Cfr10I","R'CCGG_Y","(ACCGGC|ACCGGT|GCCGGC|GCCGGT)",6,1,4,6),
"BsePI" => array("BsePI,BssHII,PauI,PteI","G'CGCG_C","(GCGCGC)",6,1,4,6),
"BseX3I" => array("BseX3I,BstZI,EagI,EclXI,Eco52I","C'GGCC_G","(CGGCCG)",6,1,4,6),
"BseYI" => array("BseYI","C'CCAG_C","(CCCAGC|GCTGGG)",6,1,4,6),
"Bsh1285I" => array("Bsh1285I,BsiEI,BstMCI","CG_RY'CG","(CGACCG|CGATCG|CGGCCG|CGGTCG)",6,4,-2,6),
"BshFI" => array("BshFI,BsnI,BspANI,BsuRI,HaeIII,PhoI","GG'CC","(GGCC)",4,2,0,4),
"BsiSI" => array("BsiSI,HapII,HpaII,MspI","C'CG_G","(CCGG)",4,1,2,4),
"BsiWI" => array("BsiWI,Pfl23II,PspLI","C'GTAC_G","(CGTACG)",6,1,4,6),
"Bsp120I" => array("Bsp120I,PspOMI","G'GGCC_C","(GGGCCC)",6,1,4,6),
"Bsp1286I" => array("Bsp1286I,MhlI,SduI","G_DGCH'C","(GAGCAC|GAGCTC|GAGCCC|GTGCAC|GTGCTC|GTGCCC|GGGCAC|GGGCTC|GGGCCC)",6,5,-4,6),
"Bsp1407I" => array("Bsp1407I,BsrGI,BstAUI,SspBI","T'GTAC_A","(TGTACA)",6,1,4,6),
"Bsp19I" => array("Bsp19I,NcoI","C'CATG_G","(CCATGG)",6,1,4,6),
"Bsp68I" => array("Bsp68I,BtuMI,NruI,RruI","TCG'CGA","(TCGCGA)",6,3,0,6),
"BspHI" => array("BspHI,CciI,PagI,RcaI","T'CATG_A","(TCATGA)",6,1,4,6),
"BspLU11I" => array("BspLU11I,PciI,PscI","A'CATG_T","(ACATGT)",6,1,4,6),
"BspMAI" => array("BspMAI,PstI","C_TGCA'G","(CTGCAG)",6,5,-4,6),
"BssNAI" => array("BssNAI,Bst1107I,BstZ17I","GTA'TAC","(GTATAC)",6,3,0,6),
"BssSI" => array("BssSI,Bst2BI","C'ACGA_G or C'TCGT_G","(CACGAG|CTCGTG)",6,1,4,6),
"BssT1I" => array("BssT1I,StyI,Eco130I,EcoT14I,ErhI","C'CWWG_G","(CCAAGG|CCATGG|CCTAGG|CCTTGG)",6,1,4,6),
"Bst4CI" => array("Bst4CI,HpyCH4III,TaaI","AC_N'GT","(AC.GT)",5,3,-1,4),
"BstAPI" => array("BstAPI","GCAN_NNN'NTGC","(GCA.....TGC)",11,7,-3,6),
"BstC8I" => array("BstC8I,Cac8I","GCN'NGC","(GC..GC)",6,3,0,4),
"BstDEI" => array("BstDEI,DdeI,HpyF3I","C'TNA_G","(CT.AG)",5,1,3,4),
"BstDSI" => array("BstDSI,BtgI","C'CRYG_G","(CCACGG|CCATGG|CCGCGG|CCGTGG)",6,1,4,6),
"BstEII" => array("BstEII,BstPI,Eco91I,EcoO65I,PspEI","G'GTNAC_C","(GGT.ACC)",7,1,5,6),
"BstENI" => array("BstENI,EcoNI,XagI","CCTNN'N_NNAGG","(CCT.....AGG)",11,5,1,6),
"BstKTI" => array("BstKTI","G_AT'C","(GATC)",4,3,2,4),
"BstMWI" => array("BstMWI,MwoI","GCNN_NNN'NNGC","(GC.......GC)",11,7,-3,4),
"BstNSI" => array("BstNSI,NspI,XceI","R_CATG'Y","(ACATGC|ACATGT|GCATGC|GCATGT)",6,5,-4,6),
"BstSNI" => array("BstSNI,Eco105I,SnaBI","TAC'GTA","(TACGTA)",6,3,0,6),
"BstX2I" => array("BstX2I,BstYI,MflI,PsuI,XhoII","R'GATC_Y","(AGATCC|AGATCT|GGATCC|GGATCT)",6,1,4,6),
"BstXI" => array("BstXI","CCAN_NNNN'NTGG","(CCA......TGG)",12,8,-4,6),
"CciNI" => array("CciNI,NotI","GC'GGCC_GC","(GCGGCCGC)",8,2,4,8),
"Cfr42I" => array("Cfr42I,KspI,SacII,Sfr303I,SgrBI,SstII","CC_GC'GG","(CCGCGG)",6,4,-2,6),
"Cfr9I" => array("Cfr9I,TspMI,XmaI,XmaCI","C'CCGG_G","(CCCGGG)",6,1,4,6),
"CfrI" => array("CfrI,EaeI","Y'GGCC_R","(CGGCCA|CGGCCG|TGGCCA|TGGCCG)",6,1,4,6),
"CpoI" => array("CpoI,CspI,RsrII,Rsr2I","CG'GWC_CG","(CGGACCG|CGGTCCG)",7,2,3,7),
"CsiI" => array("CsiI,MabI,SexAI","A'CCWGG_T","(ACCAGGT|ACCTGGT)",7,1,5,7),
"Csp6I" => array("Csp6I,CviQI,RsaNI","G'TA_C","(GTAC)",4,1,2,4),
"CviAII" => array("CviAII,FaeI,Hin1II,Hsp92II,NlaIII","_CATG'","(CATG)",4,4,-4,4),
"CviJI" => array("CviJI,CviKI-1","RG'CY","(AGCC|AGCT|GGCC|GGCT)",4,2,0,4),
"DinI" => array("DinI,Mly113I,NarI,SspDI","GG'CG_CC","(GGCGCC)",6,2,2,6),
"DpnI" => array("DpnI,MalI","GA'TC","(GATC)",4,2,0,4),
"DraI" => array("DraI","TTT'AAA","(TTTAAA)",6,3,0,6),
"Ecl136II" => array("Ecl136II,Eco53kI,EcoICRI","GAG'CTC","(GAGCTC)",6,3,0,6),
"Eco32I" => array("Eco32I,EcoRV","GAT'ATC","(GATATC)",6,3,0,6),
"EcoO109I" => array("EcoO109I,DraII","RG'GNC_CY","(AGG.CCC|AGG.CCT|GGG.CCC|GGG.CCT)",7,2,3,6),
"EcoRI" => array("EcoRI","G'AATT_C","(GAATTC)",6,1,4,6),
"EcoT22I" => array("EcoT22I,Mph1103I,NsiI,Zsp2I","A_TGCA'T","(ATGCAT)",6,5,-4,6),
"EgeI" => array("EgeI,EheI,SfoI","GGC'GCC","(GGCGCC)",6,3,0,6),
"FaiI" => array("FaiI","YA'TR","(CATA|CATG|TATA|TATG)",4,2,0,4),
"FatI" => array("FatI","'CATG_","(CATG)",4,0,4,4),
"FauNDI" => array("FauNDI,NdeI","CA'TA_TG","(CATATG)",6,2,2,6),
"FseI" => array("FseI,RigI","GG_CCGG'CC","(GGCCGGCC)",8,6,-4,8),
"FspAI" => array("FspAI","RTGC'GCAY","(ATGCGCAC|ATGCGCAT|GTGCGCAC|GTGCGCAT)",8,4,0,8),
"GlaI" => array("GlaI","GC'GC","(GCGC)",4,2,0,4),
"GsaI" => array("GsaI","C_CCAG'C","(CCCAGC|GCTGGG)",6,5,-4,6),
"Hin6I" => array("Hin6I,HinP1I,HspAI","G'CG_C","(GCGC)",4,1,2,4),
"HincII" => array("HincII,HindII","GTY'RAC","(GTCAAC|GTCGAC|GTTAAC|GTTGAC)",6,3,0,6),
"HindIII" => array("HindIII","A'AGCT_T","(AAGCTT)",6,1,4,6),
"HinfI" => array("HinfI","G'ANT_C","(GA.TC)",5,1,3,4),
"HpaI" => array("HpaI,KspAI","GTT'AAC","(GTTAAC)",6,3,0,6),
"Hpy166II" => array("Hpy166II,Hpy8I","GTN'NAC","(GT..AC)",6,3,0,4),
"Hpy188I" => array("Hpy188I","TC_N'GA","(TC.GA)",5,3,-1,4),
"Hpy188III" => array("Hpy188III","TC'NN_GA","(TC..GA)",6,2,2,4),
"Hpy99I" => array("Hpy99I","_CGWCG'","(CGACG|CGTCG)",5,5,-5,5),
"HpyCH4IV" => array("HpyCH4IV,HpySE526I,MaeII","A'CG_T","(ACGT)",4,1,2,4),
"HpyCH4V" => array("HpyCH4V","TG'CA","(TGCA)",4,2,0,4),
"HpyF10VI" => array("HpyF10VI","GCNN_NNN'NNGC","(GC.......GC)",11,7,-3,4),
"KasI" => array("KasI","G'GCGC_C","(GGCGCC)",6,1,4,6),
"KflI" => array("KflI,","GG'GWC_CC","(GGGACCC|GGGTCCC)",7,2,3,7),
"KpnI" => array("KpnI","G_GTAC'C","(GGTACC)",6,5,-4,6),
"KroI" => array("KroI,MroNI,NgoMIV","G'CCGG_C","(GCCGGC)",6,1,4,6),
"MaeIII" => array("MaeIII","'GTNAC_","(GT.AC)",5,0,5,4),
"MauBI" => array("MauBI","CG'CGCG_CG","(CGCGCGCG)",8,2,4,8),
"MfeI" => array("MfeI,MunI","C'AATT_G","(CAATTG)",6,1,4,6),
"MluCI" => array("MluCI,Sse9I,TasI,Tsp509I,TspEI","'AATT_","(AATT)",4,0,4,4),
"MluCI" => array("MluCI,Sse9I,TasI,Tsp509I,TspEI","'AATT_","(AATT)",4,0,4,4),
"MluI" => array("MluI","A'CGCG_T","(ACGCGT)",6,1,4,6),
"MreI" => array("MreI","CG'CCGG_CG","(CGCCGGCG)",8,2,4,8),
"MseI" => array("MseI,SaqAI,Tru1I,Tru9I","T'TA_A","(TTAA)",4,1,2,4),
"MslI" => array("MslI,RseI,SmiMI","CAYNN'NNRTG","(CAC....ATG|CAC....GTG|CAT....ATG|CAT....GTG)",10,5,0,6),
"MspA1I" => array("MspA1I","CMG'CKG","(CAGCGG|CAGCTG|CCGCGG|CCGCTG)",6,3,0,6),
"MssI" => array("MssI,PmeI","GTTT'AAAC","(GTTTAAAC)",8,4,0,8),
"NaeI" => array("NaeI,PdiI","GCC'GGC","(GCCGGC)",6,3,0,6),
"NmuCI" => array("NmuCI,TseFI,Tsp45I","'GTSAC_","(GTCAC|GTGAC)",5,0,5,5),
"PacI" => array("PacI","TTA_AT'TAA","(TTAATTAA)",8,5,-2,8),
"PaeR7I" => array("PaeR7I,Sfr274I,SlaI,StrI,TliI,XhoI","C'TCGA_G","(CTCGAG)",6,1,4,6),
"PasI" => array("PasI","CC'CWG_GG","(CCCAGGG|CCCTGGG)",7,2,3,7),
"PcsI" => array("PcsI","WCGNNN_N'NNNCGW","(ACG.......CGA|ACG.......CGT|TCG.......CGA|TCG.......CGT)",13,7,-1,6),
"PfeI" => array("PfeI,TfiI","G'AWT_C","(GAATC|GATTC)",5,1,3,5),
"PfoI" => array("PfoI","T'CCNGG_A","(TCC.GGA)",7,1,5,6),
"PpuMI" => array("PpuMI,Psp5II,PspPPI","RG'GWC_CY","(AGGACCC|AGGACCT|AGGTCCC|AGGTCCT|GGGACCC|GGGACCT|GGGTCCC|GGGTCCT)",7,2,3,7),
"PsiI" => array("AanI,PsiI","TTA'TAA","(TTATAA)",6,3,0,6),
"Psp124BI" => array("Psp124BI,SacI,SstI","G_AGCT'C","(GAGCTC)",6,5,-44,6),
"PspXI" => array("PspXI","VC'TCGA_GB","(ACTCGAGC|ACTCGAGG|ACTCGAGT|CCTCGAGC|CCTCGAGG|CCTCGAGT|GCTCGAGC|GCTCGAGG|GCTCGAGT)",8,2,4,8),
"PvuII" => array("PvuII","CAG'CTG","(CAGCTG)",6,3,0,6),
"SalI" => array("SalI","G'TCGA_C","(GTCGAC)",6,1,4,6),
"SbfI" => array("SbfI,SdaI,Sse8387I","CC_TGCA'GG","(CCTGCAGG)",8,6,-4,8),
"SetI" => array("SetI","_ASST'","(AGGT|AGCT|ACGT|ACCT)",4,4,-4,4),
"SfiI" => array("SfiI","GGCCN_NNN'NGGCC","(GGCC.....GGCC)",13,8,-3,8),
"SgrAI" => array("SgrAI","CR'CCGG_YG","(CACCGGCG|CACCGGTG|CGCCGGCG|CGCCGGTG)",8,2,4,8),
"SgrDI" => array("SgrDI","CG'TCGA_CG","(CGTCGACG)",8,2,4,8),
"SmaI" => array("SmaI","CCC'GGG","(CCCGGG)",6,3,0,6),
"SmiI" => array("SmiI,SwaI","ATTT'AAAT","(ATTTAAAT)",8,4,0,8),
"SmlI" => array("SmlI,SmoI","C'TYRA_G","(CTCAAG|CTCGAG|CTTAAG|CTTGAG)",6,1,4,6),
"SrfI" => array("SrfI","GCCC'GGGC","(GCCCGGGC)",8,4,0,8),
"SspI" => array("SspI","AAT'ATT","(AATATT)",6,3,0,6),
"TaiI" => array("TaiI","_ACGT'","(ACGT)",4,4,-4,4),
"TaqI" => array("TaqI","T'CG_A","(TCGA)",4,1,2,4),
"TatI" => array("TatI","W'GTAC_W","(AGTACA|AGTACT|TGTACA|TGTACT)",6,1,4,6),
"TauI" => array("TauI","G_CSG'C","(GCCGC|GCGGC)",5,4,-3,5),
"TscAI" => array("TscAI,TspRI","_NNCASTGNN'","(..CACTG..|..CAGTG..)",9,9,-9,5),
"XbaI" => array("XbaI","T'CTAG_A","(TCTAGA)",6,1,4,6),
"XcmI" => array("XcmI","CCANNNN_N'NNNNTGG","(CCA.........TGG)",15,8,-1,6),
"ZraI" => array("ZraI","GAC'GTC","(GACGTC)",6,3,0,6),
);

            foreach($enzymes_array as $key => $value){
                $enzymeInfo[] = array($key, $value[0], $value[1],$value[2],$value[3],$value[4],$value[5],$value[6]);
            };

            foreach($enzymeInfo as $enzymeInfo){
                $count += $enzymeModel->addEnzymes($enzymeInfo);
            }
            echo $count; 
        
        

    }//end test page

    public function redirectTest(){
        Helper::outputArray($_SESSION);
    }

}// end class
