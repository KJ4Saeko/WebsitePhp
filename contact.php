<?php 
	session_start();
//verification du formulaire de contact bien rempli.  Adresse mail cocktail : coktail.mim@gmail.com  | mdp : EliasLucas012 
/* Pour tester l'envoi de mail : 
----------------------------------------CECI NE MARCHE QU'EN LOCAL -------------------------------------------------------
	- Télécharger PhpMailer 5.2.26
	- inclure dans le projet 
	- require('style/PHPMailer/PHPMailerAutoload.php');
	- require_once('style/PHPMailer/class.phpmailer.php');
	- Fonctionne avec gmail voir port et SMTP ci dessous, Pour l'envoi à partir de la boite mail du site il faut autoriser :
			Activer l'autorisation d'accès au compte google à des applications moins sécurisées
	- Dans le fichier php.ini modifier : 
		Ligne 1052~ : SMTP = smtp.gmail.com
		Ligne 1054~ : smtp-port = 465
		Ligne 1062~ : sendmail_path = "Chemin de PHPMailer"
		Ligne 929~ : Enlever le ; devant : extension=php_openssl.dll
*/

	include 'Include/fonctionsPHP.php';

	//inclusion des classes de PHP mailer ( Nécessaire)
	require('style/PHPMailer/PHPMailerAutoload.php');
	require_once('style/PHPMailer/class.phpmailer.php');
	delai();

	//Variables nécessaire à la récupération de données
	$errNom="";
	$errTelephone="";
	$errMail="";
	$errSujet="";
	$errMessage="";
	$result="";
	$message_complet="";

	//Verification du formulaire valide
	if(isset($_POST["submit"])){

		//Verification nom du contact valide
		if(isset($_POST["nom_contact"]) && preg_match("/^[a-zA-Z]+[ \-']?[[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+[ \-']?]*[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+$/", $_POST['nom_contact'])){
        	$recupNomContact =$_POST['nom_contact'];
        }
        else{
        	$errNom = "Veuillez entrer Nom valide !";
      	}
        
        //Verification Telephone contact valide
        if(isset($_POST["telephone_contact"]) && preg_match("/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/", $_POST['telephone_contact'])){
        	$recupTelephoneContact = $_POST['telephone_contact'];
      	}
      	else{
        	$errTelephone = "Veuillez entrer un numéro de téléphone valide !";
      	}

      	//Verification mail contact valide
        if(isset($_POST["mail_contact"]) && preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/", $_POST["mail_contact"])){
        	$recupMailContact =$_POST["mail_contact"];
      	}
      	else{
        	$errMail = "Veuillez entrer Mail valide !";
      	}

      	//Verification Sujet Contact 
      	if(!est_vide($_POST["sujet_contact"])){
      		$recupSujetContact =$_POST["sujet_contact"];
      	}
      	else{
        	$errSujet = "Veuillez entrer Sujet !";
      	}

      	//Verification Message Contact
      	if(!est_vide($_POST["message_contact"])){
      		$recupMessageContact =$_POST["message_contact"];
      	}
      	else{
        	$errMessage = "Veuillez entrer message !";
      	}


      	//Si le formulaire de contact est bien rempli alors on envoi un mail avec les informations sur le mail du site
      	if(isset($recupNomContact) && isset($recupTelephoneContact) && isset($recupMailContact) && isset($recupSujetContact) && isset($recupMessageContact)){
      		$message_complet .= '<html>
									<body>
										<div align="center">
											<br />
												Vous avez reçu un message de la part de Mr/Mme '. $recupNomContact.
												'<br />
													Voici le message : <br /> <br />'. $recupMessageContact. 
													'<br /> <br />
													Adresse mail : ' .$recupMailContact .
													'<br />
													Numéro de téléphone : ' . $recupTelephoneContact .'
										</div>
									</body>
								</html>';

      		smtpmailer("cocktail.mim@gmail.com", "cocktail.mim@gmail.com", $recupNomContact, $recupSujetContact , $message_complet);

			//on renvoi l'utilisateur vers un la page d'authentification réussi
          	header('Location: index.php');
          	exit();
      	}
    	else{
        	$result='<div align="center" class="alert alert-danger">Certains champs sont invalides.</div>';
      	}
      	
    }  	

?>

<!DOCTYPE html>
<html lang="fr">

<!-- Inclusion des feuilles de style -->
<head>
	<!-- inclusion des stylesheet -->	
	<?php 
		include 'Include/link.php';
	?>	
</head>

	<!-- inclusion de la barre de naviguation -->	
	<?php 
		include 'Include/navbar.php';
	?>	


	<!-- Header image -->
	<header id="head" class"secondary" ></header>


	<!-- Contenu de la page -->
	<div class="container">
		<!-- Texte de redirection -->
		<ol class="breadcrumb" style="padding-left:1.5em;">
			<li><a href="index.php">Accueil</a></li>
			<li class="active">A Propos</li>
		</ol>
		<article class="col-sm-9 maincontent">
			<header class="page-header">
				<h1 class="page-title" style=" margin-left: 1px;">Nous contacter</h1>
			</header>
			<p style ="margin-left:-10px;"> Des conseils, des renseignements à propos de notre site internet ? Nous serons ravis de vous répondre !
		</article>
		<!-- FIN Texte de redirection -->
		

		<!-- Debut du formulaire -->
		<form method ="post">
			<div class="row">
				<!-- Onglet nom -->
				<div class="col-sm-4">
					<label>Nom <span class="text-danger">*</span></label>
					<input class="form-control" type="text" placeholder="Nom" name="nom_contact" value="<?php if(isset($_POST['nom_contact'])) echo($_POST['nom_contact']);?>" style="font-style:italic;">
					<?php echo "<p class='text-danger'>$errNom</p>";?>
				</div>

				<!-- Onglet mail -->	
				<div class="col-sm-4">
					<label>Email <span class="text-danger">*</span></label>
					<input class="form-control" type="text" placeholder="Email" name="mail_contact" value="<?php if(isset($_POST['mail_contact'])) echo($_POST['mail_contact']);?>" style="font-style:italic;">
					<?php echo "<p class='text-danger'>$errMail</p>";?>
				</div>

				<!-- Onglet telephone -->
				<div class="col-sm-4">
					<label>Téléphone <span class="text-danger">*</span></label>
					<input class="form-control" type="text" placeholder="Telephone" name="telephone_contact" value="<?php if(isset($_POST['telephone_contact'])) echo($_POST['telephone_contact']);?>" style="font-style:italic;">
					<?php echo "<p class='text-danger'>$errTelephone</p>";?>
				</div>
			</div>
			<br>

			<div class="row">
				<!-- Onglet Sujet -->
				<div class="col-sm-12">
					<label>Sujet <span class="text-danger">*</span></label>	
					<input class="form-control" type="text" placeholder="Sujet" name="sujet_contact" value="<?php if(isset($_POST['sujet_contact'])) echo($_POST['sujet_contact']);?>" style="font-style:italic;">
					<?php echo "<p class='text-danger'>$errSujet</p>";?>
				</div>
			</div>

			<br>
			
			<!-- Onglet message -->		
			<div class="row">
				<div class="col-sm-12">
					<label>Message <span class="text-danger">*</span></label>
					<textarea placeholder="Entrez votre message ici..." class="form-control" rows="9" name="message_contact" value="<?php if(isset($_POST['message_contact'])) echo($_POST['message_contact']);?>" style="font-style:italic;"></textarea>
					<?php echo "<p class='text-danger'>$errMessage</p>";?>
				</div>
			</div>
				
			<br>

			<div class="row">
				<div class="col-sm-12 text-right">
					<input class="btn btn-action" type="submit" name ="submit" value="Envoyer votre message">
				</div>
			</div>

			<!-- Formulaire envoyé ou pas message -->
            <div class="top-margin">
               <div class="col-sm-8 col-sm-offset-2">
                    <?php echo $result; ?>  
                </div>
            </div>
		</form>
		<!-- FIN DU FORMULAIRE -->
	</div>
	<!-- Fin du contenu de la page -->

	
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