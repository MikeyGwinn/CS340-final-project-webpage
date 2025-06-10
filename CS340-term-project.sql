-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 30, 2025 at 09:21 PM
-- Server version: 10.11.11-MariaDB-0ubuntu0.24.04.2
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CS340-term-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `Applications`
--

CREATE TABLE `Applications` (
  `application_id` int(8) NOT NULL,
  `internship_id` int(8) NOT NULL,
  `student_id` int(8) NOT NULL,
  `application_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Applications`
--

INSERT INTO `Applications` (`application_id`, `internship_id`, `student_id`, `application_date`, `status`) VALUES
(1, 1, 1, '2025-02-01', 'submitted'),
(2, 2, 2, '2025-02-03', 'under review'),
(3, 3, 3, '2025-02-05', 'interview scheduled'),
(4, 4, 4, '2025-02-07', 'submitted'),
(5, 5, 5, '2025-02-10', 'rejected'),
(6, 6, 1, '2025-02-12', 'accepted'),
(7, 7, 6, '2025-02-14', 'submitted'),
(8, 8, 7, '2025-02-16', 'under review'),
(9, 9, 8, '2025-02-18', 'interview scheduled'),
(10, 10, 9, '2025-02-20', 'submitted');

-- --------------------------------------------------------

--
-- Table structure for table `Companies`
--

CREATE TABLE `Companies` (
  `company_id` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `industry` varchar(50) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `contact_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Companies`
--

INSERT INTO `Companies` (`company_id`, `name`, `industry`, `location`, `description`, `contact_email`) VALUES
(1, 'Google', 'Technology', 'Mountain View, CA', 'Multinational technology company specializing in Internet-related services', 'careers@google.com'),
(2, 'Microsoft', 'Technology', 'Redmond, WA', 'Multinational technology corporation producing computer software and electronics', 'recruiting@microsoft.com'),
(3, 'Amazon', 'E-commerce/Cloud', 'Seattle, WA', 'Multinational technology company focusing on e-commerce and cloud computing', 'university@amazon.com'),
(4, 'Apple', 'Technology', 'Cupertino, CA', 'Multinational technology company designing and manufacturing consumer electronics', 'college@apple.com'),
(5, 'Meta', 'Social Media', 'Menlo Park, CA', 'Technology company focusing on social media and virtual reality', 'university@meta.com'),
(6, 'Netflix', 'Entertainment/Streaming', 'Los Gatos, CA', 'American media services provider and production company', 'students@netflix.com'),
(7, 'Adobe', 'Software', 'San Jose, CA', 'Multinational computer software company known for creative software', 'internships@adobe.com'),
(8, 'Salesforce', 'Cloud Computing', 'San Francisco, CA', 'American cloud-based software company providing CRM services', 'futureforce@salesforce.com'),
(9, 'Intel', 'Semiconductors', 'Santa Clara, CA', 'American multinational corporation and technology company', 'college@intel.com'),
(10, 'Nike', 'Athletic Apparel', 'Beaverton, OR', 'Multinational corporation engaged in design and manufacturing of athletic footwear and apparel', 'internships@nike.com');

-- --------------------------------------------------------

--
-- Table structure for table `Has_Skill`
--

CREATE TABLE `Has_Skill` (
  `student_id` int(8) NOT NULL,
  `skill_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Has_Skill`
--

INSERT INTO `Has_Skill` (`student_id`, `skill_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 2),
(2, 4),
(2, 6),
(3, 1),
(3, 5),
(3, 8),
(4, 2),
(4, 3),
(4, 9),
(5, 4),
(5, 7),
(5, 10),
(6, 2),
(6, 7),
(6, 9),
(7, 1),
(7, 5),
(7, 8),
(8, 1),
(8, 5),
(8, 8),
(9, 2),
(9, 3),
(9, 6),
(10, 1),
(10, 2),
(10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Internships`
--

CREATE TABLE `Internships` (
  `internship_id` int(8) NOT NULL,
  `company_id` int(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `application_deadline` date NOT NULL,
  `wage` float NOT NULL,
  `posting_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Internships`
--

INSERT INTO `Internships` (`internship_id`, `company_id`, `title`, `description`, `location`, `application_deadline`, `wage`, `posting_date`) VALUES
(1, 1, 'Software Engineering Intern', 'Work on Google Search algorithms and user interface improvements', 'Mountain View, CA', '2025-03-15', 8500, '2025-01-10'),
(2, 2, 'Data Science Intern', 'Analyze user data and develop predictive models for Microsoft Azure', 'Redmond, WA', '2025-03-20', 8200, '2025-01-15'),
(3, 3, 'AWS Cloud Developer Intern', 'Develop and maintain cloud infrastructure solutions', 'Seattle, WA', '2025-04-01', 8800, '2025-01-20'),
(4, 4, 'iOS Development Intern', 'Work on native iOS applications and App Store optimization', 'Cupertino, CA', '2025-03-10', 8600, '2025-01-12'),
(5, 5, 'Frontend Engineering Intern', 'Develop user interfaces for Meta social media platforms', 'Menlo Park, CA', '2025-03-25', 8700, '2025-01-18'),
(6, 6, 'Machine Learning Intern', 'Improve Netflix recommendation algorithms', 'Los Gatos, CA', '2025-04-05', 8300, '2025-01-22'),
(7, 7, 'UX/UI Design Intern', 'Design user experiences for Adobe Creative Suite products', 'San Jose, CA', '2025-03-30', 7800, '2025-01-25'),
(8, 8, 'Salesforce Developer Intern', 'Customize and develop Salesforce CRM solutions', 'San Francisco, CA', '2025-04-10', 8100, '2025-01-28'),
(9, 9, 'Hardware Engineering Intern', 'Work on next-generation processor design and testing', 'Santa Clara, CA', '2025-03-18', 8400, '2025-01-16'),
(10, 10, 'Digital Marketing Intern', 'Develop digital marketing strategies and analyze campaign performance', 'Beaverton, OR', '2025-04-15', 6800, '2025-01-30');

-- --------------------------------------------------------

--
-- Table structure for table `Skills`
--

CREATE TABLE `Skills` (
  `skill_id` int(8) NOT NULL,
  `name` varchar(50) NOT NULL,
  `category` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Skills`
--

INSERT INTO `Skills` (`skill_id`, `name`, `category`) VALUES
(1, 'Python Programming', 'Programming Languages'),
(2, 'Java Development', 'Programming Languages'),
(3, 'JavaScript/React', 'Web Development'),
(4, 'SQL Database Management', 'Database'),
(5, 'Machine Learning', 'Data Science'),
(6, 'Cloud Computing (AWS)', 'Cloud Platforms'),
(7, 'Project Management', 'Soft Skills'),
(8, 'Data Analysis', 'Analytics'),
(9, 'Mobile App Development', 'Mobile Development'),
(10, 'Cybersecurity', 'Security');

-- --------------------------------------------------------

--
-- Table structure for table `Students`
--

CREATE TABLE `Students` (
  `student_id` int(8) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `major` varchar(30) NOT NULL,
  `graduation_year` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Students`
--

INSERT INTO `Students` (`student_id`, `first_name`, `last_name`, `email`, `major`, `graduation_year`) VALUES
(1, 'Emily', 'Johnson', 'emily.johnson@oregonstate.edu', 'Computer Science', 2025),
(2, 'Marcus', 'Chen', 'marcus.chen@oregonstate.edu', 'Software Engineering', 2024),
(3, 'Sarah', 'Williams', 'sarah.williams@oregonstate.edu', 'Data Science', 2026),
(4, 'David', 'Rodriguez', 'david.rodriguez@oregonstate.edu', 'Computer Science', 2025),
(5, 'Jessica', 'Kim', 'jessica.kim@oregonstate.edu', 'Cybersecurity', 2024),
(6, 'Andrew', 'Thompson', 'andrew.thompson@oregonstate.edu', 'Software Engineering', 2025),
(7, 'Maria', 'Garcia', 'maria.garcia@oregonstate.edu', 'Computer Science', 2026),
(8, 'Ryan', 'Lee', 'ryan.lee@oregonstate.edu', 'Data Science', 2024),
(9, 'Ashley', 'Brown', 'ashley.brown@oregonstate.edu', 'Software Engineering', 2025),
(10, 'Christopher', 'Davis', 'christopher.davis@oregonstate.edu', 'Computer Science', 2026);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Applications`
--
ALTER TABLE `Applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `internship_id_constraints` (`internship_id`),
  ADD KEY `student_id_constraints` (`student_id`);

--
-- Indexes for table `Companies`
--
ALTER TABLE `Companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `Has_Skill`
--
ALTER TABLE `Has_Skill`
  ADD UNIQUE KEY `student_id` (`student_id`,`skill_id`),
  ADD KEY `skill_constraint` (`skill_id`);

--
-- Indexes for table `Internships`
--
ALTER TABLE `Internships`
  ADD PRIMARY KEY (`internship_id`),
  ADD KEY `company_id_constraint` (`company_id`);

--
-- Indexes for table `Skills`
--
ALTER TABLE `Skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `Students`
--
ALTER TABLE `Students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Applications`
--
ALTER TABLE `Applications`
  MODIFY `application_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Companies`
--
ALTER TABLE `Companies`
  MODIFY `company_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Internships`
--
ALTER TABLE `Internships`
  MODIFY `internship_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Skills`
--
ALTER TABLE `Skills`
  MODIFY `skill_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Students`
--
ALTER TABLE `Students`
  MODIFY `student_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Applications`
--
ALTER TABLE `Applications`
  ADD CONSTRAINT `internship_id_constraints` FOREIGN KEY (`internship_id`) REFERENCES `Applications` (`application_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_id_constraints` FOREIGN KEY (`student_id`) REFERENCES `Applications` (`application_id`) ON UPDATE CASCADE;

--
-- Constraints for table `Has_Skill`
--
ALTER TABLE `Has_Skill`
  ADD CONSTRAINT `skill_constraint` FOREIGN KEY (`skill_id`) REFERENCES `Skills` (`skill_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `student_id_constraint` FOREIGN KEY (`student_id`) REFERENCES `Students` (`student_id`) ON UPDATE CASCADE;

--
-- Constraints for table `Internships`
--
ALTER TABLE `Internships`
  ADD CONSTRAINT `company_id_constraint` FOREIGN KEY (`company_id`) REFERENCES `Companies` (`company_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
