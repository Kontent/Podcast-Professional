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
	if (!isset($fields['ordering'])) {
		$queries[] = "ALTER TABLE `#__podcast` ADD `ordering` INT NOT NULL DEFAULT '0' AFTER `itSubtitle`";
		$ordering = 1;
	}
	foreach ($queries as $query) {
		$db->setQuery($query);
		if (! $db->query()) {
			echo $db->getErrorMsg(true);
			return false;
		}
	}
	if (isset($ordering)) {
		$query = "SELECT id, introtext FROM #__content WHERE introtext LIKE '%{enclose%}%' ORDER BY publish_up ASC";
		$db->setQuery($query);
		$articles = $db->loadObjectList();
		foreach ($articles as $order => $row) {
			preg_match('/\{enclose\s+([^\}]+)\}/u', $row->introtext, $matches);
			$filename = explode(' ', $matches[1]);
			if (empty($filename[0])) continue;
			$query = "UPDATE #__podcast SET ordering={$db->quote($order)} WHERE filename={$db->quote($filename[0])}";
			$db->setQuery($query);
			if (! $db->query()) {
				echo $db->getErrorMsg(true);
				return false;
			}
		}
	}
	return true;
}
