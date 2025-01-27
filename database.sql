-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: fdb1034.atspace.me
-- Generation Time: Jan 22, 2025 at 02:19 PM
-- Server version: 8.0.32
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `4441160_base`
--

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int NOT NULL,
  `poll_id` int NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `feedback` text NOT NULL,
  `suggestions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feed`
--

INSERT INTO `feed` (`id`, `poll_id`, `name`, `email`, `feedback`, `suggestions`) VALUES
(26, 10, '', '', 'Product looks good but the market seems clouded ', 'Man I don\'t know but am not paying for this.. '),
(27, 10, '', '', 'pretty cool', 'add'),
(28, 10, '', '', 'pretty dope', 'add more features'),
(29, 10, 'anonymous', 'anonymous', 'Pretty Cool', 'add more features'),
(30, 10, 'anonymous', 'anonymous', 'good ', 'add more features'),
(31, 10, 'brian', 'Brian@gmail.com', 'lame', 'add more features'),
(32, 10, 'anonymous', 'anonymous', 'Pretty nice', 'Add more features '),
(33, 10, 'anonymous', 'anonymous', 'Hello', 'Hello'),
(34, 10, 'anonymous', 'anonymous', 'Hznzn', 'Gzhzjz'),
(35, 13, 'anonymous', 'anonymous', 'Your was terrible ', 'Pick more cool themes'),
(36, 10, 'anonymous', 'anonymous', 'Average ', 'Average '),
(37, 10, 'anonymous', 'anonymous', 'Standard ', 'Standard '),
(38, 10, 'anonymous', 'anonymous', 'Would say not that nice', ''),
(39, 10, 'anonymous', 'anonymous', 'Average ', ''),
(40, 10, 'Briana', 'briana@gmail.com', 'I think it\'s cool', 'Add more features '),
(41, 10, 'anonymous', 'anonymous', 'It think its not that useful ', ''),
(42, 10, 'anonymous', 'anonymous', 'yup its does ', 'pretty good'),
(43, 10, 'anonymous', 'anonymous', 'Pretty cool', 'Too cold');

-- --------------------------------------------------------

--
-- Table structure for table `poll`
--

CREATE TABLE `poll` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poll`
--

INSERT INTO `poll` (`id`, `user_id`, `question`) VALUES
(10, 1, 'What do you think of Feedyoo..is it a solving your feedback issues.. what more should be added to make it even cooler ... Just drop those feedbacks be cold .. ?'),
(13, 29, 'Hello everyone what do you think of my last video ?');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `message`, `profile_pic`) VALUES
(1, 'allex', 'demo1@gmail.com', '$2y$10$6QPwMVGbj.zEl3Rv6512x.fyH5Hec8YygEaskO3Ubg99ePFy5BI/C', '', 'img/default-profile-pic.png'),
(5, 'oya', 'demo2@gmail.com', '$2y$10$gSgUbp5k4LANWldlWTYEuu7bfKQ/w2eWBTWQ4NC99DEN/mWvDsJt2', 'Hello There what do you think of he product ', 'img/default-profile-pic.png'),
(7, 'allen', 'demo3@gmail.com', '', 'how you doing foxs', 'uploads/358531668_1769799676751638_7130700979272579659_n.jpg'),
(12, 'hello', 'demo4@gmail.com', '$2y$10$j7t0v7ZNi3ZG5.wRtpjLwuqOAkZlmrBq7RkyUgFJM70QFVNHIhya.', '', 'img/default-profile-pic.png'),
(14, 'andy', 'demo5@gmail.com', '$2y$10$4vBMbbOhdseAn9zeoVAO/ubsASkgEkHq46u877YPdWjeFzDsNHVzS', '', 'img/default-profile-pic.png'),
(15, 'allex', 'allex@gmail.com', '$2y$10$MGIEOCpvRIXGgrdBkrZGbuixjKCCdT6CcwczDb3ALXEGoiZQgy7au', '', 'img/default-profile-pic.png'),
(16, 'peter', 'demo9@gmail.com', '$2y$10$he0LsgJO7hU08pF/0HNzfe/d6A7zl9RasW3TmnFp9tF7daTJC5L7O', '', 'img/default-profile-pic.png'),
(17, 'olivia', 'olivia@gmail.com', '$2y$10$MHKKpJpxWKvdBdaNJ/PsKeQrIecn48TaZgFgP7.4ha7rZArYtwb6O', '', 'img/default-profile-pic.png'),
(18, 'ndepu', 'demo8@gmail.com', '$2y$10$kXLnEKIqKW2CKmBbxo3MeOlwam6qw9fMG3b6Gl8BbR4e3bFGE4rjW', '', 'img/default-profile-pic.png'),
(19, 'boi', 'boi@gmail.com', '$2y$10$vSR8T11MICx6aQ2IhxqMxuJF92LCus/vfufpH44EFZGN6iZa3EoIy', '', 'img/default-profile-pic.png'),
(20, 'hella', 'hella@gmail.com', '$2y$10$RanFy5bTY3l3HH.LCGvbmOaVzYYB1yyyOWQaoC/11.qxUJgzxUASy', '', 'img/default-profile-pic.png'),
(22, 'qwe', 'qwe@gmail.com', '$2y$10$ydpOSMyu4sxSHWYEYZOWJO7BsLQLxfRg.5ehjj8JL8AAR8iFzFAky', '', 'img/default-profile-pic.png'),
(23, 'vbn', 'vbn@gmi.mn', '$2y$10$VwVirfX.ApVaZfiI4NhRMunhwopCF3.duuiv/GDRCe56VZ1.pZPay', '', 'img/default-profile-pic.png'),
(24, 'hoyya', 'hoyya@gmail.com', '$2y$10$JlgwmUC8nflM0nn..FiOiu5FHxw1b/5E0zc96.PaprFLUWTF8wtYu', '', 'img/default-profile-pic.png'),
(25, 'boa', 'boa@boa.com', '$2y$10$y0mSC/HuYIRJGsBPc6TaWOBlkGU/OwXRmqzQwNIqA.aoCvp9.DXPG', '', 'img/default-profile-pic.png'),
(26, 'hellu', 'hellu@gmail.ai', '$2y$10$I0zLJaHGa/4oTaANGDV1NO5na3yjiCC.szHLpOWIFlWMrtCOKZAPW', '', 'img/default-profile-pic.png'),
(28, 'allen', 'demo6@gmail.com', '$2y$10$raRMdlKBmnQtULR9fdXfWOpXVosJmDKMNIYTh27tRcH3BwXWy.DRi', '', 'img/default-profile-pic.png'),
(29, 'Mc', 'demo7@gmail.com', '$2y$10$u2vbC8vC80CxK1mEdQ5EdOvBnYD3Df4HqI9taoxxPM.xx22o7v.72', '', 'img/default-profile-pic.png'),
(30, 'Nfejdekofhofjwdoe jirekdwjfreohogjkerwkrj rekwlrkfekjgoperrkfoek ojeopkfwkferjgiejfwk okfepjfgrihgoiejfklegjroi jeiokferfekfrjgiorjofeko jeoighirhgioejfoekforjgijriogjeo foefojeigjrigklej jkrjfkrejgkrhglrlrk feedyoo.xyz', 'vadimnea66+987f@list.ru', '$2y$10$7stGrKLWJG5kpKQy6ukMa.QS.uzbP78.Z6MF/VU5B2yJySpJihOVS', '', 'img/default-profile-pic.png'),
(31, 'blito', 'demo8@gmail.com', '$2y$10$jb5.HYWWWYCg7IRHk7GZ9e/96vZO0YoqRrn5gWFHZ8r3fPAf8dJvO', '', 'img/default-profile-pic.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_feed_poll` (`poll_id`);

--
-- Indexes for table `poll`
--
ALTER TABLE `poll`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_poll_user` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `poll`
--
ALTER TABLE `poll`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feed`
--
ALTER TABLE `feed`
  ADD CONSTRAINT `fk_feed_poll` FOREIGN KEY (`poll_id`) REFERENCES `poll` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `poll`
--
ALTER TABLE `poll`
  ADD CONSTRAINT `fk_poll_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
