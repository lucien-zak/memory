<style>
    <?php
    for ($i = 0; $i < $this->_difficulte; $i++) {
    ?>input.carte:nth-child(<?= $i + 1 ?>) {
        background-color: transparent;
        background-image: url('./vue/assets/images/<?= $this->set_img($i) ?>.png');
        background-repeat: no-repeat;
        background-position: center center;
        -webkit-background-size: contain;
        -moz-background-size: contain;
        -o-background-size: contain;
        background-size: contain;
        border-style: none;
        font-size: 0;
        padding: 100px 50px;
        margin: 5px;
        <?= $this->set_anim($i) ?>
    }

    <?php
    }
    ?>
</style>


<div id="page">

    <?php if ($this->set_findepartie() == FALSE) {
    ?>
        <p><?= "Mon score : " . $_SESSION['score'] ?></p>

        <form id="game" action="" method="POST">
            <?php
            for ($i = 0; $i < $this->_difficulte; $i++) {
            ?>
                <input class="carte" type="submit" name='choix' value="<?= $_SESSION['TableauAleatoire'][$i] ?>" <?= $this->est_retourne($_SESSION['TableauAleatoire'][$i]) ?>>
            <?php
            }
            ?>
        </form>
</div>

<div id="abandonner">

    <form id="abandonner" action="" method="POST">
        <input type="submit" name="restart" value="Abandonner">
</div>
<?php
    } else {
        echo 'Fin de partie<br><br>';
        echo 'Votre temps : ' . round($_SESSION['timestampfin'] - $_SESSION['timestampdebut']) . 's<br><br>';
        echo 'Votre score total : ' . $_SESSION['score'] . '<br><br>'
?>
    <form id="game" action="" method="POST">
        <input type="submit" name="restart" value="Recommencer">
    <?php

    }
    ?>