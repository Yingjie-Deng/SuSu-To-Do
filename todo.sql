CREATE DATABASE IF NOT EXISTS todo CHARACTER SET utf8;

-- 初始建表语句
-- 后期有修改
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
-- **说明
-- 仅展示当天开始的任务，若跨度时间超过一天的仅开始当天显示
-- **“重要”同
CREATE VIEW myday
AS
SELECT tid, task.pid, content, important AS `import`, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.lid = `list`.lid
WHERE my_day = TRUE AND task.`start_time` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY);
SELECT CURRENT_TIMESTAMP();
SELECT CURDATE();

DROP VIEW IF EXISTS overdue;

-- ------------------------------
-- 修改task表的lid字段默认值为all_001
ALTER TABLE `task` CHANGE COLUMN `lid` `lid` VARCHAR(20) DEFAULT 'all_001';

-- 
ALTER TABLE `person` CHANGE COLUMN `pid` `pid` VARCHAR(50) PRIMARY KEY;
DESC LIST;
ALTER TABLE `list` CHANGE COLUMN `lid` `lid` VARCHAR(150) PRIMARY KEY;

-- -------------------------------------------
-- 创建“重要”视图
-- 
CREATE VIEW important
AS
SELECT tid, task.pid, content, my_day, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.lid = `list`.`lid`
WHERE task.`important` = TRUE AND task.`start_time` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY);

-- ----------------------------------------------
-- 创建“往昔”视图
-- **说明
-- 展示昨天需要或者应当做的任务，包括跨度时间长的，过了开始当天的也一同展示
-- ** “today” 、 “谜”同
CREATE VIEW yesterday
AS
SELECT tid, task.pid, content, my_day, important AS `import`, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.`lid` = `list`.`lid`
WHERE task.`start_time` BETWEEN DATE_SUB(CURDATE(),INTERVAL 1 DAY) AND CURDATE();

-- ---------------------------------------------------
-- 创建“当下（today）”视图
CREATE VIEW today
AS
SELECT tid, task.`pid`, content, my_day, important AS `import`, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.`lid` = `list`.`lid`
WHERE task.`start_time` BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY);

-- 创建“明天->谜”视图
CREATE VIEW mystery
AS
SELECT tid, task.`pid`, content, my_day, important AS `import`, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.`lid` = `list`.`lid`
WHERE task.`start_time` BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 DAY) AND DATE_ADD(CURDATE(), INTERVAL 2 DAY);

-- 创建“已完成”视图
CREATE VIEW completed
AS
SELECT tid, task.`pid`, content, my_day, important AS `import`, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.`lid` = `list`.`lid`
WHERE end_time;

-- 创建“全部”视图
-- **说明
-- 展示当前需要做的所有任务，不展示已完成的任务，不展示逾期未完成的任务
-- 即未过截止日期的未完成任务
-- 按照清单分别展示
-- 按创建时间降序展示同清单任务
CREATE VIEW `all`
AS
SELECT tid, task.`pid`, content, my_day, important AS `import`, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.`lid` = `list`.`lid`
WHERE NOT(end_time) AND deadline >= CURRENT_TIMESTAMP()
ORDER BY `list`.`lid` DESC, task.`found_time` DESC;

DROP VIEW IF EXISTS `overdue`;
SELECT * FROM `all`;
-- 创建“逾期未完成”视图
-- **说明
-- 按照清单分类展示
-- 同清单的任务，按创建时间降序展示
CREATE VIEW overdue
AS
SELECT tid, task.`pid`, content, my_day, important AS `import`, `list`.`name` AS listName, found_time, deadline, start_time, end_time
FROM task JOIN `list` ON task.`lid` = `list`.`lid`
WHERE NOT (end_time) AND deadline < CURRENT_TIMESTAMP()
ORDER BY `list`.`name` ASC, task.`found_time` DESC;

-- 创建“用户信息视图”
CREATE VIEW personInfo
AS
SELECT person.`pid`, person.`name`, person.`head_sculpture`, login_name
FROM person JOIN direct ON person.`pid` = direct.`pid`
-- WHERE person.pid = 'exam09:47:25'
-- ORDER BY login_name DESC
-- LIMIT 1;

ALTER TABLE `direct` ADD `password` VARCHAR(20) NOT NULL;

INSERT INTO person
VALUES(
	CONCAT('exam', CURRENT_TIME), 'exam', 'http://empty.xxx'
);
INSERT INTO `list`
VALUES(
	'all_001', NULL, 'all_person_task'
);
INSERT INTO task
VALUES(
	'125845', 'exam09:47:25', 'all_001', 'fdgadfgd', '2020-9-29 9:10', '2020-9-29 10:30', '2020-10-5 20:30', NULL, TRUE,TRUE
);

SELECT *
FROM person
DELETE 
FROM LIST
SELECT *
FROM direct
WHERE pid = 'exam09:47:25';
SELECT DATE_SUB(CURDATE(),INTERVAL 1 DAY) ;
SELECT DATE_SUB(CURDATE(), INTERVAL -1 DAY);
SELECT DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL -1 DAY);
SELECT TIME();
SELECT * FROM personInfo WHERE pid = 'test09:37:39'
DESC task

DELETE FROM person
WHERE NAME = '邓英杰';

DELETE FROM direct
WHERE pid LIKE '%邓英杰%';
SELECT pid FROM direct WHERE `login_name`='18608240560' AND `password`='123456';
SELECT * FROM personInfo WHERE `pid` = 邓英杰1601719731 ORDER BY `login_name` DESC;










