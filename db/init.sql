--
-- 'registration' database creation script
--
CREATE DATABASE IF NOT EXISTS `registration`;


--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` int(11) NOT NULL,
  `nin` int(11) NOT NULL,
  `date` varchar(5) NOT NULL,
  `time` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nin` (`nin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;