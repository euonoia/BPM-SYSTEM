<?php

$config = require "config.php";

$conn = new mysqli(
    $config["db_host"],
    $config["db_user"],
    $config["db_pass"],
    $config["db_name"],
    $config["db_port"]
);

if ($conn->connect_error) {
    die("Database failed: " . $conn->connect_error);
}
