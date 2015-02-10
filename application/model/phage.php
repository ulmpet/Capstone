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

    /**
     * Get all songs from database
     */
    public function getAllPhage()
    {
        $sql = "SELECT * FROM phageTable";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    /**
     * Add a song to database
     * TODO put this explanation into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     */
    public function addPhage($phageData)
    {
        $sql = "INSERT INTO phageTable (PhageName,GenusID,ClusterID,SubclusterID,YearFound,DateFinished,Gnome) VALUES (:PhageName,:GenusID,:ClusterID,:SubclusterID,:YearFound,:DateFinished,:Gnome)";
        $query = $this->db->prepare($sql);
        $parameters = array(':PhageName' =>$phageData[0],':GenusID'=>$phageData[1],':ClusterID'=>$phageData[2],':SubclusterID'=>$phageData[3],':YearFound'=>$phageData[4],':DateFinished'=>$phageData[5],':Gnome'=>$phageData[6]);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Delete a song in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $song_id Id of song
     */
    public function deletePhage($phage_id)
    {
        $sql = "DELETE FROM phageTable WHERE id = :phage_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':phage_id' => $phage_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get a song from database
     */
    public function getPhage($phage_id)
    {
        $sql = "SELECT PhageName,GenusID,ClusterID,SubclusterID,YearFound,DateFinished,Gnome FROM phageTable WHERE id = :phage_id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':phage_id' => $phage_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch();
    }

    /**
     * Update a song in database
     * // TODO put this explaination into readme and remove it from here
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $song_id Id
     */
    public function updatePhage($phageData)
    {
        $sql = "UPDATE phageTable SET PhageName = :PhageName ,GenusID = :GenusID ,ClusterID = :ClusterID,SubclusterID=:SubclusterID WHERE phage_id = :phage_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':PhageName' => $phageData[0], ':GenusID' => $phageData[1], ':ClusterID' => $phageData[2], ':SubclusterID' => $phageData[3]);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/songs.php for more)
     */
    public function getAmountOfPhage()
    {
        $sql = "SELECT COUNT(phage_id) AS amount_of_phage FROM phageTable";
        $query = $this->db->prepare($sql);
        $query->execute();

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_phage;
    }
}
