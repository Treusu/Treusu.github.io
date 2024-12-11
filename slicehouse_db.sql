-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 09:28 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slicehouse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cartItemID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `orderDate` datetime NOT NULL DEFAULT current_timestamp(),
  `totalAmount` decimal(10,2) NOT NULL,
  `orderStatus` enum('pending','processing','completed','cancelled') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `orderItemID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceAtOrder` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `paymentID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `paymentMethod` enum('cash','gcash') NOT NULL,
  `paymentDate` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL,
  `transactionDetails` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`paymentID`, `userID`, `paymentMethod`, `paymentDate`, `amount`, `transactionDetails`) VALUES
(1, 7, 'gcash', '2024-12-12 02:38:39', '500.00', NULL),
(2, 7, 'cash', '2024-12-12 02:38:45', '500.00', NULL),
(3, 7, 'cash', '2024-12-12 02:44:49', '500.00', NULL),
(4, 7, 'cash', '2024-12-12 03:18:31', '0.30', NULL),
(5, 7, 'cash', '2024-12-12 03:19:25', '0.30', NULL),
(6, 7, 'cash', '2024-12-12 03:34:48', '947.00', NULL),
(7, 7, 'cash', '2024-12-12 03:35:00', '947.00', NULL),
(8, 7, 'cash', '2024-12-12 03:36:37', '1146.00', NULL),
(9, 7, 'cash', '2024-12-12 03:40:28', '947.00', NULL),
(10, 7, 'cash', '2024-12-12 03:44:57', '947.00', NULL),
(11, 7, 'cash', '2024-12-12 03:45:22', '947.00', NULL),
(12, 7, 'cash', '2024-12-12 03:47:11', '947.00', NULL),
(13, 7, 'cash', '2024-12-12 03:50:00', '947.00', NULL),
(14, 7, 'gcash', '2024-12-12 03:51:27', '947.00', NULL),
(15, 7, 'cash', '2024-12-12 03:54:23', '1296.00', NULL),
(16, 7, 'cash', '2024-12-12 03:56:51', '947.00', NULL),
(17, 7, 'cash', '2024-12-12 04:00:03', '947.00', NULL),
(18, 7, 'gcash', '2024-12-12 04:06:55', '1395.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `category` enum('pizza','salad','starter') NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productName`, `category`, `price`, `image_url`, `description`) VALUES
(1, 'Margherita Pizza', 'pizza', '299.00', 'https://images.getbento.com/accounts/c3d5c00dc56eb47e2e4b4b27d99c5c7b/media/images/44841istockphoto-1414575281-170667a.webp?w=1200&fit=crop&auto=compress,format&cs=origin&crop=focalpoint&fp-x=0.5&fp-y=0.5', 'A classic pizza with fresh mozzarella, tomatoes, and basil.'),
(2, 'Pepperoni Pizza', 'pizza', '349.00', 'https://eu.ooni.com/cdn/shop/articles/pepperoni-pizza.jpg?crop=center&height=800&v=1587043733&width=800', 'A pizza topped with pepperoni and melted cheese.'),
(3, 'Caesar Salad', 'salad', '199.00', 'https://itsavegworldafterall.com/wp-content/uploads/2023/04/Avocado-Caesar-Salad-FI.jpg', 'A traditional Caesar salad with romaine lettuce, croutons, and Caesar dressing.'),
(4, 'Greek Salad', 'salad', '249.00', 'https://i2.wp.com/www.downshiftology.com/wp-content/uploads/2018/08/Greek-Salad-6-1.jpg', 'A fresh mix of cucumbers, tomatoes, olives, feta cheese, and olive oil.'),
(5, 'Garlic Bread', 'starter', '99.00', 'https://static01.nyt.com/images/2018/12/11/dining/as-garlic-bread/as-garlic-bread-square640.jpg', 'Crispy bread topped with garlic butter and herbs.'),
(6, 'Chicken Wings', 'starter', '199.00', 'https://www.allrecipes.com/thmb/AtViolcfVtInHgq_mRtv4tPZASQ=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/ALR-187822-baked-chicken-wings-4x3-5c7b4624c8554f3da5aabb7d3a91a209.jpg', 'Delicious fried chicken wings tossed in your choice of sauce.'),
(7, 'BBQ Chicken Pizza', 'pizza', '299.00', 'https://breadboozebacon.com/wp-content/uploads/2023/05/BBQ-Chicken-Pizza-SQUARE.jpg', 'Grilled chicken, BBQ sauce, and mozzarella cheese.'),
(8, 'Cobb Salad', 'salad', '299.00', 'https://i2.wp.com/www.downshiftology.com/wp-content/uploads/2019/04/Cobb-Salad-main.jpg', 'A hearty salad with chicken, bacon, avocado, and boiled eggs.'),
(9, 'Mozzarella Sticks', 'starter', '159.00', 'https://beplantwell.com/wp-content/uploads/2023/01/IMG_8395-480x480.jpg', 'Golden fried mozzarella sticks served with marinara sauce.');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stockID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `lastUpdated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stockID`, `productID`, `quantity`, `lastUpdated`) VALUES
(1, 1, 50, '2024-12-12 00:19:12'),
(2, 2, 30, '2024-12-12 00:19:12'),
(3, 3, 40, '2024-12-12 00:19:12'),
(4, 4, 25, '2024-12-12 00:19:12'),
(5, 5, 100, '2024-12-12 00:19:12'),
(6, 6, 60, '2024-12-12 00:19:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `username`, `password`, `email`) VALUES
(5, 'John', 'Doe', 'johndoe', 'hashed_password_example', 'john.doe@example.com'),
(6, 'Jane', 'Smith', 'janesmith', 'hashed_password_example', 'jane.smith@example.com'),
(7, 'Richard', 'Cubia', 'Treus', '$2y$10$tc/Xn5/Zr7RjOh82fxknI.cAj2J4qMlkcrWso9ZLoTvXv5szggQPC', 'troyarceus@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `sessionID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `loginTime` datetime NOT NULL DEFAULT current_timestamp(),
  `logoutTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`sessionID`, `userID`, `loginTime`, `logoutTime`) VALUES
(1, 7, '2024-12-12 00:20:18', '2024-12-12 04:05:02'),
(2, 7, '2024-12-12 00:58:32', '2024-12-12 04:05:02'),
(3, 7, '2024-12-12 01:10:33', '2024-12-12 04:05:02'),
(4, 7, '2024-12-12 02:59:57', '2024-12-12 04:05:02'),
(5, 7, '2024-12-12 03:00:12', '2024-12-12 04:05:02'),
(6, 7, '2024-12-12 03:00:41', '2024-12-12 04:05:02'),
(7, 7, '2024-12-12 03:02:32', '2024-12-12 04:05:02'),
(8, 7, '2024-12-12 04:06:24', '2024-12-12 04:07:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cartItemID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderItemID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stockID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`sessionID`),
  ADD KEY `userID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cartItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `orderItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `paymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stockID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `sessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`) ON DELETE CASCADE;

--
-- Constraints for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `user_sessions_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
