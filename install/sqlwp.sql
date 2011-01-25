CREATE TABLE `##PREFIX##dev_modules` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `type` int(1) NOT NULL,
  `version` float NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `datarelease` varchar(255) NOT NULL,
  `depends` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `##PREFIX##dev_modules` VALUES (null,'register','Modulo utile per avere degli utenti registrati al sito.',1,1,0,'','','','',''),(null,'users','',1,1,0,'','','','','');

CREATE TABLE `##PREFIX##dev_themewidgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idtheme` int(11) NOT NULL,
  `widgetname` varchar(255) NOT NULL,
  `widgetarea` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `##PREFIX##dev_themewidgets` VALUES (null,1,'login','right',1),(null,1,'menu','right',2),(null,1,'blogcategories','right',3);

CREATE TABLE `##PREFIX##dev_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `##PREFIX##dev_groups` VALUES (1,'Administrator','Able to do Everything'),(2,'User','Able to login'),(3,'Banned','Banned from the site'),(13,'CustomerAdmin','admin');

CREATE TABLE `##PREFIX##dev_menus` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `type` int(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `view` tinyint(1) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

INSERT INTO `##PREFIX##dev_menus` VALUES (4,1,'Registrati',0,'register',2,0),(5,1,'ACP',3,'acp',4,0),(13,2,'acp',3,'acp',1,0),(14,2,'home',1,'index.php',3,0),(20,100,'dashboard_modify',1,'?m=mod',2,0),(21,100,'dashboard',1,'index.php',1,0),(22,101,'repositorycfg',1,'?p=cfg&m=reposerver',4,0),(23,101,'linkscfg',1,'?p=cfg&m=links',3,0),(24,101,'modcfg',1,'?p=cfg&m=mod',2,0),(25,101,'viewcfg',1,'?p=cfg',1,0),(30,103,'modadd',1,'?p=mod&m=search',2,0),(31,103,'modview',1,'?p=mod',1,0),(32,102,'tplmanage',1,'?p=tpl',1,0),(33,102,'modify',1,'?p=tpl&m=modify',2,0),(34,104,'users_manage',1,'?p=mod&mod=users',1,59),(35,104,'users_groups',1,'?p=mod&mod=users&m=groups',2,59),(47,100,'dashboard_errors',1,'?m=errors',3,0),(48,3,'Dashboard',1,'acp/index.php',1,0),(49,3,'Configuration',1,'acp/?p=cfg',2,0),(50,3,'Design',1,'acp/?p=tpl',3,0),(51,3,'Modules',1,'acp/?p=mod',4,0),(59,104,'Users',1,'0',0,0);

CREATE TABLE `##PREFIX##dev_servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `##PREFIX##dev_servers` VALUES (null,'http://repo.anecms.com/server.php');

CREATE TABLE `##PREFIX##dev_usersgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `idgroup` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `##PREFIX##dev_usersgroups` VALUES (null,1,1),(null,1,2);

CREATE TABLE `##PREFIX##dev_users` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `language` varchar(15) NOT NULL,
  `skin` varchar(15) NOT NULL,
  `groups` text NOT NULL,
  `status` varchar(1) NOT NULL,
  `web` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `##PREFIX##dev_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `widgetarea` text,
  `type` int(11) NOT NULL,
  `css` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8;

INSERT INTO `##PREFIX##dev_themes` VALUES (null,'default','a:1:{i:0;s:5:\"right\";}',1,''),(null,'admintasia','',2,'');

CREATE TABLE `##PREFIX##dev_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `text` text NOT NULL,
  `date` int(20) NOT NULL,
  `who` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `##PREFIX##dev_adminlog` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `user` int(7) NOT NULL,
  `date` int(12) NOT NULL,
  `text` varchar(255) NOT NULL,
  `ip` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `##PREFIX##dev_general` (
  `id` int(1) NOT NULL,
  `language` varchar(2) NOT NULL,
  `status` int(1) NOT NULL,
  `title` varchar(30) NOT NULL,
  `descr` varchar(255) NOT NULL,
  `skin` varchar(30) NOT NULL,
  `default_module` varchar(60) NOT NULL,
  `url_base` varchar(255) NOT NULL,
  `acp_skin` varchar(50) NOT NULL,
  `acpajax` int(1) NOT NULL,
  `notes` text NOT NULL,
  `version` varchar(5) NOT NULL,
  `twitter_user` varchar(255) NOT NULL,
  `twitter_password` varchar(255) NOT NULL,
  `akismetkey` varchar(255) NOT NULL,
  `infoclosed` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
