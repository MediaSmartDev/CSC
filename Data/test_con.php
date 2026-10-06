<?php
$c = file_exists(__DIR__.'/config.php') ? require __DIR__.'/config.php' : require __DIR__.'/config.example.php';
try {
    $pdo = new PDO("mysql:host={$c['db_host']};dbname={$c['db_name']};charset=utf8mb4", $c['db_user'], $c['db_pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    echo "Connexion OK à la base « {$c['db_name']} »<br>";
    foreach (['classement','joueurs'] as $t) {
        echo $t.' : '.$pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn().' lignes<br>';
    }
} catch (PDOException $e) {
    echo "Connexion échouée : " . htmlspecialchars($e->getMessage());
}
