<?php

$localhost = "localhost";
$user = "root";
$password = "";
$db = "omega-practices";

$conn = new mysqli($localhost, $user, $password, $db);

if (!$conn) {
    die("Connection Error" . $conn->error);
}
