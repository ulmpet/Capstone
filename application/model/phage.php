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
        $sql = "INSERT INTO phageTable (PhageName, GenusID, ClusterID, Subcluster, YearFound, DateFinished,Updated) 
                VALUES (:PhageName, :GenusID, :ClusterID, :Subcluster, :YearFound, :DateFinished,:Genome,:Updated)";
        $query = $this->db->prepare($sql);
        $parameters = array(':PhageName' => $phageArray[0],
                            ':GenusID' => $phageArray[1],
                            ':ClusterID' => $phageArray[2],
                            ':Subcluster' => $phageArray[3],
                            ':YearFound' => $phageArray[4],
                            ':DateFinished' => $phageArray[5],
                            ':Genome'=> $phageArray[6],
                            ':Updated'=> $phageArray[7]);

        return $query->execute($parameters);
    }

    function addShortPhage($phageArray){
         set_time_limit(0);
        $sql = "INSERT INTO phageTable (PhageName, GenusID, ClusterID, Subcluster,Updated) 
                VALUES ";
        $qpart = array_fill(0, count($phageArray), "(?,?,?,?,?)");
        $sql .= implode(",",$qpart);
        $query = $this->db->prepare($sql);
        $i =1;
        foreach($phageArray as $item){
            $query->bindParam($i++, $item[0]);
            $query->bindParam($i++, $item[1]);
            $query->bindParam($i++, $item[2]);
            $query->bindParam($i++, $item[3]);
            $query->bindParam($i++, $item[4]);
        }
        return  $query->execute();
    }
}