<?php


?>

<!DOCTYPE html>
<html lang="fr">
<?php include_once 'head.php'?>

    <body>
    <?php include_once 'nav.php'?>
        <main>
            <h1>Partie lancée !</h1>
            <form action="result.php" method="POST">
                <p>Choisir une main à jouer</p>
                <input type="radio" name="hand" value="rock" id="rock">
                <label for="rock">Pierre</label><br>
                <input type="radio" name="hand" value="paper" id="paper">
                <label for="paper">Papier</label><br>
                <input type="radio" name="hand" value="scissors" id="scissors">
                <label for="scissors">Ciseaux</label><br>
                <button type="submit">Jouer !</button>
            </form>
        </main>
        <?php include_once 'footer.php'?>
    </body>
</html>
