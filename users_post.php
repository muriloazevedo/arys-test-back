<?php 
require_once __DIR__ .  '/connection.php';

@session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require("vendor/autoload.php");
use Rakit\Validation;


// create the form with rules
$form = new Form\Validator([
    'nome' => ['required', 'trim', 'max_length' => 255],
    'email' => ['required', 'email'],
    'username' => ['required'],
    'senha' => ['required']
]);

if ( $form->validate($_POST) ) {
	$data = $form->getValues();

	$user['datacriacao'] = (new DateTime('NOW'))->format(DateTime::ISO8601);
	$user['salt'] = bin2hex(openssl_random_pseudo_bytes(16));
	// creio que usar password_hash() seria bem melhor pois utiliza bcrypt http://php.net/manual/pt_BR/function.password-hash.php
	$user['senha'] = sha256($data['senha']); 

	$sql_insert = 'INSERT INTO usuarios VALUES(:nome, :email, :senha, :username, :datacriacao, :salt)';
	try{
		$stmt = $pdo->prepare($sql_insert);
	  	$stmt->execute(array(
	    	':nome' => $user['nome'],
	    	':email' => $user['email'],
	    	'salt' => $user['salt'],
	    	':username' => $user['username'],
	    	':datacriacao' => $user['datacriacao'],
	    	'senha'=> $user['senha']
	  	));
  		echo $stmt->rowCount(); 
	} catch(PDOException $e) {
  	echo 'Error: ' . $e->getMessage();
  }
}else {
    // $_POST data is not valid
    $errors = $form->getErrors(); // contains the errors
    $values = $form->getValues(); // can be used to repopulate the form

    echo json_encode(['errors' => $errors]);
    exit;
}