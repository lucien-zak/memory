<?php

class Utilisateur_model
{

    protected function req_UtilParLogin($login)
    {
        require 'model/db.php';
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE login=?');
        $stmt->execute([$login]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function ins_util($login, $mdp){
        require 'model/db.php';
        $stmt = $pdo->prepare('INSERT INTO utilisateurs (`login`,`password`)VALUES (?,?)');
        return $stmt->execute([$login,$mdp]);

    }

    protected function getUtilisateursParLogin($login){}
}