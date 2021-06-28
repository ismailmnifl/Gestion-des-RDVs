<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/database.php';
  include_once '../../models/reservation.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $redezvous = new redezvous($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));


  $redezvous->timeSlot_id = $data->timeSlot_id;
  $redezvous->userID = $data->userID;
  $redezvous->date =  $data->date;
  $redezvous->subject = $data->subject;

  // Create post
  if($redezvous->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

