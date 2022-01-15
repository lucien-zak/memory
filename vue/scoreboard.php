<div id="pageAcceuil">
    <h1>HALL OF FAME</h1>
    <div id="pageHAF">
        <div id='scoreperso'>
            <p>Toutes mes parties</p>
            <?php
            if (isset($_SESSION['login'])) {
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Score</th>
                        <th>Durée</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once './controller/classScore.php';
                    $score = new Score($_SESSION['id']);
                    $score->generation_tableauscore(999);
                    ?>
                </tbody>
            </table>
        </div>
        <?php
            }
            else{
                echo 'Vous devez vous connecter';
            }
            ?>
        <div>
            <p>Mon score moyen : <?= isset($_SESSION['login']) ? round($score->get_scoremoyen()) : 'Vous devez vous connecter' ?> </p>
            <p>Mon temps total : <?= isset($_SESSION['login']) ? $score->get_tempstotal() : 'Vous devez vous connecter' ?> </p>
        </div>
        <div>
            <p>TOP Mondial</p>
            <table>
                <thead>
                    <tr>
                        <th>Joueurs</th>
                        <th>Score Total</th>
                        <th>Score Moyen</th>
                        <th>Temps de jeu total</th>
                        <th>Temps moyen par partie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once './controller/classScore.php';
                    $scoretot = new Score(0);
                    $scoretot->generation_top();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
