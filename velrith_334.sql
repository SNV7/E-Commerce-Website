-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2014 at 02:30 PM
-- Server version: 5.5.9-log
-- PHP Version: 5.4.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `velrith_334`
--

-- --------------------------------------------------------

--
-- Table structure for table `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
  `CategoryID` int(255) NOT NULL AUTO_INCREMENT,
  `CategoryName` text NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `Category`
--

INSERT INTO `Category` (`CategoryID`, `CategoryName`) VALUES
(1, 'Weapons'),
(2, 'Potions'),
(3, 'Maps'),
(4, 'Supplies'),
(5, 'Equipment');

-- --------------------------------------------------------

--
-- Table structure for table `Contact`
--

CREATE TABLE IF NOT EXISTS `Contact` (
  `contactID` int(255) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`contactID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `Contact`
--

INSERT INTO `Contact` (`contactID`, `name`, `email`, `message`) VALUES
(1, 'Darius', 'darius@darius.com', 'hello'),
(2, 'test', 'blah@gmail.com', 'hello world'),
(3, 'mike', 'bob ', 'helloooo'),
(4, 'adf', 'asdf', 'sadfasdf'),
(5, 'john', 'doe', 'sfsadf asf asdf'),
(6, 'adfadsf', 'zzzz', 'aaaaa'),
(7, 'veri', 'dat', 'hudi yghih d7hi hudg'),
(8, 'mike', 'mike@gmail.com', 'Great website!'),
(9, 'baskdjdf', 'asdfa@gmail.com', 'asfasdf'),
(10, 'matt', 'delly@yahoo.com', 'nkdgj suhug us hfg'),
(11, '', '', ''),
(12, '', '', ''),
(13, '', '', ''),
(14, 'jshfsq', 'uibiu', 'buibviub yhfbius fiuhiusf'),
(15, '', '', ''),
(16, '', '', ''),
(17, 'jshfsq', 'delly@yahoo.com', ''),
(18, 'Timmy T', 'asdfdf@gmail.com', 'This is a test message'),
(19, 'adf', 'adsf', 'afdadsf'),
(20, 'adfa', 'sdfa', 'adf'),
(21, 'dsfadsf', 'aaa', 'adsaffdas'),
(22, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `Inventory`
--

CREATE TABLE IF NOT EXISTS `Inventory` (
  `ProductID` int(255) NOT NULL AUTO_INCREMENT,
  `ProductName` text NOT NULL,
  `Description` text NOT NULL,
  `Picture` text NOT NULL,
  `Qty` int(255) NOT NULL,
  `Price` decimal(65,0) NOT NULL,
  `Category` text NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `Inventory`
--

INSERT INTO `Inventory` (`ProductID`, `ProductName`, `Description`, `Picture`, `Qty`, `Price`, `Category`) VALUES
(1, 'Samurai Sword', 'The best Samurai Sword you can buy', 'samuraiSword.jpg', 3, '20', 'Weapons'),
(2, 'Ninja Stars', 'A pack of 12 Ninja Stars', 'ninjaStars.png', 249, '36', 'Weapons'),
(3, 'Arctic Map', 'Map of the Arctic region. Includes locations of key towns and ports in the Arctic. Also shows routes between key locations and areas to avoid. A must own map for anyone who will be setting out on an expedition to the Arctic. ', 'arctic.jpg', 88, '2', 'Maps'),
(4, 'Basic Healing Potion', 'Use the Basic Healing Potion to give yourself a boost in you''re health and to repair any injuries you may have sustained. The Basic Healing Potion will heal up to half of your health.', 'basicHealingPotion.png', 35, '7', 'Potions'),
(5, 'Light Sabre ', 'Authentic Jedi Order Light Sabre with a 1.5 meter fixed-length plasma stream. Capable of cutting through 4 feet of re-enforced steel. Weighs only 1kg, and atom powered, with a 2000 year battery life.  ', 'lightSabre.jpg', 5, '90', 'Weapons'),
(13, 'Food Pack 7-days', 'Get all your nutrition with this 7-day food pack. Includes breakfast, lunch and dinner. Great for short trips and adventures.', 'foodPack7.jpg', 100, '5', 'Supplies'),
(14, 'Food Pack 30-day', 'Get all your nutrition with this 7-day food pack. Includes breakfast, lunch and dinner. Great for short trips and adventures.', 'foodPack30.jpg', 100, '11', 'Supplies'),
(15, 'Flint', 'Make fires with flint', 'flint.jpg', 40, '4', 'Equipment'),
(16, 'Oxygen Tank', 'Great for high altitudes. This oxygen tank can be carried on your bank and provides oxygen for up to 7 days', 'oxygen.jpg', 10, '25', 'Equipment'),
(17, 'Tent', 'You''ll need a tent if you plan on traveling in the wilderness.', 'tent.jpg', 40, '15', 'Equipment'),
(18, 'Jet Pack', 'Use a jet pack to move around faster or climb up mountains/buildings quicker.', 'jetpack.png', 30, '45', 'Equipment'),
(19, 'Map of Middle Earth', 'A detailed Map of Middle Earth. Highlights areas to avoid and safe areas to travel through.', 'middleEarth.jpeg', 100, '3', 'Maps'),
(20, 'Spear', 'A great weapon for combat with orcs and goblins.', 'spear.png', 12, '20', 'Weapons'),
(21, 'Invisible Cape', 'Hide from your enemies using this invisible cape. Simple blend in with your surroundings by covering yourself with this cape.', 'cape.png', 10, '75', 'Equipment'),
(22, 'Shield', 'Protect yourself from attacks with this shield.', 'shield.jpg', 100, '50', 'Weapons');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE IF NOT EXISTS `Orders` (
  `OrderID` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `ProductID` int(255) NOT NULL,
  `UserID` int(255) NOT NULL,
  `Quantity` int(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Date` text NOT NULL,
  PRIMARY KEY (`OrderID`,`ProductID`),
  KEY `ProductID` (`ProductID`),
  KEY `UserID` (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `ShoppingCart`
--

CREATE TABLE IF NOT EXISTS `ShoppingCart` (
  `cartID` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(255) NOT NULL,
  `pid` int(255) NOT NULL,
  `Qty` int(255) NOT NULL,
  PRIMARY KEY (`cartID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(30) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `FirstName` varchar(20) DEFAULT NULL,
  `LastName` varchar(20) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Phone` varchar(12) DEFAULT NULL,
  `ByteCoins` int(11) NOT NULL DEFAULT '300',
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Email`, `Password`, `FirstName`, `LastName`, `Address`, `Phone`, `ByteCoins`, `Admin`) VALUES
(1, 'email1@email.com', 'c904059757fa1cf87857166ac50e9059', 'Email', '2', '1 Email Addresss, Internet World', '123 345 6722', 500, 0),
(2, 'email2@other.co', 'b1d43cc90586e0ab3ebc25f227eb98bc', 'second', 'email', '2 email street, Internet', '1234567890', 10, 0),
(3, 'admin@admin.ca', '21232f297a57a5a743894a0e4a801fc3', 'ad', 'min', NULL, NULL, 1000, 1),
(4, 'a@b', '4a8a08f09d37b73795649038408b5f33', 'abc', 'def', '2 Hot Street', '', 37, 0),
(7, 'ya@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'ato', 'tola', '', '2269872507', 300, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Inventory` (`ProductID`),
  ADD CONSTRAINT `Orders_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
