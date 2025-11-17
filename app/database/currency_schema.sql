CREATE TABLE `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(5) NOT NULL,
  `is_base` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `settings` (
  `setting` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default currencies and settings
INSERT INTO `currencies` (`code`, `name`, `symbol`, `is_base`) VALUES
('NGN', 'Nigerian Naira', '₦', 1),
('USD', 'United States Dollar', '$', 0);

INSERT INTO `settings` (`setting`, `value`) VALUES
('base_currency', 'NGN'),
('usd_conversion_rate', '1200.00');
