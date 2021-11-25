<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css" />
    <strong><title>moduleconnexion</title></strong>
</head>
<body>
    <main>
        <?php
include_once("include/bdd.php");

        @$login = htmlspecialchars($_POST['login']);
        @$nom = htmlspecialchars($_POST['nom']);
        @$prenom = htmlspecialchars($_POST['prenom']);

        // header différent si l'amdin ou un utilisateur est co

        if ($_SESSION['login'] == 'admin') {
            include("include/headerAdmin.php");
        } elseif (isset($_SESSION['login'])) {
            include("include/headerOnline.php");
        }

 //récupère les données du compte 

        $req = $bdd->prepare('SELECT * FROM utilisateurs  WHERE id  = :id');
        $req->execute(array('id' => $_SESSION['id']));
        $donnees = $req->fetch();
        ?>
        
        <div class="container " id="page_centrale_connexion">
            <div class="row h-100  ">
                <div class="col-12 h-100 d-flex justify-content-center align-items-center">
                    <form class="w-50" action="profil.php" method="post">
                        <div class="form-group">
                            <label for="login">Modifier votre pseudo</label>
                            <input type="login" name="login" class="form-control form-control-lg" id="login" placeholder="<?php echo $donnees['login'];   ?>">
                        </div>
                        <div class="form-group">
                            <label for="nom">Modifier votre nom</label>
                            <input type="text" name="nom" class="form-control form-control-lg" id="nom" placeholder="<?php echo $donnees['nom'];   ?>">
                        </div>
                        <div class="form-group">
                            <label for="prenom">Modifier votre prénom</label>
                            <input type="text" name="prenom" class="form-control form-control-lg" id="prenom" placeholder="<?php echo $donnees['prenom'];   ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Modifier votre password</label>
                            <input type="password" name="password" class="form-control form-control-lg" id="password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmer la modification du password</label>
                            <input type="password" name="confirm_password" class="form-control form-control-lg" id="confirm_password">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <?php if (isset($_POST['submit'])) //verif d'envoi du formulaire
        {
            if (!$_POST['password'] == NULL or !$_POST['confirm_password'] == NULL) //verif pour le password
            {
                if (!$_POST['password'] == NULL and $_POST['confirm_password'] == NULL) {
                    echo ' <div class=row><div class="col-12"><p class="text-center">Vous devez confirmer votre mot de passe</p></div></div> ';
                    
                }
                if ($_POST['password'] == NULL and !$_POST['confirm_password'] == NULL) {
                    echo ' <div class=row><div class="col-12"><p class="text-center">Vous n\'avez pas saisi le champs " Modifier votre password "</p></div></div> ';
                    
                }
                if (!$_POST['password'] == NULL and !$_POST['confirm_password'] == NULL and  $_POST['password'] !== $_POST['confirm_password']) {
                    echo ' <div class=row><div class="col-12"><p class="text-center">Vous devez saisir deux mots de passe identiques</p></div></div> ';
                    
                    
                }
                if ($_POST['password'] === $_POST['confirm_password']) //modification du password
                {
                    $password = $_POST['password'];
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                    $req = $bdd->prepare('UPDATE utilisateurs SET password = :password WHERE id  = :id');
                    $req->execute(array(
                        'password' => $password,
                        'id' => $donnees['id']));
                }
            } 
            if (!$_POST['login'] == NULL) //verif  changement pour le login
            {
                $req = $bdd->prepare('UPDATE utilisateurs SET login = :login WHERE id  = :id');
                $req->execute(array(
                    'login' => $_POST['login'],
                    'id' => $donnees['id']));
                $_SESSION['login'] = $_POST['login'];
            }
            if (!$_POST['nom'] == NULL) //verif changement pour le nom
            {
                $req = $bdd->prepare('UPDATE utilisateurs SET nom = :nom WHERE id  = :id');
                $req->execute(array(
                    'nom' => $_POST['nom'],
                    'id' => $donnees['id']));
                
                    $_SESSION['nom'] = $_POST['nom'];
            }
            if (!$_POST['prenom'] == NULL) //verif et changement pour le prénom
            {
                $req = $bdd->prepare('UPDATE utilisateurs SET prenom = :prenom WHERE id  = :id');
                $req->execute(array(
                    'prenom' => $_POST['prenom'],
                    'id' => $donnees['id']));

                $_SESSION['prenom'] = $_POST['prenom'];
            }
            header('Location: profil.php'); //rafraichissement de la page pour remettre les valeurs affichées dans les inputs à jour
        }
?>
</main>
    <footer>
        <?php include("include/footer.php"); ?>
    </footer>
</body>
</html>