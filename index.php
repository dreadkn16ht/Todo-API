<?php

//showing errors if there's any
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS"); // Allow specified HTTP methods
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization"); // Allow specified headers
header("Access-Control-Max-Age: 3600"); // Cache preflight response for 1 hour


// defining type of a site
header('Content-Type: application/json');

// getting important scripts
require "connect.php";
require "functions.php";

$method = $_SERVER['REQUEST_METHOD'];

//getting parameters from .htacces file
$q = isset($_GET['q']) ? $_GET['q'] : null;
// getting specific content with id from an api
$params = explode('/', $q);

// parameters for id and type
$type = $params[0];
$id = isset($params[1]) ? $params[1] : null;

if ($method === 'GET'){
   // handling requests
   if ($type === "api"){
      if (isset($id)){
         getPost($conn,$id);
      }else{
         getPosts($conn);
   }
   }
}elseif($method === 'POST'){
   if ($type === 'api'){
      addPost($conn, $_POST);
   }
}elseif($method === 'PATCH'){
   if ($type === 'api'){
      if (isset($id)){
         $data = file_get_contents('php://input');
         $data = json_decode($data, true);
         updatePost($conn,$id, $data);
      }
   }
}elseif($method === 'DELETE'){
   if($type === 'api'){
      if(isset($id)){
         deletePost($conn,$id);
      }
   }
}
