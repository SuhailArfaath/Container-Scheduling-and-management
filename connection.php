<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'container_project_db';

if(!$con = mysqli_connect(
    $dbhost,$dbuser,$dbpassword,$dbname
))
{
    die("Failed to connect to the server");
}