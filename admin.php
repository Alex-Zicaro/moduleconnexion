<?php session_start(); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
    <strong><title>moduleconnexion</title></strong>
</head>

<body>

    <main>


        <?php

include_once("include/bdd.php");

include("include/headerAdmin.php"); 

        //récupère les données du compte 
        $req = $bdd->query('SELECT * FROM utilisateurs ');
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        ?>

        <!-- tableau d'affiche des données utilisateurs -->
        <div class='container  table-responsive-lg'>

            <table class="table table-bordered table-hover ">
                <th class="thead-light">
                    <tr>
                        <?php
                        foreach ($donnees as $key => $value) {
                            echo '<th>' . $key . '</th> ';
                        }
                        ?>
                    </tr>
                </th>
                <tb>
                    <tr>
                        <?php
                        echo '<tr>';
                        foreach ($donnees as $key => $value) {
                            echo '<td>' . $value . '</td>';
                        }
                        echo '<tr/>';
                        while (($donnees = $req->fetch(PDO::FETCH_ASSOC))  != NULL) {
                            echo '<tr>';
                            foreach ($donnees as $key => $value) {
                                echo '<td>' . $value . '</td>';
                            }
                            '<tr/>';
                        }
                        ?>
                    </tr>
                </tb>
            </table>
        </div>







        <?php include("include/footer.php"); ?>


    </main>

</body>

</html>