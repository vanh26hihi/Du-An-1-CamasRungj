-- Migration: add sample start/end dates to `tour` table

ALTER TABLE `tour`
  ADD COLUMN `mau_ngay_bat_dau` DATE DEFAULT NULL,
  ADD COLUMN `mau_ngay_ket_thuc` DATE DEFAULT NULL;

-- Run this SQL in your MySQL (phpMyAdmin or CLI) to add sample date columns.
