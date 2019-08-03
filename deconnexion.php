
<?php
	//Déconnexion de l'utilisateur quand il appuie sur le bouton déconnexion.
	session_start();
	$_SESSION = array();
	session_destroy();
	unset($_SESSION);
	header('Location: index.php');
	exit();

?>