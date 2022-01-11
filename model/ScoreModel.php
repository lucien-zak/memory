<?php

class ScoreModel
{
    function insert_score($score, $duree, $idutil)
    {
        require 'model/db.php';
        $stmt = $pdo->prepare('INSERT INTO memory.Score (score, duree, id_utilisateur) VALUES (?, ?, ?);');
        return $stmt->execute([$score, $duree, $idutil]);
    }

    function req_scoreparutil($id, $limit)
    {
        require 'model/db.php';
        $stmt = $pdo->prepare('SELECT `score`,`duree`,DATE_FORMAT(created_at, "%d-%m-%Y %H:%i") FROM memory.Score t WHERE id_utilisateur = ? ORDER BY created_at DESC LIMIT ?');
        $stmt->execute([$id, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function req_scoremoyenparutil($id)
    {
        require 'model/db.php';
        $stmt = $pdo->prepare('SELECT AVG(score) FROM memory.Score t WHERE id_utilisateur = ?');
        $stmt->execute([$id]);
        $scoremoyen = $stmt->fetch();
        return $scoremoyen['AVG(score)'];
    }

    function req_tempstotal($id)
    {
        require 'model/db.php';
        $stmt = $pdo->prepare('SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `duree` ) ) ) as tempstotal FROM memory.Score t WHERE id_utilisateur = ?');
        $stmt->execute([$id]);
        $tempstotal = $stmt->fetch();
        return $tempstotal['tempstotal'];
    }

    function req_top10()
    {
        require 'model/db.php';
        $stmt = $pdo->prepare('SELECT login,SUM(score),ROUND(AVG(score)), SEC_TO_TIME( SUM( TIME_TO_SEC( `duree` ) ) ) AS tempstotal, SEC_TO_TIME( AVG( TIME_TO_SEC( `duree` ) ) ) AS tempsmoyen FROM Score INNER JOIN Utilisateurs ON Utilisateurs.id = id_utilisateur GROUP BY id_utilisateur ORDER BY SUM(score) DESC');
        $stmt->execute();
        $top = $stmt->fetchAll();
        return $top;
    }
}
