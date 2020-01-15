<?php

class Item
{
    //DB
    private $conn;
    private $table = 'items';

    //Item Properties
    public $id;
    public $title;
    public $description;
    public $category_id;
    public $image;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //get Items by category
    public function read()
    {
        $query = 'SELECT 
            c.title AS category_title,
            i.id,
            i.title,
            i.description,
            i.image,
            i.category_id    
         FROM ' . $this->table . ' i 
         LEFT JOIN
         categories c ON i.category_id = c.id
         ORDER BY i.title';

        //Prepare statement
        $statement = $this->conn->prepare($query);

        //Execute query
        $statement->execute();

        return $statement;
    }

    // Get Single Item
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
        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->image = $row['image'];
        $this->category_id = $row['category_id'];
    }

    // Get by category id
    public function read_by_category()
    {
        // Create query
        $query = 'SELECT 
            c.title AS category_title,
            i.id,
            i.title,
            i.description,
            i.image,
            i.category_id    
         FROM ' . $this->table . ' i 
         LEFT JOIN
         categories c ON i.category_id = c.id
            WHERE i.category_id = ?';

        //Prepare statement
        $statement = $this->conn->prepare($query);
        // Bind category_id
        $statement->bindParam(1, $this->category_id);
        //Execute query
        $statement->execute();

        return $statement;
    }

    // Create Item
    public function create()
    {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
         SET 
         title = :title, 
         description = :description, 
         image = :image, 
         category_id = :category_id';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Clean data security
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':description', $this->description);
        $statement->bindParam(':image', $this->image);
        $statement->bindParam(':category_id', $this->category_id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Update Item
    public function update()
    {
        // Create query
        $query = 'UPDATE ' . $this->table . '
            SET title = :title,
             description = :description,
              image = :image,
               category_id = :category_id
            WHERE id = :id';
        // Prepare statement
        $statement = $this->conn->prepare($query);

        // Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->image = htmlspecialchars(strip_tags($this->image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $statement->bindParam(':title', $this->title);
        $statement->bindParam(':description', $this->description);
        $statement->bindParam(':image', $this->image);
        $statement->bindParam(':category_id', $this->category_id);
        $statement->bindParam(':id', $this->id);

        // Execute query
        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s.\n", $statement->error);
        return false;
    }

    // Delete Item
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