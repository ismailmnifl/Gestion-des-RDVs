<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/database.php';
  include_once '../../models/user.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new user($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  
  $user->FirstName = $data->FirstName;
  $user->LastName = $data->LastName;
  $user->age = $data->age;
  $user->referance =  $user->generateToken();
  $user->position = $data->position;

  // Create post
  if($user->create()) {
    echo json_encode(
      array('message' => 'Post Created',
      "ref" => $user->referance )
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }

