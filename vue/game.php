<?php
if (!isset($_POST['diff'])) {
?>
    <div id="page">
        <form action='' method="POST">
            <label for="diff">Choix de la difficulté :</label>

            <select name="diff">
                <option value="6">3 paires</option>
                <option value="8">4 paires</option>
                <option value="12">6 paires</option>
                <option value="16">8 paires</option>
                <option value="24">12 paires</option>
            </select>
            <input type="submit" value="C'est parti">
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
    unset($_SESSION['timestampfin']);
    $_SESSION['diff'] = $_POST['diff'];
}

if (isset($_POST['restart'])) {
    unset($_SESSION['diff']);
    unset($_SESSION['score']);
    unset($_SESSION['trouve']);
    unset($_SESSION['colors']);
    unset($_SESSION['TableauAssoc']);
    unset($_SESSION['TableauAleatoire']);
    unset($_SESSION['save']);
    unset($_SESSION['timestampfin']);
}

if (isset($_SESSION['diff'])) {
    $memory = new Memory($_SESSION['diff'], 0);
    $memory->generationTableau();
}

// echo count($_SESSION["TableauAleatoire"]);
// var_dump($_SESSION);
// echo '</pre>';
?>