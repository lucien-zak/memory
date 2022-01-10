<?php
require_once 'controller/classUtilisateur.php';
if (isset($_POST['submit'])) {
    $utilisateur = new Utilisateur($_POST['nomutil'],$_POST['mdp'],$_POST['confirmmdp']);
    $utilisateur->inscription_utilisateur();
}
?>

<div id = "page">
<form id="user" action="" method="POST">
    <p><?= isset($_POST["submit"]) ? $utilisateur->alerte() : ""?></p>
    <h1>Enregistrez vous</h1>
    <input type="text" name="nomutil" placeholder="Nom d'utilisateur">
    <input type="password" name="mdp" placeholder="Mot de passe">
    <input type="password" name="confirmmdp" placeholder="Confirmation du mot de passe">
    <input type="submit" name='submit' value="S'enregister">
</form>
</div>