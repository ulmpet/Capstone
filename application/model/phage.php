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

    function getPhageNames(){
        $sql = "Select PhageName from phageTable;";
        $query  = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function addFullPhage($phageArray){
        $sql = "INSERT INTO phageTable (PhageName, GenusID, ClusterID, Subcluster, YearFound, DateFinished,Updated) 
                VALUES ";
        $qpart = array_fill(0,count($phageArray),"(?,?,?,?,?,?,?)");
        $sql .= implode(",",$qpart);
        $sql .= "ON DUPLICATE KEY UPDATE GenusID=VALUES(GenusID), ClusterID=VALUES(ClusterID), Subcluster=Values(Subcluster),YearFound=VALUES(YearFound), DateFinished=VALUES(DateFinished),Updated=VALUES(Updated)";
        $query = $this->db->prepare($sql);
        $i =1;
        foreach($phageArray as $item){
            $query->bindParam($i++, $item[0]);
            $query->bindParam($i++, $item[1]);
            $query->bindParam($i++, $item[2]);
            $query->bindParam($i++, $item[3]);
            $query->bindParam($i++, $item[4]);
            $query->bindParam($i++, $item[5]);
            $query->bindParam($i++, $item[6]);
        }
        return $query->execute();
    }

    function addShortPhage($phageArray){
        $sql = "INSERT INTO phageTable (PhageName, GenusID, ClusterID, Subcluster,Updated) 
                VALUES ";
        $qpart = array_fill(0, count($phageArray), "(?,?,?,?,?)");
        $sql .= implode(",",$qpart);
        $sql .= "ON DUPLICATE KEY UPDATE GenusID=VALUES(GenusID), ClusterID=VALUES(ClusterID), Subcluster=Values(Subcluster),Updated=VALUES(Updated)";
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