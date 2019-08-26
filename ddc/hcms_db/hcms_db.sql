SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

drop database hcms;
CREATE SCHEMA IF NOT EXISTS `hcms` DEFAULT CHARACTER SET latin1 ;
USE `hcms` ;

-- -----------------------------------------------------
-- Table `hcms`.`page`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`page` (
  `page_id` INT NOT NULL AUTO_INCREMENT ,
  `page_name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`page_id`) )
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`content` (
  `content_id` INT NOT NULL AUTO_INCREMENT ,
  `content_type` VARCHAR(45) NOT NULL ,
  `container_type` VARCHAR(45) NOT NULL ,
  `page_id` INT NOT NULL ,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`content_id`) ,
  INDEX `fk_content_page1_idx` (`page_id` ASC) ,
  CONSTRAINT `fk_content_page1`
  FOREIGN KEY (`page_id` )
  REFERENCES `hcms`.`page` (`page_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`hcms_user_login`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`hcms_user_login` (
  `user_id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(20) NOT NULL ,
  `password` VARCHAR(10) NOT NULL ,
  `salt` VARCHAR(45) NOT NULL ,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  PRIMARY KEY (`user_id`) )
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`main_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`main_content` (
  `main_content_id` INT NOT NULL AUTO_INCREMENT ,
  `container_tag` VARCHAR(45) NOT NULL ,
  `content_id` INT NOT NULL ,
  PRIMARY KEY (`main_content_id`) ,
  INDEX `fk_content_main_content_idx` (`content_id` ASC) ,
  CONSTRAINT `fk_content_main_content`
  FOREIGN KEY (`content_id` )
  REFERENCES `hcms`.`content` (`content_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`multimedia_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`multimedia_content` (
  `multimedia_content_id` INT NOT NULL AUTO_INCREMENT ,
  `url` TEXT NOT NULL ,
  `content_id` INT NOT NULL ,
  PRIMARY KEY (`multimedia_content_id`) ,
  INDEX `fk_multimedia_content_content1_idx` (`content_id` ASC) ,
  CONSTRAINT `fk_multimedia_content_content1`
  FOREIGN KEY (`content_id` )
  REFERENCES `hcms`.`content` (`content_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`page_main_container`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`page_main_container` (
  `page_main_container_id` INT NOT NULL AUTO_INCREMENT ,
  `page_main_container_tag` VARCHAR(45) NOT NULL ,
  `page_id` INT NOT NULL ,
  `main_content_type` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`page_main_container_id`) ,
  INDEX `fk_page_main_container_page1_idx` (`page_id` ASC) ,
  CONSTRAINT `fk_page_main_container_page1`
  FOREIGN KEY (`page_id` )
  REFERENCES `hcms`.`page` (`page_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`page_sub_container`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`page_sub_container` (
  `page_sub_container_id` INT NOT NULL AUTO_INCREMENT ,
  `sub_container_tag` VARCHAR(20) NOT NULL ,
  `page_main_container_id` INT NOT NULL ,
  `sub_content_type` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`page_sub_container_id`) ,
  INDEX `fk_page_sub_container_page_main_container1_idx` (`page_main_container_id` ASC) ,
  CONSTRAINT `fk_page_sub_container_page_main_container1`
  FOREIGN KEY (`page_main_container_id` )
  REFERENCES `hcms`.`page_main_container` (`page_main_container_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`sub_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`sub_content` (
  `sub_content_id` INT NOT NULL AUTO_INCREMENT ,
  `container_tag` VARCHAR(45) NOT NULL ,
  `content_id` INT NOT NULL ,
  `main_content_id` INT NOT NULL ,
  PRIMARY KEY (`sub_content_id`) ,
  INDEX `fk_sub_content_content1_idx` (`content_id` ASC) ,
  INDEX `fk_sub_content_main_content1_idx` (`main_content_id` ASC) ,
  CONSTRAINT `fk_sub_content_content1`
  FOREIGN KEY (`content_id` )
  REFERENCES `hcms`.`content` (`content_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sub_content_main_content1`
  FOREIGN KEY (`main_content_id` )
  REFERENCES `hcms`.`main_content` (`main_content_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `hcms`.`text_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `hcms`.`text_content` (
  `text_content_id` INT NOT NULL AUTO_INCREMENT ,
  `text` TEXT NOT NULL ,
  `content_id` INT NOT NULL ,
  PRIMARY KEY (`text_content_id`) ,
  INDEX `fk_text_content_content1_idx` (`content_id` ASC) ,
  CONSTRAINT `fk_text_content_content1`
  FOREIGN KEY (`content_id` )
  REFERENCES `hcms`.`content` (`content_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;

USE `hcms` ;

-- -----------------------------------------------------
-- procedure fetch_main_container
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_main_container`(in pge_id int)
  begin
    select * from hcms.container where hcms.container.page_id = pge_id;
  end$$

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
          (SELECT mc_cnt.mc_tag, text.text as mc_text,mc_cnt.content_id FROM
            (SELECT mc.content_id,mc.container_tag as mc_tag FROM hcms.content AS cont
              JOIN hcms.main_content AS mc ON (cont.content_id = mc.content_id)
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


      ELSEIF (sc_content_type = 'picture' or sc_content_type = 'video') THEN
/*fetch sc_content url*/
        SELECT * FROM (SELECT mc_cnt.mc_tag, multi.url as mc_url,mc_cnt.content_id FROM (SELECT mc.content_id,mc.container_tag as mc_tag FROM hcms.content AS cont JOIN hcms.main_content AS mc ON (cont.content_id = mc.content_id)
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
/*now we select all content that belongs to a particular page together with its multimedia content*/

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_page`()
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
-- procedure fetch_sub_container
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `fetch_sub_container`(in pmc_id int)
  begin
    select hcms.page_sub_container.sub_container_tag, hcms.page_sub_container.sub_content_type from hcms.page_sub_container where hcms.page_sub_container.page_main_container_id = pmc_id;
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
-- procedure insert_content
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_content`(in content text, in containerTag varchar (45), in contentType varchar (45), in pageName varchar (45),in containerType varchar(45), in createdAt timestamp )
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
-- procedure insert_main_container
-- -----------------------------------------------------

DELIMITER $$
USE `hcms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_main_container`(in tag varchar (45),in pageName varchar (45), in contentType varchar (45))
  BEGIN
/*
     insert page_id together with the container_tag and content_type into the main_container database
     */
    insert into hcms.page_main_container (page_main_container_tag, page_id,main_content_type)
    values(tag,(select hcms.page.page_id from hcms.page where hcms.page.page_name = pageName),contentType);
  END$$

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
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_sub_container`(in tag varchar (45),in main_container_tag varchar (45),in pageName varchar (45), in contentType varchar (45))
  BEGIN
    insert into hcms.page_sub_container (sub_container_tag, sub_content_type, page_main_container_id)
    values(tag,contentType,(select hcms.page_main_container.page_main_container_id from hcms.page_main_container
    where hcms.page_main_container.page_main_container_tag = main_container_tag and
          hcms.page_main_container.page_id = (select hcms.page.page_id from hcms.page where hcms.page.page_name = pageName)));
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
