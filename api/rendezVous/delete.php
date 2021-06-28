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

 // Instantiate object
 $redezvous = new redezvous($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $redezvous->RDV_id = $data->RDV_id;

  // Delete post
  if($redezvous->delete()) {
    echo json_encode(
      array('message' => 'redez vous Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'redez vous Not Deleted')
    );
  }

