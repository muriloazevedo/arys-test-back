<?php
require_once __DIR__ .  '/connection.php';
require("vendor/autoload.php");
$db = Database::getConnection();
$v = new Valitron\Validator($_GET);
$v->rule('required', ['id']);
$v->rule('integer', 'id');


if ( $v->validate() ) {
	$smts = $db->prepare("DELETE FROM usuarios where id = :id");
	$smts->execute([
		    	':id' => $_GET['id']
	]);
	$results=  $smts ->fetchAll(PDO::FETCH_ASSOC);
	header("Content-type:application/json");
	$json = json_encode("resource deleted");
}else{
	$json = json_encode(['errors' => $v->errors()]);
}
echo $json;