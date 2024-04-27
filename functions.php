<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getPosts($conn){
    $posts = mysqli_query($conn, "SELECT * FROM `posts`");
    $postsList = [];

    while($post = mysqli_fetch_assoc($posts)) {
        $postsList[] = $post;
}

    echo json_encode($postsList);
}

function getPost($conn,$id){
    $post = mysqli_query($conn, "SELECT * FROM `posts` WHERE `id` = '$id'");

    if (mysqli_num_rows($post) < 1){
        http_response_code(404);
        $res = ["status" => false,"message" => "Todo not found"];

        echo json_encode($res);
    }else{
        $post = mysqli_fetch_assoc($post);

        echo json_encode($post);
    }
}

function addPost($conn,$data){

    $title = $data['title'];
    $body = $data['body'];

    mysqli_query($conn,"INSERT INTO `posts` (`id`, `title`, `body`) VALUES (NULL, '$title', '$body')");

    $res = ["status" => true, "post_id" => mysqli_insert_id($conn), "message" => "Todo succedsfully added!"];

    http_response_code(201);

    echo json_encode($res);
}

function updatePost($conn,$id,$data){

    $title = $data['title'];
    $body = $data['body'];

    mysqli_query($conn, "UPDATE `posts` SET `title` = '$title', `body` = '$body' WHERE `posts`.`id` = '$id'");


    $res = ["status" => true, "message" => "Todo succedsfully changed!"];

    http_response_code(200);

    echo json_encode($res);
}

function deletePost($conn, $id){
    mysqli_query($conn, "DELETE FROM `posts` WHERE `posts`.`id` = $id");

    $res = ["status" => true, "message" => "Todo succedsfully deleted!"];

    http_response_code(200);

    echo json_encode($res);
}