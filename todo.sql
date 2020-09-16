CREATE DATABASE IF NOT EXISTS todo CHARACTER SET utf8;
USE todo;
CREATE TABLE `person` (
	pid VARCHAR(20) PRIMARY KEY,
	`name` VARCHAR(15) NOT NULL,
	head_sculpture VARCHAR(200)
) ENGINE = INNODB;
CREATE TABLE direct (
	pid VARCHAR(20),
	login_name VARCHAR(50),
	PRIMARY KEY(pid, login_name),
	FOREIGN KEY (pid) REFERENCES person (pid)
) ENGINE = INNODB;
CREATE TABLE `list` (
	lid VARCHAR(20) PRIMARY KEY,
	pid VARCHAR(20),
	`name` VARCHAR(30) NOT NULL,
	FOREIGN KEY (pid) REFERENCES person (pid)
) ENGINE = INNODB;
CREATE TABLE task (
	tid VARCHAR(20) PRIMARY KEY,
	pid VARCHAR(20),
	lid VARCHAR(20),
	content TEXT,
	found_time DATETIME NOT NULL,
	start_time DATETIME NOT NULL,
	deadline DATETIME,
	end_time DATETIME,
	my_day BOOL NOT NULL,
	important BOOL NOT NULL,
	FOREIGN KEY (pid) REFERENCES person (pid),
	FOREIGN KEY (lid) REFERENCES `list` (lid)
) ENGINE = INNODB;

CREATE TABLE step (
	sid VARCHAR(20) PRIMARY KEY,
	tid VARCHAR(20) NOT NULL,
	content TEXT NOT NULL,
	number TINYINT NOT NULL,
	found_time DATETIME NOT NULL,
	end_time DATETIME,
	FOREIGN KEY (tid) REFERENCES task (tid)
) ENGINE = INNODB;
-- 创建“我的一天”视图
CREATE VIEW myday
AS
SELECT (tid, content, my_day, important )
FROM task
WHERE my_day = TRUE AND start_time = ;
SELECT CURRENT_TIMESTAMP();

-- ------------------------------
INSERT INTO person
VALUES(
	CONCAT('exam', CURRENT_TIME), 'exam', 'http://empty.xxx'
);
INSERT INTO `list`
VALUES(
	'all_001', NULL, 'all_person_task'
);

SELECT *
FROM LIST
DELETE 
FROM LIST










