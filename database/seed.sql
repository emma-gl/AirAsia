-- AirAsia Rewards Redemption System - sample data (HW3)
-- 5 ACCOUNT records and 20 GIFTCARD records.
-- cardType values must match GIFT_CARD_TYPES in includes/validation.php.

INSERT INTO ACCOUNT (userId, accountType, points) VALUES
    (1, 'Standard', 12500),
    (2, 'Premium',  48000),
    (3, 'Standard',  3200),
    (4, 'Platinum', 150000),
    (5, 'Premium',  27750);

INSERT INTO GIFTCARD (cardName, cardType, cardValue, points) VALUES
    ('Starbucks e-Gift Card',          'Food & Beverage', 50.00,   5000),
    ('Crumbl Voucher',                 'Food & Beverage', 25.00,   2500),
    ('Chipotle Gift Card',             'Food & Beverage', 20.00,   2000),
    ('DoorDash Gift Card',             'Food & Beverage', 75.00,   7500),
    ('Tealive Gift Card',              'Food & Beverage', 15.00,   1500),
    ('H&M Gift Card',                  'Retail',          25.00,   2500),
    ('Target Gift Card',               'Retail',          15.00,   1500),
    ('Amazon Gift Card',               'Retail',         100.00,  10000),
    ('Nike Gift Card',                 'Retail',          50.00,   5000),
    ('Sephora Gift Card',              'Retail',          40.00,   4000),
    ('Megaplex Movie Voucher',         'Entertainment',   30.00,   3000),
    ('Spotify Premium 3-Month Card',   'Entertainment',   30.00,   3200),
    ('Netflix Gift Card',              'Entertainment',   50.00,   5200),
    ('Steam Wallet Card',              'Entertainment',   20.00,   2100),
    ('AirAsia Flight Voucher',         'Travel',         200.00,  18000),
    ('Hotels.com Gift Card',           'Travel',         150.00,  15000),
    ('Grab Ride Voucher',              'Travel',          10.00,   1000),
    ('Costco Gift Card',               'Grocery',        200.00,  20000),
    ('Whole Foods Gift Card',          'Grocery',         50.00,   5000),
    ('Trader Joe''s Gift Card',        'Grocery',         25.00,   2500);
