<?php
$query = " 
CREATE TABLE IF NOT EXISTS `_DB_PREFIX_leohook` (
  `id_hook` int(11) NOT NULL,
  `id_module` int(11) NOT NULL,
  `id_shop` int(11) NOT NULL,
  `theme` varchar(50) NOT NULL,
  `name_hook` varchar(100) NOT NULL,
  PRIMARY KEY (`id_hook`,`id_module`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `_DB_PREFIX_leowidgets`(
  `id_leowidgets` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  `params` MEDIUMTEXT,
  `id_shop` int(11) unsigned NOT NULL,
  `key_widget` int(11)  NOT NULL,
  PRIMARY KEY (`id_leowidgets`,`id_shop`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
 
?>