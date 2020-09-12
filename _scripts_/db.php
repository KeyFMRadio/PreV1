<?php
$db_host = "localhost";
$db_user = "keyfm_temp";
$db_pass = "u%%uOPGszrj62nol";
$db_name = "keyfm_temp";
$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
?>
