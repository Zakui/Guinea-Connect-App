<?php
	 $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	// $bdd = new PDO('mysql:host=91.216.107.161;dbname=mobit597135','mobit597135','makiti1234', $pdo_options); 
	 $bdd = new PDO('mysql:host=localhost;dbname=guinea_connect','root','', $pdo_options); 
	 $bdd->exec("SET CHARACTER SET utf8");
			 
?>