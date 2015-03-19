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
    /*
    * Selects all rows in the userTable
    * returns a 2 dimentional array where the primary index is the row number and the secondarty indicies are the colomn names
    * ie. $MyArray[RowNumber][ColomnName]
    */
    public function selectAllUsers(){
        
        $sql ="select * from userTable";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAdmin(){
        $sql ="select EmailAddress from userTable WHERE AuthLevel = 1;";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /*
    * Selects UserID in the userTable matching the given email address. 
    * @param
    * @return an Integer representing the number of rows with that email address.
    */
    public function selectUserByEmail($email){
        $sql ="select UserID from userTable WHERE EmailAddress = :email;";
        $query = $this->db->prepare($sql);
        $parameters = array(':email'=>$email);
        $query->execute($parameters);
        return count($query->fetchAll());
    }

    /*
    * Selects active users with matching emailAddress and Password
    * 
    * @param $userEmail a users email address
    * @param $userPassword  a SHA512 hashed and salted password
    * @return a 2 dimentional arry where the primary index is the row number and the secondarty indicies are the colomn names
    * ie. $MyArray[RowNumber][ColomnName]
    */
    public function checkLogin($userEmail,$userPassword){
        $sql ="SELECT UserID FROM userTable WHERE EmailAddress = :userEmail AND Password = :userPassword AND Active=1;";
        $query = $this->db->prepare($sql);
        $parameters = array(':userEmail' => $userEmail, ':userPassword' => $userPassword);
        $query->execute($parameters);
        return $query->fetchAll();
    }
    /*
    *  Selects the authentication level of the user given by the user id passed to the function
    *  
    * @param $userID the user id of the user we are checking authentication level on.
    * @return a 2 dimentional arry where the primary index is the row number and the secondarty indicies are the colomn names
    * ie. $MyArray[RowNumeber][ColomnName]
    */
    public function checkAuth($userID){
        $sql = "SELECT AuthLevel FROM userTable WHERE UserID = :userID;";
        $query = $this->db->prepare($sql);
        $parameters = array(':userID' => $userID);
        $query->execute($parameters);
        return $query->fetchAll();
    }
    /*
    * Selects the Salt value of the given user email.
    *
    * @param $userEmail email address of the target user salt
    * @return the salt value for the given user.
    */
    public function getSalt($userEmail){
        $sql = "SELECT Salt FROM userTable WHERE EmailAddress = :userEmail;";
        $query = $this->db->prepare($sql);
        $parameters = array(':userEmail' => $userEmail);
        $query->execute($parameters);
        $output = $query->fetchAll();
        return $output[0]['Salt'];

    }
    /**
    *public function deactivateUser($userID){
    *$sql = "UPDATE userTable SET Active = 'false' WHERE UserID = :userID;"
    *
    *    $query = $this->db->preprae($sql);
    *
    *       $query->execute();
   * }
    */
}
