<?php
session_start();
require_once __DIR__ . '/models/match.php'; 
require_once __DIR__ . '/bdConect.php'; 


$translations = [
    'rock' => 'pierre',
    'paper' => 'feuille',
    'scissors' => 'ciseaux'
];

$userHand = $translations[$_POST['hand']] ?? null;

if (!in_array($userHand, getHandTypes())) {
    header("Location: game.php");
    exit;
}

$cpuHand = getCpuHand();

$result = getMatchResult($userHand, $cpuHand);

$insertData = "INSERT INTO games (date, handPlayedByUser, handPlayedByCPU, result) 
        VALUES (NOW(), :userHand, :cpuHand, :result)";
$stmt = $bdConnect->prepare($insertData);
$stmt->execute([
    ':userHand' => $userHand,
    ':cpuHand' => $cpuHand,
    ':result' => $result
]);
?>


<!DOCTYPE html>
<html lang="fr">
<?php include_once 'head.php'?>

    <body>
    <?php include_once 'nav.php'?>
    <main>
    <h1>Résultat de la partie</h1>
    <?php
    $selectData = "SELECT count(*) FROM games";
    $stmt = $bdConnect->prepare($selectData);
    $stmt->execute();
    $count = $stmt->fetchColumn();    
    ?>
    <p>Nombre total de parties jouées : <strong><?php echo $count; ?></strong></p>
    <p>Vous avez joué : <strong><?php echo htmlspecialchars($userHand); ?></strong></p>
    <p>L'ordinateur a joué : <strong><?php echo htmlspecialchars($cpuHand); ?></strong></p>
    <p>Résultat : 
        <strong>
            <?php 
                if ($result === 'WON') echo 'Gagné !';
                elseif ($result === 'LOST') echo 'Perdu !';
                else echo 'Égalité !';
            ?>
        </strong>
    </p>
</main>

        <?php include_once 'footer.php'?>
    </body>
</html>
