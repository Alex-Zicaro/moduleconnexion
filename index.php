<? session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css" />
    <strong><title>moduleconnexion</title></strong>
</head>
<body>
    <header>
    <? include_once("include/header.php"); ?>
    </header>
    <main>
        <?php 
        
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=alex-zicaro_moduleconnexion;charset=utf8', 'alex-zicaro', 'Lilinette83', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }

        @$login = htmlspecialchars($_POST['login']);
        @$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        if (isset($_POST['submit'])) {
            //vérification de l'utilisateur  dans la bdd
            $requete = $bdd->prepare(' SELECT * FROM utilisateurs where login = :login');
            $requete->execute(['login' => $_POST['login']]);
            $result = $requete->fetch();
            if ($result == true) {
                if (password_verify($_POST['password'], $result['password']) and $_POST['password'] === 'admin' and $_POST['login'] === 'admin') //vérification si la connection concerne le compte admin
                {
                    session_start(); //  session admin
                    $req = $bdd->prepare('SELECT * FROM utilisateurs  WHERE login  = :login');
                    $req->execute(array(
                        'login' => $_POST['login']));
                    $_SESSION = $req->fetch();
                    $_SESSION['login'] = $_POST['login'];
                    $_SESSION['nom'] = $result['nom'];
                    $_SESSION['prenom'] = $result['prenom'];
                    header('Location: admin.php'); //redirection
                } else {
                    if (password_verify($_POST['password'], $result['password'])) // ouvrir une session utilisateur 
                    {
                        session_start();
                        $req = $bdd->prepare('SELECT * FROM utilisateurs  WHERE login  = :login');
                        $req->execute(array(
                            'login' => $_POST['login']));
                        $_SESSION = $req->fetch();
                        $_SESSION['login'] = $_POST['login'];
                        $_SESSION['nom'] = $result['nom'];
                        $_SESSION['prenom'] = $result['prenom'];
                        header('Location: index.php'); //redirection
                    } else {
                        $mauvaisidentifiants = "identifiants incorrects ";
                    }
                }
            } else {
                $mauvaisidentifiants = "identifiants incorrects ";
            }
        }
        ?>
        <div class="container  " id="page_centrale_connexion">
            <div class="row h-100  ">
                <div class="col-12 h-100 d-flex justify-content-center align-items-center">
                    <form class="w-50" action="connexion.php" method="post">
                        <p class="text-center"> <?php echo @$mauvaisidentifiants;  ?> </p>
                        <div class="form-group">
                            <label for="login">Login</label>
                            <input type="login" name="login" required class="form-control form-control-lg" id="login" aria-describedby="loginHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" required class="form-control form-control-lg" id="exampleInputPassword1">
                        </div>
                        <div class="row">
                        <button type="submit" name="submit" class="btn btn-primary">Connexion</button>
                        <div class="ins">
                            <p>Vous n'êtes pas encore inscrit ?</p>
                        <a href="inscription.php" class="btn btn-primary">Inscription</a>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>

    </main>

<footer>
<? include("include/footer.php"); ?>
</footer>
</body>
</html>