<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Gift Card | AirAsia Rewards</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header class="site-header">
    <a href="card-list.php" class="logo">AirAsia <span>Rewards</span></a>
  </header>

  <main class="panel">
    <h1>Add Gift Card</h1>

    <form action="card-list.php" method="post" class="stacked-form">
      <div class="form-group">
        <label for="card-name">Card Name:</label>
        <input type="text" id="card-name" name="card_name" placeholder="e.g. Starbucks e-Gift Card" required>
      </div>

      <div class="form-group">
        <label for="card-type">Card Type:</label>
        <input type="text" id="card-type" name="card_type" placeholder="e.g. Food &amp; Beverage" required>
      </div>

      <div class="form-group">
        <label for="card-value">Card Value:</label>
        <input type="number" id="card-value" name="card_value" min="0.01" step="0.01" placeholder="e.g. 25.00" required>
      </div>

      <div class="form-group">
        <label for="points-required">Points Required:</label>
        <input type="number" id="points-required" name="points_required" min="1" step="1" placeholder="e.g. 5000" required>
      </div>

      <div class="button-row">
        <button type="submit" class="btn">Add Gift Card</button>
        <a href="card-list.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </main>
</body>
</html>
