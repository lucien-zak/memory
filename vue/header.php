<!DOCTYPE html>
<html lang="fr">
<script src="https://kit.fontawesome.com/225d5fd287.js" crossorigin="anonymous"></script>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="vue/CSS/styles.css">
    <title>Memory</title>
</head>
<body>
    <header>
        <nav id="navbar">
            <ul>
                <li id="logo"><i class="fas fa-brain"></i></li>
                <a href="/">
                    <li class="lien">Acceuil</li>
                </a>                
                <a href="/scoreboard">
                    <li class="lien">Tableau des scores</li>
                </a>
                <?php if (isset($_SESSION['login'])) { ?>
                    <a href="/memory">
                        <li class="lien">Jouer</li>
                    </a>
                    <a href="/disconnect">
                        <li class="lien">Se déconnecter</li>
                    </a>
                <?php } else { ?>
                    <a href="/register">
                        <li class="lien">S'enregister</li>
                    </a>
                    <a href="/connect">
                        <li class="lien">Se connecter</li>
                    </a>
                <?php } ?>

            </ul>
        </nav>
    </header>
    <main>
   