<?php 
  class user {
    // DB stuff
    private $conn;
    private $table = 'user';

    // Post Properties
    public $userID;
    public $FirstName;
    public $LastName;
    public $age;
    public $referance;
    public $position;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM user';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT * FROM user WHERE user.referance = ?';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->referance);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->userID = $row['userID'];
          $this->FirstName = $row['FirstName'];
          $this->LastName = $row['LastName'];
          $this->age = $row['age'];
          $this->referance = $row['referance'];
          $this->position = $row['position'];
    }

    
    // Create Post
    public function create() {
        // Create query
        $query = 'INSERT INTO user SET FirstName = :FirstName, LastName = :LastName, age = :age, referance = :referance, position = :position';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        
        $this->FirstName = htmlspecialchars(strip_tags($this->FirstName));
        $this->LastName = htmlspecialchars(strip_tags($this->LastName));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->referance = htmlspecialchars(strip_tags($this->referance));
        $this->position = htmlspecialchars(strip_tags($this->position));
        
        

        // Bind data
        
        $stmt->bindParam(':FirstName', $this->FirstName);
        $stmt->bindParam(':LastName', $this->LastName);
        $stmt->bindParam(':age', $this->age);
        $stmt->bindParam(':referance', $this->referance);
        $stmt->bindParam(':position', $this->position);
        

        // Execute query
        if($stmt->execute()) {
          return true;
    }
    //generate random unique token 
    }
   


    public function update() {
      // Create query
      $query = 'UPDATE user
                            SET FirstName = :FirstName, LastName = :LastName, age = :age, position = :position
                            WHERE userID = :userID';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->FirstName = htmlspecialchars(strip_tags($this->FirstName));
      $this->LastName = htmlspecialchars(strip_tags($this->LastName));
      $this->age = htmlspecialchars(strip_tags($this->age));
      //$this->referance = htmlspecialchars(strip_tags($this->referance));
      $this->position = htmlspecialchars(strip_tags($this->position));
      $this->userID = htmlspecialchars(strip_tags($this->userID));

      // Bind data
      $stmt->bindParam(':FirstName', $this->FirstName);
      $stmt->bindParam(':LastName', $this->LastName);
      $stmt->bindParam(':age', $this->age);
      //$stmt->bindParam(':referance', $this->referance);
      $stmt->bindParam(':position', $this->position);
      $stmt->bindParam(':userID', $this->userID);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
}
public function delete() {
  // Create query
  $query = 'DELETE FROM user WHERE userID = :userID';

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->userID = htmlspecialchars(strip_tags($this->userID));

  // Bind data
  $stmt->bindParam(':userID', $this->userID);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}

    //get user token 
    public function lastInserted() {

      $query = 'SELECT referance FROM user ORDER BY userID DESC LIMIT 1;';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      return $row['referance'];
    }

    public function generateToken() {

      $token = md5(uniqid(rand(), true));
      return $token;

    }
   
}