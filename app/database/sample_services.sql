-- Insert some sample services
INSERT INTO `services` (`user_id`, `product_id`, `next_due_date`, `status`) VALUES
-- A service for user 1 (admin) that is due in 5 days
(1, 1, CURDATE() + INTERVAL 5 DAY, 'Active'),
-- A service for user 1 (admin) that is due in 10 days (should not be invoiced yet)
(1, 2, CURDATE() + INTERVAL 10 DAY, 'Active'),
-- A service for user 2 (a regular user, if one exists) that is due tomorrow
-- Note: This assumes a user with ID 2 exists.
(2, 1, CURDATE() + INTERVAL 1 DAY, 'Active'),
-- A cancelled service that is due (should not be invoiced)
(2, 2, CURDATE(), 'Cancelled');
