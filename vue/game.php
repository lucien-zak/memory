<?php
if (!isset($_POST['diff'])){
?>
<div id = "page">
<form action='' method="POST">
    <input name='diff' type="text" class="text">
    <input type="submit">
</form>
</div><?php
}
?>
<?php
require_once './controller/classMemory.php';
if (isset($_POST['diff'])) {
    unset($_SESSION['diff']);
    unset($_SESSION['score']);
    unset($_SESSION['trouve']);
    unset($_SESSION['colors']);
    unset($_SESSION['TableauAssoc']);
    unset($_SESSION['TableauAleatoire']);
    $_SESSION['diff'] = $_POST['diff'];
}

if (isset($_POST['restart'])) {
    unset($_SESSION['diff']);
    unset($_SESSION['score']);
    unset($_SESSION['trouve']);
    unset($_SESSION['colors']);
    unset($_SESSION['TableauAssoc']);
    unset($_SESSION['TableauAleatoire']);
}

if (isset($_SESSION['diff'])) {
    $memory = new Memory($_SESSION['diff']);
    $memory->generationTableau();
}

// echo count($_SESSION["TableauAleatoire"]);
// var_dump($_SESSION);
// echo '</pre>';
?>