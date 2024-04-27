<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function getPosts($conn){
    $stmt = $conn->prepare("SELECT * FROM `posts`");
    $stmt->execute();
    $postsList = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($postsList);
}

function getPost($conn, $id){
    $stmt = $conn->prepare("SELECT * FROM `posts` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $post = $stmt->get_result()->fetch_assoc();

    if (!$post) {
        http_response_code(404);
        $res = ["status" => false, "message" => "Todo not found"];
        echo json_encode($res);
    } else {
        echo json_encode($post);
    }
}

function addPost($conn, $data){
    $title = $data['title'];
    $body = $data['body'];

    $stmt = $conn->prepare("INSERT INTO `posts` (`title`, `body`) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $body);
    $stmt->execute();

    $postId = $stmt->insert_id;

    $res = ["status" => true, "post_id" => $postId, "message" => "Todo successfully added!"];
    http_response_code(201);
    echo json_encode($res);
}

function updatePost($conn, $id, $data){
    $title = $data['title'];
    $body = $data['body'];

    $stmt = $conn->prepare("UPDATE `posts` SET `title` = ?, `body` = ? WHERE `id` = ?");
    $stmt->bind_param("ssi", $title, $body, $id);
    $stmt->execute();

    $res = ["status" => true, "message" => "Todo successfully changed!"];
    http_response_code(200);
    echo json_encode($res);
}

function deletePost($conn, $id){
    $stmt = $conn->prepare("DELETE FROM `posts` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $res = ["status" => true, "message" => "Todo successfully deleted!"];
    http_response_code(200);
    echo json_encode($res);
}
?>
