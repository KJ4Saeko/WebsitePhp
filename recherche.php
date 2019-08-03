<?php
	session_start();
	include 'Include/fonctionsPHP.php';
	include 'Donnees.inc.php';
	include 'Connexion.php';
	delai();

	function nomParent($conn, $nomC){
		$sql = $conn->query("SELECT categorieId, nomCategorie FROM Categorie INNER JOIN ParentC ON categorieId = categIdParent WHERE categIdEnfant = '".$nomC."'");
		if($sql == TRUE) {
          	while($result = $sql->fetch_assoc()){
          		if($sql->num_rows > 0){
          			return $result;
          		}
          	}
        } else {
        	return "Error querying Categorie table : " . $conn->error;
        }
	}
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

 	<!-- Header image-->
  	<header id="head" class"secondary" ></header>

	<!-- Texte de redirection -->
	<div class="container">
		<ol class="breadcrumb" style="padding-left:1.5em;">
			<li><a href="index.php">Accueil</a></li>
			<li class="active">Rechercher</li>
		</ol>
		<article class="col-sm-9 maincontent">
			<header class="page-header">
				<h1 class="page-title" style=" margin-left: 1px;">Rechercher</h1>
			</header>
		</article>
	</div>

		

	<!-- inclusion de la barre de naviguation -->	
	<?php 
		include 'Include/navbar.php';
	?>	

	<div class="container">
		<form method="post">
			<select class="form-control" name="rechercher">
				<option value="" style="font-size:200%;">Choisissez une catégorie/ingrédient</option>
<?php 

/* Barre de recherche avec couleurs selon la profondeur de la hiérarchie */
$count1 = count($Hierarchie['Aliment']['sous-categorie']);
for($i = 0; $i < $count1; $i++){
	$array1 = array_values($Hierarchie['Aliment']['sous-categorie']);
	if(isset($Hierarchie[$array1[$i]]['sous-categorie'])){
		echo '<option value="'.$array1[$i].'" style="font-weight:bold; color:#FF0000; font-size: 180%;">'.$array1[$i].'</option>';
		$count2 = count($Hierarchie[$array1[$i]]['sous-categorie']);
		for($j = 0; $j < $count2; $j++){	
			$array2 = array_values($Hierarchie[$array1[$i]]['sous-categorie']);
			if(isset($Hierarchie[$array2[$j]]['sous-categorie'])){
				echo '<option value="'.$array2[$j].'" style="font-size: 160%; color:#0000FF;">&nbsp;&nbsp;&nbsp;&nbsp;'.$array2[$j].'</option>';
				$count3 = count($Hierarchie[$array2[$j]]['sous-categorie']);
				for($k = 0; $k < $count3; $k++){
					$array3 = array_values($Hierarchie[$array2[$j]]['sous-categorie']);
					if(isset($Hierarchie[$array3[$k]]['sous-categorie'])){
						echo '<option value="'.$array3[$k].'" style="font-size: 160%; color:#FF00FF;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array3[$k].'</option>';
						$count4 = count($Hierarchie[$array3[$k]]['sous-categorie']);
						for($l = 0; $l < $count4; $l++){
							$array4 = array_values($Hierarchie[$array3[$k]]['sous-categorie']);
							if(isset($Hierarchie[$array4[$l]]['sous-categorie'])){
								echo '<option value="'.$array4[$l].'" style="font-size: 160%; color:#FFD700;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array4[$l].'</option>';
								$count5 = count($Hierarchie[$array4[$l]]['sous-categorie']);
								for($m = 0; $m < $count5; $m++){
									$array5 = array_values($Hierarchie[$array4[$l]]['sous-categorie']);
									echo '<option value="'.$array5[$m].'" style="font-style:italic; color:#32CD32; font-size: 160%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array5[$m].'</option>';
								}
							} else {
								echo '<option value="'.$array4[$l].'" style="font-style:italic; font-size: 160%; color:#FFD700;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array4[$l].'</option>';
							}
						}
					} else {
						echo '<option value="'.$array3[$k].'" style="font-style:italic; font-size: 160%; color:#FF00FF;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$array3[$k].'</option>';
					}
				}
			} else {
				echo '<option value="'.$array2[$j].'" style="font-style:italic; font-size: 160%; color:#0000FF;">&nbsp;&nbsp;&nbsp;&nbsp;'.$array2[$j].'</option>';
			}
		}
	} else {
		echo '<option value="'.$array1[$i].'" style="font-weight:bold;font-style:italic; color:#FF0000; font-size: 180%;">'.$array1[$i].'</option>';
	}
}
?>
			</form>
		</select>
	</div>
	<!-- Bouton de recherche -->
	<div class="container">
	 	<div class="row">
    		<div class="col-lg-12 text-center">
    	    	<input class="btn btn-action" type="submit" name ="submit" value="Rechercher"> </input>
        	</div>
        </div>
    </div>


    <?php 	
    /*Vérification sur l'élément rechercher ( si il s'agit d'un ingrédient ou d'une catégorie)
    	Si c'est un igrédient, affichage des recettes associé ainsi que son chemin dans la hiérarchie
    	Si il s'agit d'une catégorie alors affichage des recettes associés aux ingrédients fils de cette catégorie
    		puis parcourt des catégories fils et affichage du chemin */
    $existeIngredient = false; 
    if(isset($_POST['submit'])){
		if(isset($_POST['rechercher'])){
			$recherche = $_POST['rechercher'];
			$recherche = htmlspecialchars($conn->real_escape_string($recherche));
			$recherche = utf8_decode($recherche);
			$sql1 = $conn->query("SELECT DISTINCT ingredientId, nomIngredient, categorieId, nomCategorie FROM Ingredient INNER JOIN ParentI ON ingredientId = ingIdEnfant INNER JOIN Categorie ON categIdParent = categorieId WHERE nomIngredient = '".$recherche."'");
          	if ($sql1 == TRUE) {
          		while($result = $sql1->fetch_assoc()){
          			if($sql1->num_rows > 0){
          				$existeIngredient = TRUE;
          				$id = $result['ingredientId'];
          				$parent1 = nomParent($conn, $result['categorieId']);
          				$parent2 = nomParent($conn, $parent1['categorieId']);
          				$parent3 = nomParent($conn, $parent2['categorieId']);
          				$parent4 = nomParent($conn, $parent3['categorieId']);
          				$suivi = '>'.$parent4['nomCategorie'].'>'.$parent3['nomCategorie'].'>'.$parent2['nomCategorie'].'>'.$parent1['nomCategorie'].'>'.$result['nomCategorie'].'>'.$result['nomIngredient'];
          				echo '</br><div class="container">
          								<div class="row">
          									<div class="col-sm-12" ">
          										<h4 class="cocktail_police" style="text-align:center;">
          										'.mb_convert_encoding($suivi, "UTF-8", "Windows-1252").'
          										</h4>
          									</div>
          								</div>
          							</div></br>';
            			$sql2 = $conn->query("SELECT DISTINCT nomRecette, recetteId FROM Recette INNER JOIN Composer ON recetteId = rId WHERE iId = '".$id."'");
            			if($sql2 == TRUE){
            				$i = 0;
            				while ($result2 = $sql2->fetch_assoc()){
            					$nom =  mb_convert_encoding($result2['nomRecette'], "UTF-8", "Windows-1252");
								$arrayPhoto[$i] = str_to_noaccent(ucfirst(strtolower($nom)));
								$arrayPhoto[$i] = str_replace(' ', '_', $arrayPhoto[$i]);
								$arrayPhoto[$i] = str_replace(',', '', $arrayPhoto[$i]);
								$arrayPhoto[$i] = str_replace('-', '_', $arrayPhoto[$i]);
								$arrayPhoto[$i] .= '.jpg';
            					$rid = (int)substr($result2['recetteId'], 2) -1;
            					echo '
									<div class="container">
										<div class="row">
											<div class="col-sm-12" style="padding:4px; border:4px solid #e0e0e0;">
												<div class="col-md-3 col-sm-4 col-xs-6">
													<img height="120px" width="130px" src= "'.((file_exists('style/Photos/'.$arrayPhoto[$i])) ?  ("style/Photos/".$arrayPhoto[$i])    : ("style/images/noimg.png")).'"/>
												</div>
												<h4 class="cocktail_police">'.$nom.'</h4>
												<hr>
												<a href="informationCocktail.php?cocktailId='.$rid.'">En savoir plus sur ce cocktail</a></br>
											</div>
										</div>
									</div></br>';
								$i++;
    						}
            			}else{
            				echo "Error querying Composer table : " . $conn->error;
            			}
            		}
            	}
            	if(!$existeIngredient){
    				$sql3 = $conn->query("SELECT nomCategorie, categorieId FROM Categorie WHERE nomCategorie = '".$recherche."'");
    				if($sql3 == TRUE){
    					while($result3 = $sql3->fetch_assoc()){
    						$parent1 = nomParent($conn, $result3['categorieId']);
          					$parent2 = nomParent($conn, $parent1['categorieId']);
          					$parent3 = nomParent($conn, $parent2['categorieId']);
          					$parent4 = nomParent($conn, $parent3['categorieId']);
          					$suivi = '>'.$parent4['nomCategorie'].'>'.$parent3['nomCategorie'].'>'.$parent2['nomCategorie'].'>'.$parent1['nomCategorie'].'>'.$result3['nomCategorie'];
          					echo '</br><div class="container">
          									<div class="row">
          										<div class="col-sm-12" ">
          											<h4 class="cocktail_police" style="text-align:center;">
          											'.mb_convert_encoding($suivi, "UTF-8", "Windows-1252").'
          											</h4>
          										</div>
          									</div>
          								</div></br>';
    						$sql4 = $conn->query("SELECT ingIdEnfant FROM ParentI WHERE categIdParent = '".$result3['categorieId']."'");
    						if($sql4 == TRUE){
    							if($sql4->num_rows > 0){
    								while($result4 = $sql4->fetch_assoc()){
    									$sql5 = $conn->query("SELECT nomRecette, recetteId FROM Recette INNER JOIN Composer ON recetteId = rId WHERE iId = '".$result4['ingIdEnfant']."'");
    									if($sql5 == TRUE){
    										$i=0;
    										while($result5 = $sql5->fetch_assoc()){
            									$nom =  mb_convert_encoding($result5['nomRecette'], "UTF-8", "Windows-1252");
												$arrayPhoto[$i] = str_to_noaccent(ucfirst(strtolower($nom)));
												$arrayPhoto[$i] = str_replace(' ', '_', $arrayPhoto[$i]);
												$arrayPhoto[$i] = str_replace(',', '', $arrayPhoto[$i]);
												$arrayPhoto[$i] = str_replace('-', '_', $arrayPhoto[$i]);
												$arrayPhoto[$i] .= '.jpg';
            									$rid = (int)substr($result5['recetteId'], 2) -1;
            									echo '
													<div class="container">
														<div class="row">
															<div class="col-sm-12" style="padding:4px; border:4px solid #e0e0e0;">
																<div class="col-md-3 col-sm-4 col-xs-6">
																<img height="120px" width="130px" src= "'.((file_exists('style/Photos/'.$arrayPhoto[$i])) ?  ("style/Photos/".$arrayPhoto[$i])    : ("style/images/noimg.png")).'"/>
																</div>
																<h4 class="cocktail_police">'.$nom.'</h4>
																<hr>
																<a href="informationCocktail.php?cocktailId='.$rid.'">En savoir plus sur ce cocktail</a></br>
															</div>
														</div>
													</div></br>';
												$i++;    											
    										}
    									}
    								}
    							}
    						}else{
    							echo "Error querying ParentI table : " . $conn->error;
    						}
    						$sql6 = $conn->query("SELECT categIdEnfant FROM ParentC WHERE categIdParent = '".$result3['categorieId']."'");
    						if($sql6 == TRUE){
    							if($sql6->num_rows > 0){
    								while($result6 = $sql6->fetch_assoc()){
    									$sql7 = $conn->query("SELECT ingIdEnfant FROM ParentI WHERE categIdParent = '".$result6['categIdEnfant']."'");
    									if($sql7 == TRUE){
    										if($sql7->num_rows >0){
    											while($result7 = $sql7->fetch_assoc()){
    												$sql8= $conn->query("SELECT nomRecette, recetteId FROM Recette INNER JOIN Composer ON recetteId = rId WHERE iId = '".$result7['ingIdEnfant']."'");
    												if($sql8 == TRUE){
    													while($result7 = $sql8->fetch_assoc()){
            											$nom =  mb_convert_encoding($result7['nomRecette'], "UTF-8", "Windows-1252");
														$arrayPhoto[$i] = str_to_noaccent(ucfirst(strtolower($nom)));
														$arrayPhoto[$i] = str_replace(' ', '_', $arrayPhoto[$i]);
														$arrayPhoto[$i] = str_replace(',', '', $arrayPhoto[$i]);
														$arrayPhoto[$i] = str_replace('-', '_', $arrayPhoto[$i]);
														$arrayPhoto[$i] .= '.jpg';
            											$rid = (int)substr($result7['recetteId'], 2) -1;
            											echo '
															<div class="container">
																<div class="row">
																	<div class="col-sm-12" style="padding:4px; border:4px solid #e0e0e0;">
																		<div class="col-md-3 col-sm-4 col-xs-6">
																			<img height="120px" width="130px" src= "'.((file_exists('style/Photos/'.$arrayPhoto[$i])) ?  ("style/Photos/".$arrayPhoto[$i])    : ("style/images/noimg.png")).'"/>
																		</div>
																		<h4 class="cocktail_police">'.$nom.'</h4>
																		<hr>
																		<a href="informationCocktail.php?cocktailId='.$rid.'">En savoir plus sur ce cocktail</a></br>
																	</div>
																</div>
															</div></br>';
														$i++;    											
    													}	
    												}else{
    													echo "Error querying Recette table : " . $conn->error;
    												}
    											}
    										}
    									}else{
    										echo "Error querying ParentI table : " . $conn->error;
    									}
    									$sql9 = $conn->query("SELECT categIdEnfant FROM ParentC WHERE categIdParent = '".$result6['categIdEnfant']."'");
    									if($sql9 == TRUE){
    										if($sql9->num_rows > 0){
    											while($result8 = $sql9->fetch_assoc()){
    												$sql10 = $conn->query("SELECT ingIdEnfant FROM ParentI WHERE categIdParent = '".$result8['categIdEnfant']."'");
    												if($sql10 == TRUE){
    													if($sql10->num_rows >0){
    														while($result9 = $sql10->fetch_assoc()){
    															$sql11= $conn->query("SELECT nomRecette, recetteId FROM Recette INNER JOIN Composer ON recetteId = rId WHERE iId = '".$result9['ingIdEnfant']."'");
    															if($sql11 == TRUE){
    																while($result10 = $sql11->fetch_assoc()){
            														$nom =  mb_convert_encoding($result10['nomRecette'], "UTF-8", "Windows-1252");
																	$arrayPhoto[$i] = str_to_noaccent(ucfirst(strtolower($nom)));
																	$arrayPhoto[$i] = str_replace(' ', '_', $arrayPhoto[$i]);
																	$arrayPhoto[$i] = str_replace(',', '', $arrayPhoto[$i]);
																	$arrayPhoto[$i] = str_replace('-', '_', $arrayPhoto[$i]);
																	$arrayPhoto[$i] .= '.jpg';
            														$rid = (int)substr($result10['recetteId'], 2) -1;
            														echo '
																		<div class="container">
																			<div class="row">
																				<div class="col-sm-12" style="padding:4px; border:4px solid #e0e0e0;">
																					<div class="col-md-3 col-sm-4 col-xs-6">
																						<img height="120px" width="130px" src= "'.((file_exists('style/Photos/'.$arrayPhoto[$i])) ?  ("style/Photos/".$arrayPhoto[$i])    : ("style/images/noimg.png")).'"/>
																					</div>
																					<h4 class="cocktail_police">'.$nom.'</h4>
																					<hr>
																					<a href="informationCocktail.php?cocktailId='.$rid.'">En savoir plus sur ce cocktail</a></br>
																				</div>
																			</div>
																		</div></br>';
																	$i++;    											
    																}	
    															}else{
    																echo "Error querying Recette table : " . $conn->error;
    															}
    														}
    													}
    												}else{
    													echo "Error querying ParentI table : " . $conn->error;
    												}
    												$sql12 = $conn->query("SELECT categIdEnfant FROM ParentC WHERE categIdParent = '".$result8['categIdEnfant']."'");
    												if($sql12 == TRUE){
    													if($sql12->num_rows > 0){
    														while($result11 = $sql12->fetch_assoc()){
    															$sql13 = $conn->query("SELECT ingIdEnfant FROM ParentI WHERE categIdParent = '".$result11['categIdEnfant']."'");
    															if($sql13 == TRUE){
    																if($sql13->num_rows >0){
    																	while($result12 = $sql13->fetch_assoc()){
    																	$sql14= $conn->query("SELECT nomRecette, recetteId FROM Recette INNER JOIN Composer ON recetteId = rId WHERE iId = '".$result12['ingIdEnfant']."'");
    																		if($sql14 == TRUE){
    																			while($result13 = $sql14->fetch_assoc()){
            																		$nom =  mb_convert_encoding($result13['nomRecette'], "UTF-8", "Windows-1252");
																					$arrayPhoto[$i] = str_to_noaccent(ucfirst(strtolower($nom)));
																					$arrayPhoto[$i] = str_replace(' ', '_', $arrayPhoto[$i]);
																					$arrayPhoto[$i] = str_replace(',', '', $arrayPhoto[$i]);
																					$arrayPhoto[$i] = str_replace('-', '_', $arrayPhoto[$i]);
																					$arrayPhoto[$i] .= '.jpg';
            																		$rid = (int)substr($result13['recetteId'], 2) -1;
            																		echo '
																						<div class="container">
																							<div class="row">
																								<div class="col-sm-12" style="padding:4px; border:4px solid #e0e0e0;">
																									<div class="col-md-3 col-sm-4 col-xs-6">
																										<img height="120px" width="130px" src= "'.((file_exists('style/Photos/'.$arrayPhoto[$i])) ?  ("style/Photos/".$arrayPhoto[$i])    : ("style/images/noimg.png")).'"/>
																									</div>
																									<h4 class="cocktail_police">'.$nom.'</h4>
																									<hr>
																									<a href="informationCocktail.php?cocktailId='.$rid.'">En savoir plus sur ce cocktail</a></br>
																								</div>
																							</div>
																						</div></br>';
																					$i++;    											
    																			}	
    																		}else{
    																			echo "Error querying Recette table : " . $conn->error;
    																		}
    																	}
    																}
    															}else{
    																echo "Error querying ParentI table : " . $conn->error;
    															}
    														}
    													} 
    												}else{
    													echo "Error querying ParentC table : " . $conn->error;
    												}
    											}
    										} 
    									}else{
    										echo "Error querying ParentC table : " . $conn->error;
    									}
    								}
    							} 
    						}else{
    							echo "Error querying ParentC table : " . $conn->error;
    						}
    					}
    				}
    			}
            	
        	}else{
            	echo "Error querying Ingredient table : " . $conn->error;
        	}
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