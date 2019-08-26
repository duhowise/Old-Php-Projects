SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `hcms` DEFAULT CHARACTER SET latin1 ;
USE `hcms` ;

-- -----------------------------------------------------
-- Table `hcms`.`admin_login`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`admin_login` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(20) NOT NULL ,
  `password` CHAR(128) NOT NULL ,
  `salt` CHAR(128) NOT NULL ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`admin_profile`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`admin_profile` (
  `admin_prof_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `first_name` VARCHAR(50) NOT NULL ,
  `last_name` VARCHAR(50) NOT NULL ,
  `email` LONGTEXT NOT NULL ,
  `user_id` INT(11) NOT NULL ,
  PRIMARY KEY (`admin_prof_id`) ,
  INDEX `user_id_index` (`user_id` ASC) ,
  CONSTRAINT `admin_profile_ibfk_1`
    FOREIGN KEY (`user_id` )
    REFERENCES `hcms`.`admin_login` (`user_id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`page`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`page` (
  `page_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `page_name` VARCHAR(45) NOT NULL ,
  `flag` BINARY(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`page_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`container`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`container` (
  `container_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(45) NOT NULL ,
  `page_id` INT(11) NOT NULL ,
  `content_type` VARCHAR(45) NOT NULL ,
  `content_multi` BINARY(1) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `flag` BINARY(1) NOT NULL DEFAULT '0' ,
  `parent` BINARY(1) NULL DEFAULT NULL ,
  `child` BINARY(1) NULL DEFAULT NULL ,
  `content_format` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`container_id`) ,
  INDEX `fk_page_main_container_page1_idx` (`page_id` ASC) ,
  CONSTRAINT `container_ibfk_1`
    FOREIGN KEY (`page_id` )
    REFERENCES `hcms`.`page` (`page_id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`content` (
  `content_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `created_at` DATETIME NULL DEFAULT NULL ,
  `container_id` INT(11) NOT NULL ,
  `flag` BINARY(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`content_id`) ,
  INDEX `container_id_index` (`container_id` ASC) ,
  CONSTRAINT `content_ibfk_1`
    FOREIGN KEY (`container_id` )
    REFERENCES `hcms`.`container` (`container_id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`login_attempts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`login_attempts` (
  `login_attempts_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `login_attempt_time` VARCHAR(30) NULL DEFAULT NULL ,
  PRIMARY KEY (`login_attempts_id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`multimedia_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`multimedia_content` (
  `multimedia_content_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `url` LONGTEXT NOT NULL ,
  `content_id` INT(11) NOT NULL ,
  PRIMARY KEY (`multimedia_content_id`) ,
  INDEX `fk_multimedia_content_content1_idx` (`content_id` ASC) ,
  CONSTRAINT `multimedia_content_ibfk_1`
    FOREIGN KEY (`content_id` )
    REFERENCES `hcms`.`content` (`content_id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`sub_container`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`sub_container` (
  `sub_container_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `c_container_id` INT(11) NOT NULL ,
  `p_container_id` INT(11) NOT NULL ,
  `flag` BINARY(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`sub_container_id`) ,
  INDEX `container_id_index` (`c_container_id` ASC) ,
  INDEX `p_container_id_index` (`p_container_id` ASC) ,
  CONSTRAINT `sub_container_ibfk_1`
    FOREIGN KEY (`c_container_id` )
    REFERENCES `hcms`.`container` (`container_id` ),
  CONSTRAINT `sub_container_ibfk_2`
    FOREIGN KEY (`p_container_id` )
    REFERENCES `hcms`.`container` (`container_id` ))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`text_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`text_content` (
  `text_content_id` INT(11) NOT NULL AUTO_INCREMENT ,
  `text` LONGTEXT NOT NULL ,
  `content_id` INT(11) NOT NULL ,
  PRIMARY KEY (`text_content_id`) ,
  INDEX `fk_text_content_content1_idx` (`content_id` ASC) ,
  CONSTRAINT `text_content_ibfk_1`
    FOREIGN KEY (`content_id` )
    REFERENCES `hcms`.`content` (`content_id` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

USE `hcms` ;

-- -----------------------------------------------------
-- procedure admin_verify
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `admin_verify`(in usrName varchar(45))
BEGIN
    set @usr_count = (select count(al.user_id) from hcms.admin_login AS al where al.username = usrName);
    if (@usr_count = 1) then
      select * from hcms.admin_login AS al where al.username = usrName;
    elseif (@usr_count = 0) then
      select error_status = 10;

    elseif (@usr_count > 1) then
      select error_status = 11;
    end if;
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure delete_container
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_container`( IN contTag VARCHAR(45))
BEGIN 
    UPDATE hcms.container as c SET c.flag = 1 WHERE c.tag = contTag;
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure delete_content
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_content`(IN cntnt_id INT)
BEGIN
     UPDATE hcms.content AS c SET c.flag = 1 WHERE c.content_id = cntnt_id;
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure delete_page
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_page`( IN pageId INT)
BEGIN
      UPDATE hcms.page AS p SET p.flag = 1;
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_admin_profile
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_admin_profile`(IN usrId INT)
BEGIN
    SELECT * FROM hcms.admin_profile AS prof WHERE prof.user_id = usrId;
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_container
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_container`(in contTag VARCHAR(45))
begin
    select * from hcms.container where hcms.container.tag = contTag and hcms.container.flag = 0;
  end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_containers
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_containers`(in pageName VARCHAR(45))
begin
    SET @pageId = (SELECT p.page_id FROM hcms.page as p WHERE p.page_name = pageName);
    select c.tag from hcms.container AS c where (c.page_id = @pageId and c.flag = 0) AND ((c.child = 0 AND c.parent = 1) or (c.child = 0 AND c.parent = 0));
  end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_content
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_content`(IN cont_id INT,cntntType VARCHAR(45))
BEGIN
      IF cntntType = 'text' THEN 
        SELECT * FROM hcms.content as c JOIN hcms.text_content ON (c.content_id = text_content.content_id) WHERE c.container_id = cont_id AND c.flag = 0;
      ELSEIF cntntType = 'multimedia' THEN
        SELECT * FROM hcms.content as c JOIN hcms.multimedia_content AS mc ON (c.content_id = mc.content_id) WHERE c.container_id = cont_id AND c.flag = 0;
      END IF;
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_main_sub_content
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_main_sub_content`(in containerTag varchar(45), in mc_content_type varchar (45), in sc_content_type varchar (45),in pageName varchar (45))
begin

    if(mc_content_type = 'text') then
/*now we select all content that belongs to a particular page together with its text content*/
/*content and text content join*/
/*obtain mc and sc container ids*/
      if (sc_content_type = 'text')then

        SELECT * FROM
          (SELECT mc_cnt.mc_tag, text.text as mc_text,mc_cnt.content_id FROM (SELECT mc.content_id,mc.container_tag as mc_tag FROM hcms.content AS cont JOIN hcms.main_content AS mc ON (cont.content_id = mc.content_id)
          WHERE mc.container_tag = containerTag ORDER BY cont.created_at DESC) AS mc_cnt
            JOIN hcms.text_content AS text ON (mc_cnt.content_id = text.content_id)) AS main

          join

          (SELECT  cont2.sc_tag, txt.text as sc_text,cont2.mc_content_id from
            (SELECT mc.content_id as mc_content_id,sc.content_id as sc_content_id, sc.container_tag as sc_tag
             from hcms.main_content as mc join hcms.sub_content sc on (mc.main_content_id = sc.main_content_id)
             WHERE mc.container_tag = containerTag) as cont2
            JOIN hcms.text_content as txt join hcms.content AS cnt
              on (cont2.sc_content_id = txt.content_id and cont2.sc_content_id = cnt.content_id) ORDER BY cnt.created_at DESC ) AS sub
            on (main.content_id = sub.mc_content_id);

/*fetch sc_content text*/


      ELSEIF (sc_content_type = 'picture' or sc_content_type = 'video')THEN
/*fetch sc_content url*/
        SELECT * FROM (
                        SELECT mc_cnt.mc_tag, multi.url as mc_url,mc_cnt.content_id FROM (SELECT mc.content_id,mc.container_tag as mc_tag FROM hcms.content AS cont JOIN hcms.main_content AS mc ON (cont.content_id = mc.content_id)
                        WHERE mc.container_tag = containerTag ORDER BY cont.created_at DESC) AS mc_cnt
                          JOIN hcms.multimedia_content AS multi ON (mc_cnt.content_id = multi.content_id)) AS main

          join

          (SELECT  cont2.sc_tag, multi.url as sc_url,cont2.mc_content_id from
            (SELECT mc.content_id as mc_content_id,sc.content_id as sc_content_id, sc.container_tag as sc_tag
             from hcms.main_content as mc join hcms.sub_content sc on (mc.main_content_id = sc.main_content_id)
             WHERE mc.container_tag = containerTag) as cont2
            JOIN hcms.multimedia_content as multi join hcms.content AS cnt
              on (cont2.sc_content_id = multi.content_id and cont2.sc_content_id = cnt.content_id) ORDER BY cnt.created_at DESC ) AS sub
            on (main.content_id = sub.mc_content_id);

      END IF;


    elseif (mc_content_type = 'picture' or mc_content_type = 'video') then
/*now we select all content that belongs to a particular page together with its multimedia content

/*obtain mc and sc container ids*/
      if (sc_content_type = 'text')then

        SELECT * FROM (
                        SELECT mc_cnt.mc_tag, multi.url as mc_url,mc_cnt.content_id FROM (SELECT mc.content_id,mc.container_tag as mc_tag FROM hcms.content AS cont JOIN hcms.main_content AS mc ON (cont.content_id = mc.content_id)
                        WHERE mc.container_tag = containerTag ORDER BY cont.created_at DESC) AS mc_cnt
                          JOIN hcms.multimedia_content AS multi ON (mc_cnt.content_id = multi.content_id)) AS main

          join

          (SELECT  cont2.sc_tag, txt.text as sc_text,cont2.mc_content_id from
            (SELECT mc.content_id as mc_content_id,sc.content_id as sc_content_id, sc.container_tag as sc_tag
             from hcms.main_content as mc join hcms.sub_content sc on (mc.main_content_id = sc.main_content_id)
             WHERE mc.container_tag = containerTag) as cont2
            JOIN hcms.text_content as txt join hcms.content AS cnt
              on (cont2.sc_content_id = txt.content_id and cont2.sc_content_id = cnt.content_id) ORDER BY cnt.created_at DESC ) AS sub
            on (main.content_id = sub.mc_content_id);

/*fetch sc_content text*/


      ELSEIF (sc_content_type = 'picture' or sc_content_type = 'video')THEN
/*fetch sc_content url*/
        SELECT * FROM (
                        SELECT mc_cnt.mc_tag, multi.url as mc_url,mc_cnt.content_id FROM (SELECT mc.content_id,mc.container_tag as mc_tag FROM hcms.content AS cont JOIN hcms.main_content AS mc ON (cont.content_id = mc.content_id)
                        WHERE mc.container_tag = containerTag ORDER BY cont.created_at DESC) AS mc_cnt
                          JOIN hcms.multimedia_content AS multi ON (mc_cnt.content_id = multi.content_id)) AS main

          join

          (SELECT  cont2.sc_tag, multi.url as sc_url,cont2.mc_content_id from
            (SELECT mc.content_id as mc_content_id,sc.content_id as sc_content_id, sc.container_tag as sc_tag
             from hcms.main_content as mc join hcms.sub_content sc on (mc.main_content_id = sc.main_content_id)
             WHERE mc.container_tag = containerTag) as cont2
            JOIN hcms.multimedia_content as multi join hcms.content AS cnt
              on (cont2.sc_content_id = multi.content_id and cont2.sc_content_id = cnt.content_id) ORDER BY cnt.created_at DESC ) AS sub
            on (main.content_id = sub.mc_content_id);

      END IF;


    end if;


  end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_page
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_page`(IN pgeName VARCHAR(45))
BEGIN
    select * from hcms.page AS p WHERE p.page_name = pgeName;
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_pages
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_pages`()
BEGIN
    select * from hcms.page;
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_singular_content
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_singular_content`(in containerTag varchar(45), in contentType varchar (45),in pageName varchar (45))
begin

    if(contentType = 'text') then
/*now we select all content that belongs to a particular page together with its text content*/
      SELECT cnt1.text from (select txt.text,cnt.content_id from hcms.content as cnt join hcms.text_content as txt on (cnt.content_id = txt.content_id)
      where cnt.page_id = (select hcms.page.page_id from hcms.page where hcms.page.page_name = pageName) ORDER BY cnt.created_at DESC) as cnt1
        join hcms.main_content as mc on (cnt1.content_id = mc.content_id) where mc.container_tag = containerTag;


    elseif (contentType = 'picture' or contentType = 'video')then
/*now we select all content that belongs to a particular page together with its multimedia content*/
      SELECT cnt1.url from (select multi.url,cnt.content_id from hcms.content as cnt join hcms.multimedia_content as multi on (cnt.content_id = multi.content_id)
      where cnt.page_id = (select hcms.page.page_id from hcms.page where hcms.page.page_name = pageName) ORDER BY cnt.created_at DESC) as cnt1
        join hcms.main_content as mc on (cnt1.content_id = mc.content_id) where mc.container_tag = containerTag;

    end if;

  end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure fetch_sub_containers
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_sub_containers`(in contId int)
begin
      SELECT * FROM hcms.container as c JOIN hcms.sub_container as sc ON (c.container_id = sc.c_container_id) WHERE sc.p_container_id = contId and c.flag = 0;
    end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure hcms_login_check
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `hcms_login_check`(in usr varchar (20))
begin
    if((select count(*) from hcms.hcms_user_login where hcms.hcms_user_login.username = usr limit 1) = 1)
    then
/*we have a user so we select his or her password*/
      select hcms.hcms_user_login.password,hcms.hcms_user_login.salt from hcms.hcms_user_login where hcms.hcms_user_login.username = usr;
    elseif ((select count(*) from hcms.hcms_user_login where hcms.hcms_user_login.username = usr limit 1) > 1)
      then
/*we have a user who has more than one account. what do we do when that happens*/
        select 1;
    else
      select 0;
    end if;
  end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insert_admin
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_admin`(IN fName VARCHAR(50), IN lName VARCHAR(50),in usrName varchar(20), in userPassword char(128), in userSalt CHAR(128), IN adminemail TEXT,in createdAt TIMESTAMP)
BEGIN
    insert into hcms.admin_login(username,password,salt,created_at) values (usrName,userPassword,userSalt,createdAt);
    set @usrId = (SELECT u.user_id from hcms.admin_login AS u where u.created_at = createdAt and u.salt = userSalt);
    INSERT INTO hcms.admin_profile (first_name, last_name, email, user_id) VALUES (fName,lName,adminemail,@usrId);
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insert_container
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_container`( IN contTag VARCHAR(45), IN pageName VARCHAR(45), IN cntntType VARCHAR(45), IN cntntFormat VARCHAR(45),IN multi BINARY, IN createdAt DATETIME, IN prnt BINARY, IN chld BINARY)
BEGIN
    SET @pageId = (SELECT p.page_id FROM hcms.page as p WHERE p.page_name = pageName);
    INSERT INTO hcms.container (tag, page_id, content_type, content_multi, created_at,parent, child, content_format) 
      VALUES (contTag,@pageId,cntntType,multi,createdAt,prnt,chld,cntntFormat);
    END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insert_content
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_content`(IN contId INT, IN cntnt_type VARCHAR(45), IN txt TEXT, IN uri TEXT, IN createdAt DATETIME)
BEGIN
    INSERT INTO hcms.content (created_at, container_id) VALUES (createdAt,contId);
    
    SET @cntntId = (SELECT c.content_id FROM hcms.content as c WHERE c.created_at = createdAt AND c.container_id = contId);
    
    IF cntnt_type = 'text' THEN
      INSERT INTO hcms.text_content (text, content_id) VALUES (txt,@cntntId);
    ELSEIF cntnt_type = 'multimedia' THEN
      INSERT INTO hcms.multimedia_content (url, content_id) VALUES (uri,@cntntId);
    END IF;
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insert_contents
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_contents`(in content text, in containerTag varchar (45), in contentType varchar (45), in pageName varchar (45),in containerType varchar(45), in createdAt timestamp )
begin

/**************************************
first we insert into the content table
*/
    insert into hcms.content(content_type,container_type,created_at,page_id)
    values(contentType,containerType,createdAt,(select hcms.page.page_id from hcms.page where hcms.page.page_name = pageName));

/*****************
obtain content_id
*/
    set @contentId = (select hcms.content.content_id from hcms.content
    where hcms.content.content_type = contentType and hcms.content.container_type = containerType and hcms.content.created_at = createdAt);

    if(contentType = 'text') then
/*************************************
insert content into text content table
*/
      insert into hcms.text_content (text,content_id)
      values(content,@contentId);

    elseif (contentType = 'multimedia') then
/************************************************
insert content into the multimedia content table
*/
      insert into hcms.multimedia_content (url,content_id)
      values(content,@contentId);
    end if;

/************************************************************************************
insert container tags into their respective containers together with their content ids
*/
    if(containerType = 'main_container')then
      insert into hcms.main_content (container_tag, content_id)
      VALUES (containerTag,@contentId);

    ELSEIF (containerType = 'sub_container')THEN
/***************************************
obtain content_id for the main container
*/
      set @mc_contentId = (select hcms.content.content_id from hcms.content
      where hcms.content.container_type = 'main_container' and hcms.content.created_at = createdAt);

/*******************************************************************************************
insert sub container tag into sub content with its corresponding content and main_content id
*/
      insert into hcms.sub_content (container_tag, content_id,main_content_id)
      VALUES (containerTag,@contentId,(select hcms.main_content.main_content_id from hcms.main_content
      where hcms.main_content.content_id = (@mc_contentId)));
    END IF;

  end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insert_page
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_page`(in pageName varchar(45))
BEGIN
/*
      insert page data into the page table
      */
    insert into hcms.page (page_name) value (pageName);
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insert_sub_container
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sub_container`(in ptag VARCHAR(45), IN ctag VARCHAR(45))
BEGIN
    SET @ccid = (SELECT c.container_id FROM hcms.container as c WHERE c.tag = ctag);
    SET @pcid = (SELECT c.container_id FROM hcms.container as c WHERE c.tag = ptag);
  
    insert into hcms.sub_container (c_container_id, p_container_id)
    values(@ccId, @pcId);
  END$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure insert_user
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_user`(IN USR_USERNAME VARCHAR (20),
                                                          IN USR_PASSWORD VARCHAR (10),
                                                          IN USR_SALT VARCHAR (32), in log_date datetime)
BEGIN
    INSERT INTO HCMS.hcms_user_login (username,password,salt,created_at) value (USR_USERNAME,USR_PASSWORD,USR_SALT,log_date);
  END$$

DELIMITER ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
