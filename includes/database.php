<?php
header('Access-Control-Allow-Origin: *');

$host = 'localhost';
$username = 'root';
$passwd = 'root';
$dbname = 'appsalon';
$port = 3310;

$db =  mysqli_connect($host, $username, $passwd, $dbname, $port);
$db -> set_charset('utf8');

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
