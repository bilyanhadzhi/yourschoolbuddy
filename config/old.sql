SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `yourschoolbuddy_old` DEFAULT CHARACTER SET utf8 COLLATE utf8_swedish_ci;
USE `yourschoolbuddy_old`;

DROP TABLE IF EXISTS `exams`;
CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `grade` enum('A','B','C','D','E','F') COLLATE utf8_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

TRUNCATE TABLE `exams`;
INSERT INTO `exams` (`id`, `subject_id`, `student_id`, `type_id`, `date`, `grade`) VALUES
(1, 12, 1, 2, '2017-06-29', '');

DROP TABLE IF EXISTS `exam_types`;
CREATE TABLE `exam_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

TRUNCATE TABLE `exam_types`;
INSERT INTO `exam_types` (`id`, `name`) VALUES
(1, 'Oral'),
(2, 'Multiple choice');

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

TRUNCATE TABLE `subjects`;
INSERT INTO `subjects` (`id`, `name`) VALUES
(1, 'Art'),
(2, 'Biology'),
(3, 'Chemistry'),
(4, 'English'),
(5, 'Ethics'),
(6, 'Geography'),
(7, 'History'),
(8, 'IT'),
(9, 'Literature'),
(10, 'Mathematics'),
(11, 'Music'),
(12, 'Physics'),
(13, 'Psychology');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `registered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `username`, `email`, `password`, `registered_on`) VALUES
(1, 'user1', 'user1@gmail.com', '$2y$12$wz7fnjAqZnMJxrNnmvir4ewRw//YzLe.7a9b89lcnzdtzA5olEOIW', '2017-06-24 19:04:53');


ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `type_id` (`type_id`);

ALTER TABLE `exam_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `exam_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `exams_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `exam_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
