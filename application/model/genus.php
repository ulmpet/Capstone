<?php
class genus
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

    function getGenusList(){
        $sql ="select * from genusTable";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function addGenus($newGenus){
        $sql ="INSERT into genusTable (GenusName) VALUES (:GenusName);";
        $query = $this->db->prepare($sql);
        $paramaters = array(':GenusName' => $newGenus);
        $query->execute();
        return $query->fetchAll();
    }
}