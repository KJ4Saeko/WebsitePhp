<?php 
//Verification du formulaire bien rempli. 

include 'Include/fonctionsPHP.php';
include 'Connexion.php';

//inclusion des classes de PHP mailer pour l'envoi de mail(Nécessaire)
require('style/PHPMailer/PHPMailerAutoload.php');
require_once('style/PHPMailer/class.phpmailer.php');

  delai();
  
//Variables de récupération des erreurs lié au formulaire
$message ="";
$errLogin ="";
$errMdp1="";
$errMdp2="";
$errPrenom="";
$errNom="";
$errMail="";
$errRue="";
$errNumero="";
$errVille="";
$errCode="";
$errTelephone="";
$errDate="";


//Variables de récupération des données du formulaire.
$result="";
$recupMotDePasse="";
$recupMotDePasseControle="";
$recupMail="";
$recupNom="";
$recupPrenom="";
$recupSexe="";
$recupRue="";
$recupVille="";
$recupCode="";
$recupNaissance="";
$recupTelephone="";
$recupPays="";


  //Si le bouton a été appuyé 
  if(isset($_POST["submit"])){ 

      //verification pour le login Aucun caractère spéciaux ni d'accent. Entre 3 et 15 caracteres
      if(isset($_POST['login']) && preg_match("/^[a-zA-Z0-9 _-]{3,15}+$/", $_POST['login'])){
        $recupLogin =$_POST['login'];
      }
      else{
        $errLogin = " Veuillez entrer un Login !";
      }


      /* verification pour le mot de passe  Doit contenir 8 à 15 lettres/ au moins une minuscule / au moins une majuscule / au moins un chiffre 
          Au moins un caractère spécial :  $ @ % * + - _ ! / aucun autre caractère possible.*/
      if(isset($_POST["motdepasse"]) && preg_match("/^(?=.*[a-zA-Z])(?=.*[a-zA-Z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/", $_POST['motdepasse'])){
        $recupMotDePasse = $_POST['motdepasse'];
      }  
      else{
        $errMdp1=" Veuillez entrer un mot de passe ! Il doit contenir une minuscule, une majuscule, un chiffre et un caractère spécial : $ @ % * + - _ ! (8 caractères minimum)";
      }

      // Contrôle si les deux mots de passes sont identiques.
      if(isset($_POST["motdepassecontrole"]) && isset($_POST["motdepasse"])){
          $controle_temp = $_POST["motdepassecontrole"];
        if($recupMotDePasse == $controle_temp){
          $recupMotDePasseControle = $_POST['motdepassecontrole'];
        } 
      } 
      else{
        $errMdp2=" Vos deux mots de passe ne correspondent pas !";
      } 

      //verification pour le prénom, il doit contenir que des lettres peut contenir un "-" & un " ' " mais pas en début ni en fin. Minuscule ou majuscule
      if(isset($_POST['prenom'])){
        if(preg_match("/^[a-zA-Z]+[ \-']?[[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+[ \-']?]*[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+$/", $_POST['prenom'])){
            $recupPrenom=$_POST['prenom'];
        }
        else if(strlen($_POST['prenom']) > 1 ){
          $errPrenom=" Prénom invalide !";
        }
      }  

      //verification pour le prénom, il doit contenir que des lettres peut contenir un "-" mais pas en début ni en fin. Minuscule ou majuscule
      if(isset($_POST['nom'])){
        if(preg_match("/^[a-zA-Z]+[ \-']?[[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+[ \-']?]*[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+$/", $_POST['nom'])){
          $recupNom=$_POST['nom'];
        }
        else if(strlen($_POST['nom']) > 1 ){
          $errNom = "Nom invalide !";
          }
      } 

      //Pour le sexe
      if(isset($_POST['sexe'])){
         $recupSexe = $_POST['sexe'];
      }

      if(isset($_POST['mail'])){
        if(preg_match("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ ", $_POST['mail'])){
          $recupMail=$_POST['mail'];
        }
      else if(strlen($_POST['mail']) > 1 ){
            $errMail = "Email invalide !";
        }
      } 

      //Verification de la rue  peut contenir des espaces ainsi que des lettres.
      if(isset($_POST['rue'])){
        if(preg_match("/[A-Za-z]{1}[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s-]{5,60}/", $_POST['rue'])){
          $recupRue=$_POST['rue'];
        }
        else if(strlen($_POST['rue']) > 1 ){
          $errRue="Rue invalide !";
        }
      }

      //Verification de la ville, majuscule/minuscule peut contenir des tirets
      if(isset($_POST['ville'])){
        if(preg_match("/^[a-zA-Z]+[ \-']?[[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+[ \-']?]*[a-zàáâäçèéêëìíîïñòóôöùúûüA-Z]+$/", $_POST['ville'])){
          $recupVille=$_POST['ville'];
        }
        else if(strlen($_POST['ville']) > 1 ){
          $errVille="Ville invalide !";
        }
      } 

      //Code postal à 5 chiffres
      if(isset($_POST['code'])){
        if(preg_match("/^[0-9]{5,5}$/", $_POST['code'])){
          $recupCode=$_POST['code'];
        }
        else if(strlen($_POST['code']) > 1 ){
          $errCode = "Code invalide !";
        }
       } 

      //Téléphone français, peut commener par +33 ou 0
      if(isset($_POST['telephone'])){
        if(preg_match("/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/", $_POST['telephone'])){
            $recupTelephone=$_POST['telephone'];
        }
        else if(strlen($_POST['telephone']) > 1 ){
          $errTelephone="Téléphone invalide !";
        }
      }

      if(isset($_POST['pays'])){
        $recupPays = $_POST['pays'];
      }


      //vérification de la date de naissance entré, elle doit être sous la forme 00-00-0000, si l'utilisateur n'est pas majeur alors erreur de formulaire.
      $date_courante = new DateTime(date("d-m-Y"));
      $interval = new DateTime(date("d-m-Y"));
      if(isset($_POST['naissance'])){
        if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $_POST['naissance'])){
          $date_temp_user = new DateTime($_POST['naissance']);
            $interval = $date_courante -> diff($date_temp_user);
              if( intval($interval->format('%Y')) < 18){
                $errDate="Vous n'êtes pas majeur !";
              }
              else{
                $recupNaissance = $_POST['naissance'];
              }
        }
        else if(strlen($_POST['naissance']) > 1 ){
          $errDate = "Date de naissance invalide !";
        }
      } 

      
      //Si le login, le mot de passe sont correct ( validation du formulaire)
      if(!est_vide($recupLogin) && !est_vide($recupLogin) && !est_vide($recupMotDePasse) && !est_vide($recupMotDePasseControle)){
        //Pour l'envoi de mail, il faut le nom, le prénom et l'email.
        if(!est_vide($recupNom) && !est_vide($recupPrenom) && !est_vide($recupMail)){
          $message .= '<html>
                  <body>
                    <div align="center">
                      <br />
                        Vous avez reçu un message de la part de Cocktails & co :
                        <br />
                          Nous vous remercions de vous être inscrit ! : <br /> <br />'. $recupNom. " " . $recupPrenom .
                          '<br /> <br />
                           A bientôt sur Cocktails & co !
                    </div>
                  </body>
                </html>';
            
            //On vérifie que le login est unique ainsi que l'adresse mail    
            $sql = mysqli_query($conn,'SELECT EXISTS (SELECT * FROM Utilisateur WHERE login ="'.$recupLogin.'") AS loginExist');
            $sql2 = mysqli_query($conn,'SELECT EXISTS (SELECT * FROM Utilisateur WHERE email ="'.$recupMail.'") AS mailExist');

            $req = mysqli_fetch_array($sql);
            $req2 = mysqli_fetch_array($sql2);

            if($req['loginExist']){
              $errLogin="Login déjà utilisé !";
            }
            else if($req2['mailExist']){
              $errMail="Email déjà utilisé !";
            }
            else{
              //On hach le mot de passe avant de le rentrer dans la base de donnée. Envoi de mail et redirection.
              $motDePasseHach = password_hash($recupMotDePasse, PASSWORD_DEFAULT);
              smtpmailer($recupMail, "cocktail.mim@gmail.com", "Cocktails & co", "Bienvenue chez Cocktails & co ! ", $message);     
              insererClient($recupLogin, $motDePasseHach, $recupMail, $recupNom, $recupPrenom, $recupTelephone, $recupSexe, $recupRue, $recupVille, $recupPays, $recupCode, $recupNaissance);
              header('Location: authentificationSucces.php');
              exit();
            }
        }
        else{
            $sql = mysqli_query($conn,'SELECT EXISTS (SELECT * FROM Utilisateur WHERE login ="'.$recupLogin.'") AS loginExist');
            $sql2 = mysqli_query($conn,'SELECT EXISTS (SELECT * FROM Utilisateur WHERE email ="'.$recupMail.'") AS mailExist');

            $req = mysqli_fetch_array($sql);
            $req2 = mysqli_fetch_array($sql2);

            if($req['loginExist']){
              $errLogin="Login déjà utilisé !";
            }
            else if($req2['mailExist']){
              $errMail="Email déjà utilisé !";
            }
            else{
              $motDePasseHach = password_hash($recupMotDePasse, PASSWORD_DEFAULT);
              smtpmailer($recupMail, "cocktail.mim@gmail.com", "Cocktails & co", "Bienvenue chez Cocktails & co ! ", $message);
              insererClient($recupLogin, $motDePasseHach, $recupMail, $recupNom, $recupPrenom, $recupTelephone, $recupSexe, $recupRue, $recupVille, $recupPays, $recupCode, $recupNaissance);
              header('Location: authentificationSucces.php');
              exit();
          }       
        }
    }
    else{
        $result='<div class="alert alert-danger">Certains champs sont invalides.</div>';
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

  <!-- inclusion de la barre de naviguation --> 
  <?php 
    include 'Include/navbar.php';
  ?>  

  
  <!-- Header image -->
  <header id="head" class"secondary" ></header>

  
  <div class="container">

    <!-- Texte de redirection -->
    <ol class="breadcrumb" style="padding-left:1.5em;">
      <li><a href="index.html">Accueil</a></li>
      <li class="active">Création du compte</li>
    </ol>
    <article class="col-xs-12 maincontent">
        <header class="page-header">
          <h1 class="page-title" style=" margin-left: 1px;">Création du compte</h1>
        </header>
    </article>
    <!-- FIN Texte de redirection -->


    <!-- Début du formulaire -->
    <div class="row">  

        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          <div class="panel panel-default">
            <div class="panel-body">
              <h3 class="thin text-center">Créer un nouveau compte</h3>

              <!-- initialisation --> 
              <form data-toogle="validator" method="post" role="form">

              <!--Login utilisateur-->
                <div class="top-margin" class="form-group">
                  <label>Login<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="login" style="font-style : italic;" required>
                  <?php echo "<p class='text-danger'>$errLogin</p>";?>
                </div>

              <!--Prenom utilisateur-->
                <div class="top-margin" class="form-group">
                  <label>Prénom</label>
                  <input type="text" class="form-control" name="prenom" placeholder="Exemple: Lucas" style="font-style : italic;" value="<?php if(isset($_POST['prenom'])) echo($_POST['prenom']);?>">
                  <?php echo "<p class='text-danger'>$errPrenom</p>";?>
                </div>

              <!--Nom utilisateur-->
                <div class="top-margin">
                  <label>Nom</label>
                  <input type="text" class="form-control" name="nom" placeholder="Exemple: LaFeuille" style="font-style : italic;" value="<?php if(isset($_POST['nom'])) echo($_POST['nom']);?>">
                  <?php echo "<p class='text-danger'>$errNom</p>";?>
                </div>

              <!--Sexe Utilisateur -->
              <div class="top-margin">
                <label>Sexe</label> </br>
                <label class="radio-inline"><input type="radio"  name="sexe" value="Homme"> Homme </label>
                <label class="radio-inline"><input type="radio"  name="sexe" value="Femme"> Femme </label>
              </div>

              <!--Email utilisateur-->
                <div class="top-margin">
                  <label>Email</label>
                  <input type="text" class="form-control" name="mail" placeholder="Exemple: LucasLafeuille@gmail.com" style="font-style : italic;" value="<?php if(isset($_POST['mail'])) echo($_POST['mail']);?>">
                  <?php echo "<p class='text-danger'>$errMail</p>";?>
                </div>

              <!--Mot de passe utilisateur-->
                <div class="row top-margin">
                  <div class="col-sm-6">
                    <label>Mot de passe<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="motdepasse" placeholder="Exemple: Mdp1234$*@" style="font-style : italic;" required>
                    <?php echo "<p class='text-danger'>$errMdp1</p>";?>
                  </div>
                  <div class="col-sm-6">
                    <label>Confimer votre mot de passe<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="motdepassecontrole" required>
                    <?php echo "<p class='text-danger'>$errMdp2</p>";?>
                  </div>
                </div>

              <!--Adresse utilisateur-->
                <div class="row top-margin">
                  <div class="col-sm-6">
                    <label>Rue</label>
                    <input type="text" class="form-control" name="rue" placeholder="Exemple: rue des arbres" style="font-style : italic;" value="<?php if(isset($_POST['rue'])) echo($_POST['rue']);?>">
                    <?php echo "<p class='text-danger'>$errRue</p>";?>
                  </div>
                </div>

              <!--Ville utilisateur-->
              <div class="top-margin">
                    <label>Ville</label>
                    <input type="text" class="form-control" name="ville" placeholder="Exemple: Herbier" style="font-style : italic;" value="<?php if(isset($_POST['ville'])) echo($_POST['ville']);?>">
                    <!--verification pour la ville -->
                    <?php echo "<p class='text-danger'>$errVille</p>";?>
                  </div>

              <!--Pays & code postal utilisateur-->
                <div class="row top-margin">
                  <div class="col-sm-6">
                    <label for="inputPays">Pays</label>
                      <select id="inputPays" class="form-control" name="pays">
                        <option>France </option>
                        <option>Allemagne </option>
                        <option>Luxembourg </option>
                        <option>Angleterre </option>
                        <option>Espagne </option>
                        <option>Belgique </option>
                        <option>Autre </options>
                      </select>
                  </div>
                  <div class="col-sm-6">
                    <label>Code Postal</label>
                    <input type="text" class="form-control" name="code" placeholder="Exemple: 57000" style="font-style : italic;" value="<?php if(isset($_POST['code'])) echo($_POST['code']);?>">
                    <?php echo "<p class='text-danger'>$errCode</p>";?> 
                  </div>
                </div>

              <!--Telephone utilisateur-->
                <div class="top-margin">
                  <label>Téléphone</label>
                  <input type="tel" class="form-control" name="telephone" placeholder="Exemple: 0102030405" style="font-style : italic;" value="<?php if(isset($_POST['telephone'])) echo($_POST['telephone']);?>">
                   <?php echo "<p class='text-danger'>$errTelephone</p>";?>
                </div>

              <!--naissance utilisateur-->
                <div class="top-margin">
                  <label>Date de naissance</label>
                  <input type="text" class="form-control" name="naissance" placeholder="Exemple: 01-01-1990" style="font-style : italic;" min="1900-01-01" value="<?php if(isset($_POST['naissance'])) echo($_POST['naissance']);?>">
                   <?php echo "<p class='text-danger'>$errDate</p>";?>
                </div>

                <hr>

                <div class="row">
                  <div class="col-lg-12 text-center">
                    <input class="btn btn-action" type="submit" name ="submit" value="S'enregistrer"> </input>
                  </div>
                </div>

                <!-- Formulaire envoyé ou pas message -->
                <div class="top-margin">
                  <div class="col-sm-8 col-sm-offset-2">
                    <?php echo $result; ?>  
                  </div>
                </div>

              </form> <!-- FIN du formulaire -->
            </div>
          </div>
        </div>
    </div>
    <!-- Fin -->
  </div>
  <!-- Fin du container --> 


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