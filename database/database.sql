#Create database----------------------------------

CREATE DATABASE IF NOT EXISTS herdr;
USE herdr;

#Create tables---------------------------------------

CREATE TABLE IF NOT EXISTS adminusers 
(
lnum int(8) NOT NULL,
name varchar(20),
email varchar (50),
pswd varchar(64)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS bio 
(
l_num int(8) PRIMARY KEY, 
l_name varchar(20) NOT NULL,
f_name varchar(20) NOT NULL,
p_name varchar(20),
suspend bool NOT NULL,
suspend_num int(2),
warn_num int(2),
hall_id int(2),
bday date,
sex char(1) NOT NULL,
prof_pic varchar(255),
college varchar(30),
major varchar(45),
aboutme varchar(500),
allergies varchar(100)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS studentusers
(
lnum int(8) PRIMARY KEY,
email varchar(50) NOT NULL,
pswd blob NOT NULL,
FOREIGN KEY (lnum) REFERENCES bio(l_num)
)ENGINE=InnoDB; 

CREATE TABLE IF NOT EXISTS question
(
L_num int(8),
q_introvert bool NOT NULL,
q_study char(5) NOT NULL, 
q_bedtime varchar(10) NOT NULL,
q_guest varchar(10) NOT NULL,
q_nightguest varchar(14) NOT NULL,
q_travel char(10) NOT NULL,
q_shared bool NOT NULL DEFAULT 0, 
q_relationship varchar(25) NOT NULL,
q_temp char(10) NOT NULL,
oq_enneagram int(1),
oq_myersbriggs varchar(7),
oq_lightsleep bool,
oq_clean varchar(12),
oq_nap bool,
oq_noise char (8),
hq_gpa varchar(4),
hq_religion varchar(13), 
hq_sat varchar(4),
hq_act varchar(2),
hq_smoke bool NOT NULL,
hq_drink bool NOT NULL,
hq_lgbt bool,
hq_mental char(15),
PRIMARY KEY (L_num),
FOREIGN KEY (L_num) REFERENCES bio(l_num)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS hall 
(
h_id int(2) PRIMARY KEY,
hallname varchar(20) NOT NULL
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS matches
(
 m_id mediumint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 match_time datetime,
 lnum1 int(8) NOT NULL,
 lnum2 int(8) NOT NULL,
 checked bool NOT NULL DEFAULT 0,
 confirm_match bool DEFAULT 0,
 blocked bool DEFAULT 0,
 FOREIGN KEY (lnum1) REFERENCES bio(l_num),
 FOREIGN KEY (lnum2) REFERENCES bio(l_num)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS reports 
( 
r_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
r_time datetime,
`status` varchar(10) NOT NULL DEFAULT 'no status',
lnum int(8) NOT NULL,
category varchar(20) NOT NULL,
comment varchar(200),
checked tinyint(1) NOT NULL DEFAULT 0,
warn tinyint(1) DEFAULT 0,
`suspend` tinyint(1) NOT NULL DEFAULT 0,
FOREIGN KEY (lnum) REFERENCES bio(l_num)
)ENGINE=InnoDB; 

CREATE TABLE IF NOT EXISTS contactinfo
(
lnum int(8),
p_email varchar(50),
phone_num int(11),
PRIMARY KEY (lnum),
FOREIGN KEY (lnum) REFERENCES bio(l_num)
)ENGINE=InnoDB;

#Adding foreign keys------------------------------

ALTER TABLE bio
ADD FOREIGN KEY (hall_id) REFERENCES hall (h_id);

#Adding hall values--------------------------------

INSERT INTO hall 
	(h_id, hallname)
VALUES 
	(00, "OFF CAMPUS"),
	(01, "BISON HALL"),
	(02, "ELAM HALL"),
	(03, "FANNING HALL"),
	(04, "HIGH RISE"),
	(05, "JOHNSON HALL"),
	(06, "SEWELL HALL"),
	(07, "THE VILLAGE")
;

#Adding test subjects-----------------------------

#JANE DOE
INSERT INTO studentusers VALUES (12345678, "JaneDoe@gmail.com", SHA2("LouLouLou_WhereAreYou", 512) );
INSERT INTO bio VALUES (12345678, "DOE", "JANE", "JANIE", 0, 01, NULL, "F", "https://zinoui.com/blog/storing-passwords-securely", "CCT", "Project Management", "Live, Laugh, Love", "Watermelon");
INSERT INTO question VALUES (12345678, 1, "OFTEN", "11:00pm", "SOME", "A LOT", "NEVER", 0, "FRIENDS", "HOT", 4, "ENTP", 1, "MESSY", 1, "QUIET", "1.59", "THE FORCE", "200", "28", 1, 1, 1, "ROUGH"); 
INSERT INTO contactinfo VALUES (12345678, "itsjaneee@hotmail.com", 1766784356);
#GROGNAK THE DESTROYER
INSERT INTO studentusers VALUES (87654321, "thelaw@yahoo.com", SHA2("Amnosia??75", 512) );
INSERT INTO bio VALUES (87654321, "THE DESTROYER", "GROGNAK", "ATT. AT LAW", 0, 01, NULL, "F", "https://youtu.be/dQw4w9WgXcQ", "Public Relations", "LJS", "ill clean the bathroom", "Sarcasm");
DELETE FROM question WHERE (L_num = 87654321);
INSERT INTO question VALUES (87654321, 0, "NEVER", "6:00am", "SOME", "NEVER", "ALWAYS", 1, "NEMESIS", "COLD",  6, "INTF-J", 0, "CLEAN", 0, "LOUD", "6.99", "NO", "666", "01", 0, 0, 0, "GREAT");
INSERT INTO contactinfo VALUES(87654321, "GROGNAK@GROGNAK.com", 1986954976); 

#Testing------------------------------------------
/*
SELECT * FROM studentusers;
SELECT * FROM bio;
SELECT * FROM question;
SELECT * FROM contactinfo;
SELECT * FROM hall;
*/

#Creating stored procedures-----------------------
Delimiter $$
DROP PROCEDURE GetProfile;
CREATE PROCEDURE GetProfile ( IN lnum INT )
BEGIN 
    SELECT
		l_name,
		f_name,
		p_name,
		sex,
		prof_pic,
		college,
		major,
		aboutme,
		allergies 
   FROM bio
   WHERE l_num = lnum;   
   SELECT 
		q_introvert,
		q_study,
        q_bedtime,
        q_guest,
        q_nightguest,
        q_travel,
        q_shared,
        q_relationship,
        q_temp,
        oq_enneagram,
        oq_myersbriggs,
        oq_lightsleep,
        oq_clean,
        oq_nap,
        oq_noise,
        hq_gpa,
        hq_religion,
        hq_act,
        hq_smoke,
        hq_lgbt,
        hq_mental
	FROM herdr.question
	WHERE question.L_num = lnum;
        
END$$
DELIMITER ;  

Delimiter $$
CREATE PROCEDURE CreateStudentAccount ( IN lnum INT(8), mail VARCHAR(50), pswrd BLOB )
BEGIN
	INSERT INTO herdr.studentusers (L_num, email, pwsd)
	VALUES (lnum, mail, SHA2(pwsd, 512) );
END$$
DELIMITER ;  

DELIMITER $$
DROP PROCEDURE UserInfo;
CREATE PROCEDURE UserInfo ( IN lnum INT(8))
BEGIN
	SELECT lnum, email, pswd
	FROM studentusers 
	WHERE l_num = lnum;
END$$
DELIMITER ;

#Testing stored procedures--------------------

Call GetProfile(87654321);
CALL UserInfo(87654321);

