<?php
	session_start();
	include 'Connexion.php';

    //Récupération des recettes dans le tableau associé.
    $tabRecette = array();
    $sql1 = $conn->query("SELECT nomRecette FROM Recette");
        while ($result1 = $sql1->fetch_assoc()) {
            $tabRecette[] = $result1;
        }

    //Récupération des préparation des recettes
	$tabPrep = array();
 	$sql2 = $conn->query("SELECT preparation FROM Recette");
  		while ($result2 = $sql2->fetch_assoc()) {
    		$tabPrep[] = $result2;
    	}

    //Récupération des ingrédients des recettes.
    $tabIngredient = array();
    $sql3 = $conn->query("SELECT ingredients FROM Recette");
        while ($result3 = $sql3->fetch_assoc()) {
            $tabIngredient[] = $result3;
        }

    $value = $_GET['cocktailId'];

    //Si l'utilisateur est connecté alors il peut ajouter une recette à ses recettes préférées. 
    if(isset($_SESSION['login'])){
        $login = $_SESSION['login'];
        if(isset($_POST['ajouter'])){
            $idCocktail = $_GET['cocktailId']+1;
             $sql2 = "INSERT INTO Favoris VALUES ('$login', 'r_".$idCocktail."')";
                if ($conn->query($sql2) === TRUE) {
                    $erreurAjout= "Cette recette fait désormais partie de vos favoris.";
                } else {
                    $erreurAjout= "Vous avez déjà ajouté cette recette à votre liste de favoris.";
                }          
        }                  
    }
    else{
        $erreurAjout =" Vous devez être connecté pour ajouter des recettes à votre panier.";
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

    <!-- inclusion de la barre de naviguation -->   
    <?php 
        include 'Include/navbar.php';
    ?>  

    <!-- Selection du mois sans alcool -->
        <div class="container">
            <div class="row">
                <div class="container text-center">
                    <br> <br>
                    <h1 class="select_mois" ><?php echo mb_convert_encoding($tabRecette[$value]['nomRecette'],"UTF-8", "Windows-1252"); ?></h1>   
                    <hr>
                    <br>
                </div>
                <div class="col-sm-6">
                    <br>
                    <div class="col-md-3 col-sm-4 col-xs-6"></div>
                    <h3 class="select_mois" style="border:4px solid black;">Préparation</h3>
                    <p class="indent_police"><?php echo mb_convert_encoding($tabPrep[$value]['preparation'],"UTF-8", "Windows-1252"); ?></p>
                </div>
                <div class="col-sm-6">
                    </br>
                    <div class="col-md-3 col-sm-4 col-xs-6"></div>
                    <h3 class="select_mois" style="border:4px solid black">Ingrédients</h3>
                    <p class="indent_police"><?php echo mb_convert_encoding($tabIngredient[$value]['ingredients'],"UTF-8", "Windows-1252"); ?></p>
                </div>
                <div id ="input" class="container text-center">
                    <form method = "post">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <?php if(isset($erreurAjout)){ echo '<h2>'.$erreurAjout.'</h2>';} else{ echo '<input class="btn btn-action" type="submit" name ="ajouter" value="Ajouter à mes favoris"> </input>';} ?>
                            </div> 
                        </div>
                    </form>
                </div>
            </div>            
        </div>
    <!-- Selection du mois avec alcool FIN -->



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