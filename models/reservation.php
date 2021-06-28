<?php 
  class redezvous {
    // DB stuff

    // rendezvous Properties
    public $RDV_id;
    public $timeSlot_id;
    public $userID;
    public $date;
    public $subject;
    

    //timeslot properties
    public $TimeSlot;
    public $TimeSlotID; 

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get reservation
    public function read() {
        // Create query
        $query = 'SELECT * FROM redezvous WHERE redezvous.userID = ?';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
  
        // Execute query
        $stmt->execute([$this->userID]);
  
        return $stmt;
    }

    public function getTimeSlote() {

      $query = "SELECT * FROM timeslot WHERE TimeSlotID not in (
        SELECT redezvous.timeSlot_id FROM redezvous 
        INNER JOIN  timeslot ON redezvous.timeSlot_id = timeslot.TimeSlotID
        WHERE redezvous.date = ?
        )";
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Execute query
      $stmt->execute([$this->date]);

      return $stmt;
    }


    public function create() {
        // Create query
        $query = 'INSERT INTO redezvous SET timeSlot_id = :timeSlot_id, userID = :userID, date = :date, subject = :subject';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        
        $this->timeSlot_id = htmlspecialchars(strip_tags($this->timeSlot_id));
        $this->LastName = htmlspecialchars(strip_tags($this->userID));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->subject = htmlspecialchars(strip_tags($this->subject));
        
        

        // Bind data
        
        $stmt->bindParam(':timeSlot_id', $this->timeSlot_id);
        $stmt->bindParam(':userID', $this->userID);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':subject', $this->subject);
       
        

        // Execute query
        if($stmt->execute()) {
          return true;
        }
    //generate random unique token 
    }

    public function delete() {
      // Create query
      $query = 'DELETE FROM redezvous WHERE RDV_id = ?';
    
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Execute query
      $stmt->execute([$this->RDV_id]);
    }
}