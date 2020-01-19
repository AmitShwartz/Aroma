<?php
class Model
{
    // DB
    protected $conn;
    protected $table;

    // Properties
    public $columns;

    public function __construct($db, $table, $columns=[])
    {
        $this->conn = $db;
        $this->table = $table;
        $this->columns = $columns;
    }

    // Get All
    public function getAll()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table;
        // Prepare statement
        $statement = $this->conn->prepare($query);
        // Execute query
        $statement->execute();
        return $statement;
    }

    // Get Single
    public function getSingle()
    {
        // Create query
        $query = 'SELECT *
                  FROM
                  ' . $this->table . '
                  WHERE id = ?
                  LIMIT 0,1';
        //Prepare statement
        $statement = $this->conn->prepare($query);
        // Bind ID
        $statement->bindParam(1, $this->columns['id']);
        // Execute query
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set properties
        foreach ($row as $key=> $value){
            $this->columns[$key]= $value;
        }
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

        //    title = :title, image = :image';
        return $this->executeStatement($query);
    }

    // Update
    public function update()
    {
        // Create Query
        $query = 'UPDATE ' . $this->table . ' SET ';
        $arguments = array();
        foreach ($this->columns as $key => $value) {
            if($key == 'id') continue;
            array_push($arguments,$key.'= :'.$key);
        }
        $query .= implode(",", $arguments).' WHERE id = :id';

        return $this->executeStatement($query);
    }

    // Delete
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        // Prepare Statement
        $statement = $this->conn->prepare($query);
        // clean data
        $this->columns['id'] = htmlspecialchars(strip_tags($this->columns['id']));
        // Bind Data
        $statement->bindParam(':id', $this->columns['id']);
        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    protected function executeStatement($query){
        //Prepare statement
        $statement = $this->conn->prepare($query);

        foreach ($this->columns as $key => $value) {
            // Clean data
            $this->columns[$key] = htmlspecialchars(strip_tags($value));
            // Bind data
            $statement->bindParam(':' . $key, $this->columns[$key]);
        }
        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }
}