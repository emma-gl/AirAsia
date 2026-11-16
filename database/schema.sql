-- AirAsia Rewards Redemption System - SQLite schema (HW3)
-- Table and column names follow the AirAsia Requirements Document.
--
-- ACCOUNT.userId refers to the USER table, which is created in HW4 along with login.
-- The foreign key constraint is added then; for now userId is a required integer.
-- ACCOUNT and GIFTCARD are related through the REDEMPTION table (also HW4).

PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS GIFTCARD;
DROP TABLE IF EXISTS ACCOUNT;

-- Account table data structure
CREATE TABLE ACCOUNT (
    accountId    INTEGER      PRIMARY KEY AUTOINCREMENT,  -- int(11), auto, primary
    userId       INT          NOT NULL,                   -- int(11)
    accountType  VARCHAR(100) NOT NULL,                   -- varchar(100)
    points       INT          NOT NULL CHECK (points >= 0) -- int(50)
);

-- Gift card table data structure
CREATE TABLE GIFTCARD (
    cardId     INTEGER      PRIMARY KEY AUTOINCREMENT,              -- int(11), auto, primary
    cardName   VARCHAR(100) NOT NULL CHECK (length(cardName) BETWEEN 1 AND 100),
    cardType   VARCHAR(100) NOT NULL,                               -- varchar(100)
    cardValue  FLOAT        NOT NULL CHECK (cardValue > 0),         -- float(10)
    points     INT          NOT NULL CHECK (points > 0)             -- int(50): points required to redeem
);
