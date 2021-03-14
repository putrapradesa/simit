-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2021 at 05:58 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simit`
--

-- --------------------------------------------------------

--
-- Table structure for table `bagian`
--

CREATE TABLE `bagian` (
  `Id` int(10) NOT NULL,
  `NoBagian` varchar(100) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `PT` varchar(100) NOT NULL,
  `IdPT` int(10) NOT NULL,
  `Divisi` varchar(100) NOT NULL,
  `IdDivisi` int(10) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `Id` int(10) NOT NULL,
  `NoBarang` varchar(100) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Kategori` varchar(100) NOT NULL,
  `IdKategori` int(10) NOT NULL,
  `Uom` varchar(100) NOT NULL,
  `IdUom` int(10) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `Id` int(10) NOT NULL,
  `Barang` varchar(100) NOT NULL,
  `IdBarang` int(10) NOT NULL,
  `Qty` double NOT NULL,
  `IdSupplier` int(10) NOT NULL,
  `Supplier` varchar(100) NOT NULL,
  `Kategori` varchar(100) NOT NULL,
  `TglSJ` datetime NOT NULL,
  `IdDetailPermintaan` int(10) NOT NULL,
  `NoSj` varchar(100) NOT NULL,
  `TipeTransaksi` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_permintaan`
--

CREATE TABLE `detail_permintaan` (
  `Id` int(10) NOT NULL,
  `Barang` varchar(100) NOT NULL,
  `NoBarang` varchar(100) NOT NULL,
  `IdBarang` int(10) NOT NULL,
  `Kategori` varchar(100) NOT NULL,
  `IdKategori` int(10) NOT NULL,
  `Qty` double NOT NULL,
  `RemainingQty` double NOT NULL,
  `Uom` varchar(100) NOT NULL,
  `IdUom` int(10) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL,
  `IdPermintaan` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `Id` int(10) NOT NULL,
  `NoDivisi` varchar(100) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `PT` varchar(100) NOT NULL,
  `IdPT` int(10) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `Id` int(11) NOT NULL,
  `Barang` int(11) NOT NULL,
  `NoBarang` int(11) NOT NULL,
  `IdBarang` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `RemainingQty` int(11) NOT NULL,
  `PT` int(11) NOT NULL,
  `Divisi` int(11) NOT NULL,
  `Bagian` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedUtc` int(11) NOT NULL,
  `UpdatedBy` int(11) NOT NULL,
  `UpdatedUtc` int(11) NOT NULL,
  `IsDeleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `Id` int(10) NOT NULL,
  `NoKategori` varchar(100) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `permintaan`
--

CREATE TABLE `permintaan` (
  `Id` int(10) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Divisi` varchar(100) NOT NULL,
  `IdDivisi` int(11) NOT NULL,
  `IdBagian` int(11) NOT NULL,
  `Bagian` varchar(100) NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  `TglPermintaan` datetime NOT NULL,
  `PT` varchar(100) NOT NULL,
  `IdPT` int(11) NOT NULL,
  `Qty` double NOT NULL,
  `RemainingQty` double NOT NULL,
  `Status` varchar(50) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pt`
--

CREATE TABLE `pt` (
  `Id` int(11) NOT NULL,
  `NoPT` varchar(100) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Id` int(10) NOT NULL,
  `NoSupplier` varchar(100) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `Alamat` varchar(100) NOT NULL,
  `NoTelp` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE `uom` (
  `Id` int(10) NOT NULL,
  `Nama` varchar(100) NOT NULL,
  `CreatedBy` varchar(100) NOT NULL,
  `CreatedUtc` datetime NOT NULL,
  `UpdatedBy` varchar(100) NOT NULL,
  `UpdatedUtc` datetime NOT NULL,
  `IsDeleted` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bagian`
--
ALTER TABLE `bagian`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPT` (`IdPT`),
  ADD KEY `IdDivisi` (`IdDivisi`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdKategori` (`IdKategori`),
  ADD KEY `IdUom` (`IdUom`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdSupplier` (`IdSupplier`),
  ADD KEY `IdDetailPermintaan` (`IdDetailPermintaan`),
  ADD KEY `IdBarang` (`IdBarang`);

--
-- Indexes for table `detail_permintaan`
--
ALTER TABLE `detail_permintaan`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdBarang` (`IdBarang`),
  ADD KEY `IdKategori` (`IdKategori`),
  ADD KEY `IdUom` (`IdUom`),
  ADD KEY `IdPermintaan` (`IdPermintaan`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPT` (`IdPT`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD KEY `IdBarang` (`IdBarang`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPT` (`IdPT`),
  ADD KEY `IdDivisi` (`IdDivisi`),
  ADD KEY `IdBagian` (`IdBagian`);

--
-- Indexes for table `pt`
--
ALTER TABLE `pt`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `uom`
--
ALTER TABLE `uom`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bagian`
--
ALTER TABLE `bagian`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_permintaan`
--
ALTER TABLE `detail_permintaan`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permintaan`
--
ALTER TABLE `permintaan`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pt`
--
ALTER TABLE `pt`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uom`
--
ALTER TABLE `uom`
  MODIFY `Id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bagian`
--
ALTER TABLE `bagian`
  ADD CONSTRAINT `FK_Bagian_Divisi` FOREIGN KEY (`IdDivisi`) REFERENCES `divisi` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Bagian_PT` FOREIGN KEY (`IdPT`) REFERENCES `pt` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `FK_Barang_Kategori` FOREIGN KEY (`IdKategori`) REFERENCES `kategori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Barang_Uom` FOREIGN KEY (`IdUom`) REFERENCES `uom` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD CONSTRAINT `FK_BarangMasuk_Barang` FOREIGN KEY (`IdBarang`) REFERENCES `barang` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BarangMasuk_DaftarPermintaan` FOREIGN KEY (`IdDetailPermintaan`) REFERENCES `detail_permintaan` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BarangMasuk_Supplier` FOREIGN KEY (`IdSupplier`) REFERENCES `supplier` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_permintaan`
--
ALTER TABLE `detail_permintaan`
  ADD CONSTRAINT `FK_DetailPermintaan_Barang` FOREIGN KEY (`IdBarang`) REFERENCES `barang` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_DetailPermintaan_Kategori` FOREIGN KEY (`IdKategori`) REFERENCES `kategori` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_DetailPermintaan_Permintaan` FOREIGN KEY (`IdPermintaan`) REFERENCES `permintaan` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_DetailPermintaan_Uom` FOREIGN KEY (`IdUom`) REFERENCES `uom` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `divisi`
--
ALTER TABLE `divisi`
  ADD CONSTRAINT `FK_Divisi_PT` FOREIGN KEY (`IdPT`) REFERENCES `pt` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `FK_Inventories_Barang` FOREIGN KEY (`IdBarang`) REFERENCES `barang` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permintaan`
--
ALTER TABLE `permintaan`
  ADD CONSTRAINT `FK_Permintaan_Bagian` FOREIGN KEY (`IdBagian`) REFERENCES `bagian` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Permintaan_Divisi` FOREIGN KEY (`IdDivisi`) REFERENCES `divisi` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Permintaan_PT` FOREIGN KEY (`IdPT`) REFERENCES `pt` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
