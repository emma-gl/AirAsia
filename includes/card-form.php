<?php
/*
 * Gift Card form fields shared by card-add.php and card-update.php.
 *
 * Expects:
 *   $values      - field name => current value (strings)
 *   $errors      - field name => error message
 *   $submitLabel - text for the submit button
 *   $cancelUrl   - where the Cancel button goes
 *   $formAction  - URL the form posts to
 *   $cardId      - (optional) id of the card being updated, sent as a hidden field
 */

/** Prints the error message for one field, if it has one. */
function field_error(array $errors, string $field): void
{
    if (isset($errors[$field])) {
        echo '<p class="field-error" id="' . $field . '-error">' . htmlspecialchars($errors[$field]) . '</p>';
    }
}

/** Adds aria attributes so screen readers announce the field's error. */
function error_attrs(array $errors, string $field): string
{
    return isset($errors[$field]) ? ' aria-invalid="true" aria-describedby="' . $field . '-error"' : '';
}
?>
<?php if ($errors): ?>
  <div class="error-summary" role="alert">
    <p>Please correct the following:</p>
    <ul>
      <?php foreach ($errors as $message): ?>
        <li><?= htmlspecialchars($message) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form action="<?= htmlspecialchars($formAction) ?>" method="post" class="stacked-form" novalidate>
  <?php if (isset($cardId)): ?>
    <input type="hidden" name="card_id" value="<?= htmlspecialchars((string) $cardId) ?>">
  <?php endif; ?>

  <div class="form-group">
    <label for="card_name">Card Name:</label>
    <input type="text" id="card_name" name="card_name" maxlength="<?= CARD_NAME_MAX_LENGTH ?>"
           placeholder="e.g. Starbucks e-Gift Card" required
           value="<?= htmlspecialchars($values['card_name']) ?>"<?= error_attrs($errors, 'card_name') ?>>
    <?php field_error($errors, 'card_name'); ?>
  </div>

  <div class="form-group">
    <label for="card_type">Card Type:</label>
    <select id="card_type" name="card_type" required<?= error_attrs($errors, 'card_type') ?>>
      <option value="">-- Select a card type --</option>
      <?php foreach (GIFT_CARD_TYPES as $type): ?>
        <option value="<?= htmlspecialchars($type) ?>"<?= $values['card_type'] === $type ? ' selected' : '' ?>><?= htmlspecialchars($type) ?></option>
      <?php endforeach; ?>
    </select>
    <?php field_error($errors, 'card_type'); ?>
  </div>

  <div class="form-group">
    <label for="card_value">Card Value ($):</label>
    <input type="number" id="card_value" name="card_value" min="0.01" max="<?= CARD_VALUE_MAX ?>" step="0.01"
           placeholder="e.g. 25.00" required
           value="<?= htmlspecialchars($values['card_value']) ?>"<?= error_attrs($errors, 'card_value') ?>>
    <?php field_error($errors, 'card_value'); ?>
  </div>

  <div class="form-group">
    <label for="points_required">Points Required:</label>
    <input type="number" id="points_required" name="points_required" min="1" max="<?= POINTS_MAX ?>" step="1"
           placeholder="e.g. 5000" required
           value="<?= htmlspecialchars($values['points_required']) ?>"<?= error_attrs($errors, 'points_required') ?>>
    <?php field_error($errors, 'points_required'); ?>
  </div>

  <div class="button-row">
    <button type="submit" class="btn"><?= htmlspecialchars($submitLabel) ?></button>
    <a href="<?= htmlspecialchars($cancelUrl) ?>" class="btn btn-secondary">Cancel</a>
  </div>
</form>
