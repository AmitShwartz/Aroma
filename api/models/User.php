<?php
include_once 'Model.php';

class User extends Model {

    public function __construct($db, $columns = [])
    {
        parent::__construct($db, 'users', $columns);
    }

    // Create
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' . $this->table . ' SET ';
        $arguments = array();
        foreach ($this->columns as $key => $value) {
            array_push($arguments,$key.'= :'.$key);
        }
        $query .= implode(",", $arguments);

        //Prepare statement
        $statement = $this->conn->prepare($query);

        foreach ($this->columns as $key => $value) {
            // Clean data
            $this->columns[$key] = htmlspecialchars(strip_tags($value));
            // Bind data
            if($key == 'password'){
                // hash the password before saving to database
                $password_hash = password_hash($this->columns[$key], PASSWORD_BCRYPT);
                $statement->bindParam(':password', $password_hash);
            }else{
                $statement->bindParam(':' . $key, $this->columns[$key]);
            }

        }
        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    public function nameExists(){
        // query to check if name exists
        $query = "SELECT *
            FROM " . $this->table . "
            WHERE name = ?
            LIMIT 0,1";

        //Prepare statement
        $statement = $this->conn->prepare($query);
        // sanitize
        $this->columns['name']=htmlspecialchars(strip_tags($this->columns['name']));
        // Bind ID
        $statement->bindParam(1, $this->columns['name']);
        // Execute query
        $statement->execute();

        if($statement->rowCount()>0){
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // Set properties
            foreach ($row as $key=> $value){
                $this->columns[$key]= $value;
            }
            return true;
        }
        return false;
    }
}