<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | AirAsia Rewards</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body class="login-page">
  <main>
    <section class="panel">
      <h1 class="title-box">AirAsia Rewards Redemption</h1>

      <form action="card-list.php" method="post" class="stacked-form">
        <div class="form-group">
          <label for="username">Enter your username:</label>
          <input type="text" id="username" name="username" autocomplete="username" required>
        </div>

        <div class="form-group">
          <label for="password">Enter your password:</label>
          <input type="password" id="password" name="password" autocomplete="current-password" required>
        </div>

        <div class="button-row">
          <button type="submit" class="btn btn-wide">Log in</button>
        </div>
      </form>
    </section>
  </main>
</body>
</html>
