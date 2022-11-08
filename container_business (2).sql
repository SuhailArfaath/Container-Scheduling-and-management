-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 26, 2022 at 02:27 AM
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
-- Database: `container_business`
--

-- --------------------------------------------------------

--
-- Table structure for table `backorder`
--

CREATE TABLE `backorder` (
  `orderId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `exporterCompanyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `containers`
--

CREATE TABLE `containers` (
  `containerId` int(11) NOT NULL,
  `iso6346Code` varchar(10) NOT NULL,
  `ownerComapnyId` int(11) NOT NULL,
  `containerAvailabilityStatus` varchar(45) DEFAULT NULL,
  `sourceHarborId` int(11) DEFAULT NULL,
  `destinationHarborId` int(11) DEFAULT NULL,
  `shippingOrderId` int(11) NOT NULL,
  `truckOrderId` int(11) NOT NULL,
  `loadingOrderId` int(11) NOT NULL,
  `photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driverId` int(11) NOT NULL,
  `driverName` varchar(255) DEFAULT NULL,
  `driverPhone` int(11) DEFAULT NULL,
  `pickupDriver` varchar(100) NOT NULL,
  `deliveryDriver` varchar(100) NOT NULL,
  `returnDriver` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exportercompany`
--

CREATE TABLE `exportercompany` (
  `exporterCompanyId` int(11) NOT NULL,
  `exporterCompanyName` varchar(45) DEFAULT NULL,
  `exporterCompanyPhone` int(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contactPerson` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state/province` varchar(255) NOT NULL,
  `zipCode` int(10) NOT NULL,
  `country` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exporterorder`
--

CREATE TABLE `exporterorder` (
  `orderId` int(11) NOT NULL,
  `manufacturerId` int(11) NOT NULL,
  `exporterCompanyId` int(11) NOT NULL,
  `harborId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `orderDateTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Exporter orders from manufacturer';

-- --------------------------------------------------------

--
-- Table structure for table `freighforwardingcompany`
--

CREATE TABLE `freighforwardingcompany` (
  `companyId` int(11) NOT NULL,
  `companyName` varchar(100) DEFAULT NULL,
  `companyPhone` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contactPerson` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state/province` varchar(100) NOT NULL,
  `zipCode` int(10) NOT NULL,
  `country` varchar(100) NOT NULL,
  `shipId` int(11) DEFAULT NULL,
  `exporterCompanyId` int(11) DEFAULT NULL,
  `harborId` int(11) DEFAULT NULL,
  `truckId` int(11) NOT NULL,
  `dutyFee` double NOT NULL,
  `insuranceFee` double NOT NULL,
  `miscTaxes` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `harbors`
--

CREATE TABLE `harbors` (
  `harborId` int(11) NOT NULL,
  `harborName` varchar(255) DEFAULT NULL,
  `phone` int(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state/province` varchar(255) NOT NULL,
  `zipCode` int(11) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `harborstock`
--

CREATE TABLE `harborstock` (
  `harborStockId` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `productId` int(11) DEFAULT NULL,
  `harborId` int(11) NOT NULL,
  `companyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `importercompany`
--

CREATE TABLE `importercompany` (
  `importerId` int(11) NOT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `companyPhone` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contactPerson` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state/province` varchar(100) NOT NULL,
  `zipCode` int(10) NOT NULL,
  `country` varchar(100) NOT NULL,
  `OrderDate` date DEFAULT NULL,
  `importerOrderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `importerorders`
--

CREATE TABLE `importerorders` (
  `importerOrderId` int(11) NOT NULL,
  `exporterId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `productQuantity` int(11) DEFAULT NULL,
  `warehouseId` int(11) NOT NULL,
  `harborId` int(11) NOT NULL,
  `orderTime` datetime DEFAULT NULL,
  `systemAccept` varchar(45) DEFAULT NULL,
  `OrderShipped` varchar(45) DEFAULT NULL,
  `OrderCompleted` varchar(45) DEFAULT NULL,
  `totalPrice` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `loadingorders`
--

CREATE TABLE `loadingorders` (
  `loadingOrderId` int(11) NOT NULL,
  `containerId` int(11) DEFAULT NULL,
  `importerOrderId` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL,
  `sourceHarborId` int(11) DEFAULT NULL,
  `packId` int(11) DEFAULT NULL,
  `grossWeight` int(11) DEFAULT NULL,
  `grossCubicFeet` int(11) NOT NULL,
  `loadDateTime` datetime DEFAULT NULL,
  `loadingStatus` varchar(255) DEFAULT NULL,
  `photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `manufacturerId` int(11) NOT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contactPerson` varchar(255) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state/province` varchar(100) NOT NULL,
  `zipCode` int(10) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `exporterId` int(11) DEFAULT NULL,
  `productId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orderstatus`
--

CREATE TABLE `orderstatus` (
  `orderStatusId` int(11) NOT NULL,
  `statusName` varchar(45) DEFAULT NULL,
  `truckOrderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `productpriceexporter`
--

CREATE TABLE `productpriceexporter` (
  `productId` int(11) NOT NULL,
  `exporterCompanyId` int(11) NOT NULL,
  `productPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Price list of exporter products';

-- --------------------------------------------------------

--
-- Table structure for table `productpricemanufacturer`
--

CREATE TABLE `productpricemanufacturer` (
  `productId` int(11) NOT NULL,
  `manufacturerId` int(11) NOT NULL,
  `productPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Price list of manufacturer products';

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `productName` varchar(45) DEFAULT NULL,
  `productBrand` varchar(45) DEFAULT NULL,
  `productType` varchar(45) DEFAULT NULL,
  `productBarCode` varchar(100) NOT NULL,
  `productWeight` varchar(45) DEFAULT NULL,
  `productLength` int(11) NOT NULL,
  `productWidth` int(11) NOT NULL,
  `productHeight` int(11) NOT NULL,
  `image` int(11) NOT NULL,
  `shortDescription` varchar(255) NOT NULL,
  `longDescription` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productName`, `productBrand`, `productType`, `productBarCode`, `productWeight`, `productLength`, `productWidth`, `productHeight`, `image`, `shortDescription`, `longDescription`) VALUES
(12345, 'IPhonee13', 'Apple', 'Pro', '', '2', 0, 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `productsincontainer`
--

CREATE TABLE `productsincontainer` (
  `packId` int(11) NOT NULL,
  `productId` int(11) DEFAULT NULL,
  `quantity` int(10) DEFAULT NULL,
  `loadingOrderId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `seashippingorders`
--

CREATE TABLE `seashippingorders` (
  `shippingOrderId` int(11) NOT NULL,
  `containerId` int(11) DEFAULT NULL,
  `sourceHarborId` int(11) DEFAULT NULL,
  `destinationHarborId` int(11) DEFAULT NULL,
  `shipId` int(11) DEFAULT NULL,
  `onShipDate` datetime NOT NULL,
  `departureDate` datetime DEFAULT NULL,
  `arrivalDate` date DEFAULT NULL,
  `shippingStatus` varchar(45) DEFAULT NULL,
  `truckPickup` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shippingcompanies`
--

CREATE TABLE `shippingcompanies` (
  `companyId` int(11) NOT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `companyPhone` varchar(45) DEFAULT NULL,
  `shipId` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contactPerson` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state/province` varchar(100) NOT NULL,
  `zipCode` int(10) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ships`
--

CREATE TABLE `ships` (
  `shipId` int(11) NOT NULL,
  `shipName` varchar(45) DEFAULT NULL,
  `companyId` int(11) DEFAULT NULL,
  `shipTimeId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `shiptime`
--

CREATE TABLE `shiptime` (
  `shipTimeId` int(11) NOT NULL,
  `arrivalDate` date DEFAULT NULL,
  `shipId` int(11) DEFAULT NULL,
  `sourceHarborId` int(11) DEFAULT NULL,
  `destinationHarborId` int(11) DEFAULT NULL,
  `shippingOrderId` int(11) NOT NULL,
  `departureDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `statusId` int(11) NOT NULL,
  `statusName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `truckcompany`
--

CREATE TABLE `truckcompany` (
  `truckCompanyId` int(11) NOT NULL,
  `truckCompanyName` varchar(255) DEFAULT NULL,
  `truckCompanyPhone` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contactPerson` varchar(100) NOT NULL,
  `truckCompanyAddress` varchar(255) DEFAULT NULL,
  `truckCompanyCountry` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `truckorder`
--

CREATE TABLE `truckorder` (
  `truckOrderId` int(11) NOT NULL,
  `containerId` int(11) DEFAULT NULL,
  `statusId` int(11) DEFAULT NULL,
  `destinationHarborId` int(11) DEFAULT NULL,
  `departureDate` datetime DEFAULT NULL,
  `truckId` int(11) DEFAULT NULL,
  `pickupDriverId` int(11) DEFAULT NULL,
  `arrivalDate` datetime DEFAULT NULL,
  `destinationWarehouseId` int(11) DEFAULT NULL,
  `unloadDate` datetime DEFAULT NULL,
  `deliveryDriverId` int(11) NOT NULL,
  `returnDriverId` int(11) DEFAULT NULL,
  `returnedProducts` varchar(255) NOT NULL,
  `returnGrossweight` int(11) DEFAULT NULL,
  `truckacceptionStatus` varchar(45) DEFAULT NULL,
  `warehouseAcceptionStatus` varchar(45) DEFAULT NULL,
  `notes` varchar(245) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `truckId` int(11) NOT NULL,
  `truckLicensePlate` varchar(20) DEFAULT NULL,
  `truckCompanyId` int(11) DEFAULT NULL,
  `harborId` int(11) DEFAULT NULL,
  `mileage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `userrank`
--

CREATE TABLE `userrank` (
  `userRankId` int(11) NOT NULL,
  `userRankTitle` varchar(255) DEFAULT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `privilegeLevel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `userName` varchar(100) DEFAULT NULL,
  `userRankId` int(11) DEFAULT NULL,
  `userPw` varchar(45) DEFAULT NULL,
  `companyId` int(11) DEFAULT NULL,
  `importerId` int(11) NOT NULL,
  `harborId` int(11) NOT NULL,
  `userPhoneNo` int(20) DEFAULT NULL,
  `userStatus` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `warehouseId` int(11) NOT NULL,
  `warehouseName` varchar(255) DEFAULT NULL,
  `warehousePhone` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contactPerson` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state/province` varchar(100) NOT NULL,
  `zipCode` int(10) NOT NULL,
  `country` varchar(100) NOT NULL,
  `openHours` varchar(100) NOT NULL,
  `importCompanyId` int(11) DEFAULT NULL,
  `orderId` int(11) NOT NULL,
  `harborId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backorder`
--
ALTER TABLE `backorder`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `productId` (`productId`),
  ADD KEY `exporterCompanyId` (`exporterCompanyId`);

--
-- Indexes for table `containers`
--
ALTER TABLE `containers`
  ADD PRIMARY KEY (`containerId`),
  ADD KEY `sourceHarborId` (`sourceHarborId`),
  ADD KEY `destinationHarborId` (`destinationHarborId`),
  ADD KEY `loadingOrderId` (`loadingOrderId`),
  ADD KEY `truckOrderId` (`truckOrderId`),
  ADD KEY `shippingOrderId` (`shippingOrderId`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driverId`);

--
-- Indexes for table `exportercompany`
--
ALTER TABLE `exportercompany`
  ADD PRIMARY KEY (`exporterCompanyId`);

--
-- Indexes for table `exporterorder`
--
ALTER TABLE `exporterorder`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `harborId` (`harborId`),
  ADD KEY `exporterorder_ibfk_1` (`manufacturerId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `freighforwardingcompany`
--
ALTER TABLE `freighforwardingcompany`
  ADD PRIMARY KEY (`companyId`),
  ADD KEY `shipId` (`shipId`),
  ADD KEY `exporterCompanyId` (`exporterCompanyId`),
  ADD KEY `harborId` (`harborId`),
  ADD KEY `truckId` (`truckId`);

--
-- Indexes for table `harbors`
--
ALTER TABLE `harbors`
  ADD PRIMARY KEY (`harborId`);

--
-- Indexes for table `harborstock`
--
ALTER TABLE `harborstock`
  ADD PRIMARY KEY (`harborStockId`),
  ADD KEY `harborId` (`harborId`),
  ADD KEY `productId` (`productId`),
  ADD KEY `companyId` (`companyId`);

--
-- Indexes for table `importercompany`
--
ALTER TABLE `importercompany`
  ADD PRIMARY KEY (`importerId`),
  ADD KEY `importerOrderId` (`importerOrderId`);

--
-- Indexes for table `importerorders`
--
ALTER TABLE `importerorders`
  ADD PRIMARY KEY (`importerOrderId`),
  ADD KEY `exporterId` (`exporterId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `warehouseId` (`warehouseId`),
  ADD KEY `harborId` (`harborId`);

--
-- Indexes for table `loadingorders`
--
ALTER TABLE `loadingorders`
  ADD PRIMARY KEY (`loadingOrderId`),
  ADD KEY `containerId` (`containerId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `sourceHarborId` (`sourceHarborId`),
  ADD KEY `packId` (`packId`),
  ADD KEY `importerOrderId` (`importerOrderId`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`manufacturerId`),
  ADD KEY `exporterId` (`exporterId`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD PRIMARY KEY (`orderStatusId`),
  ADD KEY `truckOrderId` (`truckOrderId`);

--
-- Indexes for table `productpriceexporter`
--
ALTER TABLE `productpriceexporter`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `exporterCompanyId` (`exporterCompanyId`);

--
-- Indexes for table `productpricemanufacturer`
--
ALTER TABLE `productpricemanufacturer`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `manufacturerId` (`manufacturerId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `productsincontainer`
--
ALTER TABLE `productsincontainer`
  ADD PRIMARY KEY (`packId`),
  ADD KEY `productId` (`productId`),
  ADD KEY `loadingOrderId` (`loadingOrderId`);

--
-- Indexes for table `seashippingorders`
--
ALTER TABLE `seashippingorders`
  ADD PRIMARY KEY (`shippingOrderId`),
  ADD KEY `containerId` (`containerId`),
  ADD KEY `destinationHarborId` (`destinationHarborId`),
  ADD KEY `sourceHarborId` (`sourceHarborId`),
  ADD KEY `shipId` (`shipId`);

--
-- Indexes for table `shippingcompanies`
--
ALTER TABLE `shippingcompanies`
  ADD PRIMARY KEY (`companyId`),
  ADD KEY `shipId` (`shipId`);

--
-- Indexes for table `ships`
--
ALTER TABLE `ships`
  ADD PRIMARY KEY (`shipId`),
  ADD KEY `shipTimeId` (`shipTimeId`),
  ADD KEY `companyId` (`companyId`);

--
-- Indexes for table `shiptime`
--
ALTER TABLE `shiptime`
  ADD PRIMARY KEY (`shipTimeId`),
  ADD KEY `destinationHarborId` (`destinationHarborId`),
  ADD KEY `sourceHarborId` (`sourceHarborId`),
  ADD KEY `shipId` (`shipId`),
  ADD KEY `shippingOrderId` (`shippingOrderId`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`statusId`);

--
-- Indexes for table `truckcompany`
--
ALTER TABLE `truckcompany`
  ADD PRIMARY KEY (`truckCompanyId`);

--
-- Indexes for table `truckorder`
--
ALTER TABLE `truckorder`
  ADD PRIMARY KEY (`truckOrderId`),
  ADD KEY `containerId` (`containerId`),
  ADD KEY `deliveryDriverId` (`deliveryDriverId`),
  ADD KEY `returnDriverId` (`returnDriverId`),
  ADD KEY `pickupDriverId` (`pickupDriverId`),
  ADD KEY `destinationHarborId` (`destinationHarborId`),
  ADD KEY `statusId` (`statusId`),
  ADD KEY `truckId` (`truckId`),
  ADD KEY `destinationWarehouseId` (`destinationWarehouseId`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`truckId`),
  ADD KEY `harborId` (`harborId`),
  ADD KEY `truckCompanyId` (`truckCompanyId`);

--
-- Indexes for table `userrank`
--
ALTER TABLE `userrank`
  ADD PRIMARY KEY (`userRankId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD KEY `importerId` (`importerId`),
  ADD KEY `userRankId` (`userRankId`),
  ADD KEY `companyId` (`companyId`),
  ADD KEY `harborId` (`harborId`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`warehouseId`),
  ADD KEY `importCompanyId` (`importCompanyId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `harborId` (`harborId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `backorder`
--
ALTER TABLE `backorder`
  ADD CONSTRAINT `backorder_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `importerorders` (`importerOrderId`),
  ADD CONSTRAINT `backorder_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`),
  ADD CONSTRAINT `backorder_ibfk_3` FOREIGN KEY (`exporterCompanyId`) REFERENCES `exportercompany` (`exporterCompanyId`);

--
-- Constraints for table `containers`
--
ALTER TABLE `containers`
  ADD CONSTRAINT `containers_ibfk_1` FOREIGN KEY (`sourceHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `containers_ibfk_2` FOREIGN KEY (`destinationHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `containers_ibfk_3` FOREIGN KEY (`loadingOrderId`) REFERENCES `loadingorders` (`loadingOrderId`),
  ADD CONSTRAINT `containers_ibfk_4` FOREIGN KEY (`truckOrderId`) REFERENCES `truckorder` (`truckOrderId`),
  ADD CONSTRAINT `containers_ibfk_5` FOREIGN KEY (`shippingOrderId`) REFERENCES `seashippingorders` (`shippingOrderId`);

--
-- Constraints for table `exporterorder`
--
ALTER TABLE `exporterorder`
  ADD CONSTRAINT `exporterorder_ibfk_1` FOREIGN KEY (`manufacturerId`) REFERENCES `manufacturer` (`manufacturerId`),
  ADD CONSTRAINT `exporterorder_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `importerorders` (`importerOrderId`),
  ADD CONSTRAINT `exporterorder_ibfk_3` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `freighforwardingcompany`
--
ALTER TABLE `freighforwardingcompany`
  ADD CONSTRAINT `freighforwardingcompany_ibfk_1` FOREIGN KEY (`shipId`) REFERENCES `ships` (`shipId`),
  ADD CONSTRAINT `freighforwardingcompany_ibfk_2` FOREIGN KEY (`exporterCompanyId`) REFERENCES `exportercompany` (`exporterCompanyId`),
  ADD CONSTRAINT `freighforwardingcompany_ibfk_3` FOREIGN KEY (`harborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `freighforwardingcompany_ibfk_4` FOREIGN KEY (`truckId`) REFERENCES `trucks` (`truckId`);

--
-- Constraints for table `harborstock`
--
ALTER TABLE `harborstock`
  ADD CONSTRAINT `harborstock_ibfk_1` FOREIGN KEY (`harborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `harborstock_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`),
  ADD CONSTRAINT `harborstock_ibfk_3` FOREIGN KEY (`companyId`) REFERENCES `exportercompany` (`exporterCompanyId`);

--
-- Constraints for table `importercompany`
--
ALTER TABLE `importercompany`
  ADD CONSTRAINT `importercompany_ibfk_1` FOREIGN KEY (`importerOrderId`) REFERENCES `importerorders` (`importerOrderId`);

--
-- Constraints for table `importerorders`
--
ALTER TABLE `importerorders`
  ADD CONSTRAINT `importerorders_ibfk_1` FOREIGN KEY (`exporterId`) REFERENCES `exportercompany` (`exporterCompanyId`),
  ADD CONSTRAINT `importerorders_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `importerorders_ibfk_3` FOREIGN KEY (`warehouseId`) REFERENCES `warehouse` (`warehouseId`),
  ADD CONSTRAINT `importerorders_ibfk_4` FOREIGN KEY (`harborId`) REFERENCES `harbors` (`harborId`);

--
-- Constraints for table `loadingorders`
--
ALTER TABLE `loadingorders`
  ADD CONSTRAINT `loadingorders_ibfk_1` FOREIGN KEY (`containerId`) REFERENCES `containers` (`ContainerId`),
  ADD CONSTRAINT `loadingorders_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `importerorders` (`importerOrderId`),
  ADD CONSTRAINT `loadingorders_ibfk_3` FOREIGN KEY (`sourceHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `loadingorders_ibfk_4` FOREIGN KEY (`packId`) REFERENCES `productsincontainer` (`packId`),
  ADD CONSTRAINT `loadingorders_ibfk_5` FOREIGN KEY (`importerOrderId`) REFERENCES `importerorders` (`importerOrderId`);

--
-- Constraints for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD CONSTRAINT `manufacturer_ibfk_1` FOREIGN KEY (`exporterId`) REFERENCES `exportercompany` (`exporterCompanyId`),
  ADD CONSTRAINT `manufacturer_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `orderstatus`
--
ALTER TABLE `orderstatus`
  ADD CONSTRAINT `orderstatus_ibfk_1` FOREIGN KEY (`truckOrderId`) REFERENCES `truckorder` (`truckOrderId`);

--
-- Constraints for table `productpriceexporter`
--
ALTER TABLE `productpriceexporter`
  ADD CONSTRAINT `productpriceexporter_ibfk_1` FOREIGN KEY (`exporterCompanyId`) REFERENCES `exportercompany` (`exporterCompanyId`),
  ADD CONSTRAINT `productpriceexporter_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `productpricemanufacturer`
--
ALTER TABLE `productpricemanufacturer`
  ADD CONSTRAINT `productpricemanufacturer_ibfk_1` FOREIGN KEY (`manufacturerId`) REFERENCES `manufacturer` (`manufacturerId`),
  ADD CONSTRAINT `productpricemanufacturer_ibfk_2` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`);

--
-- Constraints for table `productsincontainer`
--
ALTER TABLE `productsincontainer`
  ADD CONSTRAINT `productsincontainer_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`),
  ADD CONSTRAINT `productsincontainer_ibfk_2` FOREIGN KEY (`loadingOrderId`) REFERENCES `loadingorders` (`loadingOrderId`);

--
-- Constraints for table `seashippingorders`
--
ALTER TABLE `seashippingorders`
  ADD CONSTRAINT `seashippingorders_ibfk_1` FOREIGN KEY (`containerId`) REFERENCES `containers` (`ContainerId`),
  ADD CONSTRAINT `seashippingorders_ibfk_2` FOREIGN KEY (`destinationHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `seashippingorders_ibfk_3` FOREIGN KEY (`sourceHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `seashippingorders_ibfk_4` FOREIGN KEY (`shipId`) REFERENCES `ships` (`shipId`);

--
-- Constraints for table `shippingcompanies`
--
ALTER TABLE `shippingcompanies`
  ADD CONSTRAINT `shippingcompanies_ibfk_1` FOREIGN KEY (`shipId`) REFERENCES `ships` (`shipId`);

--
-- Constraints for table `ships`
--
ALTER TABLE `ships`
  ADD CONSTRAINT `ships_ibfk_1` FOREIGN KEY (`shipTimeId`) REFERENCES `shiptime` (`shipTimeId`),
  ADD CONSTRAINT `ships_ibfk_2` FOREIGN KEY (`companyId`) REFERENCES `shippingcompanies` (`companyId`);

--
-- Constraints for table `shiptime`
--
ALTER TABLE `shiptime`
  ADD CONSTRAINT `shiptime_ibfk_1` FOREIGN KEY (`destinationHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `shiptime_ibfk_2` FOREIGN KEY (`sourceHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `shiptime_ibfk_3` FOREIGN KEY (`shipId`) REFERENCES `ships` (`shipId`),
  ADD CONSTRAINT `shiptime_ibfk_4` FOREIGN KEY (`shippingOrderId`) REFERENCES `seashippingorders` (`shippingOrderId`);

--
-- Constraints for table `truckorder`
--
ALTER TABLE `truckorder`
  ADD CONSTRAINT `truckorder_ibfk_1` FOREIGN KEY (`containerId`) REFERENCES `containers` (`ContainerId`),
  ADD CONSTRAINT `truckorder_ibfk_2` FOREIGN KEY (`deliveryDriverId`) REFERENCES `driver` (`driverId`),
  ADD CONSTRAINT `truckorder_ibfk_3` FOREIGN KEY (`returnDriverId`) REFERENCES `driver` (`driverId`),
  ADD CONSTRAINT `truckorder_ibfk_4` FOREIGN KEY (`pickupDriverId`) REFERENCES `driver` (`driverId`),
  ADD CONSTRAINT `truckorder_ibfk_5` FOREIGN KEY (`destinationHarborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `truckorder_ibfk_6` FOREIGN KEY (`statusId`) REFERENCES `status` (`statusId`),
  ADD CONSTRAINT `truckorder_ibfk_7` FOREIGN KEY (`truckId`) REFERENCES `trucks` (`truckId`),
  ADD CONSTRAINT `truckorder_ibfk_8` FOREIGN KEY (`destinationWarehouseId`) REFERENCES `warehouse` (`warehouseId`);

--
-- Constraints for table `trucks`
--
ALTER TABLE `trucks`
  ADD CONSTRAINT `trucks_ibfk_1` FOREIGN KEY (`harborId`) REFERENCES `harbors` (`harborId`),
  ADD CONSTRAINT `trucks_ibfk_2` FOREIGN KEY (`truckCompanyId`) REFERENCES `truckcompany` (`truckCompanyId`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`importerId`) REFERENCES `importercompany` (`importerId`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`userRankId`) REFERENCES `userrank` (`userRankId`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`companyId`) REFERENCES `exportercompany` (`exporterCompanyId`),
  ADD CONSTRAINT `users_ibfk_4` FOREIGN KEY (`companyId`) REFERENCES `shippingcompanies` (`companyId`),
  ADD CONSTRAINT `users_ibfk_5` FOREIGN KEY (`companyId`) REFERENCES `truckcompany` (`truckCompanyId`),
  ADD CONSTRAINT `users_ibfk_6` FOREIGN KEY (`companyId`) REFERENCES `freighforwardingcompany` (`companyId`),
  ADD CONSTRAINT `users_ibfk_7` FOREIGN KEY (`harborId`) REFERENCES `harbors` (`harborId`);

--
-- Constraints for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD CONSTRAINT `warehouse_ibfk_1` FOREIGN KEY (`importCompanyId`) REFERENCES `importercompany` (`importerId`),
  ADD CONSTRAINT `warehouse_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `importerorders` (`importerOrderId`),
  ADD CONSTRAINT `warehouse_ibfk_3` FOREIGN KEY (`orderId`) REFERENCES `truckorder` (`truckOrderId`),
  ADD CONSTRAINT `warehouse_ibfk_4` FOREIGN KEY (`harborId`) REFERENCES `harbors` (`harborId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
