<div id = "pageAcceuil">
<h1>Programme d’entraînement Mémoriel du Dr Zak-Guerin</h1>
<?php if (isset($_SESSION['login'])){
    ?>
    <div id = "pageScore">
    <p>Vos 5 dernieres parties : </p>
        <div>
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
                 $score->generation_tableauscore(5);
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php }
?>
</div>
<?php 



