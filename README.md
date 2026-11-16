# AirAsia Rewards – Gift Card Management (HW3)

A PHP and SQLite application for managing AirAsia Rewards Gift Cards. It supports creating, reading, updating, and deleting Gift Card records. It uses PDO prepared statements, shared page templates, and server-side validation.

Login, sessions, authorization, customer management, and redemption are part of HW4. They are not in this homework.

## Running the app in GitHub Codespaces

1. Open the repository in a Codespace.
2. From the project root, start PHP's built-in web server:

   ```bash
   php -S 0.0.0.0:8000
   ```

3. When Codespaces offers to open port 8000, open it in the browser and go to `/card-list.php`.
4. The validation test harness is at `/tests/validation-tests.php`.

### Rebuilding the database

`database/rewards.db` is committed with the seed data already loaded. To reset it to the original 5 accounts and 20 gift cards (this deletes any changes made in the app):

```bash
php database/init-db.php
```

The script runs `database/schema.sql` and then `database/seed.sql`. Both scripts need PHP's `pdo_sqlite` extension, which Codespaces includes. To check that it is loaded, run `php -m | grep -i sqlite`.

## Project structure

| Path | Purpose |
| --- | --- |
| `card-list.php` | Lists all gift cards with image, name, and points |
| `card-details.php` | Read-only view of one gift card |
| `card-add.php` | Form to add a gift card |
| `card-update.php` | Prepopulated form to update a gift card |
| `card-delete.php` | Confirmation page; deletes only on POST |
| `includes/header.php`, `nav.php`, `footer.php` | Shared page templates |
| `includes/db.php` | PDO connection to SQLite and the `get_gift_card()` helper |
| `includes/validation.php` | Reusable validation functions and the allowed Card Types |
| `includes/card-form.php` | Form fields shared by the add and update pages |
| `includes/load-card.php` | Validates `card_id` and loads the card, used by details, update, and delete |
| `includes/not-found.php` | Error page for a missing, invalid, or nonexistent `card_id` |
| `database/schema.sql` | Creates the `ACCOUNT` and `GIFTCARD` tables |
| `database/seed.sql` | Inserts 5 `ACCOUNT` rows and 20 `GIFTCARD` rows |
| `database/init-db.php` | Rebuilds `rewards.db` from the two SQL scripts |
| `database/rewards.db` | The SQLite database |
| `tests/validation-tests.php` | Validation test harness (does not touch the database) |
| `login.php` | Static login prototype from HW2, to be implemented in HW4 |

## Database

Table and column names follow the AirAsia Requirements Document.

**GIFTCARD**: `cardId` (int, auto-increment, primary key), `cardName` (varchar 100), `cardType` (varchar 100), `cardValue` (float), `points` (int). None of the columns allow NULL. The `points` column holds the **Points Required** to redeem the card.

**ACCOUNT**: `accountId` (int, auto-increment, primary key), `userId` (int), `accountType` (varchar 100), `points` (int). None of the columns allow NULL.

`ACCOUNT.userId` refers to the `USER` table, which will be created in HW4. `ACCOUNT` and `GIFTCARD` are linked through the `REDEMPTION` table, which is also part of HW4.

## Validation rules

All rules are enforced on the server in `includes/validation.php`. The HTML form attributes only improve the user experience and do not replace these checks.

| Field | Rule |
| --- | --- |
| Card Name | Required after trimming spaces; 1–100 characters |
| Card Type | Must exactly match one of: Food & Beverage, Retail, Entertainment, Travel, Grocery |
| Card Value | Positive number, up to 2 decimal places, greater than 0 and at most 10,000 |
| Points Required | Positive whole number from 1 to 10,000,000 |
| Card ID (`card_id`) | Positive whole number; otherwise the page returns 400. If no card has that ID, the page returns 404. |

The requirements document does not list allowed Card Type values, so this project defines the set above. The same list is used to build the dropdown and to validate submitted values.

## Use Case Traceability

Use case names come from the AirAsia Requirements Document.

| Use case | PHP page or pages | Database table | Test evidence |
| --- | --- | --- | --- |
| View a list of gift cards | `card-list.php` | GIFTCARD | Opened card-list.php and confirmed all 20 seeded cards appeared with image, name, and points, each linking to `card-details.php?card_id=…` (T02). |
| View details of one gift card | `card-details.php` (with `includes/load-card.php`) | GIFTCARD | Opened `card-details.php?card_id=1` and confirmed every attribute matched the database row, with links to update, delete, and return to the list. Invalid and nonexistent IDs showed an error page (T03, T08). |
| Add data for a new gift card | `card-add.php` (with `includes/card-form.php`, `includes/validation.php`) | GIFTCARD | Submitted valid Gift Card data and confirmed the new record appeared on card-list.php. Invalid data was rejected with error messages (T04, T07). |
| Update data for one gift card | `card-update.php` (with `includes/card-form.php`, `includes/validation.php`) | GIFTCARD | Confirmed the form was prepopulated, saved new values, and was redirected to card-details.php showing the updated values (T05). |
| Delete a card | `card-delete.php` | GIFTCARD | Confirmed opening the page by GET only shows the confirmation. Submitting the POST form removed the card and returned to card-list.php with one fewer card (T06). |

### Notes on differences from the requirements document

- **Update redirect:** The requirements document forwards to card-list after an update. The HW3 assignment's required workflow says to show card-details with the updated information, so this project does that.
- **Delete page:** The requirements document describes card-delete as a PHP page with no HTML. HW3 requires a confirmation page with a POST form, so card-delete shows the card first and deletes it only after confirmation.
- **Add Customer link:** The link to cust-add on card-list is left out because Add Customer belongs to HW4.

## Testing

- `test-report.md` documents tests T01–T08.
- `tests/validation-tests.php` runs 25 automated validation checks and shows PASS or FAIL for each.
