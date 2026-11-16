<?php
/*
 * Validates the card_id (from the URL, or the hidden form field on POST)
 * and loads that Gift Card into $card. Shows the "not found" page and stops if it can't.
 * Requires db.php and validation.php to be loaded first.
 */
$rawCardId = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? ($_POST['card_id'] ?? null)
    : ($_GET['card_id'] ?? null);

$cardId = validate_card_id($rawCardId);

if ($cardId === null) {
    http_response_code(400);
    $notFoundMessage = 'The Gift Card ID is missing or invalid. Please choose a card from the list.';
    require __DIR__ . '/not-found.php';
}

$card = get_gift_card($pdo, $cardId);

if ($card === null) {
    http_response_code(404);
    $notFoundMessage = 'No Gift Card exists with ID ' . $cardId . '. It may have been deleted.';
    require __DIR__ . '/not-found.php';
}
