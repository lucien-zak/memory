<?php
session_start();
class Memory
{

    private int $_difficulte;
    public string $_Malert;
    public string $_Talert;

    function __construct(int $difficulte)
    {
        $this->_difficulte = $difficulte;
    }


    function setPremiereCarte()
    {
        if (!isset($_SESSION['carte1']) && isset($_POST['choix'])) {
            $_SESSION['carte1'] = $_POST['choix'];
            unset($_POST);
        }
    }


    function setDeuxiemeCarte()
    {
        if (isset($_POST['choix']) && !empty($_SESSION['carte1'])) {
            $_SESSION['carte2'] = $_POST['choix'];
            unset($_POST);
            header('refresh:0');
        }
    }

    function verifCarte()
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
                $_SESSION['score']++;
            } else {
                $this->_Malert =  'Perdu';
            }
            $_SESSION['unset'] = 1;
        }
    }
    function initScore()
    {
        if (!isset($_SESSION['score'])) {
            $_SESSION['score'] = 0;
        }
        if (!isset($_SESSION['trouve'])) {
            $_SESSION['trouve'] = [];
        }
    }

    function reinit()
    {
        if (isset($_POST['restart']) && $_POST['restart'] == 'restart') {
            session_destroy();
            header('refresh:0');
        }
    }

    function TableauAleatoireAssoc($nbid)
    {
        $tableaualeatoire = [];
        $couleur = $this->GetColors($nbid / 2);
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

    function GetColors($nbColor)
    {
        $color = ['green', 'red', 'orange', 'yellow', 'blue', 'brown', 'grey', 'pink'];
        shuffle($color);
        for ($m = 0; $m < $nbColor; $m++) {
            $randColor[$m] = $color[$m];
        }
        if (!isset($_SESSION['colors'])) {
            $_SESSION['colors'] = $randColor;
        }
        return $randColor;
    }

    function GetColor($indexcarte)
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
        return 'black';
    }

    function getAnim($indexcarte)
    {
        if (isset($_SESSION['carte1']) && $_SESSION['TableauAleatoire'][$indexcarte] == $_SESSION['carte1']) {
            return 'animation: 10s forwards changeCarte;';
        }
        if (isset($_SESSION['carte2']) && $_SESSION['TableauAleatoire'][$indexcarte] == $_SESSION['carte2']) {
            return 'animation: 10s changeCarte forwards;';
        }
    }

    function estRetourne($id)
    {
        foreach ($_SESSION['trouve'] as $value) {
            if ($id == $value) {
                echo 'disabled';
            }
        }
    }

    function findepartie()
    {
        if (count($_SESSION["TableauAleatoire"]) != count($_SESSION["trouve"])) {
            return 'hidden';
        } else {
            $this->_Malert =  'Fin de partie';
            return '';
        }
    }

    function alertes()
    {
        if (isset($this->_Malert)) {
            echo $this->_Malert;
        }
    }

    function generationTableau()
    {
        $this->initScore();
        $this->reinit();
        $this->verifCarte();
        echo '<br>Mon Score : ' . $_SESSION['score'] . '<br>';
        $this->alertes();
        $this->setPremiereCarte();
        $this->setDeuxiemeCarte();
        $this->TableauAleatoireAssoc($this->_difficulte);
        echo $this->getAnim(0);
        echo '<form action="" method="POST">';
        for ($i = 0; $i < $this->_difficulte; $i++) {
?>
            <input type="submit" name='choix' value="<?= $_SESSION['TableauAleatoire'][$i] ?>" <?= $this->estRetourne($_SESSION['TableauAleatoire'][$i]) ?>>
        <?php
        }
        echo '<input  type="submit" name="restart" value="restart">';
        echo '</form>';
        echo '<style>';
        for ($i = 0; $i < $this->_difficulte; $i++) {
        ?>
            input:nth-child(<?= $i + 1 ?>) {
            background-color: grey;
            background-image: url('./assets/images/<?= $this->GetColor($i) ?>.png');
            background-repeat:no-repeat;
            background-position: center center;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            border-style: none;
            font-size: 0;
            padding: 20vh 5vw;
            margin : 5px;
        }

        @keyframes changeCarte {
            from {background-image: url('./assets/images/black.png');} 
            to {background-image: url('./assets/images/<?= $this->GetColor($i) ?>.png');}
    }

        <?php
        }
        ?>
        </style>
<?php
    }
}
?>