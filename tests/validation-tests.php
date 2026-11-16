<?php
/*
 * Validation test harness.
 * Calls the functions in includes/validation.php directly. It never connects to the
 * database, so running it cannot add, change, or delete any records.
 */
require_once __DIR__ . '/../includes/validation.php';

$validCard = [
    'card_name'       => 'Starbucks e-Gift Card',
    'card_type'       => 'Food & Beverage',
    'card_value'      => '50.00',
    'points_required' => '5000',
];

/** Returns true when validate_gift_card() reports no errors for $input. */
function passes(array $input): bool
{
    [, $errors] = validate_gift_card($input);
    return $errors === [];
}

/** Returns true when validate_gift_card() reports an error on $field for $input. */
function fails_on(array $input, string $field): bool
{
    [, $errors] = validate_gift_card($input);
    return isset($errors[$field]);
}

// Each test: [description, input shown on the page, expected result, actual outcome matched expectation?]
$tests = [
    // Required tests
    ['Valid Gift Card data', $validCard, 'Passes validation',
        passes($validCard)],
    ['Blank Card Name', ['card_name' => ''] + $validCard, 'Fails validation',
        fails_on(['card_name' => ''] + $validCard, 'card_name')],
    ['Altered or invalid Card Type', ['card_type' => 'Cryptocurrency'] + $validCard, 'Fails validation',
        fails_on(['card_type' => 'Cryptocurrency'] + $validCard, 'card_type')],
    ['Zero Card Value', ['card_value' => '0'] + $validCard, 'Fails validation',
        fails_on(['card_value' => '0'] + $validCard, 'card_value')],
    ['Negative Card Value', ['card_value' => '-25'] + $validCard, 'Fails validation',
        fails_on(['card_value' => '-25'] + $validCard, 'card_value')],
    ['Invalid Points Required (decimal)', ['points_required' => '12.5'] + $validCard, 'Fails validation',
        fails_on(['points_required' => '12.5'] + $validCard, 'points_required')],

    // Additional tests
    ['Card Name of only spaces', ['card_name' => '    '] + $validCard, 'Fails validation',
        fails_on(['card_name' => '    '] + $validCard, 'card_name')],
    ['Card Name longer than 100 characters', ['card_name' => str_repeat('A', 101)] + $validCard, 'Fails validation',
        fails_on(['card_name' => str_repeat('A', 101)] + $validCard, 'card_name')],
    ['Card Name of exactly 100 characters', ['card_name' => str_repeat('A', 100)] + $validCard, 'Passes validation',
        passes(['card_name' => str_repeat('A', 100)] + $validCard)],
    ['Card Type with different letter case', ['card_type' => 'retail'] + $validCard, 'Fails validation',
        fails_on(['card_type' => 'retail'] + $validCard, 'card_type')],
    ['Non-numeric Card Value', ['card_value' => 'fifty'] + $validCard, 'Fails validation',
        fails_on(['card_value' => 'fifty'] + $validCard, 'card_value')],
    ['Zero Points Required', ['points_required' => '0'] + $validCard, 'Fails validation',
        fails_on(['points_required' => '0'] + $validCard, 'points_required')],
    ['Negative Points Required', ['points_required' => '-100'] + $validCard, 'Fails validation',
        fails_on(['points_required' => '-100'] + $validCard, 'points_required')],
    ['Missing fields (empty submission)', [], 'Fails validation',
        fails_on([], 'card_name') && fails_on([], 'card_type')
        && fails_on([], 'card_value') && fails_on([], 'points_required')],
    ['Field submitted as an array (card_name[]=x)', ['card_name' => ['x']] + $validCard, 'Fails validation',
        fails_on(['card_name' => ['x']] + $validCard, 'card_name')],
];

// Card identifier tests: [input, expected id or null]
$idCases = [
    ['12', 12], ['1', 1], ['0', null], ['-3', null], ['abc', null],
    ['1.5', null], ['12abc', null], ['', null], [null, null], [['1'], null],
];
foreach ($idCases as [$input, $expected]) {
    $tests[] = [
        'Card ID ' . var_export($input, true),
        ['card_id' => $input],
        $expected === null ? 'Rejected as invalid' : "Accepted as {$expected}",
        validate_card_id($input) === $expected,
    ];
}

$passCount = count(array_filter(array_column($tests, 3)));
$total     = count($tests);

/** Formats a test input for display. */
function show_input(array $input): string
{
    $parts = [];
    foreach ($input as $key => $value) {
        $parts[] = $key . ' = ' . (is_string($value) && strlen($value) > 30
            ? '"' . substr($value, 0, 12) . '..." (' . strlen($value) . ' chars)'
            : var_export($value, true));
    }
    return $parts ? implode("\n", $parts) : '(no fields)';
}

$pageTitle = 'Validation Tests';
$basePath  = '../';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/nav.php';
?>
    <h1>Validation Test Harness</h1>
    <p class="sub-heading">Tests the functions in includes/validation.php. No database records are added, changed, or deleted.</p>

    <p class="alert <?= $passCount === $total ? 'alert-success' : 'alert-error' ?>">
      <?= $passCount ?> of <?= $total ?> tests passed.
    </p>

    <div class="table-wrap">
      <table class="test-table">
        <thead>
          <tr><th>#</th><th>Test</th><th>Input</th><th>Expected result</th><th>Status</th></tr>
        </thead>
        <tbody>
          <?php foreach ($tests as $i => [$name, $input, $expected, $ok]): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($name) ?></td>
              <td><pre><?= htmlspecialchars(show_input($input)) ?></pre></td>
              <td><?= htmlspecialchars($expected) ?></td>
              <td class="<?= $ok ? 'pass' : 'fail' ?>"><?= $ok ? 'PASS' : 'FAIL' ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
