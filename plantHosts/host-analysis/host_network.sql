-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2013 at 02:43 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `AOE`
--

-- --------------------------------------------------------

--
-- Table structure for table `host_network`
--

DROP TABLE IF EXISTS `host_network_species`;
CREATE TABLE IF NOT EXISTS `host_network_species` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `h_species` varchar(40) NOT NULL DEFAULT 'sp.',
  `h_genus` varchar(40) DEFAULT NULL,
  `h_family` varchar(40) DEFAULT NULL,
  `i_species` varchar(40) DEFAULT NULL,
  `i_genus` varchar(40) DEFAULT NULL,
  `i_tribe` varchar(40) DEFAULT NULL,
  `i_family` varchar(40) DEFAULT NULL,
  `i_family_id` int(11) NOT NULL DEFAULT '0',
  `i_tribe_id` int(11) NOT NULL DEFAULT '0',
  `i_genus_id` int(11) NOT NULL DEFAULT '0',
  `i_species_id` int(11) NOT NULL DEFAULT '0',
  `h_family_id` int(11) NOT NULL DEFAULT '0',
  `h_genus_id` int(11) NOT NULL DEFAULT '0',
  `h_species_id` int(11) NOT NULL DEFAULT '0',
  `coll_total_i` int(11) NOT NULL DEFAULT '0',
  `coll_number_same_h` int(11) NOT NULL DEFAULT '0',
  `coll_percent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `h_n_specimens` int(11) NOT NULL DEFAULT '0',
  `i_j_h_col_event` int(11) NOT NULL DEFAULT '0',
  `i_j_same_col` int(11) NOT NULL DEFAULT '0',
  `h_voucher` int(11) DEFAULT '0',
  `rel_confidence` varchar(40) NOT NULL DEFAULT 'LOW',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------



  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=181 ;
