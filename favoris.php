<?php 
	session_start();
	include 'Connexion.php';
	include 'Include/fonctionsPHP.php';
	delai();


// On récupère les recettes ID de la table favoris en fonction de l'utilisateur dans un tableau 
	if(isset($_SESSION['login'])){
		$login = $_SESSION['login'];
		$tabFavoris = array();
		$sql = "SELECT recetteId FROM Favoris WHERE login = '$login'";
		if($result = $conn->query($sql)){
			while($row = $result->fetch_assoc()){
				$tabFavoris[] = $row['recetteId'];
			}
		}
	}else{
		$errConnexion = " Vous devez être connecté pour afficher vos recettes favorites.";	}
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
			<li class="active">Favoris</li>
		</ol>
		<article class="col-sm-9 maincontent">
				<header class="page-header">
					<h1 class="page-title" style=" margin-left: 1px;">Favoris</h1>
				</header>
		</article>
	</div>

<?php 
			// Pour chaque recette id de la table favoris, on va chercher la recette, son nom etc ..
			if(isset($tabFavoris)){
				foreach($tabFavoris as $cle => $value){
					$sqlRecette = "SELECT recetteId, nomRecette, ingredients, preparation FROM Recette WHERE recetteId = '$value'";
					if($result2 = $conn->query($sqlRecette)) {
            			if($resultat = $result2->fetch_assoc()){
            				$tabRecette[] = array(
            					'recetteId' => $resultat['recetteId'],
            					'nomRecette' => $resultat['nomRecette'],
            					'ingredients' => $resultat['ingredients'],
            					'preparation' => $resultat['preparation']);
            			}
            		}
        		}
			}
			if(isset($tabRecette)){
				$i = 1;
				foreach($tabRecette as $cle => $array){ 
					$recetteID = $array['recetteId']; //récupération de l'id de la recette + affichage de celle-ci
						echo' 
						<div class="container" style="padding-left:3em; border:4px solid #e0e0e0;">
							<div class="row">
							<h3 class="indent_police"> '.mb_convert_encoding($array['nomRecette'],"UTF-8", "Windows-1252").'</h3>
							<hr>
							<h4 class="indent_police"> Ingrédients : '.mb_convert_encoding($array['ingredients'],"UTF-8", "Windows-1252").'</h4>
							<hr>
							<h4 class="indent_police"> Préparation : '.mb_convert_encoding($array['preparation'],"UTF-8", "Windows-1252").'</h4>
							<hr>';

						echo'
							</div>
							<div class="col-sm-12 text-center">
								<form method="post">
								<input class="btn btn-action" type="submit" name= "'.$recetteID .'" value="Supprimer ce cocktail de mes favoris">';
						echo		'<form>
							</div>
						</div>';
						
						if(isset($_POST[$recetteID])){
							$sql3 = "DELETE FROM Favoris WHERE recetteId = '$recetteID' AND login ='$login'";
							    if($conn->query($sql3) === TRUE) {
            						echo "<script type='text/javascript'>document.location.replace('favoris.php');</script>";
          						}
						}

					
					echo'</br>';
					$i++;
				}
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