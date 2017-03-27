--
-- Database: 'company'
--

-- --------------------------------------------------------

--
-- Table structure for table 'department'
--

DROP TABLE IF EXISTS department;
CREATE TABLE department (
  Dname varchar(15) NOT NULL,
  Dnumber int(11) NOT NULL,
  Mgr_ssn char(9) NOT NULL,
  Mgr_start_date date default NULL,
  PRIMARY KEY  (Dnumber),
  UNIQUE KEY Dname (Dname)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'department'
--

INSERT INTO department VALUES
('Headquarters', 1, '888665555', '1981-06-19'),
('Administration', 4, '987654321', '1995-01-01'),
('Research', 5, '333445555', '1988-05-22'),
('Software', 6, '111111100', '2009-05-15'),
('Hardware', 7, '444444400', '2008-05-15'),
('Sales', 8, '555555500', '2007-01-01');

-- --------------------------------------------------------

--
-- Table structure for table 'dependent'
--

DROP TABLE IF EXISTS dependent;
CREATE TABLE dependent (
  Essn char(9) NOT NULL,
  Dependent_name varchar(15) NOT NULL,
  Sex char(1) default NULL,
  Bdate date default NULL,
  Relationship varchar(8) default NULL,
  PRIMARY KEY  (Essn,Dependent_name)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'dependent'
--

INSERT INTO dependent VALUES
('121231234', 'abcd', 'M', '2001-05-22', 'Son'),
('123456789', 'Alice', 'F', '1988-12-30', 'Daughter'),
('123456789', 'Elizabeth', 'F', '1967-05-05', 'Spouse'),
('123456789', 'Michael', 'M', '1988-01-04', 'Son'),
('333445555', 'Alice', 'F', '1986-04-05', 'Daughter'),
('333445555', 'Joy', 'F', '1958-05-03', 'Spouse'),
('333445555', 'Theodore', 'M', '1983-10-25', 'Son'),
('444444400', 'Johnny', 'M', '2007-04-04', 'Son'),
('444444400', 'Tommy', 'M', '2009-06-07', 'Son'),
('444444401', 'Chris', 'M', '1979-04-19', 'Spouse'),
('444444402', 'Alec', 'M', '1974-02-14', 'Spouse'),
('987654321', 'Abner', 'M', '1942-02-28', 'Spouse');

-- --------------------------------------------------------

--
-- Table structure for table 'dept_locations'
--

DROP TABLE IF EXISTS dept_locations;
CREATE TABLE dept_locations (
  Dnumber int(11) NOT NULL,
  Dlocation varchar(15) NOT NULL,
  PRIMARY KEY  (Dnumber,Dlocation)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'dept_locations'
--

INSERT INTO dept_locations VALUES
(1, 'Houston'),
(4, 'Stafford'),
(5, 'Bellaire'),
(5, 'Houston'),
(5, 'Sugarland'),
(6, 'Atlanta'),
(6, 'Sacramento'),
(7, 'Milwaukee'),
(8, 'Chicago'),
(8, 'Dallas'),
(8, 'Miami'),
(8, 'Philadephia'),
(8, 'Seattle');

-- --------------------------------------------------------

--
-- Table structure for table 'employee'
--

DROP TABLE IF EXISTS employee;
CREATE TABLE employee (
  Fname varchar(15) NOT NULL,
  Minit char(1) default NULL,
  Lname varchar(20) NOT NULL,
  Ssn varchar(11) NOT NULL,
  Bdate date default NULL,
  Address varchar(50) default NULL,
  Sex char(1) default NULL,
  Salary float(10,2) default NULL,
  Super_ssn char(9) default NULL,
  Dno int(11) NOT NULL,
  PRIMARY KEY  (Ssn)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'employee'
--

INSERT INTO employee VALUES
('Jared', 'D', 'James', '111111100', '1976-10-10', '123 Peachtree, Atlanta, GA', 'M', 85000.00, '', 6),
('Jon', 'C', 'Jones', '111111101', '1977-11-14', '111 Allgood, Atlanta, GA', 'M', 45000.00, '111111100', 6),
('Justin', '', 'Mark', '111111102', '1976-01-12', '2342 May, Atlanta, GA', 'M', 40000.00, '111111100', 6),
('Brad', 'C', 'Knight', '111111103', '1978-02-13', '176 Main St., Atlanta, GA', 'M', 44000.00, '111111100', 6),
('John', 'B', 'Smith', '123456789', '1965-01-09', '731 Fondren, Houston, TX', 'M', 30000.00, '333445555', 5),
('Evan', 'E', 'Wallis', '222222200', '1968-01-16', '134 Pelham, Milwaukee, WI', 'M', 92000.00, '', 7),
('Josh', 'U', 'Zell', '222222201', '1964-05-22', '266 McGrady, Milwaukee, WI', 'M', 56000.00, '222222200', 7),
('Andy', 'C', 'Vile', '222222202', '1954-06-21', '1967 Jordan, Milwaukee, WI', 'M', 53000.00, '222222200', 7),
('Tom', 'G', 'Brand', '222222203', '1976-12-16', '112 Third St, Milwaukee, WI', 'M', 62500.00, '222222200', 7),
('Jenny', 'F', 'Vos', '222222204', '1977-11-11', '263 Mayberry, Milwaukee, WI', 'F', 61000.00, '222222201', 7),
('Chris', 'A', 'Carter', '222222205', '1970-03-21', '565 Jordan, Milwaukee, WI', 'F', 43000.00, '222222201', 7),
('Kim', 'C', 'Grace', '333333300', '1980-10-23', '6677 Mills Ave, Sacramento, CA', 'F', 79000.00, '', 6),
('Jeff', 'H', 'Chase', '333333301', '1980-01-07', '145 Bradbury, Sacramento, CA', 'M', 44000.00, '333333300', 6),
('Franklin', 'T', 'Wong', '333445555', '1955-12-08', '638 Voss, Houston, TX', 'M', 40000.00, '888665555', 5),
('Alex', 'D', 'Freed', '444444400', '1960-10-09', '4333 Pillsbury, Milwaukee, WI', 'M', 89000.00, '', 7),
('Bonnie', 'S', 'Bays', '444444401', '1966-06-19', '111 Hollow, Milwaukee, WI', 'F', 70000.00, '444444400', 7),
('Alec', 'C', 'Best', '444444402', '1976-06-18', '233 Solid, Milwaukee, WI', 'M', 60000.00, '444444400', 7),
('Sam', 'S', 'Snedden', '444444403', '1987-07-31', '987 Windy St, Milwaukee, WI', 'M', 48000.00, '444444400', 7),
('Joyce', 'A', 'English', '453453453', '1972-07-31', '5631 Rice, Houston, TX', 'F', 25000.00, '333445555', 5),
('John', 'C', 'James', '555555500', '1985-06-30', '7676 Bloomington, Sacramento, CA', 'M', 81000.00, '', 6),
('Nandita', 'K', 'Ball', '555555501', '1979-04-16', '222 Howard, Sacramento, CA', 'M', 62000.00, '555555500', 6),
('Bob', 'B', 'Bender', '666666600', '1978-04-17', '8794 Garfield, Chicago, IL', 'M', 96000.00, '', 8),
('Jill', 'J', 'Jarvis', '666666601', '1976-01-14', '6234 Lincoln, Chicago, IL', 'F', 36000.00, '666666600', 8),
('Kate', 'W', 'King', '666666602', '1976-04-16', '1976 Boone Trace, Chicago, IL', 'F', 44000.00, '666666600', 8),
('Lyle', 'G', 'Leslie', '666666603', '1973-06-09', '417 Hancock Ave, Chicago, IL', 'M', 41000.00, '666666601', 8),
('Billie', 'J', 'King', '666666604', '1970-01-01', '556 Washington, Chicago, IL', 'F', 38000.00, '666666603', 8),
('Jon', 'A', 'Kramer', '666666605', '1974-08-22', '1988 Windy Creek, Seattle, WA', 'M', 41500.00, '666666603', 8),
('Ray', 'H', 'King', '666666606', '1959-08-16', '213 Delk Road, Seattle, WA', 'M', 44500.00, '666666604', 8),
('Gerald', 'D', 'Small', '666666607', '1972-05-19', '122 Ball Street, Dallas, TX', 'M', 29000.00, '666666602', 8),
('Arnold', 'A', 'Head', '666666608', '1977-05-19', '233 Spring St, Dallas, TX', 'M', 33000.00, '666666602', 8),
('Helga', 'C', 'Pataki', '666666609', '1979-03-11', '101 Holyoke St, Dallas, TX', 'F', 32000.00, '666666602', 8),
('Naveen', 'B', 'Drew', '666666610', '1980-05-23', '198 Elm St, Philadelphia, PA', 'M', 34000.00, '666666607', 8),
('Carl', 'E', 'Reedy', '666666611', '1987-06-21', '213 Ball St, Philadelphia, PA', 'M', 32000.00, '666666610', 8),
('Sammy', 'G', 'Hall', '666666612', '1980-01-11', '433 Main Street, Miami, FL', 'M', 37000.00, '666666611', 8),
('Red', 'A', 'Bacher', '666666613', '1990-05-21', '196 Elm Street, Miami, FL', 'M', 33500.00, '666666612', 8),
('Ramesh', 'K', 'Narayan', '666884444', '1962-09-15', '971 Fire Oak, Humble, TX', 'M', 38000.00, '333445555', 5),
('James', 'E', 'Borg', '888665555', '1937-11-10', '450 Stone, Houston, TX', 'M', 55000.00, '', 1),
('Jennifer', 'S', 'Wallace', '987654321', '1941-06-20', '291 Berry, Bellaire, TX', 'F', 43000.00, '888665555', 4),
('Ahmad', 'V', 'Jabbar', '987987987', '1969-03-29', '980 Dallas, Houston, TX', 'M', 25000.00, '987654321', 4),
('Alicia', 'J', 'Zelaya', '999887777', '1968-07-19', '3321 Castle, Spring, TX', 'F', 25000.00, '987654321', 4);

-- --------------------------------------------------------

--
-- Table structure for table 'project'
--

DROP TABLE IF EXISTS project;
CREATE TABLE project (
  Pname varchar(20) NOT NULL,
  Pnumber int(11) NOT NULL,
  Plocation varchar(15) default NULL,
  Dnum int(11) NOT NULL,
  PRIMARY KEY  (Pnumber),
  UNIQUE KEY Pname (Pname)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'project'
--

INSERT INTO project VALUES
('ProductX', 1, 'Bellaire', 5),
('ProductY', 2, 'Sugarland', 5),
('ProductZ', 3, 'Houston', 5),
('Computerization', 10, 'Stafford', 4),
('Reorganization', 20, 'Houston', 1),
('Newbenefits', 30, 'Stafford', 4),
('OperatingSystems', 61, 'Jacksonville', 6),
('DatabaseSystems', 62, 'Birmingham', 6),
('Middleware', 63, 'Jackson', 6),
('InkjetPrinters', 91, 'Phoenix', 7),
('LaserPrinters', 92, 'LasVegas', 7);

-- --------------------------------------------------------

--
-- Table structure for table 'works_on'
--

DROP TABLE IF EXISTS works_on;
CREATE TABLE works_on (
  Essn char(9) NOT NULL,
  Pno int(10) unsigned NOT NULL,
  Hours float(3,1) NOT NULL,
  PRIMARY KEY  (Essn,Pno)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'works_on'
--

INSERT INTO works_on VALUES
('111111100', 61, 40.0),
('111111101', 61, 40.0),
('111111102', 61, 40.0),
('111111103', 61, 40.0),
('123456789', 1, 32.5),
('123456789', 2, 7.5),
('222222200', 62, 40.0),
('222222201', 62, 48.0),
('222222202', 62, 40.0),
('222222203', 62, 40.0),
('222222204', 62, 40.0),
('222222205', 62, 40.0),
('333333300', 63, 40.0),
('333333301', 63, 46.0),
('333445555', 2, 10.0),
('333445555', 3, 10.0),
('333445555', 10, 10.0),
('333445555', 20, 10.0),
('444444400', 91, 40.0),
('444444401', 91, 40.0),
('444444402', 91, 40.0),
('444444403', 91, 40.0),
('453453453', 1, 20.0),
('453453453', 2, 20.0),
('555555500', 92, 40.0),
('555555501', 92, 44.0),
('666666601', 91, 40.0),
('666666603', 91, 40.0),
('666666604', 91, 40.0),
('666666605', 92, 40.0),
('666666606', 91, 40.0),
('666666607', 61, 40.0),
('666666608', 62, 40.0),
('666666609', 63, 40.0),
('666666610', 61, 40.0),
('666666611', 61, 40.0),
('666666612', 61, 40.0),
('666666613', 61, 30.0),
('666666613', 62, 10.0),
('666666613', 63, 10.0),
('666884444', 3, 40.0),
('888665555', 20, 0.0),
('987654321', 20, 15.0),
('987654321', 30, 20.0),
('987987987', 10, 35.0),
('987987987', 30, 5.0),
('999887777', 10, 10.0),
('999887777', 30, 30.0);

-- --------------------------------------------------------

--
-- Table structure for table 'works_on_info'
--

DROP TABLE IF EXISTS works_on_info;
CREATE TABLE works_on_info (
  Emp_name varchar(15) default NULL,
  Proj_name varchar(15) default NULL,
  Hours_per_week decimal(3,1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table 'works_on_info'
--

