<?php
include 'logins.php';
$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error; 
}
            
$createUserQuery = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    password CHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL
)";

if (!$mysqli->query("DROP TABLE IF EXISTS users") || !$mysqli->query($createUserQuery)) {
    echo "Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!($stmt = $mysqli->prepare("INSERT INTO users(username, password, email) VALUES (?, ?, ?)"))) {
    echo "Preare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
?>