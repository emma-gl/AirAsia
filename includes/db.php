<?php
/*
 * Creates the shared PDO connection to the SQLite database ($pdo)
 * and provides small data-access helpers used by the Gift Card pages.
 */

$dbPath = __DIR__ . '/../database/rewards.db';

try {
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec('PRAGMA foreign_keys = ON');
} catch (PDOException $e) {
    http_response_code(500);
    error_log('Database connection failed: ' . $e->getMessage());
    exit('Sorry, the gift card database is unavailable right now.');
}

/**
 * Returns one GIFTCARD row as an associative array, or null if no card has that id.
 */
function get_gift_card(PDO $pdo, int $cardId): ?array
{
    $stmt = $pdo->prepare(
        'SELECT cardId, cardName, cardType, cardValue, points
           FROM GIFTCARD
          WHERE cardId = :cardId'
    );
    $stmt->execute([':cardId' => $cardId]);
    $card = $stmt->fetch();

    return $card === false ? null : $card;
}
