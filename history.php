<?php
require_once __DIR__ . '/bdConect.php';

$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1); 

$offset = ($page - 1) * $limit;

$totalQuery = $bdConnect->query("SELECT COUNT(*) FROM games");
$totalGames = (int) $totalQuery->fetchColumn();
$totalPages = ceil($totalGames / $limit);

$selectData = "SELECT * FROM games ORDER BY date DESC LIMIT :limit OFFSET :offset";
$stmt = $bdConnect->prepare($selectData);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<?php include_once 'head.php'?>

<body>
    <?php include_once 'nav.php' ?>
    <main>
        <h1>Historique des parties</h1>

        <form method="get" action="">
            <label for="limit">Nombre de parties par page :</label>
            <select name="limit" id="limit" onchange="this.form.submit()">
                <option value="3" <?= $limit == 3 ? 'selected' : '' ?>>3</option>
                <option value="6" <?= $limit == 6 ? 'selected' : '' ?>>6</option>
                <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
            </select>
        </form>

        <table >
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Main jouée</th>
                    <th>Main CPU</th>
                    <th>Résultat</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($games)): ?>
                <?php foreach ($games as $game): ?>
                    <tr>
                        <td><?= htmlspecialchars($game['date']) ?></td>
                        <td><?= htmlspecialchars($game['handPlayedByUser']) ?></td>
                        <td><?= htmlspecialchars($game['handPlayedByCPU']) ?></td>
                        <td><?= htmlspecialchars($game['result']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">Aucune partie jouée pour l'instant.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>">← Page précédente</a>
            <?php endif; ?>

            Page <?= $page ?> / <?= $totalPages ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>">Page suivante →</a>
            <?php endif; ?>
        </div>
        <?php if (isset($_GET['message'])): ?>
    <p style="color: green;"><?= htmlspecialchars($_GET['message']) ?></p>
<?php endif; ?>

        <form action="delete_history.php" method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer tout l’historique ?');">
    <button type="submit">Réinitialiser l’historique</button>
</form>

    </main>
    <?php include_once 'footer.php' ?>
</body>
</html>
