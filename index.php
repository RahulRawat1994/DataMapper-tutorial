<?php

$conn_string='mysql:host=localhost;dbname=testdb;charset=utf8mb4';
$username ='root';
$password = '';

//$db = new PdoAdapter($conn_string, $username, $password);
$db = new MongoAdapter($conn_string, $username, $password);
$user = new UserMapper($db);

$user -> findAll();