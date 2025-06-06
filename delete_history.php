<?php
require_once __DIR__ . '/bdConect.php';

try {
    $stmt = $bdConnect->prepare("DELETE FROM games");
    $stmt->execute();
    header("Location: history.php");
    exit;
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
