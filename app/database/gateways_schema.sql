CREATE TABLE `payment_gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `instructions` text,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default manual gateways
INSERT INTO `payment_gateways` (`name`, `display_name`, `instructions`, `is_enabled`) VALUES
('bank_transfer', 'Bank Transfer', 'Please transfer the total amount to the following bank account:\n\nBank: Example Bank\nAccount Number: 123456789\nAccount Name: HostBill Inc.\n\nPlease include your invoice number in the reference.', 1),
('cryptocurrency', 'Cryptocurrency', 'Please send the total amount in BTC to the following address:\n\n[Your BTC Wallet Address]\n\nAfter sending, please open a support ticket with the transaction details.', 1);
