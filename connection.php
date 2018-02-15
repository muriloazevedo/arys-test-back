<?php
include 'db.php';
try {
    $db = new PDO("pgsql:host=localhost dbname={$database['db']} user={$database['user']} password={$database['password']}");
 } catch (PDOException  $e) {
    print $e->getMessage();
 }

