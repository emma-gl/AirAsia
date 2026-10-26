<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Gift Card | AirAsia Rewards</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header class="site-header">
    <a href="card-list.php" class="logo">AirAsia <span>Rewards</span></a>
  </header>

  <main class="panel">
    <h1>Update Gift Card</h1>

    <form action="card-list.php" method="post" class="stacked-form">
      <div class="form-group">
        <label for="card-name">Card Name:</label>
        <input type="text" id="card-name" name="card_name" value="Starbucks e-Gift Card" required>
      </div>

      <div class="form-group">
        <label for="card-type">Card Type:</label>
        <input type="text" id="card-type" name="card_type" value="Food &amp; Beverage" required>
      </div>

      <div class="form-group">
        <label for="card-value">Card Value:</label>
        <input type="number" id="card-value" name="card_value" min="0.01" step="0.01" value="50.00" required>
      </div>

      <div class="form-group">
        <label for="points-required">Points Required:</label>
        <input type="number" id="points-required" name="points_required" min="1" step="1" value="5000" required>
      </div>

      <div class="button-row">
        <button type="submit" class="btn">Save Changes</button>
        <a href="card-details.php" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </main>
</body>
</html>
