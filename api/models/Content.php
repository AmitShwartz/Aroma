<?php

class Content
{
    //DB
    private $conn;
    private $table = 'contents';

    //Message Properties
    public $id;
    public $title;
    public $info;
    public $active;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get content
    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table ;

        //Prepare statement
        $statement = $this->conn->prepare($query);

        //Execute query
        $statement->execute();

        return $statement;
    }

    // Get Single content
    public function read_single()
    {
        // Create query
        $query = 'SELECT *
            FROM ' . $this->table . ' c
            WHERE c.id = ?
            LIMIT 0,1';

        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Bind ID
        $statement->bindParam(1, $this->id);

        // Execute query
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->info = $row['info'];
        $this->title = $row['title'];
        $this->active = $row['active'];
    }

    // Create Content
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
         SET
         title = :title,
         info = :info';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Clean data security
        $this->info = htmlspecialchars(strip_tags($this->info));
        $this->title = htmlspecialchars(strip_tags($this->title));

        // Bind data
        $statement->bindParam(':info', $this->info);
        $statement->bindParam(':title', $this->title);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Update content
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
            SET info = :info,
             title = :title,
             active = :active
            WHERE id = :id';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Clean data
        $this->info = htmlspecialchars(strip_tags($this->info));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->active = htmlspecialchars(strip_tags($this->active));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $statement->bindParam(':info', $this->info);
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':active', $this->active);
        $statement->bindParam(':id', $this->id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Delete content
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