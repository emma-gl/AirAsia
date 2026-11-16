<?php
/* Shared navigation. Closes the site header opened in header.php and opens <main>. */
$basePath = $basePath ?? '';
?>
    <nav class="site-nav" aria-label="Main navigation">
      <a href="<?= htmlspecialchars($basePath) ?>card-list.php">Gift Card List</a>
      <a href="<?= htmlspecialchars($basePath) ?>card-add.php">Add Gift Card</a>
    </nav>
  </header>

  <main class="panel">
