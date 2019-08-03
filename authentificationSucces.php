<?php 
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


  <!-- Header image-->
  <header id="head" class"secondary" ></header>


  <!-- Contenu de la page -->
  <div class="container">
    <!-- Texte de redirection -->
    <ol class="breadcrumb" style="padding-left:1.5em;">
      <li><a href="index.html">Accueil</a></li>
      <li class="active">Création du compte</li>
    </ol>
    <div class="row">
      <article class="col-xs-12 maincontent">
        <header class="page-header">
          <h1 class="page-title" style=" margin-left: 1px;">Merci de vous être enregistré ! </h1>
        </header>
      </article>
    <!-- Fin de texte de redirection -->


      <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-default">
          <div class="panel-body">
            <h3 class="select_mois"> Bienvenue </h3>
            <p class ="select_mois"> Votre compte a bien été créé. 
              Vous pouvez désormais découvrir nos cocktails !</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- FIN du contenu -->


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