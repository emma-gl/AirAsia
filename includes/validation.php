<?php
/*
 * Reusable server-side validation for Gift Card data.
 * These functions do not touch the database, so tests/validation-tests.php can call them safely.
 */

/** Allowed values for GIFTCARD.cardType. Form dropdowns are built from this same list. */
const GIFT_CARD_TYPES = [
    'Food & Beverage',
    'Retail',
    'Entertainment',
    'Travel',
    'Grocery',
];

const CARD_NAME_MAX_LENGTH = 100;  // GIFTCARD.cardName is varchar(100)
const CARD_VALUE_MAX       = 10000;
const POINTS_MAX           = 10000000;

/**
 * Reads a submitted field as a trimmed string.
 * Returns '' when the field is missing or was submitted as an array (e.g. card_name[]=x).
 */
function input_string(array $source, string $key): string
{
    $value = $source[$key] ?? '';
    return is_string($value) ? trim($value) : '';
}

/**
 * Validates a Gift Card identifier (from a URL parameter or hidden form field).
 * Returns the id as a positive int, or null if it is not a valid positive whole number.
 */
function validate_card_id($value): ?int
{
    if (!is_string($value) && !is_int($value)) {
        return null;
    }
    if (is_string($value) && !preg_match('/^[0-9]+$/', $value)) {
        return null; // rejects "", "-3", "1.5", "12abc", " 7", "1e3"
    }
    $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? null : $id;
}

/** Card Name is required and at most 100 characters. Returns an error message or null. */
function validate_card_name(string $name): ?string
{
    if ($name === '') {
        return 'Card Name is required.';
    }
    if (!preg_match('/^.{1,' . CARD_NAME_MAX_LENGTH . '}$/us', $name)) {
        return 'Card Name must be ' . CARD_NAME_MAX_LENGTH . ' characters or fewer.';
    }
    return null;
}

/** Card Type must be one of GIFT_CARD_TYPES (exact match). Returns an error message or null. */
function validate_card_type(string $type): ?string
{
    if ($type === '') {
        return 'Card Type is required.';
    }
    if (!in_array($type, GIFT_CARD_TYPES, true)) {
        return 'Card Type must be one of: ' . implode(', ', GIFT_CARD_TYPES) . '.';
    }
    return null;
}

/** Card Value must be a positive amount with at most 2 decimal places. Returns an error message or null. */
function validate_card_value(string $value): ?string
{
    if ($value === '') {
        return 'Card Value is required.';
    }
    if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $value)) {
        return 'Card Value must be a positive number with up to 2 decimal places (e.g. 25.00).';
    }
    $amount = (float) $value;
    if ($amount <= 0) {
        return 'Card Value must be greater than 0.';
    }
    if ($amount > CARD_VALUE_MAX) {
        return 'Card Value cannot be more than ' . number_format(CARD_VALUE_MAX) . '.';
    }
    return null;
}

/** Points Required must be a positive whole number. Returns an error message or null. */
function validate_points(string $points): ?string
{
    if ($points === '') {
        return 'Points Required is required.';
    }
    if (!preg_match('/^[0-9]+$/', $points)) {
        return 'Points Required must be a whole number with no decimals, signs, or commas.';
    }
    $count = filter_var($points, FILTER_VALIDATE_INT);
    if ($count === false || $count < 1) {
        return 'Points Required must be at least 1.';
    }
    if ($count > POINTS_MAX) {
        return 'Points Required cannot be more than ' . number_format(POINTS_MAX) . '.';
    }
    return null;
}

/**
 * Validates submitted Gift Card form data.
 *
 * Returns [$values, $errors]:
 *   $values - trimmed submitted strings keyed by form field name (for redisplaying the form)
 *   $errors - field name => error message; empty when the data is valid
 */
function validate_gift_card(array $input): array
{
    $values = [
        'card_name'       => input_string($input, 'card_name'),
        'card_type'       => input_string($input, 'card_type'),
        'card_value'      => input_string($input, 'card_value'),
        'points_required' => input_string($input, 'points_required'),
    ];

    $errors = array_filter([
        'card_name'       => validate_card_name($values['card_name']),
        'card_type'       => validate_card_type($values['card_type']),
        'card_value'      => validate_card_value($values['card_value']),
        'points_required' => validate_points($values['points_required']),
    ]);

    return [$values, $errors];
}
