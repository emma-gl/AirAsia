<?php
/*
 * Rebuilds database/rewards.db from schema.sql and seed.sql.
 * Run from the project root:   php database/init-db.php
 * WARNING: this drops and recreates the tables, so any changes made in the app are lost.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Run this script from the command line: php database/init-db.php');
}

$pdo = new PDO('sqlite:' . __DIR__ . '/rewards.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec(file_get_contents(__DIR__ . '/schema.sql'));
$pdo->exec(file_get_contents(__DIR__ . '/seed.sql'));

$accounts  = $pdo->query('SELECT COUNT(*) FROM ACCOUNT')->fetchColumn();
$giftCards = $pdo->query('SELECT COUNT(*) FROM GIFTCARD')->fetchColumn();

echo "rewards.db rebuilt: {$accounts} ACCOUNT rows, {$giftCards} GIFTCARD rows." . PHP_EOL;
