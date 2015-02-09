<?php
class user
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
     * Add user information into the userTable in the phage_enzyme_tool database
     * @param array $userInfo UserInfo
     */
    public function addUser(userInfo)
    {
        $sql = "INSERT INTO userTable (EmailAddress, Password, Root, VerificationValue, IPAdrress, Organization) VALUES (:EmailAddress, :Password, :Root, :VerificationValue, :IPAdrress, :Organization)";
        $query = $this->db->prepare($sql);
        $parameters = array(':EmailAddress' => $userInfo[0], ':Password' => $userInfo[1], ':Root' => $userInfo[2], ':VerificationValue' => $userInfo[3], ':IPAdrress' => $userInfo[4], ':Organization' => $userInfo[5]);

        $query->execute($parameters);
    }

}
