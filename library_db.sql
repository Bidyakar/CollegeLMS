

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `library_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `library_db`;




CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `role` enum('student','faculty','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



INSERT INTO `users` (`id`, `name`, `email`, `password`, `student_id`, `role`) VALUES
(1, 'Student User', 'student@example.com', '$2y$10$8W3Y6s7Y9/GvS9Z5jP2cOu3l2F0z1m8j7W5Y6s7Y9/GvS9Z5jP2cO', 'STD001', 'student'),
(2, 'Admin User', 'admin@example.com', '$2y$10$8W3Y6s7Y9/GvS9Z5jP2cOu3l2F0z1m8j7W5Y6s7Y9/GvS9Z5jP2cO', 'ADM001', 'admin');



CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(50) DEFAULT NULL,
  `course` enum('BIM','BCA','BBA','BITM') NOT NULL,
  `semester` int(11) NOT NULL,
  `available_copies` int(11) DEFAULT 1,
  `total_copies` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `course`, `semester`, `available_copies`, `total_copies`) VALUES
(1, 'Digital Logic', 'Mio Morris', '978-0132145321', 'BIM', 1, 5, 5),
(2, 'C Programming', 'Dennis Ritchie', '978-0131103627', 'BIM', 1, 3, 5),
(3, 'Discrete Mathematics', 'Kenneth Rosen', '978-0073383095', 'BIM', 2, 4, 4),
(4, 'Computer Fundamentals', 'Pradeep K. Sinha', '978-8176567527', 'BCA', 1, 10, 10),
(5, 'Principles of Management', 'P.C. Tripathi', '978-0070146467', 'BBA', 1, 7, 7);



CREATE TABLE IF NOT EXISTS `issued_books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `issued_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `issued_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
