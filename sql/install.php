<?php

	// Init
	$sql = array();

	// Create Table in Database
	$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'answerandwin` (
`id` INT( 10 ) UNSIGNED NOT NULL ,
`question` VARCHAR( 255 ) NOT NULL ,
`response` VARCHAR( 255 ) NOT NULL ,
`fk_id_rule` INT( 10 ) UNSIGNED NOT NULL ,
`count_offer` INT UNSIGNED NOT NULL ,
`max_offer` INT UNSIGNED NOT NULL ,
`active` INT UNSIGNED NOT NULL ,
`amount` DECIMAL( 17, 2 ) NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = '._MYSQL_ENGINE_.' ;';
	