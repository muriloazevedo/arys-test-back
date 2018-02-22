<?php 
require_once __DIR__ .  '/connection.php';

@session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require("vendor/autoload.php");


// create the form with rules
$v = new Valitron\Validator($_POST);
$v->rule('required', ['nome', 'sobrenome', 'username', 'senha']);


if ( $v->validate() ) {
	// deveria receber o json encode do body, mas coloquei $_POST para fim  de testes
	$data = $_POST;
	$user = $data;

	$user['datacriacao'] = (new DateTime('NOW'))->format(DateTime::ISO8601);
	$user['salt'] = bin2hex(openssl_random_pseudo_bytes(16));
	// creio que usar password_hash() seria bem melhor pois utiliza bcrypt http://php.net/manual/pt_BR/function.password-hash.php
	$user['senha'] = password_hash($user['senha'], PASSWORD_BCRYPT);

	$sql_insert = 'UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome,  senha = :senha, username = :username, salt = :salt WHERE id = :id';
	try{
		$db = Database::getConnection();
		$smts = $db->prepare($sql_insert);
		
		$smts->execute([
	    	':nome' => $user['nome'],
	    	':sobrenome' => $user['sobrenome'],
	    	':salt' => $user['salt'],
	    	':username' => $user['username'],
	    	'senha'=> $user['senha'],
	    	':id' => $_GET['id'] 
	  	]);
  		echo $smts->rowCount(); 
	} catch(PDOException $e) {
  		echo 'Error: ' . $e->getMessage();
  	}
}else {
    echo json_encode(['errors' => $v->errors()]);
    exit;
 }