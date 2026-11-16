<?php
/*
 * Shown when a card_id is missing, invalid, or does not match a Gift Card.
 * Expects $notFoundMessage. Renders the full page (with templates) and stops the script.
 */
$pageTitle = 'Gift Card Not Found';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/nav.php';
?>
    <h1>Gift Card Not Found</h1>
    <p class="alert alert-error"><?= htmlspecialchars($notFoundMessage) ?></p>
    <div class="button-row">
      <a href="card-list.php" class="btn">Return to Gift Card List</a>
    </div>
<?php
require_once __DIR__ . '/footer.php';
exit;
