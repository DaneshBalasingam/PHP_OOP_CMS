-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2015 at 09:03 AM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basic_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` smallint(3) NOT NULL,
  `cat_name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`) VALUES
(3, 'Bass Guitar'),
(2, 'Guitar'),
(4, 'violin');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `comment_id` int(5) NOT NULL,
  `page_id` int(5) NOT NULL,
  `created` datetime NOT NULL,
  `username` varchar(30) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `page_id`, `created`, `username`, `content`) VALUES
(7, 9, '2015-02-26 11:36:10', 'Bakunin', ' Vim ceteros accusata cu, est et elit nulla. Mei ceteros minimum ad, at quodsi quaerendum qui. Prompta senserit per no, facete noluisse vis cu. Mel quis constituto et, dicat errem volutpat at est, vim exerci consul prompta an. Omnium erroribus pro ad, cibo iriure sanctus in mei, ut fugit nostrum pri.\r\n\r\n           Cu possim alienum duo. Quo at erant repudiandae, euismod petentium vis et. Cum ei eirmod graecis scriptorem, ne insolens democritum est, eos lorem contentiones id. Mnesarchum elaboraret vim in. Nam modo cibo scripserit eu.'),
(10, 9, '2015-03-27 16:39:26', 'test', 'test comment by admin'),
(11, 3, '2015-03-27 16:41:32', 'test', 'testing another admin comment'),
(12, 8, '2015-08-10 09:31:12', 'NormalUser', 'Normal user leaves a comment');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(5) NOT NULL,
  `file_name` varchar(30) NOT NULL,
  `file_size` int(9) NOT NULL,
  `file_type` varchar(30) NOT NULL,
  `page_id` int(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `file_name`, `file_size`, `file_type`, `page_id`) VALUES
(1, 'newGuitar.png', 24505, 'image/png', 1),
(2, 'popularGuitar.png', 24781, 'image/png', 2),
(3, 'guitar1.jpg', 97380, 'image/jpeg', 3),
(4, 'gaucho.png', 51798, 'image/png', 4),
(5, 'aja.jpg', 8019, 'image/jpeg', 5),
(10, 'black_guitar.jpg', 5558, 'image/jpeg', 7),
(11, 'Classic_guitar.png', 830389, 'image/png', 8),
(12, 'bass_guitar.jpg', 69619, 'image/jpeg', 9),
(13, 'jazz_guitar.jpg', 57025, 'image/jpeg', 10),
(14, 'Violin.jpg', 113765, 'image/jpeg', 11),
(15, 'Lighthouse.jpg', 561276, 'image/jpeg', 12),
(16, 'AGT103A.jpg', 61584, 'image/jpeg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE IF NOT EXISTS `menu_item` (
  `menu_item_id` int(6) NOT NULL,
  `menu_name` varchar(30) NOT NULL,
  `menu_type` enum('top','left','','') NOT NULL,
  `page_address` varchar(100) NOT NULL,
  `position` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_item`
--

INSERT INTO `menu_item` (`menu_item_id`, `menu_name`, `menu_type`, `page_address`, `position`) VALUES
(14, 'Home', 'top', 'single_blog.php?id=1', 1),
(15, 'Blogs', 'top', 'blogs.php', 3),
(16, 'Products', 'top', 'products.php', 2),
(17, 'Home', 'left', 'single_blog.php?id=1', 1),
(18, 'Bass Guitar', 'left', 'product_cat.php?id=3', 3),
(19, 'Guitar', 'left', 'product_cat.php?id=2', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `page_id` int(5) NOT NULL,
  `page_name` varchar(30) NOT NULL,
  `page_desc` varchar(300) NOT NULL,
  `page_content` text NOT NULL,
  `page_type` varchar(20) NOT NULL,
  `home_page` varchar(10) NOT NULL,
  `cat_id` smallint(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`page_id`, `page_name`, `page_desc`, `page_content`, `page_type`, `home_page`, `cat_id`) VALUES
(1, 'Welcome', 'this is a test page', 'This is to be the home page', 'blog_page', 'true', 0),
(3, 'Libris aeterno quo', 'Lorem ipsum dolor sit amet, mei id albucius deleniti erroribus, cu vix tation ubique. Per adhuc persius ceteros in. Libris aeterno quo ad  ', '<p>Lorem ipsum dolor sit amet, mei id albucius deleniti erroribus, cu vix tation ubique. Per adhuc persius ceteros in. Libris aeterno quo ad, mei latine phaedrum dissentias te, id sed nonumy voluptatum. Eu aeque conclusionemque sit, qui an nullam fuisset. Impetus convenire vix ei, aeque tincidunt ne mea. Ei cum legimus mediocrem laboramus, altera theophrastus et mea, adhuc alterum duo cu.</p>\r\n<p>Vim ceteros accusata cu, est et elit nulla. Mei ceteros minimum ad, at quodsi quaerendum qui. Prompta senserit per no, facete noluisse vis cu. Mel quis constituto et, dicat errem volutpat at est, vim exerci consul prompta an. Omnium erroribus pro ad, cibo iriure sanctus in mei, ut fugit nostrum pri.</p>\r\n<p>Cu possim alienum duo. Quo at erant repudiandae, euismod petentium vis et. Cum ei eirmod graecis scriptorem, ne insolens democritum est, eos lorem contentiones id. Mnesarchum elaboraret vim in. Nam modo cibo scripserit eu.</p>\r\n', 'blog_page', 'false', 0),
(4, 'Steely Dan review', 'Review of gaucho album by Steely Dan according to writers opinion.', 'This is the best album ever written.  Vim ceteros accusata cu, est et elit nulla. Mei ceteros minimum ad, at quodsi quaerendum qui. Prompta senserit per no, facete noluisse vis cu. Mel quis constituto et, dicat errem volutpat at est, vim exerci consul prompta an. Omnium erroribus pro ad, cibo iriure sanctus in mei, ut fugit nostrum pri.\r\nCu possim alienum duo. Quo at erant repudiandae, euismod petentium vis et. Cum ei eirmod graecis scriptorem, ne insolens democritum est, eos lorem contentiones id. Mnesarchum elaboraret vim in. Nam modo cibo scripserit eu.\r\nSit id ferri illum accusata, pri justo officiis et, cu nonumes pericula sit. Ut per vide fabellas. Et eum vidisse ', 'blog_page', 'false', 0),
(5, 'Steely Dan Aja', 'Review of Aja album by Steely Dan. An absolute classic fusion of jazz and rock.', 'Lorem ipsum dolor sit amet, mei id albucius deleniti erroribus, cu vix tation ubique. Per adhuc persius ceteros in. Libris aeterno quo ad, mei latine phaedrum dissentias te, id sed nonumy voluptatum. Eu aeque conclusionemque sit, qui an nullam fuisset. Impetus convenire vix ei, aeque tincidunt ne mea. Ei cum legimus mediocrem laboramus, altera theophrastus et mea, adhuc alterum duo cu. Vim ceteros accusata cu, est et elit nulla. Mei ceteros minimum ad, at quodsi quaerendum qui. Prompta senserit per no, facete noluisse vis cu. Mel quis constituto et, dicat errem volutpat at est, vim exerci consul prompta an. Omnium erroribus pro ad, cibo iriure sanctus in mei, ut fugit nostrum pri.', 'blog_page', 'false', 0),
(7, 'Black guitar', 'A warlock shaped guitar', 'Lorem ipsum dolor sit amet, mei id albucius deleniti erroribus, cu vix tation ubique. Per adhuc persius ceteros in. Libris aeterno quo ad, mei latine phaedrum dissentias te, id sed nonumy voluptatum. Eu aeque conclusionemque sit, qui an nullam fuisset. Impetus convenire vix ei, aeque tincidunt ne mea. Ei cum legimus mediocrem laboramus, altera theophrastus et mea, adhuc alterum duo cu. Vim ceteros accusata cu, est et elit nulla. Mei ceteros minimum ad, at quodsi quaerendum qui. Prompta senserit per no, facete noluisse vis cu. Mel quis constituto et, dicat errem volutpat at est, vim exerci consul prompta an. Omnium erroribus pro ad, cibo iriure sanctus in mei, ut fugit nostrum pri.', 'product_page', 'false', 2),
(8, 'Bakunin Classic', 'Hand made classical guitar by Bakunin', 'Sit id ferri illum accusata, pri justo officiis et, cu nonumes pericula sit. Ut per vide fabellas. Et eum vidisse habemus, vix ea affert detracto. Dico regione feugait ex nam, ex mei iisque urbanitas. Id ius debitis senserit petentium, cibo instructior vix in. Usu hinc quodsi vocibus ne, reque praesent ut his. Nec id dolorum theophrastus concludaturque. Ut mutat tantas indoctum nec, error maiorum ut mei. Ut eros paulo salutandi sea, omittam posidonium sed ad. Per et habeo exerci fierent, mea at ornatus intellegam. Aliquando appellantur mel ei, eam ea nonumes honestatis.', 'product_page', 'false', 2),
(9, 'Malatesta Bass', 'Hand made bass guitar by Malatesta', 'Vim ceteros accusata cu, est et elit nulla. Mei ceteros minimum ad, at quodsi quaerendum qui. Prompta senserit per no, facete noluisse vis cu. Mel quis constituto et, dicat errem volutpat at est, vim exerci consul prompta an. Omnium erroribus pro ad, cibo iriure sanctus in mei, ut fugit nostrum pri.Cu possim alienum duo. Quo at erant repudiandae, euismod petentium vis et. Cum ei eirmod graecis scriptorem, ne insolens democritum est, eos lorem contentiones id. Mnesarchum elaboraret vim in. Nam modo cibo scripserit eu.', 'product_page', 'false', 3),
(10, 'jazz guitar', 'This is a jazz guitar', 'This is some text', 'product_page', 'false', 2),
(11, 'stravinsky', 'classic violin', 'very expensive', 'product_page', 'false', 4),
(12, 'Tiny Mce test', '<p>This is just some random text</p>', '<p>This is a test to check</p>\r\n<p>&nbsp;</p>\r\n<p>the&nbsp;<strong>functionality</strong> of tinymce</p>\r\n<p>&nbsp;</p>\r\n<p><em>Some Italic content</em></p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n<li>More test</li>\r\n<li>some more test</li>\r\n<li>blah</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>How do I add and image here???</p>', 'blog_page', 'false', 3),
(13, 'Page test', 'Testing if this still works', '<p>Testing if this still worksTesting if this still worksTesting if this still worksTesting if this still worksTesting if this still worksTesting if this still worksTesting if this still worksTesting if this still works</p>', 'blog_page', 'false', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(5) NOT NULL,
  `username` varchar(40) NOT NULL,
  `hashed_password` varchar(100) NOT NULL,
  `email` varchar(70) NOT NULL,
  `user_type` varchar(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `hashed_password`, `email`, `user_type`) VALUES
(1, 'test', '$2y$10$Nzg3YmEzZDQ2MGQ1ZTZkYeVBa4K9D3sZ5ZlRwW.DBf7bMGveSi5a2', 'hsjsj@gmail.com', 'admin'),
(22, 'test@yahoo.com', '$2y$10$NGFlYjI2NWZhNDA4MTQ0O.LVU9UARzW5QsteJmraX.c/SC6558KNa', 'test@yahoo.com', 'admin'),
(23, 'NormalUser', '$2y$10$MmU2YTg1Mzg4MWI4ZjQ5Me1tCSdWr9gD0n0wPJESGIkTxj4ZRoDSG', 'NormalUser@yahoo.com', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name_2` (`cat_name`),
  ADD KEY `cat_name` (`cat_name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD UNIQUE KEY `file_name` (`file_name`);

--
-- Indexes for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD PRIMARY KEY (`menu_item_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`),
  ADD KEY `page_name` (`page_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username_2` (`username`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` smallint(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `menu_item`
--
ALTER TABLE `menu_item`
  MODIFY `menu_item_id` int(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
