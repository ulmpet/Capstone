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
    public function addUser($userInfo)
    {
        $sql = "INSERT INTO userTable (EmailAddress, Password, AuthLevel, VerificationValue, IPAddress, Organization,Salt,Active) VALUES (:EmailAddress, :Password, :Root, :VerificationValue, :IPAddress, :Organization,:Salt,:Active)";
        $query = $this->db->prepare($sql);
        $parameters = array(':EmailAddress' => $userInfo[0],
                            ':Password' => $userInfo[1],
                            ':Root' => $userInfo[2],
                            ':VerificationValue' => $userInfo[3],
                            ':IPAddress' => $userInfo[4],
                            ':Organization' => $userInfo[5],
                            ':Salt'=> $userInfo[6],
                            ':Active'=> $userInfo[7]);

        return $query->execute($parameters);
    }

    public function selectAllUsers(){
        
        $sql ="select * from userTable";
         $query = $this->db->prepare($sql);
        $query->execute();
         return $query->fetchAll();
    }

    public function selectUserByEmail($email){
        $sql ="select UserID from userTable WHERE EmailAddress = :email;";
         $query = $this->db->prepare($sql);
         $parameters = array(':email'=>$email);
        $query->execute($parameters);
         return count($query->fetchAll());
    }

    public function checkLogin($userEmail,$userPassword){
        $sql ="SELECT UserID FROM userTable WHERE EmailAddress = :userEmail AND Password = :userPassword AND Active=1;";
        $query = $this->db->prepare($sql);
        $parameters = array(':userEmail' => $userEmail, ':userPassword' => $userPassword);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function checkAuth($userID){
        $sql = "SELECT AuthLevel FROM userTable Where UserID = :userID;";
        $query = $this->db->prepare($sql);
        $parameters = array(':userID' => $userID);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getSalt($userEmail){
        $sql = "SELECT Salt from userTable WHERE EmailAddress = :userEmail;";
        $query = $this->db->prepare($sql);
        $parameters = array(':userEmail' => $userEmail);
        $query->execute($parameters);
        $output = $query->fetchAll();
        return $output[0]['Salt'];

    }
}
