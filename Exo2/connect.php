<?php

// open the session
session_start();

$dsn = 'mysql:host=localhost; dbname=exo1_userslist';
$login = 'root';
$pwd = '';
$attributes = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

$db = new PDO($dsn, $login, $pwd, $attributes);

?>