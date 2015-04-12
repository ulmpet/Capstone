<?php
class cut
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

    function insertCuts($data){
        //echo print_r($data);
        $sql = "INSERT INTO cutsTable (PhageID,EnzymeID,CutCount,CutLocations) VALUES (:PhageID,:EnzymeID,:CutCount,:CutLocations)";
        $query = $this->db->prepare($sql);
        foreach ($data as $key => $value) {        
        $params = array(':PhageID' => $value[0],':EnzymeID' => $value[1],':CutCount' => $value[2],':CutLocations' => $value[3]);
        $query->execute($params);
        }
    }

    function insertMassCuts($data){
                $null = null;
        $sql = "REPLACE INTO cutsTable (PhageID,EnzymeID,CutCount,CutLocations) VALUES ";
        $qpart = array_fill(0,(count($data[1])-1) *count($data),"(?,?,?,?)");
        $sql .= implode(",",$qpart);
        //$sql .= "ON DUPLICATE KEY IGNORE ";//UPDATE CutCount=VALUES(CutCount), CutLocations=VALUES(CutLocations)";
        $query = $this->db->prepare($sql);
        $i =1;
        //echo $sql;
        foreach($data as $entryset){
            foreach ($entryset as $key => $value) {
            //echo $key . " : " . $value . "<br>";
                if ($key != 'PhageName') {
                    //echo " " . $entryset['PhageName'] .", ".$key.", ". $value.", ". $null ." <br>";
                    $query->bindValue($i++, $entryset['PhageName']);
                    $query->bindValue($i++, $key);
                    $query->bindValue($i++, $value);
                    $query->bindValue($i++, $null);
                }
            }
        }
        //echo $sql;
        return $query->execute();
    }

    function insertNebCuts($data,$phageID){
        //echo "here <br>";
        //Helper::outputArray($data);
        $null = null;
        $sql = "REPLACE INTO cutsTable (PhageID,EnzymeID,CutCount,CutLocations) VALUES ";
        $qpart = array_fill(0,count($data),"(?,?,?,?)");
        $sql .= implode(",",$qpart);
        //$sql .= "ON DUPLICATE KEY IGNORE ";//UPDATE CutCount=VALUES(CutCount), CutLocations=VALUES(CutLocations)";
        $query = $this->db->prepare($sql);
        $i =1;
        foreach($data as $key => $value){
            echo $key . " : " . $value . "<br>";
            $query->bindValue($i++, $phageID);
            $query->bindValue($i++, $key);
            $query->bindValue($i++, $value);
            $query->bindValue($i++, $null);
        }
        //echo $sql;
        return $query->execute();
    }

    function selectCuts($phageArray, $enzymeArray,$ranges = null){
        $phages = implode(',', array_fill(0, count($phageArray), '?'));
        $enzymes = implode(',', array_fill(0, count($enzymeArray), '?'));
        $sql = "SELECT p.PhageName, g.Genus, e.EnzymeName, c.Cluster, p.Subcluster, ct.CutCount from cutsTable ct 
                LEFT JOIN phageTable as p on p.PhageID = ct.PhageID
                LEFT JOIN enzymeTable as e on e.EnzymeID = ct.EnzymeID
                LEFT JOIN clusterTable as c on p.ClusterID = c.ClusterID
                LEFT JOIN genusTable as g on p.GenusID = g.GenusID
                WHERE ct.PhageID in (" . $phages .") AND ct.EnzymeID in (" . $enzymes .")";
        if(!is_null($ranges)){
            $sql .= "and ((ct.CutCount between ";
            $qpart = array_fill(0, count($ranges), "? and ?");
            $sql .= implode(") or  ( ct.CutCount between ", $qpart) ."))";
            echo $sql;
        }
        $query = $this->db->prepare($sql);
        $i=1;
        foreach ($phageArray as $key => $value) {
            $query->bindValue($i++, $value);
        }
        foreach ($enzymeArray as $key => $value) {
            $query->bindValue($i++, $value);
        }
        if(!is_null($ranges)){
            foreach($ranges as $k => $v){
                $query->bindParam($i++, $v[0], PDO::PARAM_INT);
                $query->bindParam($i++, $v[1], PDO::PARAM_INT);
            }
        }
        $query->execute();
        return $query->fetchAll();
    }
}