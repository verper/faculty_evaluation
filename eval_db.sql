-- phpMyAdmin SQL Dump
-- version 4.3.13.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2017 at 12:21 AM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eval_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `form` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `form`) VALUES
(1, 'Teaching Competencies', 1),
(9, 'Teacher’s Personality and Interpersonal Relations', 1),
(10, 'Leaderships', 1),
(12, 'CLASSROOM MANAGEMENT/PUNCTUALITY', 3),
(13, 'PRINCIPLES AND METHODS OF TEACHING', 3),
(14, 'KNOWLEDGE OF SUBJECT MATTER', 3),
(15, 'MOTIVATIONAL TEACHER BEHAVIOR', 3),
(16, 'PERSONAL AND PROFESSIONAL QUALITIES', 3),
(17, 'Regard for self', 4),
(18, 'Regard for others', 4),
(19, 'Attitudes towards work', 4),
(20, 'Miscellaneous', 4);

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE IF NOT EXISTS `colleges` (
  `id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `dean` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `title`, `dean`) VALUES
('CBA', 'COLLEGE OF BUSINESS AND ACCOUNTANCY', 'd1'),
('CECS', 'COLLEGE OF ENGINEERING AND COMPUTER STUDIES', 'd2'),
('CPAHP', 'COLLEGE OF PHARMACY AND HEALTH RELATED PROGRAM', 'd3'),
('CTEAS', 'COLLEGE OF TEACHERS ARTS AND SCIENCES', 'd4');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `assigned` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `assigned`, `program`) VALUES
('BAR1', 'BARTENDING 1', 'f4', 'BSHRM'),
('CS2', 'BASIC PROGRAMMING', 'f2', 'BSIT'),
('SAD', 'SYSTEM ANALYSIS AND DESIGN', 'f1', 'BSIT');

-- --------------------------------------------------------

--
-- Table structure for table `course_load`
--

CREATE TABLE IF NOT EXISTS `course_load` (
  `course` varchar(255) NOT NULL,
  `student` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_load`
--

INSERT INTO `course_load` (`course`, `student`) VALUES
('CS2', 's1'),
('CS2', 's2'),
('SAD', 's1');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `title`, `status`) VALUES
(1, 'TEACHER’S EVALUATION', 1),
(3, 'INSTRUCTOR’S CLASSROOM PERFORMANCE', 0),
(4, 'PEER EVALUATION', 0);

-- --------------------------------------------------------

--
-- Table structure for table `peer_peer`
--

CREATE TABLE IF NOT EXISTS `peer_peer` (
  `id` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
  `id` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `supervisor` varchar(255) NOT NULL,
  `college` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `title`, `supervisor`, `college`) VALUES
('BSHRM', 'BACHELOR OF SCIENCE IN HOTEL AND RESTAURANT MANAGEMENT', 'ph2', 'CTEAS'),
('BSIT', 'BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY', 'ph1', 'CECS');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `category`) VALUES
(1, 'Sets precise, practical and achievable objectives within a given period.', 1),
(2, 'Syllabus/Lesson plan reflects knowledge on the subject matter. ', 1),
(3, 'Relates well with others and shows a capacity totranscend personal consideration in dealing with issues.', 9),
(4, 'Utilizes appropriate and adequate teaching material and devices,  and shows resourcefulness’ in acquiring them.', 1),
(5, 'Utilizes appropriate evaluation tool. ', 1),
(6, 'Relates concepts and theory effectively in real life situations. ', 1),
(7, 'Approachable, honest, friendly, fair, sincere, patient.', 9),
(8, 'Accepts limitations and welcomes constructive criticisms.', 9),
(9, 'Actively participates in activities of the department and the College.', 9),
(10, 'Contributes one’s expertise in a given field to enable a committee and peers to attain its/their goals and objectives.', 9),
(11, 'Is fully aware and dedicated in the discharge of his/her duties, functions and responsibilities.', 10),
(12, 'Commands the respect and inspire confidence among peers.', 10),
(13, 'Effectively manages work/assignments and accomplishes work targets. ', 10),
(14, 'Conforms to and accepts group standards.', 10),
(15, 'Abides by the policies, rules, and regulations of the College,(including wearing of ID, school uniform, non-smoking in the campus, etc.)', 10),
(21, 'Comes to class on time.', 12),
(23, 'Observes proper order and discipline before starting the class.', 12),
(24, 'Ensures the observance of cleanliness, neatness and orderliness in the classroom.', 12),
(25, 'Uses the whole time for teaching and learning activity.', 12),
(26, 'Demonstrates firmness/strictness and consistency; strict but reasonable in disciplining students.', 12),
(27, 'Gives favorable and encouraging comments when students give correct answer or give new good ideas.', 13),
(28, 'Gives examples and illustrations.', 13),
(29, 'Relates present lessons to the previous ones.', 13),
(30, 'Provides a short summary at the end of the class.', 13),
(31, 'Explains the purpose/objectives of the lesson.', 13),
(32, 'Adjusts way of teaching to the student’s learning abilities.', 13),
(33, 'Encourages students to ask questions.', 13),
(34, 'Speaks English and/or Filipino as the case maybe and enforce the same from students.', 13),
(35, 'Integrates values appropriate to the lesson.', 13),
(36, 'Introduces creative and varied activities to keep students interested and attentive to the lessons.', 13),
(37, 'Explains the lesson clearly.', 14),
(38, 'Delivers the lesson fluently and smoothly.', 14),
(39, 'Clarifies conflict/argument that may arise from the lesson.', 14),
(40, 'Speaks clearly.', 14),
(41, 'Gives students challenging learning tasks, assignments, and problems.', 15),
(42, 'Modifies and changes teaching procedures if test result show poor performance by the students.', 15),
(43, 'Informs students of the results of written tests and assignments within reasonable time.', 15),
(44, 'Selects, prepares, and utilizes varied instructional materials effectively in achieving teaching goals.', 15),
(45, 'Encourages students to speak or discuss their opinions without being humiliated.', 15),
(46, 'Shows self-confidence.', 16),
(47, 'Commands respect in and out of the classroom.', 16),
(48, 'Makes himself available to the students for guidance and assistance.', 16),
(49, 'Shows interest and enthusiasm in the lesson with his voice and gestures.', 16),
(50, 'Demonstrates consistency and fairness in dealing with students.', 16),
(51, 'Nags or keeps reminding students about their undesirable behaviors.', 16),
(52, 'Exhibits disturbing mannerism and behaviors.', 16),
(53, 'Loses one’s temper in class by shouting or throwing things, leaving class, etc.', 16),
(54, 'Embarrasses and insults students. ', 16),
(55, 'Explains with clarity and speaks with confidence using the medium of instruction.', 1),
(56, 'Comes to class prepared and shows a great range of knowledge of the subject matter.', 1),
(57, 'Using an effective questioning technique. ', 1),
(58, 'Responds to student’s questions and endeavors to see relevance in the subject. ', 1),
(59, 'Applies skillfully innovative teaching approaches and strategies.', 1),
(60, 'Exhibits mastery of the subject matter. ', 1),
(61, 'Maintains class atmosphere conducive to learning.', 1),
(62, 'Renders willingly extra time/service for the good of the department and of the College even without compensation. ', 9),
(63, 'Shows liking for students/pupils and genuine concern for their progress.', 9),
(64, 'Has a sense of personal dignity and self-worth. ', 10),
(65, 'Exercise fairness in dealing with students and peers, and is sensitive to and perceptive of their feelings. ', 10),
(66, 'Upholds and protects the integrity of the school.', 10),
(67, 'Submits syllabus on time.', 10),
(68, 'Submits TOS and test questions on time.', 10),
(69, 'Submits grades on time.', 10),
(70, 'Submits other required reports on time.', 10),
(71, 'Show evidence of active participation in school activities. (Spiritual, cultural, professional, etc.) ', 10),
(72, 'Accepts criticisms openly and works toward improving them', 17),
(73, 'Displays humility at all times', 17),
(74, 'Demonstrates gentleness or evenness of temper even when under stress or pressure', 17),
(75, 'Possesses pleasant disposition and works well under pressure or unexpected situation/circumstances', 17),
(76, 'Exhibit sound mind and body conditions that enables him/her to do one’s task smoothly.', 17),
(77, 'Respects and keeps confidential information of others (students and teachers)', 18),
(78, 'Regards the person authentically regardless of status or standing in school and society.', 18),
(79, 'Generous of time and knowledge in helping others.', 18),
(80, 'Demonstrates impartiality/fairness/objectiveness in his/her dealings or relationship and judgement. Discourages grapevine talk.', 18),
(81, 'Speaks well of his/her colleagues and others and their accomplishments.', 18),
(82, 'Displays positive attitude/outlook towards work, assignment or responsibility.', 19),
(83, 'Stands for what is right and just even how unpopular it may be.', 19),
(84, 'Is a stabilizing factor for peace and harmony in and out of the faculty circle.', 19),
(85, 'Observes and respects SOP’s, protocols, practices, procedures in the conduct of affair in and out of the campus.', 19),
(86, 'Welcomes additional responsibilities that may be assigned or given.', 19),
(87, 'Cooperates with the plans and programs of the school towards development.', 19),
(88, 'Speaks well of the school, its administrators, its programs and activities.', 19),
(89, 'Relates well with others.', 19),
(90, 'Exhibits disturbing mannerisms and behavior.', 20),
(91, 'Critical of the manners or ideas of others.', 20),
(92, 'Resorts to manipulating situations, rules, and others to get one’s desires or wants.', 20);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` bigint(20) NOT NULL,
  `evaluator` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `form` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`) VALUES
(1, 'student'),
(2, 'faculty'),
(3, 'program head'),
(4, 'dean'),
(5, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `role_form`
--

CREATE TABLE IF NOT EXISTS `role_form` (
  `role` int(11) NOT NULL,
  `form` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_form`
--

INSERT INTO `role_form` (`role`, `form`) VALUES
(1, 1),
(2, 4),
(3, 3),
(4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `middlename` text NOT NULL,
  `role` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL DEFAULT 'default.png',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `firstname`, `lastname`, `middlename`, `role`, `photo`, `created`) VALUES
('000', 'c6f057b86584942e415435ffb1fa93d4', 'ARIEL', 'VERZOSA', 'REROMA', 5, 'default.png', '2017-04-19 13:28:23'),
('d1', 'c81e728d9d4c2f636f067f89cc14862c', 'ANDRES', 'BONIFACIO', '', 4, 'default.png', '2017-04-19 13:28:23'),
('d2', 'b25b0651e4b6e887e5194135d3692631', 'JOSE', 'RIZAL', 'POTASIO', 4, 'default.png', '2017-04-19 13:28:23'),
('d3', 'e53125275854402400f74fd6ab3f7659', 'DEAN 3', 'DEAN 3', '', 4, 'default.png', '2017-04-19 21:53:09'),
('d4', 'ae11976937537e4c1206237dea035331', 'DEAN 4', 'DEAN 4', '', 4, 'default.png', '2017-04-19 21:53:18'),
('f1', 'bd19836ddb62c11c55ab251ccaca5645', 'GREGORIO', 'DEL PILAR', '', 2, '7ff7753876b907eae63b80a9af67612b.jpg', '2017-04-19 13:28:23'),
('f2', '3667f6a0c97490758d7dc9659d01ea34', 'MARIANO', 'PONCE', '', 2, 'default.png', '2017-04-19 13:28:23'),
('f3', '1779cf3aa50c413afc7e05adb7e1b0de', 'FACULTY 3', 'FACULTY 3', '', 2, 'default.png', '2017-04-19 22:18:59'),
('f4', '6e1fcd704528ad8bf6d6bbedb9210096', 'FACULTY4', 'FACULTY4', '', 2, 'default.png', '2017-04-21 03:56:01'),
('ph1', '65d452a3e381ee81fa685942e6966990', 'EMILIO', 'JACINTO', '', 3, 'default.png', '2017-04-19 13:28:23'),
('ph2', 'f1c1592588411002af340cbaedd6fc33', 'JUAN', 'LUNA', '', 3, 'default.png', '2017-04-19 13:28:23'),
('s1', '8ddf878039b70767c4a5bcf4f0c4f65e', 'JOHN', 'DOE', '', 1, 'default.png', '2017-04-19 13:28:23'),
('s2', 'fac989447cad2edbc89fbcba70003b36', 'BARRY', 'ALLEN', '', 1, 'default.png', '2017-04-19 13:28:23'),
('s3', 'c0828e0381730befd1f7a025057c74fb', 'S3', 'S3', '', 1, 'default.png', '2017-04-20 04:13:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`), ADD KEY `form` (`form`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `dean_2` (`dean`), ADD KEY `dean` (`dean`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`), ADD KEY `assigned` (`assigned`), ADD KEY `program` (`program`);

--
-- Indexes for table `course_load`
--
ALTER TABLE `course_load`
  ADD PRIMARY KEY (`course`,`student`), ADD KEY `course` (`course`), ADD KEY `student` (`student`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peer_peer`
--
ALTER TABLE `peer_peer`
  ADD PRIMARY KEY (`id`), ADD KEY `target` (`target`), ADD KEY `source` (`source`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `supervisor_2` (`supervisor`), ADD KEY `supervisor` (`supervisor`), ADD KEY `college` (`college`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`), ADD KEY `category` (`category`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`), ADD KEY `evaluator` (`evaluator`), ADD KEY `subject` (`subject`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_form`
--
ALTER TABLE `role_form`
  ADD PRIMARY KEY (`role`,`form`), ADD KEY `role` (`role`), ADD KEY `form` (`form`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `peer_peer`
--
ALTER TABLE `peer_peer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`form`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `colleges`
--
ALTER TABLE `colleges`
ADD CONSTRAINT `target_user` FOREIGN KEY (`dean`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`assigned`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`program`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_load`
--
ALTER TABLE `course_load`
ADD CONSTRAINT `target_course` FOREIGN KEY (`course`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `target_student` FOREIGN KEY (`student`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peer_peer`
--
ALTER TABLE `peer_peer`
ADD CONSTRAINT `peer_peer_ibfk_1` FOREIGN KEY (`source`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `peer_peer_ibfk_2` FOREIGN KEY (`target`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`college`) REFERENCES `colleges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `programs_ibfk_2` FOREIGN KEY (`supervisor`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`evaluator`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`subject`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_form`
--
ALTER TABLE `role_form`
ADD CONSTRAINT `role_form_ibfk_1` FOREIGN KEY (`form`) REFERENCES `forms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `role_form_ibfk_2` FOREIGN KEY (`role`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
