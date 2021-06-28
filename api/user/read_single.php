<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/database.php';
  include_once '../../models/user.php';

  // Instantiate DB & connect
  $database = new database();
  $db = $database->connect();

  // Instantiate blog post object
  $user = new user($db);


  // Get ID
  //$user->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
  $data = json_decode(file_get_contents("php://input"));
  $user->referance = $data->ref;
  // Get user
  $user->read_single();

  // Create array
  $post_arr = array(
    'userID' =>     $user->userID,
    'FirstName' =>  $user->FirstName,
     'LastName' =>   $user->LastName,
     'age' =>        $user->age,
     'referance' =>  $user->referance,
     'position' =>   $user->position
  );

  // Make JSON
  print_r(json_encode($post_arr));