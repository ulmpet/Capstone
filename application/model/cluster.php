<?php
class cluster
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

    function getClusterList(){
        $sql ="select * from clusterTable";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    function addCluster($newCluster){
        $sql ="INSERT into clusterTable (Cluster) VALUES (:ClusterName);";
        $query = $this->db->prepare($sql);
        $paramaters = array(':ClusterName' => $newCluster);
        //Helper::outputArray($paramaters);
        return $query->execute($paramaters);
    }
}