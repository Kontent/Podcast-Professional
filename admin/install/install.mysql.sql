-- WARNING: this file is in 2 locations!

CREATE TABLE IF NOT EXISTS `#__podcast` (
  `podcast_id` int(11) NOT NULL auto_increment,
  `filename` varchar(255) NOT NULL,
  `itAuthor` varchar(255) NOT NULL default '',
  `itBlock` tinyint(1) NOT NULL default '0',
  `itCategory` varchar(255) NOT NULL default '',
  `itDuration` varchar(10) NOT NULL default '',
  `itClosedCaptioned` tinyint(1) NOT NULL default '0',
  `itExplicit` tinyint(1) NOT NULL default '0',
  `itKeywords` varchar(255) NOT NULL default '',
  `itSubtitle` varchar(255) NOT NULL default '',
  `ordering` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`podcast_id`)
);