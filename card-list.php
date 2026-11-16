<?php
/* Use case: View a list of gift cards */
require_once __DIR__ . '/includes/db.php';

$cards = $pdo->query('SELECT cardId, cardName, points FROM GIFTCARD ORDER BY cardName')->fetchAll();

// Status message after a redirect. Only these fixed messages can ever be shown.
$statusMessages = [
    'added'   => 'The Gift Card was added.',
    'deleted' => 'The Gift Card was deleted.',
];
$status = $_GET['status'] ?? '';
$statusMessage = is_string($status) ? ($statusMessages[$status] ?? null) : null;

$pageTitle = 'Gift Cards';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>
    <div class="page-heading">
      <div>
        <h1>Gift Cards</h1>
        <p class="sub-heading">Select a card to view more details</p>
      </div>
      <a href="card-add.php" class="btn">Add Gift Card</a>
    </div>

    <?php if ($statusMessage): ?>
      <p class="alert alert-success" role="status"><?= htmlspecialchars($statusMessage) ?></p>
    <?php endif; ?>

    <?php if (!$cards): ?>
      <p>No gift cards have been added yet. <a href="card-add.php">Add the first one.</a></p>
    <?php else: ?>
      <ul class="card-grid">
        <?php foreach ($cards as $card): ?>
          <?php $detailsUrl = 'card-details.php?card_id=' . urlencode((string) $card['cardId']); ?>
          <li class="gift-card">
            <a href="<?= htmlspecialchars($detailsUrl) ?>">
              <img src="images/gift-card.svg" alt="<?= htmlspecialchars($card['cardName']) ?> - view details">
            </a>
            <h2><a href="<?= htmlspecialchars($detailsUrl) ?>"><?= htmlspecialchars($card['cardName']) ?></a></h2>
            <p class="points"><?= htmlspecialchars(number_format((int) $card['points'])) ?> points</p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
