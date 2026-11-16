# HW3 Test Report – Gift Card Management


| Test ID | Test | Status |
| --- | --- | --- |
| T01 | Validation test harness | Pass |
| T02 | View Gift Card List | Pass |
| T03 | View Gift Card Details | Pass |
| T04 | Add Gift Card | Pass |
| T05 | Update Gift Card | Pass |
| T06 | Delete Gift Card | Pass |
| T07 | Invalid or altered input handling | Pass |
| T08 | Invalid Gift Card identifier handling | Pass |

---

## T01 – Validation test harness

**Steps and input**
1. Open `/tests/validation-tests.php`.
2. Review the PASS/FAIL column. The required inputs are:
   - Valid data: `Starbucks e-Gift Card` / `Food & Beverage` / `50.00` / `5000`
   - Blank Card Name: `""`
   - Altered Card Type: `Cryptocurrency`
   - Zero Card Value: `0`
   - Negative Card Value: `-25`
   - Invalid Points Required: `12.5`
   - Additional checks: a name of only spaces, 101- and 100-character names, `retail` in the wrong letter case, the value `fifty`, 0 and -100 points, an empty submission, a field sent as an array, and 10 Card ID inputs.
3. Compare the GIFTCARD row count before and after loading the page.

**Expected result:** Valid data passes and each invalid case fails validation. Every row shows PASS. The page does not change the database.

**Actual result:** The page showed "25 of 25 tests passed" and every row read PASS. The harness only includes `validation.php` and never opens a database connection. The GIFTCARD count stayed at 20.

**Status:** Pass

---

## T02 – View Gift Card List

**Steps and input**
1. Open `/card-list.php`.
2. Check the cards shown, the links, and the navigation.

**Expected result:** All 20 seeded gift cards appear, each with the card image, Card Name, and Points Required. The image and the name both link to `card-details.php?card_id=<id>`. An "Add Gift Card" link is shown, and the shared header, navigation (Gift Card List, Add Gift Card), and footer appear.

**Actual result:** HTTP 200. 20 cards were shown in alphabetical order, each with an image, name, and formatted points (for example "18,000 points"). The image and name linked to the matching `card-details.php?card_id=…` (for example `card_id=15` for AirAsia Flight Voucher). The "Add Gift Card" button and the shared navigation were present.

**Status:** Pass

---

## T03 – View Gift Card Details

**Steps and input**
1. On card-list.php, click **Starbucks e-Gift Card**, which opens `card-details.php?card_id=1`.

**Expected result:** A read-only page shows the card image, Card ID, Card Name, Card Type, Card Value, and Points Required, matching the database. It has links to Update Gift Card, Delete Gift Card, and Return to Gift Card List.

**Actual result:** HTTP 200. The page showed Card ID 1, Starbucks e-Gift Card, Food & Beverage, $50.00, and 5,000, which matches seed.sql. The links went to `card-update.php?card_id=1`, `card-delete.php?card_id=1`, and `card-list.php`. The page has no form fields.

**Status:** Pass

---

## T04 – Add Gift Card

**Steps and input**
1. Click **Add Gift Card** in the navigation.
2. Enter Card Name `Test <b>Card</b>`, Card Type `Retail`, Card Value `12.50`, Points Required `1250`. The name contains HTML to check that output is escaped.
3. Click **Add Gift Card**.

**Expected result:** The form submits by POST, passes validation, and the record is inserted. The browser goes to card-list.php with a success message, and the new card appears with its name shown as text, not as HTML.

**Actual result:** POST returned **302** to `card-list.php?status=added`. The list showed "The Gift Card was added." and 21 cards. The new card (card_id 21) showed the name literally as `Test <b>Card</b>`, and the page source contained `Test &lt;b&gt;Card&lt;/b&gt;`. This confirms `htmlspecialchars()` escaped it. There is no Card ID input on the form.

**Status:** Pass

---

## T05 – Update Gift Card

**Steps and input**
1. Open the new card's details page and click **Update Gift Card**, which opens `card-update.php?card_id=21`.
2. Confirm the form is prepopulated.
3. Change the values to Card Name `Test Card Updated`, Card Type `Travel`, Card Value `99.99`, Points Required `9999`, and click **Save Changes**.
4. Repeat with invalid values: Card Value `0`, Points Required `abc`.

**Expected result:** The form shows the saved values with `Retail` selected. A valid submission updates the record by POST and redirects to `card-details.php?card_id=21`, which shows the new values. An invalid submission shows error messages and does not change the record.

**Actual result:** The form was prepopulated with `Test <b>Card</b>` (escaped), `Retail` selected, `12.50`, and `1250`, plus a hidden `card_id` of 21. The valid POST returned **302** to `card-details.php?card_id=21&status=updated`. That page showed "The Gift Card was updated" and the values Test Card Updated, Travel, $99.99, and 9,999. The invalid POST returned 200 with "Card Value must be greater than 0." and "Points Required must be a whole number…". The record was not changed.

**Status:** Pass

---

## T06 – Delete Gift Card

**Steps and input**
1. On the card 21 details page, click **Delete Gift Card**, which opens `card-delete.php?card_id=21` by GET.
2. Without confirming, reload `card-details.php?card_id=21`.
3. Send a POST to card-delete.php with `card_id=21` but without the confirmation field.
4. Click **Yes, Delete Gift Card**.

**Expected result:** The GET request shows the card's details and a confirmation form, and nothing is deleted. A POST without confirmation deletes nothing. The confirmed POST deletes the card and returns to card-list.php.

**Actual result:** The GET request returned 200 and showed Card ID 21, Test Card Updated, Travel, $99.99, 9,999, a warning, and the button. The card still existed after the GET (details returned 200) and after the unconfirmed POST (still 200). The confirmed POST returned **302** to `card-list.php?status=deleted`. The list showed "The Gift Card was deleted." and 20 cards. `card-details.php?card_id=21` then returned 404.

**Status:** Pass

---

## T07 – Invalid or altered input handling

**Steps and input**
1. On card-add.php, submit Card Name blank, Card Type `Crypto` (sent with curl because it is not a dropdown option), Card Value `-5`, and Points Required `12.5`.
2. Submit `card_name[]=x`, which sends the field as an array instead of a string.
3. In the browser, try the same values with the HTML `required`/`min` limits. The form uses `novalidate`, so the server checks are what get tested.

**Expected result:** No record is inserted. The page shows an error summary and an error message under each invalid field, and keeps the entered values. No PHP warnings or errors appear.

**Actual result:** Both submissions returned 200 and no record was inserted. Step 1 listed four errors: "Card Name is required.", "Card Type must be one of: Food & Beverage, Retail, Entertainment, Travel, Grocery.", "Card Value must be a positive number with up to 2 decimal places", and "Points Required must be a whole number…". The entered value `-5` was kept in the field. Step 2 was treated as a blank name ("Card Name is required.") with no PHP error.

**Status:** Pass

---

## T08 – Invalid Gift Card identifier handling

**Steps and input**
Request `card-details.php` with each of these `card_id` values: `999` (does not exist), `0`, `-1`, `abc`, `1.5`, `1 OR 1=1`, `<script>`, an empty value, no parameter at all, and `card_id[]=1`. Also try:
- `card-update.php?card_id=999`
- `card-delete.php?card_id=999`
- a POST to card-update.php with a hidden `card_id=abc`
- a POST to card-delete.php with `card_id=999&confirm=yes`

**Expected result:** No query runs for an invalid ID, and the page returns **400**. A valid ID with no matching card returns **404**. Both show a friendly "Gift Card Not Found" page, with the shared templates, that links back to the list. No PHP errors appear and nothing is changed.

**Actual result:** `999` and the deleted ID `21` returned **404** with "No Gift Card exists with ID 999. It may have been deleted." All other invalid values, including the empty value, the missing parameter, and the array, returned **400** with "The Gift Card ID is missing or invalid." The update and delete pages returned 404 for ID 999. The update POST with a bad hidden ID returned 400, and the delete POST for 999 returned 404. No rows were changed.

**Status:** Pass

---
