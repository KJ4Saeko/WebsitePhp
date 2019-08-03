<?php 

	include 'Include/fonctionsPHP.php';
	include 'Connexion.php';
	delai();
	
$errConnexion="";
$result="";

	//Verification Authentification réussi ou non
	if(isset($_POST['submit'])){

		//Verification nom du contact valide
		if(isset($_POST["login_contact"]) && isset($_POST["mdp_contact"])){
        	$recupLogin=$_POST['login_contact'];
        	$recupMdp=$_POST['mdp_contact'];
        }
        else{
        	$recup_login="";
      		$recup_mdp="";
        	$errConnexion = "Identifiants incorrects, veuillez vérifier votre email et mot de passe";
        	$result='<div align="center" class="alert alert-danger">'.$errConnexion.'.</div>';
      	}

		if(existeClient($recupLogin,$recupMdp)){
			//Vérification qu'un utilisateur existe dans la base de donnée et qu'il s'est connecté.
      		session_start();
      		$_SESSION['valide'] = 1;
            $_SESSION['login'] = $recupLogin;
            $recup_login="";
      		$recup_mdp="";
			header('Location: espacePerso.php');
          	exit();
		}         	
      	else{
      		$recup_login="";
      		$recup_mdp="";
      		$errConnexion = "Identifiants incorrects, veuillez vérifier votre email et mot de passe";
        	$result='<div align="center" class="alert alert-danger">'.$errConnexion.'.</div>';
      	}

	}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <?php 
    include 'Include/link.php';
  ?>
</head>


<!-- Contenu de la page -->
<body class="home">

	<!-- inclusion de la barre de naviguation -->	
	<?php 
		include 'Include/navbar.php';
	?>	

	<!-- Header image  -->
	<header id="head" class"secondary" ></header>

	<!-- Si l'utilisateur est connecté alors il ne pourra pas se retrouver sur la page de connexion, au contraire, si il n'est pas connecter, alors il sera dirigé vers la page de connexion. -->
	<?php
		session_start();
		if(isset($_SESSION['valide'])){
			header('Location: espacePerso.php');
		}else{
			include'ongletConnexion.php';
		}
	?>


	<!-- inclusion du footer -->	
	<?php 
		include 'Include/footer.php';
	?>	
		

	<!-- inclusion des links js et jquery -->	
	<?php 
		include 'Include/linkJS.php';
	?>	


</body>
</html>