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

    function getPhageNamesAndID(){
        $sql = "Select PhageID,PhageName from phageTable;";
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

    public function inputGenome($genomeInfo){
        //var_dump($genomeInfo);
        $sql = "UPDATE phageTable set Gnome=:Gnome where PhageName=:PhageName";
        $query = $this->db->prepare($sql);
        foreach($genomeInfo as $key => $value){
            $params = array(':PhageName' => $key, ':Gnome' => $value);
            $query->execute($params);
        }
        
    }

    public function getPhageDataForTool(){
        $sql = "SELECT p.PhageName,c.Cluster,g.Genus from phageTable as p
                LEFT JOIN clusterTable as c on p.ClusterID = c.ClusterID
                LEFT JOIN genusTable as g on p.GenusID = g.GenusID;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getSubClusterAssociations(){
        $sql = "SELECT distinct p.Subcluster,c.Cluster,c.ClusterID from phageTable as p
                LEFT JOIN clusterTable as c on p.ClusterID = c.ClusterID 
                Order by Cluster,Subcluster;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}