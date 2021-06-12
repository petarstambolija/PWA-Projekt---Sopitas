<?php

header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username ="root";
$password = "";
$basename = "sopitas";

$dbc = mysqli_connect($servername, $username, $password, $basename) or
	die ("Error connecting to MySQL Server". mysqli_connect_error);

mysqli_set_charset($dbc, "utf8");
?>