<div id="page">
<form id="game" action="" method="POST">
    <?php
    for ($i = 0; $i < $this->_difficulte; $i++) {
    ?>
        <input class="carte" type="submit" name='choix' value="<?= $_SESSION['TableauAleatoire'][$i] ?>" <?= $this->estRetourne($_SESSION['TableauAleatoire'][$i]) ?>>
    <?php
    }
    ?>
        <input  type="submit" name="restart" value="restart">

    </form>
    <style>
    <?php
    for ($i = 0; $i < $this->_difficulte; $i++) {
    ?>
        input.carte:nth-child(<?= $i + 1 ?>) {
        background-color: transparent;
        background-image: url('./vue/assets/images/<?= $this->GetColor($i) ?>.png');
        background-repeat:no-repeat;
        background-position: center center;
        -webkit-background-size: contain;
        -moz-background-size: contain;
        -o-background-size: contain;
        background-size: contain;
        border-style: none;
        font-size: 0;
        padding: 100px 50px;
        margin : 5px;
        }
    <?php
    }
    ?>
    </style>
    
</div>

