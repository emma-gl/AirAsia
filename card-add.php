<?php
/* Use case: Add data for a new gift card */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/validation.php';

$values = ['card_name' => '', 'card_type' => '', 'card_value' => '', 'points_required' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$values, $errors] = validate_gift_card($_POST);

    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO GIFTCARD (cardName, cardType, cardValue, points)
             VALUES (:cardName, :cardType, :cardValue, :points)'
        );
        $stmt->execute([
            ':cardName'  => $values['card_name'],
            ':cardType'  => $values['card_type'],
            ':cardValue' => (float) $values['card_value'],
            ':points'    => (int) $values['points_required'],
        ]);

        header('Location: card-list.php?status=added');
        exit;
    }
}

$pageTitle   = 'Add Gift Card';
$formAction  = 'card-add.php';
$submitLabel = 'Add Gift Card';
$cancelUrl   = 'card-list.php';

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <h1>Add Gift Card</h1>
    <?php require __DIR__ . '/includes/card-form.php'; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
