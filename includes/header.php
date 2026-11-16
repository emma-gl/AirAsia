<?php
/*
 * Shared page header: document setup, stylesheet link, and site banner.
 *
 * Pages may set these before requiring this file:
 *   $pageTitle - text shown in the browser tab (defaults to "AirAsia Rewards")
 *   $basePath  - path back to the project root ("" for root pages, "../" for tests/)
 */
$pageTitle = $pageTitle ?? 'AirAsia Rewards';
$basePath  = $basePath ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?> | AirAsia Rewards</title>
  <link rel="stylesheet" href="<?= htmlspecialchars($basePath) ?>css/styles.css">
</head>
<body>
  <header class="site-header">
    <a href="<?= htmlspecialchars($basePath) ?>card-list.php" class="logo">AirAsia <span>Rewards</span></a>
