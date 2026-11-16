<?php
/* Use case: Update data for one gift card */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/validation.php';
require_once __DIR__ . '/includes/load-card.php';  // validates card_id and sets $card, $cardId

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$values, $errors] = validate_gift_card($_POST);

    if (!$errors) {
        $stmt = $pdo->prepare(
            'UPDATE GIFTCARD
                SET cardName = :cardName, cardType = :cardType, cardValue = :cardValue, points = :points
              WHERE cardId = :cardId'
        );
        $stmt->execute([
            ':cardName'  => $values['card_name'],
            ':cardType'  => $values['card_type'],
            ':cardValue' => (float) $values['card_value'],
            ':points'    => (int) $values['points_required'],
            ':cardId'    => $cardId,
        ]);

        header('Location: card-details.php?card_id=' . urlencode((string) $cardId) . '&status=updated');
        exit;
    }
} else {
    // Prepopulate the form with the saved values.
    $values = [
        'card_name'       => $card['cardName'],
        'card_type'       => $card['cardType'],
        'card_value'      => number_format((float) $card['cardValue'], 2, '.', ''),
        'points_required' => (string) $card['points'],
    ];
}

$pageTitle   = 'Update Gift Card';
$formAction  = 'card-update.php?card_id=' . urlencode((string) $cardId);
$submitLabel = 'Save Changes';
$cancelUrl   = 'card-details.php?card_id=' . urlencode((string) $cardId);

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <a href="<?= htmlspecialchars($cancelUrl) ?>" class="back-link">&larr; Back to Gift Card Details</a>
    <h1>Update Gift Card</h1>
    <p class="sub-heading">Editing Card ID <?= htmlspecialchars((string) $cardId) ?>: <?= htmlspecialchars($card['cardName']) ?></p>
    <?php require __DIR__ . '/includes/card-form.php'; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
