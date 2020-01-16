<?php

class Message
{
    //DB
    private $conn;
    private $table = 'messages';

    //Message Properties
    public $id;
    public $cause;
    public $content;
    public $responded;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get Messages by category
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table ;

        //Prepare statement
        $statement = $this->conn->prepare($query);

        //Execute query
        $statement->execute();

        return $statement;
    }

    // Get Single Message
    public function read_single()
    {
        // Create query
        $query = 'SELECT *
            FROM ' . $this->table . ' i
            WHERE i.id = ?
            LIMIT 0,1';

        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->id);

        // Execute query
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->content = $row['content'];
        $this->cause = $row['cause'];
        $this->responded = $row['responded'];
    }

    // Create Message
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
         SET
         content = :content,
         cause = :cause';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Clean data security
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->cause = htmlspecialchars(strip_tags($this->cause));

        // Bind data
        $statement->bindParam(':content', $this->content);
        $statement->bindParam(':cause', $this->cause);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Update Message
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
            SET 
             responded = :responded
            WHERE id = :id';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Clean data
        $this->responded = htmlspecialchars(strip_tags($this->responded));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $statement->bindParam(':responded', $this->responded);
        $statement->bindParam(':id', $this->id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Delete Message
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $statement->bindParam(':id', $this->id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }
}