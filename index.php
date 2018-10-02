<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Database\PdoAdapter;
use Mapper\UserMapper;
use Entity\User;

// Bootstrap all classes
require_once 'Autoloader.php';
Autoloader::register();

// Database connection
$conn_string='mysql:host=localhost;dbname=testdb;charset=utf8mb4';
$username ='root';
$password = 'devWel189';

// PATH CONSTANT
define('ENTITY_PATH', '\Entity\\');

//Working
$db = new PdoAdapter($conn_string, $username, $password);
$db->openConnection();

$userMapper = new UserMapper($db);

$user=$userMapper->findAll();
print_r($user[0]->lname);
