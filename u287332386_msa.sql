
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 03, 2017 at 11:31 PM
-- Server version: 10.0.28-MariaDB
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `u287332386_msa`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE IF NOT EXISTS `attendence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `attendence`
--

INSERT INTO `attendence` (`id`, `org_id`, `date`, `course_id`, `student_id`) VALUES
(19, 10, '2016-04-21', 8, 22),
(20, 10, '2016-04-22', 8, 22),
(21, 10, '2016-04-20', 9, 24),
(22, 53, '2016-09-27', 10, 41),
(23, 53, '2016-09-28', 10, 41),
(25, 53, '2016-09-26', 11, 40),
(26, 53, '2016-09-28', 11, 40);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` varchar(500) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `phone`, `address`, `email`, `user_id`) VALUES
(4, 'test 123', 'fhjh', 'dghdn', 'hfdgd', 3);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `course_name` varchar(150) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `fee_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `org_id`, `course_name`, `status`, `fee_amount`) VALUES
(8, 10, '6th', 1, 500),
(9, 10, '5th', 1, 500),
(10, 53, '10', 1, 600),
(11, 53, '12', 1, 700),
(12, 54, '10', 1, 5000),
(13, 56, 'Time waste', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `examination`
--

CREATE TABLE IF NOT EXISTS `examination` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `org_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=>active , 2=>cancelled',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `examination`
--

INSERT INTO `examination` (`id`, `name`, `org_id`, `course_id`, `date`, `status`) VALUES
(12, 'final exams', 10, 8, '2016-04-29', 1),
(13, 'final exams', 10, 9, '2016-04-29', 1),
(14, 'Finals ', 53, 10, '2016-09-30', 1),
(15, 'Finals ', 53, 11, '2016-09-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE IF NOT EXISTS `faculty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `course_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `join_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `name`, `course_id`, `org_id`, `join_date`) VALUES
(1, 'Facult1', 1, 3, '2016-03-09');

-- --------------------------------------------------------

--
-- Table structure for table `fee_status`
--

CREATE TABLE IF NOT EXISTS `fee_status` (
  `unique_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `int_student_id` int(11) DEFAULT NULL,
  `int_month` int(11) DEFAULT NULL,
  `int_year` int(11) DEFAULT NULL,
  `payment_date` date NOT NULL,
  PRIMARY KEY (`unique_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `fee_status`
--

INSERT INTO `fee_status` (`unique_id`, `int_student_id`, `int_month`, `int_year`, `payment_date`) VALUES
(8, 3, 3, 2016, '2016-04-09'),
(9, 8, 3, 2016, '2016-04-09'),
(10, 9, 3, 2016, '2016-04-22'),
(11, 3, 1, 2016, '2016-04-01'),
(12, 8, 1, 2016, '2016-04-09'),
(13, 9, 1, 2016, '2016-04-09'),
(14, 22, 4, 2016, '2016-04-30'),
(15, 26, 4, 2016, '2016-04-30'),
(18, 26, 3, 2016, '2016-04-28'),
(19, 27, 5, 2016, '2016-05-02'),
(20, 34, 7, 2016, '2016-05-10'),
(21, 35, 7, 2016, '2016-05-10'),
(22, 34, 4, 2016, '2016-05-10'),
(23, 35, 4, 2016, '2016-05-10'),
(24, 35, 5, 2016, '2016-05-10'),
(42, 36, 1, 2016, '2016-05-15'),
(43, 36, 1, 2016, '2016-05-15'),
(46, 36, 5, 2016, '2016-05-17'),
(47, 41, 9, 2016, '2016-09-28');

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE IF NOT EXISTS `holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `org_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `title`, `start_date`, `end_date`, `org_id`) VALUES
(24, 'mj', '2016-04-22', '2016-04-22', 10);

-- --------------------------------------------------------

--
-- Table structure for table `navigation`
--

CREATE TABLE IF NOT EXISTS `navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `url` varchar(150) NOT NULL,
  `user_group` tinyint(4) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `int_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `navigation`
--

INSERT INTO `navigation` (`id`, `title`, `url`, `user_group`, `parent_id`, `int_order`) VALUES
(1, 'School', '#', 1, 0, 1),
(2, 'Form', 'organization_form.html', 1, 1, 2),
(3, 'Report', 'organization_report.html', 1, 1, 3),
(4, 'Student', '#', 2, 0, 1),
(5, 'Add', 'student_form.html', 2, 4, 2),
(6, 'List', 'student_course.html', 2, 4, 3),
(7, 'Notice', '#', 2, 0, 4),
(8, 'Add ', 'notice_form.html', 2, 7, 2),
(9, 'List', 'notice_report.html', 2, 7, 2),
(10, 'Course', '#', 2, 0, 4),
(11, 'Add', 'course_form.html', 2, 10, 5),
(12, 'List', 'course_report.html', 2, 10, 6),
(16, 'Attendance', '#', 2, 0, 16),
(17, 'Manage', 'attendance_course.html', 2, 16, 17),
(19, 'Change Password', 'change_password.html', 1, 0, 7),
(20, 'Change Password', 'change_password.html', 2, 0, 29),
(21, 'Change Password', 'change_password.html', 3, 0, 4),
(22, 'Examination', '#', 2, 0, 11),
(23, 'Add Exam', 'exam_form.html', 2, 22, 12),
(24, 'List Exam', 'exam_report.html', 2, 22, 13),
(25, 'Result', '#', 2, 0, 14),
(26, 'Manage', 'manage_result.html', 2, 25, 15),
(27, 'Attendance', 'student_attendance.html', 4, 0, 1),
(28, 'Notice', 'student_notice.html', 4, 0, 2),
(29, 'Result', 'student_result.html', 4, 0, 3),
(31, 'Change Password', 'change_password.html', 4, 0, 12),
(32, 'Transport', '#', 2, 0, 20),
(33, 'Add', 'transport_form.html', 2, 32, 21),
(34, 'List', 'transport_report.html', 2, 32, 22),
(35, 'Contact', '#', 2, 0, 23),
(36, 'Add', 'contact_form.html', 2, 35, 24),
(37, 'List', 'contact_report.html', 2, 35, 25),
(40, 'Contact', '#', 3, 0, 1),
(41, 'Add', 'contact_form.html', 3, 40, 2),
(42, 'List', 'contact_report.html', 3, 40, 3),
(43, 'Contact', '#', 4, 0, 8),
(44, 'Add', 'contact_form.html', 4, 43, 9),
(45, 'List', 'contact_report.html', 4, 43, 10),
(46, 'Contact', '#', 1, 0, 4),
(47, 'Add', 'contact_form.html', 1, 46, 5),
(48, 'List', 'contact_report.html', 1, 46, 6),
(49, 'Fees', '#', 2, 0, 18),
(50, 'Manage Fees', 'manage_fees.html', 2, 49, 19),
(51, 'Subject', '#', 2, 0, 7),
(52, 'Add Subject', 'subject_add.html', 2, 51, 8),
(53, 'List Subject', 'subject_list.html', 2, 51, 9),
(58, 'Holiday', '#', 2, 0, 25),
(59, 'Add', 'holiday_form.html', 2, 58, 25),
(60, 'List', 'holiday_report.html', 2, 58, 25),
(61, 'Holiday', 'student_holiday.html', 4, 0, 11),
(62, 'Assignment', '#', 2, 0, 26),
(63, 'Add', 'assignment_add.html', 2, 62, 27),
(64, 'List', 'assignment_list.html', 2, 62, 27),
(66, 'Assignment', 'my_assignment.html', 4, 0, 4),
(67, 'Transport', 'stud_transport.html', 4, 0, 7),
(68, 'Fee Status', 'student_fee.html', 4, 0, 6),
(69, 'Examination', 'student_exam.html', 4, 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `notice_board`
--

CREATE TABLE IF NOT EXISTS `notice_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `description` text NOT NULL,
  `created_on` datetime NOT NULL,
  `expiration_date` date NOT NULL,
  `notice_type` tinyint(4) NOT NULL,
  `type_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `notice_board`
--

INSERT INTO `notice_board` (`id`, `org_id`, `subject`, `description`, `created_on`, `expiration_date`, `notice_type`, `type_id`, `status`) VALUES
(1, 2, 'Test notice', 'This is test notice.', '2016-03-15 00:00:00', '2016-03-31', 1, 0, 1),
(2, 10, 'white dress tomorrow', 'please come with full white dress code', '2016-04-21 00:00:00', '2016-04-22', 1, 0, 1),
(3, 11, 'Jayanti', 'jaikey jayanti', '2016-04-28 00:00:00', '2016-04-29', 1, 0, 1),
(4, 15, 'white dress code', 'please come in white dress on tomorrow', '2016-05-10 00:00:00', '2016-05-11', 1, 0, 1),
(5, 15, 'don''t come', 'please don''t come', '2016-05-10 00:00:00', '2016-05-12', 2, 34, 1),
(6, 53, 'Holiday tomorrow', 'On 29 sept', '2016-09-27 00:00:00', '2016-09-29', 3, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE IF NOT EXISTS `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(500) DEFAULT NULL,
  `owner` varchar(200) NOT NULL,
  `image` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id`, `name`, `address`, `owner`, `image`) VALUES
(7, 'KV 1', 'kv1 army cant gwalior', 'KV 1', ''),
(44, 'dheeraj public school', 'sdh', 'dheeraj', ''),
(45, 'madhur public school', 'jkkk', 'madhur', ''),
(46, 'vishal public school', 'hd', 'vishal', ''),
(53, 'Zoe mission school', 'Nxjx', 'Zoe', ''),
(54, 'Abc', 'Jp', 'Abcdefg', ''),
(55, 'mps', 'mncj', 'mahesh', ''),
(56, 'Time waste with Vishal', 'Nayamandir, Kayasth Mohalla', 'Vishal Sharma', '');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE IF NOT EXISTS `parents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image` varchar(50) NOT NULL,
  `phone_no` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `name`, `image`, `phone_no`) VALUES
(27, 'Smith', '', '8854058808'),
(28, 'V.K. Gupta', '', '7784578854'),
(29, 'Dinesh', '', '9309090070'),
(30, 'Neeraj', '', '9269057835'),
(31, 'Nandwana', '', '8873'),
(32, 'njh', '', '987'),
(33, 'Dinanath', '', '9529998889'),
(34, 'Qasd', '', '866458'),
(35, 'Vikash', '', '7737421817');

-- --------------------------------------------------------

--
-- Table structure for table `resource_category`
--

CREATE TABLE IF NOT EXISTS `resource_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`id`, `exam_id`, `student_id`, `marks`) VALUES
(1, 2, 3, 43),
(2, 2, 4, 33),
(3, 2, 7, 98),
(4, 2, 8, 66),
(5, 2, 9, 0),
(6, 12, 22, 600),
(7, 12, 23, 500),
(8, 13, 24, 500),
(9, 14, 26, 600),
(10, 18, 36, 300);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `mother_name` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` varchar(20) NOT NULL,
  `image` varchar(30) DEFAULT NULL,
  `transport_id` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `enroll_no` varchar(50) DEFAULT NULL,
  `parent_ph_no` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `father_name`, `mother_name`, `gender`, `dob`, `image`, `transport_id`, `course_id`, `org_id`, `parent_id`, `enroll_no`, `parent_ph_no`) VALUES
(30, 'Robert', 'Smith', 'Terra', 'Male', '2016-05-10', NULL, NULL, 15, 14, 27, '102102', '8854058808'),
(31, 'Robert', 'Smith', 'Terra', 'Male', '2016-05-10', NULL, NULL, 15, 14, 27, '102102', '8854058808'),
(32, 'Rahul Gupta', 'V.K. Gupta', 'Ridhima Gupta', 'Male', '2016-05-02', NULL, NULL, 14, 13, 28, '101', '7784578854'),
(34, 'rahul', 'Dinesh', 'manju', 'Male', '2016-05-25', NULL, NULL, 16, 15, 29, '001/2016', '9309090070'),
(35, 'jky', 'dinesh', 'manju', 'Male', '2016-05-28', NULL, NULL, 16, 15, 29, '002/2016', '9309090070'),
(36, 'Pranav', 'Neeraj', 'Nisha', 'Male', '2010-01-01', NULL, NULL, 17, 17, 30, '01/2016', '9269057835'),
(37, 'Sandeep', 'Nandwana', 'Abv', 'Male', '6-06-13', NULL, NULL, 19, 33, 31, '9173', '8873'),
(38, 'anu', 'njh', 'hjkk', 'Female', '2009-01-01', NULL, NULL, 15, 33, 32, '98kk', '987'),
(40, 'Rahul', 'Dinesh', 'Manju', 'Male', '1992-06-05', NULL, NULL, 11, 53, 29, '20160902', '9309090070'),
(41, 'Jky', 'Dinesh', 'Manju', 'Male', '1990-04-28', NULL, NULL, 10, 53, 29, '20160901', '9309090070'),
(42, 'Asd', 'Qasd', 'Qasd', 'Male', '2016-09-27', NULL, NULL, 12, 54, 34, '1233', '866458'),
(43, 'Vijay', 'Vikash', 'Jayshree', 'Male', '1995-05-03', NULL, NULL, 13, 56, 35, '1234', '7737421817');

-- --------------------------------------------------------

--
-- Table structure for table `student_transport`
--

CREATE TABLE IF NOT EXISTS `student_transport` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transport_type` int(11) NOT NULL COMMENT '1=>self; 2=>school',
  `student_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  `transport_id` int(11) DEFAULT NULL,
  `vehical_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `student_transport`
--

INSERT INTO `student_transport` (`id`, `transport_type`, `student_id`, `org_id`, `transport_id`, `vehical_no`) VALUES
(1, 2, 7, 2, 2, 0),
(2, 2, 9, 2, 2, 0),
(3, 2, 22, 10, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE IF NOT EXISTS `subject` (
  `subject_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(100) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`subject_id`, `subject_name`, `course_id`) VALUES
(4, 'maths', 1),
(5, 'Physics', 1),
(6, 'Chemistry', 1),
(7, 'hindi', 8),
(8, 'english', 8),
(9, 'maths', 9),
(18, 'English', 13),
(19, 'hindi', 14),
(21, 'english', 14),
(24, 'eng', 16),
(25, 'Arts', 17),
(26, 'hindi', 14),
(27, 'english', 14),
(28, 'Mathmatics', 14),
(29, 'Science', 14),
(31, 'Hindi', 10),
(32, 'Math', 10),
(33, 'Hindi', 12);

-- --------------------------------------------------------

--
-- Table structure for table `tab_assignment`
--

CREATE TABLE IF NOT EXISTS `tab_assignment` (
  `int_unique` bigint(20) NOT NULL AUTO_INCREMENT,
  `int_course_id` int(11) DEFAULT NULL,
  `int_subject_id` int(11) NOT NULL,
  `int_org_id` int(11) DEFAULT NULL,
  `txt_assignment_topic` varchar(255) DEFAULT NULL,
  `txt_assignment_url` varchar(255) DEFAULT NULL,
  `dt_submission_date` date DEFAULT NULL,
  `int_grace_days` int(11) DEFAULT NULL,
  `int_max_marks` int(11) DEFAULT NULL,
  PRIMARY KEY (`int_unique`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tab_assignment`
--

INSERT INTO `tab_assignment` (`int_unique`, `int_course_id`, `int_subject_id`, `int_org_id`, `txt_assignment_topic`, `txt_assignment_url`, `dt_submission_date`, `int_grace_days`, `int_max_marks`) VALUES
(3, 8, 7, 10, 'nibandh', NULL, '2016-04-22', 3, 200);

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE IF NOT EXISTS `transport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `vehical_no` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`id`, `org_id`, `name`, `vehical_no`) VALUES
(3, 10, '5', '5566');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `user_group` tinyint(4) NOT NULL,
  `user_code` varchar(10) DEFAULT NULL,
  `api_key` varchar(20) NOT NULL,
  `avtar` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=131 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `phone`, `address`, `city`, `state`, `zipcode`, `status`, `user_group`, `user_code`, `api_key`, `avtar`) VALUES
(1, 'admin', '96e79218965eb72c92a549dd5a330112', 'admin@admin.com', 'Super Admin', '2222222', 'Test address1', 'Lko1', NULL, '222211', 0, 1, '', '130379511457637859', ''),
(110, 'dps98', 'cd50a35e4d0d5834c4c7e79da26d3bc1', 'dheerajdheeraj@yopmail.com', 'dheeraj public school', 'jllkj', 'sdh', NULL, NULL, NULL, 0, 2, '44', '', NULL),
(111, 'mps22', '21fa28cc4a4eac0a5715eb948b2c4334', 'madhurmadhur@yopmail.com', 'madhur public school', 'hkl', 'jkkk', NULL, NULL, NULL, 0, 2, '45', '', NULL),
(112, 'vps59', '6f7b9921195e3e9c901c8fe0f8abc953', 'vishalvishal@yopmail.com', 'vishal public school', 'hkl', 'hd', NULL, NULL, NULL, 0, 2, '46', '', NULL),
(119, 'Zms', 'f02aded8da214f85d4bc6e8be89cad39', 'Zoe@yopmail.com', 'Zoe mission school', '888888', 'Nxjx', NULL, NULL, NULL, 0, 2, '53', '11957123601474994430', NULL),
(121, 'Zms20160902', '2d1e49afb4309a18880f365d6ec6378e', 'Rahul@yopmail.com', 'Rahul', NULL, 'Biwai', NULL, NULL, NULL, 0, 4, '40', '12112008391474996763', NULL),
(122, 'Zms20160901', '2d1e49afb4309a18880f365d6ec6378e', 'Jky@yopmail.com', 'Jky', NULL, 'Niwai', NULL, NULL, NULL, 0, 4, '41', '12273419351474996900', NULL),
(123, 'Zmsp20160901', '7e399275d8919967eb101a994f257ac3', '', 'Dinanath', '9529998889', 'Niwai', NULL, NULL, NULL, 0, 3, '33', '', NULL),
(124, 'A', '4db3c4efae4997437db42855cf0ebf50', 'Abcdefg@yopmail.com', 'Abc', '00000000', 'Jp', NULL, NULL, NULL, 0, 2, '54', '12477860251476685293', NULL),
(125, 'Ap1233', '6b0883c95a1a7aa37f6069c9b45ef262', '', 'Qasd', '866458', 'Qasf', NULL, NULL, NULL, 0, 3, '34', '', NULL),
(126, 'A1233', '6b0883c95a1a7aa37f6069c9b45ef262', 'Qasdqasd@yopmail.com', 'Asd', NULL, 'Qasf', NULL, NULL, NULL, 0, 4, '42', '', NULL),
(127, 'm', '2a34ae092d61989d0444a8d345eb8240', 'mpsmps123@yopmail.com', 'mps', '9999999999', 'mncj', NULL, NULL, NULL, 0, 2, '55', '', NULL),
(128, 'TwwV', '0ccbb30cc77a7c551565241110be6b06', 'Newaivirus@gmail.com', 'Time waste with Vishal', '7737421817', 'Nayamandir, Kayasth Mohalla', NULL, NULL, NULL, 0, 2, '56', '12869813031483440092', NULL),
(129, 'TwwVp1234', '2205a2a5b0d41193ce634ace255ae2d4', '', 'Vikash', '7737421817', 'Noida', NULL, NULL, NULL, 0, 3, '35', '', NULL),
(130, 'TwwV1234', '2205a2a5b0d41193ce634ace255ae2d4', 'Newaivirus@gmail.com', 'Vijay', NULL, 'Noida', NULL, NULL, NULL, 0, 4, '43', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `name`, `code`) VALUES
(1, 'Super Admin', 'superadmin'),
(2, 'Admin', 'admin'),
(3, 'Parent', 'parent'),
(4, 'Student', 'student');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
