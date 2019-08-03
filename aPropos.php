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
</head>


<!-- Contenu de la page -->
<body class="home">

	<!-- inclusion de la barre de naviguation -->	
	<?php 
		include 'Include/navbar.php';
	?>	


	<!-- Header image -->
	<header id="head" class"secondary" ></header>


	<!-- Texte de redirection -->
	<div class="container">
		<ol class="breadcrumb" style="padding-left:1.5em;">
			<li><a href="index.php">Accueil</a></li>
			<li class="active">A Propos</li>
		</ol>
		<article class="col-sm-9 maincontent">
				<header class="page-header">
					<h1 class="page-title" style=" margin-left: 1px;">A Propos</h1>
				</header>
		</article>
	</div>

	<!-- Intro -->
	<div class="container text-center">
		<br> <br>
		<h2 class="thin" >Qui sommes-nous ?</h2>
		<p class="indent_police">
			Sur Cocktails & co nous proposons une large gamme de recettes de préparation de boisson, avec ou sans alcool, fruité ou non pour ainsi varier les plaisirs de chacuns d'entre vous.
			Nous travaillons au plus proches des artisans locaux pour vous proposer des ingrédients d'une qualité irréprochable et pour favoriser une économie de proximité !
		</p>
		<img height="75%" width="75%" src= "style/images/Cocktails-entre-amis.jpg">
	</br>
		<p class="indent_police">
			N'hésitez pas à venir nous rencontrer pour boire un cocktail ensemble !
		</p>
	</div>
	<!-- /Intro-->


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