<?php
 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @copyright 	(c) 2005-2008 Joseph L. LeBlanc
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined('_JEXEC') or die;

function com_install() {
	$db = &JFactory::getDBO();
	$queries = array();

	$db->setQuery("SHOW FIELDS FROM #__podcast");
	$fields = $db->loadObjectList('Field');
	if (!isset($fields['itClosedCaptioned'])) {
		$queries[] = "ALTER TABLE `#__podcast` ADD `itClosedCaptioned` TINYINT(1) NOT NULL DEFAULT '0' AFTER `itDuration`";
	}
	foreach ($queries as $query) {
		$db->setQuery($query);
		if (! $db->query()) {
			echo $db->getErrorMsg(true);
			return false;
		}
	}
	return true;
}
