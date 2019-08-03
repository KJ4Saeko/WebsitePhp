<?php
	session_start();
	include 'Include/fonctionsPHP.php';
	delai();
?>

<!DOCTYPE html>
<html lang="fr">

<!-- Inclusion des feuilles de style -->
<head>		
	<?php 
		include 'Include/link.php';
	?>	

	<?php if(!isset($_COOKIE['estMajeur'])){

	setcookie('estMajeur', 'majeur', (time() + 1200));
	echo '	<script language="javascript">
		var agePrompt=prompt("Quel est votre âge ? Vous devez être majeur pour accéder à ce site.");
		if (agePrompt>=18){
			alert("Bienvenue sur Cockails & co");			
		}
		else {
			alert("Désolé, reviens dans quelques années !");
			document.location="http://www.google.fr"; 
		}
		</script>';
 	}?>

</head>


<!-- Contenu de la page -->
<body class="home">

 <!-- Header image-->
  <header id="head" class"secondary" ></header>


	<!-- Intro -->
	<div class="container text-center">
		<br> <br>
		<h2 class="thin" >Venez vous rafraichir avec nos cocktails !</h2>
		<p class="text-muted">
			Sur Cocktails&Co, nous vous proposerons une large game de cocktails !
			Avec ou sans alcool, incontournables ou originaux, ils seront vous satisfaire !
		</p>
	</div>
	<!-- /Intro-->
		

	<!-- inclusion de la barre de naviguation -->	
	<?php 
		include 'Include/navbar.php';
	?>	


	<!-- Selection du mois sans alcool -->
		<div class="container">
			<div class="row">
				<div class="container text-center">
					<br> <br>
					<h1 class="thin">Notre sélection du mois sans alcool</h1>	
					<br>
				</div>
				<div class="col-sm-6">
					<br>
					<div class="col-md-3 col-sm-4 col-xs-6"><img class="img-responsive" src="style/Photos/Coconut_kiss.jpg" /></div>
					<h3 class="select_mois">Coconut Kiss</h3>
					<p class="indent_police">Cocktail sans alcool délicieusement onctueux à la noix de coco.</p>
				</div>
				<div class="col-sm-6">
					</br>
					<div class="col-md-3 col-sm-4 col-xs-6"><img class="img-responsive" src="style/Photos/Bora_bora.jpg" /></div>
					<h3 class="select_mois">Bora Bora</h3>
					<p class="indent_police">Un délicieux cocktail sans alcool qui saura faire son petit effet ! De l'ananas, un peu de citron couplé aux fruits de la passion.</p>
				</div>
			</div>
		</div>
	<!-- Selection du mois avec alcool FIN -->


	<!-- Selection du mois avec alcool -->
	<div class="container">
		<div class="row">
			<div class="container text-center">
				<br> <br>
				<h1 class="thin">Notre sélection du mois alcoolisé</h1>	
				<br>
			</div>
			<div class="col-sm-6">
				<br>
				<div class="col-md-3 col-sm-4 col-xs-6"><img class="img-responsive" src="style/Photos/Bloody_mary.jpg" /></div>
				<h3 class="select_mois">Bloody Mary</h3>
				<p class="indent_police">L'incontournable cocktail à base de vodka, jus de tomates, citron et d'épices. </p>
			</div>
			<div class="col-sm-6">
				</br>
				<div class="col-md-3 col-sm-4 col-xs-6"><img class="img-responsive" src="style/Photos/Cuba_libre.jpg" /></div>
				<h3 class="select_mois">Cuba Libre</h3>
				<p class="indent_police">Ressentez la puissance du Rhum cubain. </p>
			</div>
		</div>
	</div>
	<!-- FIN Selection du mois avec alcool -->


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