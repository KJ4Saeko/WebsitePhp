<?php 
	session_start();
	include 'Include/fonctionsPHP.php';
	include 'Connexion.php';
	delai();


//Variable de récupération d'erreur lié au formulaire
$errLogin="";
$errMail="";
$errNom ="";
$errPrenom="";
$errTelephone="";
$errAdresse="";
$errVille="";
$errPays="";
$errCodePostal="";
$errDate="";
$errMdpNouveau="";
$errMdpNouveauVerification="";
$errMdpVerification="";

//Variable de récupération des données du formulaire
$recupLogin="";
$recupMail="";
$recupNom="";
$recupPrenom="";
$recupSexe="";
$recupTelephone="";
$recupAdresse="";
$recupVille="";
$recupPays="";
$recupCodePostal="";
$recupDate="";
$recupMdpNouveau="";
$recupMdpVerificationNouveau="";
$recupMdpVerification="";


$tabClient = recupClient($_SESSION['login']);

if(isset($_POST['submit'])){

    if(isset($_POST["verificationMdp"])){
      	if(preg_match("/^(?=.*[a-zA-Z])(?=.*[a-zA-Z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/", $_POST['verificationMdp'])){
      			$recupMdpVerification = $_POST['verificationMdp'];
      	}      	
      	else{
        		$errMdpVerification="Vous devez entrer votre ancien mot de passe.";
      	}
    } 

	if(existeClient($tabClient['login'], $recupMdpVerification)){

		//Changement de mail
		if(isset($_POST['mail'])){
			if(preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST['mail'])){
				$recupMail = $_POST['mail'];
				//On vérifie que l'email n'existe déjà pas.
				$sqlVerifMail = mysqli_query($conn,'SELECT EXISTS (SELECT * FROM Utilisateur WHERE email ="'.$recupMail.'") AS mailExist');
				$req2 = mysqli_fetch_array($sqlVerifMail);
				if($req2['mailExist'] && strlen($recupMail) > 1){
              		$errMail=" Email déjà utilisé !";
            	}
            	else{
            		$sql2 = "UPDATE Utilisateur SET email = '$recupMail' ";
					if ($conn->query($sql2) === TRUE) {
          			} 
            	}	
			}
			else if(strlen($_POST['mail']) > 1){
				$errMail = ' Mail incorrect ! ';
			}
		}

		//Changement de nom 
		if(isset($_POST['nom'])){
			if(preg_match("/^[a-zA-Z]+[ \-']?[[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+[ \-']?]*[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+$/", $_POST['nom'])){
					$recupNom = $_POST['nom'];
					$sql3 = "UPDATE Utilisateur SET nom = '$recupNom' ";
					if ($conn->query($sql3) === TRUE) {
          			}	
			}else if(strlen($_POST['nom']) > 1){
				$errNom =" Nom incorrect !";
			}
		}
	

		//Changement de prénom
		if(isset($_POST['prenom'])){
			if(preg_match("/^[a-zA-Z]+[ \-']?[[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+[ \-']?]*[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+$/", $_POST['prenom'])){
				$recupPrenom = $_POST['prenom'];
				$sql4 = "UPDATE Utilisateur SET prenom = '$recupPrenom' ";
				if ($conn->query($sql4) === TRUE) {
          		}
			}
			else if(strlen($_POST['prenom']) > 1){
				$errPrenom = ' Prenom incorrect';
			}
		}

		//Changement de numéro de téléphone
		if(isset($_POST['telephone'])){
			if(preg_match("/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/", $_POST['telephone'])){
				$recupTelephone = $_POST['telephone'];
				$sql5 = "UPDATE Utilisateur SET numeroTel = '$recupTelephone' ";
				if ($conn->query($sql5) === TRUE) {
          		}
			}
			else if(strlen($_POST['telephone']) > 1){
				$errTelephone = 'Numéro de téléphone incorrect';
			}
		}

		//Changement de sexe
		if(isset($_POST['sexe'])){
				$recupSexe = $_POST['sexe'];
				$sql6 = "UPDATE Utilisateur SET sex = '$recupSexe' ";
				if ($conn->query($sql6) === TRUE) {
          		}
		}
		

		//Changement de l'adresse
		if(isset($_POST['adresse'])){
			if(preg_match("/[A-Za-z]{1}[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s-]{5,60}/", $_POST['adresse'])){
				$recupAdresse = $_POST['adresse'];
				$sql7 = "UPDATE Utilisateur SET adresse = '$recupAdresse' ";
				if ($conn->query($sql7) === TRUE) {
          		}
			}
			else if(strlen($_POST['adresse']) > 1){
				$errAdresse= 'Adresse incorrect';
			}
		}

		//Changement de ville
		if(isset($_POST['ville'])){
			if(preg_match("/[A-Za-z]{1}[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s-]{5,60}/", $_POST['ville'])){
				$recupVille = $_POST['ville'];
				$sql8 = "UPDATE Utilisateur SET ville = '$recupVille' ";
				if ($conn->query($sql8) === TRUE) {
          		}
			}
			else if(strlen($_POST['ville']) > 1){
				$errVille= 'Ville incorrect';
			}
		}

		//Changement de pays
		if(isset($_POST['pays'])){
				$recupPays = $_POST['pays'];
				$sql9 = "UPDATE Utilisateur SET pays = '$recupPays' ";
				if ($conn->query($sql9) === TRUE) {
          		} 
		}

		//Changement de code
		if(isset($_POST['code'])){
			if(preg_match("/^[0-9]{5,5}$/", $_POST['code'])){
				$recupCode = $_POST['code'];
				$sql10 = "UPDATE Utilisateur SET codePostal = '$recupCode' ";
				if ($conn->query($sql10) === TRUE) {
          		}
			}
			else if(strlen($_POST['code']) > 1){
				$errCode= ' Code incorrect ! ';
			}
		}

		//Changement de date
		if(isset($_POST['naissance'])){
			if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $_POST['naissance'])){
				$recupDate = $_POST['naissance'];
				$sql11 = "UPDATE Utilisateur SET dateNaissance = '$recupDate' ";
				if ($conn->query($sql11) === TRUE) {
          		} 
			}
			else if(strlen($_POST['naissance']) > 1){
				$errDate= ' Date de naissance incorrecte ! ';
			}
		}

      	if(isset($_POST["nouveauMdp"])){
      		if(preg_match("/^(?=.*[a-zA-Z])(?=.*[a-zA-Z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/", $_POST['nouveauMdp'])){
      			$recupMdpNouveau = $_POST['nouveauMdp'];
      		}      	
      		else if(strlen($_POST['nouveauMdp']) > 1){
        		$errMdpNouveau="Ce mot de passe est trop court ou ne respecte pas les normes.";
      		}
      	} 
        
        if(!est_vide($recupMdpNouveau) && isset($_POST["nouveauMdpVerification"])){
        	$controle_temp = $_POST["nouveauMdpVerification"];
        	if($recupMdpNouveau == $controle_temp){
          		$recupMdpVerificationNouveau = $_POST['nouveauMdpVerification'];
          		$recupMdpVerificationNouveau = password_hash($recupMdpVerificationNouveau, PASSWORD_DEFAULT);
          		$sql12 = "UPDATE Utilisateur SET motDePasse = '$recupMdpVerificationNouveau'";
				if ($conn->query($sql12) === TRUE) {
          		} 
        	} 
      	} 
      	else if(strlen($_POST['nouveauMdpVerification']) > 1){
        	$errMdpNouveauVerification=" Vos deux mots de passe ne correspondent pas !";
      	} 

      	$validation = "Vos coordonnées ont été modifiées.";
      	$result='<div align="center" class="alert alert-success">'.$validation.'.</div>';  	 
    }
}  	
		unset($_POST);

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


	<?php
		//Si l'utilisateur s'est connecté alors on affiche ses données personnelles + modificiation possible
		if($_SESSION['valide'] == 1){
			$row = recupClient($_SESSION['login']);
			echo '
				<div class="container">
					<ol class="breadcrumb" style="padding-left:1.5em;">
						<li><a href="index.php">Accueil</a></li>
							<li class="active">Espace personnel</li>
					</ol>

					<article class="col-sm-9 maincontent">
						<header class="page-header">
							<h1 class="page-title" style=" margin-left: 1px;" >Espace personnel</h1>
						</header>
					</article>
				</div>

				<div class="container">
					<div class="row">
						<div class="container text-center">
							<h1 class="thin">Vos données personnelles</h1>		
						</div>
						</br>
						<form method ="post">
						<table class ="table table-hover table-dark">
							<thead>
								<tr>
									<th scope="col"></th>
									<th scope="col"> Informations actuelles</th>
									<th scope="col"> Mofifier vos informations</th>
								</tr>
							</thead>

							<tbody>
							<tr>
								<th scope="row"> Login </th> 
									<td> '.$row['login'].' </td>
							</tr>
							<tr>
								<th scope="row"> Email </th> 
									<td>'.$row['email'].'</td>
									<td> <input type="text" class="form-control" name="mail" placeholder="Exemple: JeanClaude@gmail.com" style="font-style : italic;"><p class="text-danger">'.$errMail.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Nom </th> 
									<td>'.$row['nom'].'</td>
									<td> <input type="text" class="form-control" name="nom" placeholder="Exemple: Dubois" style="font-style : italic;"><p class="text-danger">'.$errNom.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Prenom </th> 
									<td>'.$row['prenom'].'</td>
									<td> <input type="text" class="form-control" name="prenom" placeholder="Exemple: Lucas" style="font-style : italic;"><p class="text-danger">'.$errPrenom.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Sexe </th> 
									<td>'.$row['sex'].'</td>
									<td> <label class="radio-inline"><input type="radio"  name="sexe" value="Homme"> Homme </label>
                						 <label class="radio-inline"><input type="radio"  name="sexe" value="Femme"> Femme </label>
                					</td>
							</tr>
							<tr>
								<th scope="row"> Adresse </th> 
									<td>'.$row['adresse'].'</td>
									<td> <input type="text" class="form-control" name="adresse" placeholder="Exemple: 3 rue de la place" style="font-style : italic;"><p class="text-danger">'.$errAdresse.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Code postal </th> 
									<td>'.$row['codePostal'].'</td>
									<td> <input type="text" class="form-control" name="code" placeholder="Exemple: 57000" style="font-style : italic;"><p class="text-danger">'.$errCodePostal.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Ville </th> 
									<td>'.$row['ville'].'</td>
									<td> <input type="text" class="form-control" name="ville" placeholder="Exemple: Paris" style="font-style : italic;"><p class="text-danger">'.$errVille.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Pays </th> 
									<td>'.$row['pays'].'</td>
									<td>
                      					 <select id="inputPays" class="form-control" name="pays">
                        					<option>France </option>
                        					<option>Allemagne </option>
                       						<option>Luxembourg </option>
                        					<option>Angleterre </option>
                        					<option>Espagne </option>
                        					<option>Belgique </option>
                        					<option>Autre </options>
                      					</select>
                      				</td>
							</tr>
							<tr>
								<th scope="row"> Téléphone </th> 
									<td>'.$row['numeroTel'].'</td>
									<td> <input type="text" class="form-control" name="telephone" placeholder="Exemple: 0102030405" style="font-style : italic;"><p class="text-danger">'.$errTelephone.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Date de naissance </th> 
									<td>'.$row['dateNaissance'].'</td>
									<td> <input type="text" class="form-control" name="naissance" placeholder="Exemple: 01-10-1990" style="font-style : italic;"><p class="text-danger">'.$errDate.'</p></td>
							</tr>
							<tr>
								<th scope="row"> Nouveau Mot de Passe </th>
									<td> <input type="password" class="form-control" name="nouveauMdp"> <p class="text-danger">'.$errMdpNouveau.'</p></td>	
							</tr>
								<th scope="row"> Confirmation du nouveau mot de passe </th>
									<td> <input type="password" class="form-control" name="nouveauMdpVerification"> <p class="text-danger">'.$errMdpNouveauVerification.'</p></td>	
							</tr>		
							</tr>
								<th scope="row"> Confirmation de votre ancien mot de passe</th>
									<td> <input type="password" class="form-control" name="verificationMdp"> <p class="text-danger">'.$errMdpVerification.'</p></td>	
							</tr>							
							</tbody>
						</table>
						<div class="row">
							<div class="col-sm-12 text-right">
								<input class="btn btn-action" type="submit" name ="submit" value="Modifier">
							</div>
						</div>
					</div>
				</div>
				';
		}else{
			header('Location: seConnecter.php');
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