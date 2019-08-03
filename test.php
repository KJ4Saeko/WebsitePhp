<?php
include 'Donnees.inc.php';

echo'-Recettes</br>';
foreach($Recettes as $key => $value){
	echo $key;
	foreach($value as $key1 => $value1){
		if(gettype($value1) == 'string'){
			echo '----'.$key1.' : '.$value1.'</br>';
		} else {
			echo '----'.$key1.'</br>';
			foreach(array_unique($value1) as $key2 => $value2){
				echo '--------'.$value2.'</br>';
			}
		}
	}
	echo '</br>';
}

/*
//Parcours version foreach
$compteurCategorieTotal = 1;
$compteurCategorieParent =1;
$compteurSousCategorieParent1=1;
$compteurSousCategorieParent2=1;
$compteurSousCategorieParent3 = 1;
$compteurSousCategorieParent4 = 1;



echo'-Aliment'. "...Mon indice est :".$compteurCategorieTotal." <br/>";
//Récupération du type d'aliment.
foreach($Hierarchie['Aliment']['sous-categorie'] as $indice1 => $categorie1){
	$compteurCategorieTotal++;
	$compteurCategorieParent =$compteurCategorieTotal-1;
	echo '----'.$categorie1. "...Mon indice est ".$compteurCategorieTotal."...Mon parent est : ".$compteurCategorieParent.'</br>';

	if(isset($Hierarchie[$categorie1]['sous-categorie'])){
		$compteurSousCategorieParent1 = $compteurCategorieTotal ;
		foreach($Hierarchie[$categorie1]['sous-categorie'] as $indice2 => $categorie2){
			$compteurCategorieTotal++;
			echo '--------'.$categorie2. "...Mon indice est ".$compteurCategorieTotal." ...Mon parent est : ".$compteurSousCategorieParent1. '</br>';

				if(isset($Hierarchie[$categorie2]['sous-categorie'])){
					$compteurSousCategorieParent2 = $compteurCategorieTotal ;
					foreach($Hierarchie[$categorie2]['sous-categorie'] as $indice3 => $categorie3){
						$compteurCategorieTotal++;
					echo '----------------'.$categorie3."...Mon indice est ".$compteurCategorieTotal." ...Mon parent est : ".$compteurSousCategorieParent2. '</br>';

						if(isset($Hierarchie[$categorie3]['sous-categorie'])){
							$compteurSousCategorieParent3 = $compteurCategorieTotal ;
							foreach($Hierarchie[$categorie3]['sous-categorie'] as $indice4 => $categorie4){	
								$compteurCategorieTotal++;
								echo '--------------------------------'.$categorie4."...Mon indice est ".$compteurCategorieTotal." ...Mon parent est : ".$compteurSousCategorieParent3. '</br>';

									if(isset($Hierarchie[$categorie4]['sous-categorie'])){
										
										$compteurSousCategorieParent4 = $compteurCategorieTotal ;
										foreach($Hierarchie[$categorie4]['sous-categorie'] as $indice5 => $categorie5){	
																$compteurCategorieTotal++;			
											echo '----------------------------------------------------------------'.$categorie5. "...Mon indice est ".$compteurCategorieTotal." ...Mon parent est : ".$compteurSousCategorieParent4. '</br>';
										}
									}
							}
						}	
				}
		}
	}
}
}

*/
$compteurIngredient = 0;
$compteurCategorieTotal = 1;
$compteurCategorieParent = 1;
$compteurSousCategorieParent1 = 0;
$compteurSousCategorieParent2 = 0;
$compteurSousCategorieParent3 = 0;
$compteurSousCategorieParent4 = 0;

echo'<ul><li>Aliment 1</li>';
$indice = 2;
$count1 = count($Hierarchie['Aliment']['sous-categorie']);
echo '<ul>';
for($i = 0; $i < $count1; $i++){
	$array1 = array_values($Hierarchie['Aliment']['sous-categorie']);
	if(isset($Hierarchie[$array1[$i]]['sous-categorie'])){
		$compteurCategorieTotal++;
		$compteurSousCategorieParent1 = $compteurCategorieTotal;
		echo '<li>'.$array1[$i].' '.$compteurCategorieTotal.'(C) PARENT : '.$compteurCategorieParent.' </li>';
		$count2 = count($Hierarchie[$array1[$i]]['sous-categorie']);
		echo '<ul>';
		for($j = 0; $j < $count2; $j++){	
			$array2 = array_values($Hierarchie[$array1[$i]]['sous-categorie']);
			if(isset($Hierarchie[$array2[$j]]['sous-categorie'])){
				$compteurCategorieTotal++;
				$compteurSousCategorieParent2 = $compteurCategorieTotal;
				echo '<li>'.$array2[$j].' '.$compteurCategorieTotal.'(C) PARENT : '.$compteurSousCategorieParent1.' </li>';
				$count3 = count($Hierarchie[$array2[$j]]['sous-categorie']);
				echo '<ul>';
				for($k = 0; $k < $count3; $k++){
					$array3 = array_values($Hierarchie[$array2[$j]]['sous-categorie']);
					if(isset($Hierarchie[$array3[$k]]['sous-categorie'])){
						$compteurCategorieTotal++;
						$compteurSousCategorieParent3 = $compteurCategorieTotal;
						echo '<li>'.$array3[$k].' '.$compteurCategorieTotal.'(C) PARENT : '.$compteurSousCategorieParent2.' </li>';
						$count4 = count($Hierarchie[$array3[$k]]['sous-categorie']);
						echo '<ul>';
						for($l = 0; $l < $count4; $l++){
							$array4 = array_values($Hierarchie[$array3[$k]]['sous-categorie']);
							if(isset($Hierarchie[$array4[$l]]['sous-categorie'])){
								$compteurCategorieTotal++;
								$compteurSousCategorieParent4 = $compteurCategorieTotal;
								echo '<li>'.$array4[$l].' '.$compteurCategorieTotal.'(C) PARENT : '.$compteurSousCategorieParent3.' </li>';
								$count5 = count($Hierarchie[$array4[$l]]['sous-categorie']);
								echo '<ul>';
								for($m = 0; $m < $count5; $m++){
									$compteurIngredient++;
									$array5 = array_values($Hierarchie[$array4[$l]]['sous-categorie']);
									echo '<li>'.$array5[$m].' '.$compteurIngredient.'(I) PARENT : '.$compteurSousCategorieParent4.' </li>';
									foreach($Recettes as $key => $value){
										foreach($value as $key1 => $value1){
											if(gettype($value1) != 'string'){
												foreach($value1 as $key2 => $value2){
													if($value2 == $array5[$m]){
														echo '  RECETTE'.$key.'</br>';
													}
												}
											}
										}
									}
								}
								echo '</ul>';
							} else {
								$compteurIngredient++;
								echo '<li>'.$array4[$l].' '.$compteurIngredient.'(I) PARENT : '.$compteurSousCategorieParent3.' </li>';
								foreach($Recettes as $key => $value){
									foreach($value as $key1 => $value1){
										if(gettype($value1) != 'string'){
											foreach($value1 as $key2 => $value2){
												if($value2 == $array4[$l]){
													echo '  RECETTE'.$key.'</br>';
												}
											}
										}
									}
								}
							}
						}
						echo '</ul>';
					} else {
						$compteurIngredient++;
						echo '<li>'.$array3[$k].' '.$compteurIngredient.'(I) PARENT : '.$compteurSousCategorieParent2.' </li>';
						foreach($Recettes as $key => $value){
							foreach($value as $key1 => $value1){
								if(gettype($value1) != 'string'){
									foreach($value1 as $key2 => $value2){
										if($value2 == $array3[$k]){
											echo '  RECETTE'.$key.'</br>';
										}
									}
								}
							}
						}
					}
				}
				echo '</ul>';
			} else {
				$compteurIngredient++;
				echo '<li>'.$array2[$j].' '.$compteurIngredient.'(I) PARENT : '.$compteurSousCategorieParent1.' </li>';
				foreach($Recettes as $key => $value){
					foreach($value as $key1 => $value1){
						if(gettype($value1) != 'string'){
							foreach($value1 as $key2 => $value2){
								if($value2 == $array2[$j]){
									echo '  RECETTE'.$key.'</br>';
								}
							}
						}
					}
				}
			}
		}
		echo '</ul>';
	} else {
		$compteurIngredient++;
		echo '<li>'.$array1[$i].' '.$compteurIngredient.'(I) PARENT : '.$compteurCategorieParent.' </li>';
		foreach($Recettes as $key => $value){
			foreach($value as $key1 => $value1){
				if(gettype($value1) != 'string'){
					foreach($value1 as $key2 => $value2){
						if($value2 == $array1[$i]){
							echo '  RECETTE'.$key.'</br>';
						}
					}
				}
			}
		}
	}
}
echo '</ul></ul>';

?>
