<?php

class Category
{
    // DB
    private $conn;
    private $table = 'categories';

    // Properties
    public $id;
    public $title;
    public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get categories
    public function read()
    {
        // Create query
        $query = 'SELECT id, title, image
            FROM ' . $this->table;

        // Prepare statement
        $statement = $this->conn->prepare($query);
        // Execute query
        $statement->execute();
        return $statement;
    }

    // Get Single Category
    public function read_items()
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
        $statement->bindParam(1, $this->id);
        // Execute query
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        // set properties
        $this->id = $row['id'];
        $this->title = $row['title'];
        $this->image = $row['image'];
    }

    // Create Category
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' .
            $this->table . '
        SET title = :title, image = :image';

        // Prepare Statement
        $statement = $this->conn->prepare($query);
        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->image = htmlspecialchars(strip_tags($this->image));
        // Bind data
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':image', $this->image);
        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Update Category
    public function update()
    {
        // Create Query
        $query = 'UPDATE ' .
            $this->table . '
           SET title = :title, image = :image
           WHERE id = :id';
        // Prepare Statement
        $statement = $this->conn->prepare($query);
        // Clean data
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Bind data
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':image', $this->image);
        $statement->bindParam(':id', $this->id);
        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Delete Category
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        // Prepare Statement
        $statement = $this->conn->prepare($query);
        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Bind Data
        $statement->bindParam(':id', $this->id);
        // Execute query
        if ($statement->execute()) {
            return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $statement->error);
        return false;
    }
}