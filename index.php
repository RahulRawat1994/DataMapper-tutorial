<?php

require __DIR__.'/vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Database\PdoAdapter;
use App\Mapper\UserMapper as User;

// Database connection
$conn_string = 'mysql:host=localhost;dbname=testdb;charset=utf8mb4';
$username = 'root';
$password = 'admin';

// PATH CONSTANT
define('ENTITY_PATH', 'App\Entity\\');

// Create Database connection
$db = new PdoAdapter($conn_string, $username, $password);
$db->openConnection();

$userMapper = new User($db);

// find all records
$user = $userMapper->findAll();
if (!empty($user)) {
    print_r($user[0]->lname);
}

// Insert New Record
$user = $userMapper->getEntityClass();
$user->fname = 'Sam';
$user->lname = 'William';
$user->email = 'samw@gmail.com';
$userMapper->insert($user);

// Update existing document
$user = $userMapper->getEntityClass();
$user->id = 5;
$user->fname = 'Pankaj';
$userMapper->update($user);

// Delete existing document
$user = $userMapper->getEntityClass();
$user->id = 5;
$userMapper->delete($user);
