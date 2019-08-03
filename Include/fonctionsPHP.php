<?php


// Fonction pour tester si une chaine de caractère est vide.
function est_vide($chaine){ 
  return (trim($chaine)=='');
}


//Fonction permettant l'envoi de mail 
function smtpmailer($to, $from, $from_name, $subject, $body) { 
      global $error;
      $mail = new PHPMailer();  // create a new object
      $mail->CharSet = 'UTF-8';
      $mail->IsSMTP(); // enable SMTP
      //$mail->SMTPDebug = 2; Pour débugger
      $mail->SMTPAuth = true;  // authentication enabled
      $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
      $mail->SMTPAutoTLS = false;
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;

      $mail->Username = "cocktail.mim@gmail.com";  
      $mail->Password = "EliasLucas012";           
      $mail->SetFrom($from, $from_name);
      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->IsHTML(true);
      $mail->AddAddress($to);
      if(!$mail->Send()) {
          $error = 'Mail error: '.$mail->ErrorInfo; 
          return false;
      } else {
          $error = 'Message sent!';
        return true;
      }
}


//Fonction pour insérer un utilisateur dans la base de donnée
function insererClient($login, $mdp, $email, $nom, $prenom, $tel, $sexe, $rue, $ville, $pays, $code, $date){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ProjetPHP";

  // Création de la connexion
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Vérification de la connexion
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

    $sql = "INSERT INTO Utilisateur VALUES ('$login', '$mdp', '$email', '$nom', '$prenom', '$tel', '$sexe', '$rue', '$ville', '$pays', '$code', '$date')";
          if ($conn->query($sql) === TRUE) {
            echo "Row inserted in Utilisateur table successfully</br>";
          } else {
            echo "Error inserting row in Utilisateur : " . $conn->error;
            }
}


function existeClient($login, $mdp){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ProjetPHP";

  // Création de la connexion
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Vérification de la connexion
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT login, motDePasse FROM Utilisateur WHERE login = '$login'";

    if ($result = mysqli_query($conn, $sql)) {
      /* Récupère un tableau associatif */
      while ($row = mysqli_fetch_assoc($result)) {
        $mdpVerif = password_verify($mdp, $row['motDePasse']);
        if($row["login"] == $login && $mdpVerif){
          return true;
        }
        else{
          return false;
        }
      }

      /* Libération des résultats */
      mysqli_free_result($result);
    }
}


//Verifie si une session est en cours
function sessionActive(){
  if(session_status() == 2){
    return true;
  }
  else{
    return false;
  }
}


//Deconnecte l'utilisateur au bout de 5 minutes
function delai(){
  $time = time();
  $delay = 300 - ( $time % 300);

  if($delay == 0){
    include'deconnexion.php';
  }
}

//Récupère les données d'un utilisateur
function recupClient($login){
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ProjetPHP";

  // Création de la connexion
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Vérification de la connexion
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql ="SELECT login, email, nom, prenom, sex, adresse, codePostal, ville, pays, numeroTel, dateNaissance  from Utilisateur where login  = '$login'";
    if($result = mysqli_query($conn, $sql)) {
      $row = mysqli_fetch_assoc($result);
      return $row;
      
    }
}

function str_to_noaccent($str)
{
    $url = $str;
    $url = preg_replace('#Ç#', 'C', $url);
    $url = preg_replace('#ç#', 'c', $url);
    $url = preg_replace('#è|é|ê|ë#', 'e', $url);
    $url = preg_replace('#È|É|Ê|Ë#', 'E', $url);
    $url = preg_replace('#à|á|â|ã|ä|å#', 'a', $url);
    $url = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $url);
    $url = preg_replace('#ì|í|î|ï#', 'i', $url);
    $url = preg_replace('#Ì|Í|Î|Ï#', 'I', $url);
    $url = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $url);
    $url = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $url);
    $url = preg_replace('#ù|ú|û|ü#', 'u', $url);
    $url = preg_replace('#Ù|Ú|Û|Ü#', 'U', $url);
    $url = preg_replace('#ý|ÿ#', 'y', $url);
    $url = preg_replace('#Ý#', 'Y', $url);
    $url = preg_replace('#ñ#', 'n', $url);
     
    return ($url);
}

?>