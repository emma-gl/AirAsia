<?php
/* Use case: Delete a card */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/validation.php';
require_once __DIR__ . '/includes/load-card.php';  // validates card_id and sets $card, $cardId

// Delete only after the user confirms with the POST form below. A GET request never deletes.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['confirm'] ?? '') === 'yes') {
    $stmt = $pdo->prepare('DELETE FROM GIFTCARD WHERE cardId = :cardId');
    $stmt->execute([':cardId' => $cardId]);

    header('Location: card-list.php?status=deleted');
    exit;
}

$detailsUrl = 'card-details.php?card_id=' . urlencode((string) $cardId);

$pageTitle = 'Delete Gift Card';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <h1>Delete Gift Card</h1>
    <p class="alert alert-error">Are you sure you want to permanently delete this Gift Card? This cannot be undone.</p>

    <div class="details">
      <img src="images/gift-card.svg" alt="<?= htmlspecialchars($card['cardName']) ?> gift card">
      <dl>
        <div><dt>Card ID:</dt><dd><?= htmlspecialchars((string) $card['cardId']) ?></dd></div>
        <div><dt>Card Name:</dt><dd><?= htmlspecialchars($card['cardName']) ?></dd></div>
        <div><dt>Card Type:</dt><dd><?= htmlspecialchars($card['cardType']) ?></dd></div>
        <div><dt>Card Value:</dt><dd>$<?= htmlspecialchars(number_format((float) $card['cardValue'], 2)) ?></dd></div>
        <div><dt>Points Required:</dt><dd><?= htmlspecialchars(number_format((int) $card['points'])) ?></dd></div>
      </dl>
    </div>

    <form action="card-delete.php" method="post" class="button-row">
      <input type="hidden" name="card_id" value="<?= htmlspecialchars((string) $cardId) ?>">
      <input type="hidden" name="confirm" value="yes">
      <button type="submit" class="btn btn-danger">Yes, Delete Gift Card</button>
      <a href="<?= htmlspecialchars($detailsUrl) ?>" class="btn btn-secondary">Cancel</a>
    </form>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
