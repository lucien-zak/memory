<?php

require_once 'model/ScoreModel.php';

class Memory extends ScoreModel
{

    private int $_difficulte;
    private int $_vie;
    public string $_Malert;
    public string $_Talert;

    function __construct(int $difficulte, int $vie)
    {
        $this->_difficulte = $difficulte;
        $this->_vie = $vie;
    }

// Initialise la premiere carte dans $_SESSION['carte1']
    function set_premierecarte()
    {
        if (!isset($_SESSION['carte1']) && isset($_POST['choix'])) {
            $_SESSION['carte1'] = $_POST['choix'];
            unset($_POST);
        }
    }

    // Initialise la seconde carte dans $_SESSION['carte2']
    function set_deuxiemecarte()
    {
        if (isset($_POST['choix']) && !empty($_SESSION['carte1'])) {
            $_SESSION['carte2'] = $_POST['choix'];
            unset($_POST);
            header('location:/memory');
        }
    }


// Detruit Carte1 et Carte 2 si la vérif a été faite, puis fais la comparaison, si ok, pousse carte1 et 2 dans 'trouve"' et ajoute du score, sinon soustrait du score.
    function verif_carte()
    {
        if (isset($_SESSION['unset']) && $_SESSION['unset'] == 1) {
            unset($_SESSION['carte1']);
            unset($_SESSION['carte2']);
            $_SESSION['unset'] = 0;
        }
        if (isset($_SESSION['carte1']) && isset($_SESSION['carte2'])) {
            $_SESSION['count'] = 0;
            foreach ($_SESSION['TableauAssoc'] as $value) {
                $_SESSION['count'] = 0;
                foreach ($value as $val) {
                    if ($_SESSION['carte1'] == $val or $_SESSION['carte2'] == $val) {
                        $_SESSION['count']++;
                    }
                    if ($_SESSION['count'] == 2) {
                        $gain = 1;
                    }
                }
            }
            if (isset($gain) == 1) {
                $this->_Malert = 'Gagné';
                array_push($_SESSION['trouve'], $_SESSION['carte2'], $_SESSION['carte1']);
                $_SESSION['score'] = $_SESSION['score'] + 500;
                header('refresh:2');
            } else {
                $this->_Malert =  'Perdu';
                $_SESSION['score'] = $_SESSION['score'] - 250;
                header('refresh:2');

            }
            $_SESSION['unset'] = 1;
        }
    }

    // initialisation du score et du timer
    function init_score()
    {
        if (!isset($_SESSION['score'])) {
            $_SESSION['score'] = 1000;
            $_SESSION['timestampdebut'] = microtime(true);
        }
        if (!isset($_SESSION['trouve'])) {
            $_SESSION['trouve'] = [];
        }
    }
    //reinit les variables pour redémarrer le jeu
    function reinit()
    {
        if (isset($_POST['restart']) && $_POST['restart'] == 'restart') {
            unset($_SESSION['diff']);
            unset($_SESSION['score']);
            unset($_SESSION['trouve']);
            unset($_SESSION['colors']);
            unset($_SESSION['TableauAssoc']);
            unset($_SESSION['TableauAleatoire']);
        }
    }
    //definit un tableau aléatoire associatif 
    function set_tableaualeatoireassoc($nbid)
    {
        $tableaualeatoire = [];
        $couleur = $this->set_imgs($nbid / 2);
        for ($j = 0; $j < $nbid / 2; $j++) {
            $tableaualeatoire[0][$couleur[$j]] = uniqid();
        }
        for ($k = 0; $k < $nbid / 2; $k++) {
            $tableaualeatoire[1][$couleur[$k]] = uniqid();
        }
        if (!isset($_SESSION['TableauAssoc'])) {
            $_SESSION['TableauAssoc'] = array_merge_recursive($tableaualeatoire[0], $tableaualeatoire[1]);
        }
        if (!isset($_SESSION['TableauAleatoire'])) {
            $tabaleatoire = array_values($tableaualeatoire);
            $stack = array_values($tabaleatoire[0]);
            foreach ($tabaleatoire[1] as $value) {
                array_push($stack, $value);
            }
            shuffle($stack);
            $_SESSION['TableauAleatoire'] = $stack;
        }
    }

    //definit aléatoirement des color qui correspondent à des cartes. (nommé $color.png et retourne un tableau
    function set_imgs($nbColor)
    {
        $color = ['b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm'];
        shuffle($color);
        for ($m = 0; $m < $nbColor; $m++) {
            $randColor[$m] = $color[$m];
        }
        if (!isset($_SESSION['colors'])) {
            $_SESSION['colors'] = $randColor;
        }
        return $randColor;
    }
    
    // Retourne une couleur si la carte est cliqué ou trouvé pour le <styles>
    function set_img($indexcarte)
    {
        if (isset($_SESSION['carte1'])) {
            for ($j = 0; $j < count($_SESSION['TableauAssoc']); $j++) {
                foreach ($_SESSION['TableauAssoc'][$_SESSION['colors'][$j]] as $value) {
                    if ($value == $_SESSION['TableauAleatoire'][$indexcarte] && $value == $_SESSION['carte1']) {
                        return $_SESSION['colors'][$j];
                    }
                }
            }
        }
        if (isset($_SESSION['carte2']) && isset($_SESSION['carte1'])) {
            for ($k = 0; $k < count($_SESSION['TableauAssoc']); $k++) {
                foreach ($_SESSION['TableauAssoc'][$_SESSION['colors'][$k]] as $value) {
                    if ($value == $_SESSION['TableauAleatoire'][$indexcarte] && $value == $_SESSION['carte2']) {
                        return $_SESSION['colors'][$k];
                    }
                }
            }
        }
        if (isset($_SESSION['trouve'])) {
            foreach ($_SESSION['trouve'] as $value1) {
                for ($n = 0; $n < count($_SESSION['colors']); $n++) {
                    foreach ($_SESSION['TableauAssoc'][$_SESSION['colors'][$n]] as $value2) {
                        if ($value1 == $value2 && $value1 == $_SESSION['TableauAleatoire'][$indexcarte]) {
                            return $_SESSION['colors'][$n];
                        }
                    }
                }
            }
        }
        return 'a';
    }

    //animation fadin fadout pour les cartes, retourne une ligne d'animation pour <styles>
    function set_anim($indexcarte)
    {
        if (isset($_SESSION['carte1']) && !isset($_SESSION['carte2']) && $_SESSION['TableauAleatoire'][$indexcarte] == $_SESSION['carte1']) {
            return 'animation: 1s ease changecarte;';
        }
        if (isset($_SESSION['carte2']) && $_SESSION['TableauAleatoire'][$indexcarte] == $_SESSION['carte2']) {
            return 'animation: 1s ease changecarte ;';
        }
    }
    // retourne disabled dans la vue pour ne plus rendre clikable les cartes retournées
    function est_retourne($id)
    {
        foreach ($_SESSION['trouve'] as $value) {
            if ($id == $value) {
                echo 'disabled';
            }
        }
    }
    // définit la fin de partie, retourne un booléen
    function set_findepartie()
    {
        if (count($_SESSION["TableauAleatoire"]) == count($_SESSION["trouve"])) {
            if (!isset($_SESSION['timestampfin'])) {
                $_SESSION['timestampfin'] = microtime(true);
            }
            if (!isset($_SESSION['save'])) {
                $this->insert_score($_SESSION['score'], round($_SESSION['timestampfin'] - $_SESSION['timestampdebut']), $_SESSION['id']);
                $_SESSION['save'] = 1;
            }
            return TRUE;
        }
    }

    function alertes()
    {
        if (isset($this->_Malert)) {
            echo $this->_Malert;
        }
    }
    // lancement des méthodes dans l'orde du jeu et require la vue pour les submit + styles
    function generationTableau()
    {
        $this->init_score();
        $this->verif_carte();
        $this->set_premierecarte();
        $this->set_deuxiemecarte();
        $this->set_tableaualeatoireassoc($this->_difficulte);
        $this->set_findepartie();
        require './vue/memory.php';
    }
}
