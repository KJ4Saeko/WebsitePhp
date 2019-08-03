<?php 
	session_start();
	include 'Connexion.php';
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
			<li class="active">Nos recettes</li>
		</ol>
		<article class="col-sm-9 maincontent">
			<header class="page-header">
				<h1 class="page-title" style=" margin-left: 1px;">Nos Recettes</h1>
			</header>
		</article>
	</div>

	<?php 

	//Récupération des recettes
	$tab = array();
 	$sql = $conn->query("SELECT nomRecette FROM Recette");
  		while ($result = $sql->fetch_assoc()) {
    		$tab[] = mb_convert_encoding($result['nomRecette'], "UTF-8", "Windows-1252");
    		$nbRecettes = $sql->num_rows;
    	}

  	//Début Pagination
  	$nbCocktailsPage = 10; //le nombre de membres par page
	$nbDePages  = ceil($nbRecettes / $nbCocktailsPage);
 
	if (isset($_GET['id']) && preg_match("/^[0-9]+$/", $_GET['id'])) {
    	$page = $_GET['id'];
	}
    else {
        $_GET['id'] = 1;
        $page = 1;
    }
  
	// on lance la requete qui ira chercher les cocktails par exemple...
    $premierMembre = ($page - 1) * $nbCocktailsPage;
	// regarde si il a quelque chose de trouver...
	if ($nbRecettes == 0) {
    	echo 'Aucun recette trouvé';
    }
    else {
        $i = 1;
  		while($donnee = $sql->fetch_array()) {
            // on calcule quel est sa position..
			$nbligne = $page * $nbCocktailsPage + $i++ - 10;
            	echo '<tr><td align="center">',$nbligne,'</td></tr>';                  
            }
				echo'</table>';
 
		// lancement checkup des pages precedents si nous sommes pas a la premiere page..
		if ($page != 1){
           $pageprece0 = ($_GET['id']-1);
           $pageprece1 = ($_GET['id']-2);
           $pageprece2 = ($_GET['id']-3);
           $pageprece3 = ($_GET['id']-4);
           $pageprece4 = ($_GET['id']-5);
           $pageprece5 = 1;
        } 

		// lancement du checkup des pages suivante..
                       echo '&nbsp;&nbsp;';
                       $pagesuiv = ($_GET['id']+1);
                       $pagesuiv1 = ($_GET['id']+2);
                       $pagesuiv2 = ($_GET['id']+3);
                       $pagesuiv3 = ($_GET['id']+4);
                       $pagesuiv4 = ($_GET['id']+5);
                       $pagesuiv5 = $nbDePages;
 
 			echo '
 			<nav aria-label="Pagination" style="padding-left: 20;">
  				<ul class="pagination justify-content-center">
    				<li class="page-item">
      					<a class="page-link" href="?id=1" aria-label="Previous">
        					<span aria-hidden="true">&laquo;</span>
        					<span class="sr-only">Previous</span>
      					</a>
    				</li>';

			if ($pagesuiv <= $nbDePages){
				if($_GET['id'] == 1){
					echo '<li class="page-item active"><a class="page-link" href="?id=1"> 1 </a> </li>';
				}else{
					echo '<li class="page-item"><a class="page-link" href="?id=1"> 1 </a> </li>';
				}
			}
			if ($pagesuiv1 <= $nbDePages){
				if($_GET['id'] == 2){
                	echo '<li class="page-item active"><a class="page-link" href="?id=2"> 2 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=2"> 2 </a> </li>';
                }
			}
			if ($pagesuiv2 <= $nbDePages){
                if($_GET['id'] == 3){
                	echo '<li class="page-item active"><a class="page-link" href="?id=3"> 3 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=3"> 3 </a> </li>';
                }
			}
			if ($pagesuiv3 <= $nbDePages){
               	if($_GET['id'] == 4){
                	echo '<li class="page-item active"><a class="page-link" href="?id=4"> 4 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=4"> 4 </a> </li>';
                }
			}
			if ($pagesuiv4 <= $nbDePages){
                if($_GET['id'] == 5){
                	echo '<li class="page-item active"><a class="page-link" href="?id=5"> 5 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=5"> 5 </a> </li>';
                }
			}
			else{
				echo '<li class="page-item"><a class="page-link" href="?id=1"> 1 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=2"> 2 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=3"> 3 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=4"> 4 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=5"> 5 </a> </li>';
			}
			echo'
					<li class="page-item">
      					<a class="page-link" href="?id=5" aria-label="Next">
        					<span aria-hidden="true">&raquo;</span>
        					<span class="sr-only">Next</span>
      					</a>
    				</li>
				</ul>
			</nav>';
   }
$sql->free_result();	

//Conversion noms de photos en noms d'images
foreach($tab as $key => $value){
	$arrayPhoto[$key] = str_to_noaccent(ucfirst(strtolower($value)));
	$arrayPhoto[$key] = str_replace(' ', '_', $arrayPhoto[$key]);
	$arrayPhoto[$key] = str_replace(',', '', $arrayPhoto[$key]);
	$arrayPhoto[$key] = str_replace('-', '_', $arrayPhoto[$key]);
	$arrayPhoto[$key] .= '.jpg';
}

$nbRecettesPage = 24;
$nbPages = intval($nbRecettes/$nbRecettesPage)+1;

/*Affichage des cocktails avec leurs photos associé si existante dans le dossier sinon photo générique. 
  Division des recettes /Affichage de 24 recettes sur 5 pages en deux colonnes de 12 */

for($i=1; $i<=$nbPages; $i++){
	if($_GET['id'] == $i){
		for($k=($i-1)*$nbRecettesPage, $p=1; $k <$nbRecettesPage*$i; $k+=2){
			$k2 = $k + 1;
			if($k2 <= $nbRecettes){
				echo '
				<div class="container">
					<div class="row">
						<div class="col-sm-6" style="padding:4px; border:4px solid #e0e0e0;">
							<div class="col-md-3 col-sm-4 col-xs-6">
								<img height="120px" width="200px" src= "'.((file_exists('style/Photos/'.$arrayPhoto[$k])) ?  ("style/Photos/".$arrayPhoto[$k])    : ("style/images/noimg.png")).'"/>
							</div>
								<h4 class="cocktail_police">'.$tab[$k].'</h4>
								<hr>
								<a href="informationCocktail.php?cocktailId='.$k.'">En savoir plus sur ce cocktail</a></br>
						</div>
						<div class="col-sm-6" style="padding:4px; border:4px solid #e0e0e0;">
							<div class="col-md-3 col-sm-4 col-xs-6" >
								<img height="120px" width="200px" src="'.((file_exists('style/Photos/'.$arrayPhoto[$k2])) ?  ("style/Photos/".$arrayPhoto[$k2]) : ("style/images/noimg.png")).'" />
							</div>
								<h4 class="cocktail_police">'.$tab[$k2].'</h4>
								<hr>
								<a href="informationCocktail.php?cocktailId='.$k2.'">En savoir plus sur ce cocktail</a></br>
						</div>
					</div>
				</div></br>';
			}
		}
	} else {
		if($_GET['id'] > $nbPages){
			echo "<script type='text/javascript'>document.location.replace('nosRecettes.php');</script>";
		}
	}
}

// Barre de pagination bas de page
echo '
 			<nav aria-label="Pagination" style="padding-left: 20;">
  				<ul class="pagination justify-content-center">
    				<li class="page-item">
      					<a class="page-link" href="?id=1" aria-label="Previous">
        					<span aria-hidden="true">&laquo;</span>
        					<span class="sr-only">Previous</span>
      					</a>
    				</li>';

			if ($pagesuiv <= $nbDePages){
				if($_GET['id'] == 1){
					echo '<li class="page-item active"><a class="page-link" href="?id=1"> 1 </a> </li>';
				}else{
					echo '<li class="page-item"><a class="page-link" href="?id=1"> 1 </a> </li>';
				}
			}
			if ($pagesuiv1 <= $nbDePages){
				if($_GET['id'] == 2){
                	echo '<li class="page-item active"><a class="page-link" href="?id=2"> 2 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=2"> 2 </a> </li>';
                }
			}
			if ($pagesuiv2 <= $nbDePages){
                if($_GET['id'] == 3){
                	echo '<li class="page-item active"><a class="page-link" href="?id=3"> 3 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=3"> 3 </a> </li>';
                }
			}
			if ($pagesuiv3 <= $nbDePages){
               	if($_GET['id'] == 4){
                	echo '<li class="page-item active"><a class="page-link" href="?id=4"> 4 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=4"> 4 </a> </li>';
                }
			}
			if ($pagesuiv4 <= $nbDePages){
                if($_GET['id'] == 5){
                	echo '<li class="page-item active"><a class="page-link" href="?id=5"> 5 </a> </li>';
                } else {
                	echo '<li class="page-item"><a class="page-link" href="?id=5"> 5 </a> </li>';
                }
			}
			else{
				echo '<li class="page-item"><a class="page-link" href="?id=1"> 1 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=2"> 2 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=3"> 3 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=4"> 4 </a> </li>';
				echo '<li class="page-item"><a class="page-link" href="?id=5"> 5 </a> </li>';
			}
			echo'
					<li class="page-item">
      					<a class="page-link" href="?id=5" aria-label="Next">
        					<span aria-hidden="true">&raquo;</span>
        					<span class="sr-only">Next</span>
      					</a>
    				</li>
				</ul>
			</nav>';


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