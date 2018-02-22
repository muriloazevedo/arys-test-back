<?php
require_once __DIR__ .  '/connection.php';
require("vendor/autoload.php");
$db = Database::getConnection();
$statement = $db->prepare("SELECT * FROM usuarios");
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_ASSOC);
header("Content-type:application/json");
$json = json_encode($results);
echo $json;