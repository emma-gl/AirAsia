<?php
/* Use case: View details of one gift card */
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/validation.php';
require_once __DIR__ . '/includes/load-card.php';  // validates card_id and sets $card

$justUpdated = ($_GET['status'] ?? '') === 'updated';
$cardIdParam = urlencode((string) $card['cardId']);

$pageTitle = $card['cardName'];
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <a href="card-list.php" class="back-link">&larr; Return to Gift Card List</a>

    <?php if ($justUpdated): ?>
      <p class="alert alert-success" role="status">The Gift Card was updated. The saved information is shown below.</p>
    <?php endif; ?>

    <article>
      <h1 class="centered"><?= htmlspecialchars($card['cardName']) ?></h1>

      <div class="details">
        <img src="images/gift-card.svg" alt="<?= htmlspecialchars($card['cardName']) ?> gift card">

        <dl>
          <div>
            <dt>Card ID:</dt>
            <dd><?= htmlspecialchars((string) $card['cardId']) ?></dd>
          </div>
          <div>
            <dt>Card Name:</dt>
            <dd><?= htmlspecialchars($card['cardName']) ?></dd>
          </div>
          <div>
            <dt>Card Type:</dt>
            <dd><?= htmlspecialchars($card['cardType']) ?></dd>
          </div>
          <div>
            <dt>Card Value:</dt>
            <dd>$<?= htmlspecialchars(number_format((float) $card['cardValue'], 2)) ?></dd>
          </div>
          <div>
            <dt>Points Required:</dt>
            <dd><?= htmlspecialchars(number_format((int) $card['points'])) ?></dd>
          </div>
        </dl>
      </div>

      <div class="button-row">
        <a href="card-update.php?card_id=<?= $cardIdParam ?>" class="btn">Update Gift Card</a>
        <a href="card-delete.php?card_id=<?= $cardIdParam ?>" class="btn btn-danger">Delete Gift Card</a>
        <a href="card-list.php" class="btn btn-secondary">Return to Gift Card List</a>
      </div>
    </article>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
