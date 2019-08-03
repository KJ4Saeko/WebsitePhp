<?php
include 'Donnees.inc.php';

// Connexion au serveur
$servername = "localhost";
$username = "root";
$password = "";

// Création de la connexion
$conn = new mysqli($servername, $username, $password);
// Vérification de la connexion
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . "</br>");
}


// Création de la base de données
$sql = "CREATE DATABASE ProjetPHP";
if ($conn->query($sql) === TRUE) {
	echo "Database created successfully</br>";
} else {
	echo "Error creating database: " . $conn->error . "</br>";
}
$conn->close();

// Connexion au serveur
include 'Connexion.php';


// Connexion à la base de donnée crée
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ProjetPHP";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);
// Vérification de la connexion
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . "</br>");
}
mysqli_set_charset($conn, "utf8");

// Création des tables
// Table Recette
$sql = "CREATE TABLE Recette (
recetteId VARCHAR(10) NOT NULL ,
nomRecette VARCHAR(100) NOT NULL,
ingredients VARCHAR(1000) NOT NULL,
preparation VARCHAR(1000) NOT NULL,
PRIMARY KEY (recetteId)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table Recette created successfully</br>";
} else {
	echo "Error creating table Recette: " . $conn->error . "</br>";
}

// Table Categorie
$sql = "CREATE TABLE Categorie (
categorieId VARCHAR(10) NOT NULL,
nomCategorie VARCHAR(30) NOT NULL,
PRIMARY KEY (categorieId)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table Categorie created successfully</br>";
} else {
	echo "Error creating table: " . $conn->error . "</br>";
}

// Table ParentC (Categories parents d'autres categories)
$sql = "CREATE TABLE ParentC (
categIdParent VARCHAR(10) NOT NULL,
categIdEnfant VARCHAR(10) NOT NULL,
PRIMARY KEY (categIdParent, categIdEnfant),
FOREIGN KEY (categIdParent) REFERENCES Categorie(categorieId),
FOREIGN KEY (categIdEnfant) REFERENCES Categorie(categorieId)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table ParentC created successfully</br>";
} else {
	echo "Error creating table ParentC: " . $conn->error . "</br>";
}

// Table Ingredient
$sql = "CREATE TABLE Ingredient (
ingredientId VARCHAR(10) NOT NULL,
nomIngredient VARCHAR(30) NOT NULL,
PRIMARY KEY (ingredientId)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table Ingredient created successfully</br>";
} else {
	echo "Error creating table: " . $conn->error . "</br>";
}

// Table ParentI (Categories parents d'ingredients)
$sql = "CREATE TABLE ParentI (
categIdParent VARCHAR(10) NOT NULL,
ingIdEnfant VARCHAR(10) NOT NULL,
PRIMARY KEY (categIdParent, ingIdEnfant),
FOREIGN KEY (categIdParent) REFERENCES Categorie(categorieId),
FOREIGN KEY (ingIdEnfant) REFERENCES Ingredient(ingredientId)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table ParentI created successfully</br>";
} else {
	echo "Error creating table ParentI: " . $conn->error . "</br>";
}

// Table Composer
$sql = "CREATE TABLE Composer (
rId VARCHAR(10) NOT NULL,
iId VARCHAR(10) NOT NULL,
PRIMARY KEY (rId,iId),
FOREIGN KEY (rId) REFERENCES Recette(recetteId),
FOREIGN KEY (iId) REFERENCES Ingredient(ingredientId)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table Composer created successfully</br>";
} else {
	echo "Error creating table Composer: " . $conn->error . "</br>";
}

// Table Utilisateur
$sql = "CREATE TABLE Utilisateur (
login VARCHAR(15) NOT NULL,
motDePasse VARCHAR(255)NOT NULL,
email VARCHAR(50) UNIQUE,
nom VARCHAR(30),
prenom VARCHAR(30),
numeroTel VARCHAR(30),
sex VARCHAR(30),
adresse VARCHAR(50),
ville VARCHAR(30),
pays VARCHAR(30),
codePostal VARCHAR(30),
dateNaissance VARCHAR(30),
PRIMARY KEY (login)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table Utilisateur created successfully</br>";
} else {
	echo "Error creating table Utilisateur: " . $conn->error . "</br>" . "</br>";
}

// Table favoris
$sql = "CREATE TABLE Favoris (
login VARCHAR(15) NOT NULL,
recetteId VARCHAR(10) NOT NULL,
PRIMARY KEY (recetteId, login),
FOREIGN KEY (login) REFERENCES Utilisateur(login),
FOREIGN KEY (recetteId) REFERENCES Recette(recetteId)
)";

if ($conn->query($sql) === TRUE) {
	echo "Table Favoris created successfully</br>";
} else {
	echo "Error creating table Favoris: " . $conn->error . "</br>" . "</br>";
}

//Parcours et insertion dans la table Categorie/Ingredient/ParentC/ParentI
$compteurIngredient = 0;
$compteurCategorieTotal = 1;
$compteurCategorieParent = 1;
$compteurSousCategorieParent1 = 0;
$compteurSousCategorieParent2 = 0;
$compteurSousCategorieParent3 = 0;
$compteurSousCategorieParent4 = 0;

$sql = "INSERT INTO Categorie VALUES ('c_1', 'Aliment')";
if ($conn->query($sql) === TRUE) {
	echo "Row inserted in Categorie table successfully</br>";
} else {
	echo "Error inserting row in Categorie : " . $conn->error . "</br>";
}
$indice = 2;
$count1 = count($Hierarchie['Aliment']['sous-categorie']);
for($i = 0; $i < $count1; $i++){
	$array1 = array_values($Hierarchie['Aliment']['sous-categorie']);
	if(isset($Hierarchie[$array1[$i]]['sous-categorie'])){
		$compteurCategorieTotal++;
		$compteurSousCategorieParent1 = $compteurCategorieTotal;
		$sql = "INSERT INTO Categorie VALUES ('c_".$compteurCategorieTotal."', '".htmlspecialchars($conn->real_escape_string($array1[$i]))."')";
		if ($conn->query($sql) === TRUE) {
			echo "Row inserted in Categorie table successfully</br>";
		} else {
			echo "Error inserting row in Categorie : " . $conn->error . "</br>";
		}
		$sql = "INSERT INTO ParentC VALUES ('c_".$compteurCategorieParent."', 'c_".$compteurCategorieTotal."')";
		if ($conn->query($sql) === TRUE) {
			echo "Row inserted in ParentC table successfully</br>";
		} else {
			echo "Error inserting row in ParentC : " . $conn->error . "</br>";
		}
		$count2 = count($Hierarchie[$array1[$i]]['sous-categorie']);
		for($j = 0; $j < $count2; $j++){	
			$array2 = array_values($Hierarchie[$array1[$i]]['sous-categorie']);
			if(isset($Hierarchie[$array2[$j]]['sous-categorie'])){
				$compteurCategorieTotal++;
				$compteurSousCategorieParent2 = $compteurCategorieTotal;
				$sql = "INSERT INTO Categorie VALUES ('c_".$compteurCategorieTotal."', '".htmlspecialchars($conn->real_escape_string($array2[$j]))."')";
				if ($conn->query($sql) === TRUE) {
					echo "Row inserted in Categorie table successfully</br>";
				} else {
					echo "Error inserting row in Categorie : " . $conn->error . "</br>";
				}
				$sql = "INSERT INTO ParentC VALUES ('c_".$compteurSousCategorieParent1."', 'c_".$compteurCategorieTotal."')";
				if ($conn->query($sql) === TRUE) {
					echo "Row inserted in ParentC table successfully</br>";
				} else {
					echo "Error inserting row in ParentC : " . $conn->error . "</br>";
				}
				$count3 = count($Hierarchie[$array2[$j]]['sous-categorie']);
				for($k = 0; $k < $count3; $k++){
					$array3 = array_values($Hierarchie[$array2[$j]]['sous-categorie']);
					if(isset($Hierarchie[$array3[$k]]['sous-categorie'])){
						$compteurCategorieTotal++;
						$compteurSousCategorieParent3 = $compteurCategorieTotal;
						$sql = "INSERT INTO Categorie VALUES ('c_".$compteurCategorieTotal."', '".htmlspecialchars($conn->real_escape_string($array3[$k]))."')";
						if ($conn->query($sql) === TRUE) {
							echo "Row inserted in Categorie table successfully</br>";
						} else {
							echo "Error inserting row in Categorie : " . $conn->error . "</br>";
						}
						$sql = "INSERT INTO ParentC VALUES ('c_".$compteurSousCategorieParent2."', 'c_".$compteurCategorieTotal."')";
						if ($conn->query($sql) === TRUE) {
							echo "Row inserted in ParentC table successfully</br>";
						} else {
							echo "Error inserting row in ParentC : " . $conn->error . "</br>";
						}
						$count4 = count($Hierarchie[$array3[$k]]['sous-categorie']);
						for($l = 0; $l < $count4; $l++){
							$array4 = array_values($Hierarchie[$array3[$k]]['sous-categorie']);
							if(isset($Hierarchie[$array4[$l]]['sous-categorie'])){
								$compteurCategorieTotal++;
								$compteurSousCategorieParent4 = $compteurCategorieTotal;
								$sql = "INSERT INTO Categorie VALUES ('c_".$compteurCategorieTotal."', '".htmlspecialchars($conn->real_escape_string($array4[$l]))."')";
								if ($conn->query($sql) === TRUE) {
									echo "Row inserted in Categorie table successfully</br>";
								} else {
									echo "Error inserting row in Categorie : " . $conn->error . "</br>";
								}
								$sql = "INSERT INTO ParentC VALUES ('c_".$compteurSousCategorieParent3."', 'c_".$compteurCategorieTotal."')";
								if ($conn->query($sql) === TRUE) {
									echo "Row inserted in ParentC table successfully</br>";
								} else {
									echo "Error inserting row in ParentC : " . $conn->error . "</br>";
								}
								$count5 = count($Hierarchie[$array4[$l]]['sous-categorie']);
								for($m = 0; $m < $count5; $m++){
									$array5 = array_values($Hierarchie[$array4[$l]]['sous-categorie']);
									$sql = "SELECT ingredientId FROM Ingredient WHERE nomIngredient = '".htmlspecialchars($conn->real_escape_string($array5[$m]))."'";
									if ($result = $conn->query($sql)) {
										if($conn->affected_rows > 0){
											if ($row = $result->fetch_assoc()) {
												$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent4."', '".$row["ingredientId"]."')";
												if ($conn->query($sql) === TRUE) {
													echo "Row inserted in ParentI table successfully</br>";
												} else {
													echo "Error inserting row in ParentI : " . $conn->error . "</br>";
												}
											}
										} else {
											$compteurIngredient++;
											$sql = "INSERT INTO Ingredient VALUES ('i_".$compteurIngredient."', '".htmlspecialchars($conn->real_escape_string($array5[$m]))."')";
											if ($conn->query($sql) === TRUE) {
												echo "Row inserted in Ingredient table successfully</br>";
											} else {
												echo "Error inserting row in Ingredient : " . $conn->error . "</br>";
											}
											$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent4."', 'i_".$compteurIngredient."')";
											if ($conn->query($sql) === TRUE) {
												echo "Row inserted in ParentI table successfully</br>";
											} else {
												echo "Error inserting row in ParentI : " . $conn->error . "</br>";
											}
										}
									}
									$result->free();
								}
							} else {
								$sql = "SELECT ingredientId FROM Ingredient WHERE nomIngredient = '".htmlspecialchars($conn->real_escape_string($array4[$l]))."'";
								if ($result = $conn->query($sql)) {
									if($conn->affected_rows > 0){
										if ($row = $result->fetch_assoc()) {
											$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent3."', '".$row["ingredientId"]."')";
											if ($conn->query($sql) === TRUE) {
												echo "Row inserted in ParentI table successfully</br>";
											} else {
												echo "Error inserting row in ParentI : " . $conn->error . "</br>";
											}
										}
									} else {
										$compteurIngredient++;
										$sql = "INSERT INTO Ingredient VALUES ('i_".$compteurIngredient."', '".htmlspecialchars($conn->real_escape_string($array4[$l]))."')";
										if ($conn->query($sql) === TRUE) {
											echo "Row inserted in Ingredient table successfully</br>";
										} else {
											echo "Error inserting row in Ingredient : " . $conn->error . "</br>";
										}
										$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent3."', 'i_".$compteurIngredient."')";
										if ($conn->query($sql) === TRUE) {
											echo "Row inserted in ParentI table successfully</br>";
										} else {
											echo "Error inserting row in ParentI : " . $conn->error . "</br>";
										}
									}
								}
								$result->free();
							}
						}
					} else {
						$sql = "SELECT ingredientId FROM Ingredient WHERE nomIngredient = '".htmlspecialchars($conn->real_escape_string($array3[$k]))."'";
						if ($result = $conn->query($sql)) {
							if($conn->affected_rows > 0){
								if ($row = $result->fetch_assoc()) {
									$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent2."', '".$row["ingredientId"]."')";
									if ($conn->query($sql) === TRUE) {
										echo "Row inserted in ParentI table successfully</br>";
									} else {
										echo "Error inserting row in ParentI : " . $conn->error . "</br>";
									}
								}
							} else {
								$compteurIngredient++;
								$sql = "INSERT INTO Ingredient VALUES ('i_".$compteurIngredient."', '".htmlspecialchars($conn->real_escape_string($array3[$k]))."')";
								if ($conn->query($sql) === TRUE) {
									echo "Row inserted in Ingredient table successfully</br>";
								} else {
									echo "Error inserting row in Ingredient : " . $conn->error . "</br>";
								}
								$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent2."', 'i_".$compteurIngredient."')";
								if ($conn->query($sql) === TRUE) {
									echo "Row inserted in ParentI table successfully</br>";
								} else {
									echo "Error inserting row in ParentI : " . $conn->error . "</br>";
								}
							}
						}
						$result->free();
					}
				}
			} else {
				$sql = "SELECT ingredientId FROM Ingredient WHERE nomIngredient = '".htmlspecialchars($conn->real_escape_string($array2[$j]))."'";
				if ($result = $conn->query($sql)) {
					if($conn->affected_rows > 0){
						if ($row = $result->fetch_assoc()) {
							$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent1."', '".$row["ingredientId"]."')";
							if ($conn->query($sql) === TRUE) {
								echo "Row inserted in ParentI table successfully</br>";
							} else {
								echo "Error inserting row in ParentI : " . $conn->error . "</br>";
							}
						}
					} else {
						$compteurIngredient++;
						$sql = "INSERT INTO Ingredient VALUES ('i_".$compteurIngredient."', '".htmlspecialchars($conn->real_escape_string($array2[$j]))."')";
						if ($conn->query($sql) === TRUE) {
							echo "Row inserted in Ingredient table successfully</br>";
						} else {
							echo "Error inserting row in Ingredient : " . $conn->error . "</br>";
						}
						$sql = "INSERT INTO ParentI VALUES ('c_".$compteurSousCategorieParent1."', 'i_".$compteurIngredient."')";
						if ($conn->query($sql) === TRUE) {								echo "Row inserted in ParentI table successfully</br>";
						} else {
							echo "Error inserting row in ParentI : " . $conn->error . "</br>";
						}
					}
				}
				$result->free();
			}
		}
	} else {
		$sql = "SELECT ingredientId FROM Ingredient WHERE nomIngredient = '".htmlspecialchars($conn->real_escape_string($array1[$i]))."'";
		if ($result = $conn->query($sql)) {
			if($conn->affected_rows > 0){
				if ($row = $result->fetch_assoc()) {
					$sql = "INSERT INTO ParentI VALUES ('c_".$compteurCategorieParent."', '".$row["ingredientId"]."')";
					if ($conn->query($sql) === TRUE) {
						echo "Row inserted in ParentI table successfully</br>";
					} else {
						echo "Error inserting row in ParentI : " . $conn->error . "</br>";
					}
				}	
			} else {
				$compteurIngredient++;
				$sql = "INSERT INTO Ingredient VALUES ('i_".$compteurIngredient."', '".htmlspecialchars($conn->real_escape_string($array1[$i]))."')";
				if ($conn->query($sql) === TRUE) {
					echo "Row inserted in Ingredient table successfully</br>";
				} else {
					echo "Error inserting row in Ingredient : " . $conn->error . "</br>";
				}
				$sql = "INSERT INTO ParentI VALUES ('c_".$compteurCategorieParent."', 'i_".$compteurIngredient."')";
				if ($conn->query($sql) === TRUE) {								
					echo "Row inserted in ParentI table successfully</br>";
				} else {
					echo "Error inserting row in ParentI : " . $conn->error . "</br>";
				}
			}
		}
		$result->free();
	}
}

//Parcours et insertion dans la table Recette
foreach($Recettes as $key => $value){
	$id = $key+1;
	$sql = "INSERT INTO Recette VALUES ('r_".$id."', '".htmlspecialchars($conn->real_escape_string($value['titre']))."', '".htmlspecialchars($conn->real_escape_string($value['ingredients']))."', '".htmlspecialchars($conn->real_escape_string($value['preparation']))."')";
	if ($conn->query($sql) === TRUE) {
		echo "Row inserted in Recette table successfully</br>";
	} else {
		echo "Error inserting row in Recette : " . $conn->error . "</br>";
	}
	foreach($value as $key1 => $value1){
		if(gettype($value1) != 'string'){
			foreach(array_unique($value1) as $key2 => $value2){
				$sql = "SELECT ingredientId FROM Ingredient WHERE nomIngredient = '".htmlspecialchars($conn->real_escape_string($value2))."'";
				if ($result = $conn->query($sql)){	
					if($row = $result->fetch_assoc()){
						$sql = "INSERT INTO Composer VALUES ('r_".$id."', '".$row['ingredientId']."')";
						if ($conn->query($sql) === TRUE) {
							echo "Row inserted in Composer table successfully</br>";
						} else {
							echo "Error inserting row in Composer : " . $conn->error . "</br>";
						}
					}		
				}
			}
		}
	}
}

$conn->close();
?>
