<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Polices d'écritures -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
      <!-- Icônes Bootstrap -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
      <title>Cryptaux - Connexion</title>
      <link rel="stylesheet" href="src/style.css">
      <link rel="stylesheet" href="src/Connexion.css">
      <?php session_start();?>
   </head>
   <body>
      <?php require('connect_database.php');?>
      <aside>
         <section class="form-container">
            <form method="post">
               <h1 id="form-title">Connexion</h1>
               <div class="form-input">
                  <label for="username">Adresse mail</label>
                  <input class="user-input" type="mail" name="mail" placeholder="Adresse mail" value=""  required="required">
               </div>
               <div class="form-input">   
                  <label for="password">Mot de passe</label>
                  <div class="user-input password-input">
                     <input type="password" name="password" placeholder="Nom d'utilisateur" value=""  required="required">
                     <i id="icon-eye-show" class="bi bi-eye"></i>
                     <i id="icon-eye-hide" class="bi bi-eye-slash"></i>
                  </div>
               </div>
               <?php
               // Le formulaire a été envoyé
               if (!empty($_POST)) {
                  // Récupérer les données du formulaire
                  $mail_user = $_POST["mail"];
                  $password_user = $_POST["password"];

                  // La personne est-elle dans la base de données ?
                  $is_inscrit = $db->query("SELECT count(mail) FROM cryptaux WHERE mail='$mail_user'")->fetchColumn();
                  
                  if ($is_inscrit > 0) {                     
                     $reponse=$db->query("SELECT password FROM cryptaux WHERE mail='$mail_user'")->fetchAll(PDO::FETCH_OBJ);
                     $password = $reponse[0]->password;
                  
                     if (password_verify($password_user, $password)) {
                        // Accéder au nom d'utilisateur et aux favs
                        $reponse=$db->query("SELECT username, favs FROM cryptaux WHERE mail='$mail_user'")->fetchAll(PDO::FETCH_OBJ);
                        
                        $username = $reponse[0]->username;
                        $favs = $reponse[0]->favs;

                        $_SESSION['username'] = $username;
                        $_SESSION['favs'] = $favs;

                        // Changer de page
                        header("Location: index.php");
                        exit();
                     } else {
                        echo "Mot de passe incorrect ❌";
                     }
                  } else {
                     echo "Adresse mail inconnue ❌";
                  }
               }
               ?>
               <div class="form-input">
                  <input type="submit" value="Se connecter">
                  <p style="text-align: center;">Vous n'avez pas de compte ? <a  href="inscription.php">Inscrivez-vous</a></p>
               </div>
            </form>
            <p class="text-bottom-creator-logo">EHRHARD Alexandre & ECKSTEIN Théo</p>
         </section>
      </aside>
      <div id="hero-banner">
         <div class="hero-banner-container">
            <h2 id="hero-banner-slogan">L’outil ultime<br>pour les<br>crypto-monnaies.</h2>
            <p id="hero-banner-text">Consultez en <span style="color: var(--color-orange);">un coup d’œil</span> le cours des principales crypto-monnaies. Le volume d'échange et la capitalisation boursière seront à votre porté dans une interface moderne. </p>
         </div>
         <p id="title" class="text-bottom-creator-logo">Cryp<span id="title-orange">taux</span>.</p>
      </div>
      <script src="src/Connexion.js"></script>
   </body>
</html>