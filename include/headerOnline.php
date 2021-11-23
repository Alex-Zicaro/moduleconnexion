<header class="container-fluid-xl  sticky-top" id=header>

    <nav class="h-100 navbar navbar-expand-md navbar-dark bg-dark ">

        <a class="navbar-brand h-100" href="index.php"><img src="media/logo.png"  class="h-100 img-fluid"   alt="logo">Welcome !</a>

        <button class=" navbar-toggler navbar-toggler-dark bg-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        
                <ul class="bg-dark justify-content-around navbar-nav ">

                            <p class='d-flex align-items-center text-light my-2 bg-dark text-nowrap align ml-5'>Bienvenue <?php echo $_SESSION['prenom'] ?></p>

                            <li class="nav-item ml-5 my-2 ">
                                <a class="nav-link text-nowrap " href="profil.php">modifier votre profil</a>
                            </li>

                            <form class="ml-5 my-2 d-flex align-items-center" action="index.php" method="post">
                                    <input class="btn btn-primary " name = "deco" type="submit" value="Se déconnecter">
                            </form>
                        
                </ul>
    
        </div>

    </nav>

</header>

<?php 
// déconnexion
    if ( isset($_POST['deco']))

        {
            session_destroy() ;
            $_SESSION = NULL;
            header('Location: index.php'); 
        }   
        
?> 