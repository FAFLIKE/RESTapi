<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$URL = explode('/', explode('?', $_SERVER['REQUEST_URI'])[0]);

require 'handler/connect.php';

if ($URL[1] === 'city') {

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (array_key_exists('limit', $_GET)) {
            $limit = $_GET['limit'];
            if ($limit === 0) {
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(array("message" => "Requested zero rows."));
                die();
            }
            if (array_key_exists('offset', $_GET)) {
                $offset = $_GET['offset'];
            } else {
                $offset = 0;
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(array("message" => "Get parametrs doesn't exist"));
            die();
        }



        $query = "SELECT * FROM CITY LIMIT " . $limit . " OFFSET " . $offset . "";
        $data = mysqli_query($connect, $query);

        if (mysqli_num_rows($data) < 1) {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("message" => "Query return zero rows. Not Found!"));
        } else {
            header("HTTP/1.1 200 OK");
            $postList = [];
            while ($post = mysqli_fetch_assoc($data)) {
                $postList[] = $post;
            }
            echo json_encode($postList);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    var_dump($_POST);
}
