

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lethbridge autojones`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

-- UNCOMMENT TO DELETE EXISTING DB -- ORDER MATTERS
-- original ordering of dropping tables doesn't work except on initial construction

-- DROP TABLE IF EXISTS warranty;
-- DROP TABLE IF EXISTS payment;
-- DROP TABLE IF EXISTS sale;
-- DROP TABLE IF EXISTS employee;
-- DROP TABLE IF EXISTS customer_employment_history;
-- DROP TABLE IF EXISTS customer;
-- DROP TABLE IF EXISTS problem;
-- DROP TABLE IF EXISTS purchase;
-- DROP TABLE IF EXISTS vehicle;





DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(16) NOT NULL,
  `last_name` varchar(16) NOT NULL,
  `gender` varchar(16) NOT NULL,
  `DOB` date NOT NULL,
  `phone_number` bigint NOT NULL,
  `address` varchar(32) NOT NULL,
  `city` varchar(16) NOT NULL,
  `state` varchar(16) NOT NULL,
  `zip` varchar(16) NOT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_employment_history`
--

DROP TABLE IF EXISTS `customer_employment_history`;
CREATE TABLE IF NOT EXISTS `customer_employment_history` (
  `employer` varchar(16) NOT NULL,
  `job_title` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `supervisor` varchar(16) NOT NULL,
  `customer_id` int NOT NULL,
  `phone_number` bigint NOT NULL,
  `start_date` date NOT NULL,
  PRIMARY KEY (`employer`,`job_title`,`customer_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(16) NOT NULL,
  `last_name` varchar(16) NOT NULL,
  `job_title` varchar(16) NOT NULL,
  `phone_number` bigint NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `payment_number` int NOT NULL,
  `sale_id` int NOT NULL,
  `due_date` date NOT NULL,
  `paid_date` date NOT NULL,
  `amount_due` decimal(8,2) NOT NULL,
  `amount_paid` decimal(8,2) NOT NULL,
  `bank_account` varchar(16) NOT NULL,
  PRIMARY KEY (`sale_id`, `payment_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `problem`
--

DROP TABLE IF EXISTS `problem`;
CREATE TABLE IF NOT EXISTS `problem` (
  `problem_type` varchar(16) NOT NULL,
  `problem_description` text NOT NULL,
  `eestimated_repair_cost` float(8,2) NOT NULL,
  `actual_repair_cost` float(8,2) NOT NULL,
  `vehicle_id` int NOT NULL,
  PRIMARY KEY (`problem_type`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

DROP TABLE IF EXISTS `purchase`;
CREATE TABLE IF NOT EXISTS `purchase` (
  `vehicle_id` int NOT NULL AUTO_INCREMENT,
  `purchase_date` date NOT NULL,
  `location` varchar(16) NOT NULL,
  `seller` varchar(16) NOT NULL,
  `auction` tinyint(1) NOT NULL,
  `price_paid` float(8,2) NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
CREATE TABLE IF NOT EXISTS `sale` (
  `sale_id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `sale_date` date NOT NULL,
  `sale_price` decimal(8,2) NOT NULL,
  `down_payment` decimal(8,2) NOT NULL,
  `finance_term_length` int NOT NULL,
  `interest` decimal(8,2) NOT NULL,
  `commission` decimal(8,2) NOT NULL,
  `employee_id` int NOT NULL,
  `open_closed` varchar(16) NOT NULL, 
  PRIMARY KEY (`sale_id`),
  KEY `employee_id` (`employee_id`),
  KEY `sale_ibfk_1` (`customer_id`),
  KEY `vehicle_id` (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
CREATE TABLE IF NOT EXISTS `vehicle` (
  `vehicle_id` int NOT NULL AUTO_INCREMENT,
  `make` varchar(16) NOT NULL,
  `model` varchar(16) NOT NULL,
  `year` int NOT NULL,
  `colour` varchar(16) NOT NULL,
  `miles` int NOT NULL,
  `vehicle_condition` varchar(16) NOT NULL,
  `book_price` decimal(8,2) NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty`
--

DROP TABLE IF EXISTS `warranty`;
CREATE TABLE IF NOT EXISTS `warranty` (
  `warranty_id` int NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `cost` decimal(8,2) NOT NULL,
  `deductible` decimal(8,2) NOT NULL,
  `sale_id` int NOT NULL,
  PRIMARY KEY (`warranty_id`),
  KEY `sale_id` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_employment_history`
--
ALTER TABLE `customer_employment_history`
  ADD CONSTRAINT `customer_employment_history_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `problem`
--
ALTER TABLE `problem`
  ADD CONSTRAINT `problem_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `sale`
--
ALTER TABLE `sale`
  ADD CONSTRAINT `sale_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sale_ibfk_3` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `warranty`
--
ALTER TABLE `warranty`
  ADD CONSTRAINT `warranty_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`sale_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
