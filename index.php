<?php

require './classMemory.php';
$memory = new Memory(8);
$memory->generationTableau();



// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
?>

<style>
    test {
        animation: forwards;
    }
    @keyframes changeCarte {
        0% {background-image: url('./assets/images/black.png');}
        100% {background-image: url('./assets/images/<?= $this->GetColor($i) ?>.png');}
    }
</style>