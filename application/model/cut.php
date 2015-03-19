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
}