<?php
// $dsn = 'mysql:host=localhost;dbname=devgeops;charset=utf8';
// $user = 'root';
// $pass = '';

$dsn = 'mysql:host=35.195.188.161;dbname=devgeops;charset=utf8';
$user = 'AdminGeOPS';
$pass = '3jczLxbgXYAmhT';

$user=1;

try {
 	$bdd = new PDO($dsn, $user , $pass);
}
catch (PDOException $exception) {
	exit('Erreur de connexion à la base de données !');
}

?>	
