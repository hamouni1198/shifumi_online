<?php
$config = json_decode(file_get_contents(__DIR__ . '/bdConfig.json'), true);

$host = $config['host'];
$db = $config['dbname'];
$user = $config['user'];
$password = $config['password'];
$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

try {
    $bdConnect = new PDO($dsn, $user, $password);
    $bdConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
