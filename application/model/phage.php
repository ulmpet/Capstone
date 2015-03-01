<?php
class phage
{
	 /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    function addFullPhage($phageArray){
        $sql = "INSERT INTO phageTable (PhageName, GenusID, ClusterID, SubclusterID, YearFound, DateFinished,Updated) 
                VALUES (:PhageName, :GenusID, :ClusterID, :SubclusterID, :YearFound, :DateFinished,:Genome,:Updated)";
        $query = $this->db->prepare($sql);
        $parameters = array(':PhageName' => $phageArray[0],
                            ':GenusID' => $phageArray[1],
                            ':ClusterID' => $phageArray[2],
                            ':SubclusterID' => $phageArray[3],
                            ':YearFound' => $phageArray[4],
                            ':DateFinished' => $phageArray[5],
                            ':Genome'=> $phageArray[6],
                            ':Updated'=> $phageArray[7]);

        return $query->execute($parameters);
    }

    function addShortPhage($phageArray,$type){
         set_time_limit(0);
        $sql = "INSERT INTO phageTable (PhageName, GenusID, ClusterID, SubclusterID,Updated) 
                VALUES (:PhageName, :GenusID, :ClusterID, :SubclusterID,:Updated)";
        $query = $this->db->prepare($sql);
        $lines =0;
        $success =0;
        foreach($phageArray as $phage=>$value){
            $lines +=1;
            $parameters = array(':PhageName' => $phage,
                            ':GenusID' => $type,
                            ':ClusterID' => $value[0],
                            ':SubclusterID' => $value[1],
                            ':Updated'=> date(MYSQL_DATE_FORMAT));
            if($query->execute($parameters)){
                $success+=1;
            }
            
                           
        }
        return  array($lines,$success);
    }
}