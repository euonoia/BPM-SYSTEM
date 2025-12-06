<?php

// Read from .env
$envContent = file_get_contents(__DIR__ . '/../.env');
preg_match('/APP_ENV=(.*)/', $envContent, $matches);
$ENV = trim($matches[1] ?? 'xampp');

if ($ENV === "docker") {
    return [
        "db_host" => "db",
        "db_user" => "root",
        "db_pass" => "rootpassword",
        "db_name" => "hospital_system",
        "db_port" => 3306
    ];
}

return [
    "db_host" => "127.0.0.1",
    "db_user" => "root",
    "db_pass" => "",
    "db_name" => "hospital_system",
    "db_port" => 3306
];
