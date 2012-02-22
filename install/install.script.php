<?php
/**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional
 * @copyright 	(C) 2011 Kontent Design. All rights reserved.
 * @copyright 	(c) 2005-2008 Joseph L. LeBlanc
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined ( '_JEXEC' ) or die ();

// WARNING: this file is in 2 locations!

jimport( 'joomla.filesystem.folder' );
jimport( 'joomla.filesystem.file' );

class Com_PodcastProInstallerScript {
	protected $versions = array(
		'PHP' => array (
			'5.2' => '5.2.4',
		),
		'MySQL' => array (
			'5.0' => '5.0.4',
		),
		'Joomla' => array (
			'2.5' => '2.5.0',
		)
	);
	protected $extensions = array ('gd');

	public function install($parent) {
		$db = JFactory::getDBO();
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

	public function discover_install($parent) {
		return self::install($parent);
	}

	public function update($parent) {
		return self::install($parent);
	}

	public function uninstall($parent) {
		return true;
	}

	public function preflight($type, $parent) {
		// Prevent installation if requirements are not met.
		if (!$this->checkRequirements()) return false;
		return true;
	}

	public function postflight($type, $parent) {
		$installer = $parent->getParent();

		// Rename podcastpro.j25.xml to podcastpro.xml
		$adminpath = JPATH_ADMINISTRATOR . 'components/com_podcastpro';
		if (JFile::exists("{$adminpath}/podcastpro.j25.xml")) {
			if ( JFile::exists("{$adminpath}/podcastpro.xml")) JFile::delete("{$adminpath}/podcastpro.xml");
			JFile::move("{$adminpath}/podcastpro.j25.xml", "{$adminpath}/podcastpro.xml");
		}
		return true;
	}

	// Internal functions

	protected function checkRequirements() {
		$pass = $this->checkVersion('Joomla', JVERSION);
		$pass &= $this->checkVersion('MySQL', JFactory::getDbo()->getVersion ());
		$pass &= $this->checkVersion('PHP', phpversion());
		foreach ($this->extensions as $name) {
			if (!extension_loaded($name)) {
				JFactory::getApplication()->enqueueMessage(sprintf('Missing PHP extension: %s.', $name), 'notice');
				$pass = false;
			}
		}
		return $pass;
	}

	protected function checkVersion($name, $version) {
		foreach ($this->versions[$name] as $major=>$minor) {
			if (version_compare ( $version, $major, "<" )) continue;
			if (version_compare ( $version, $minor, ">=" )) return true;
			break;
		}
		JFactory::getApplication()->enqueueMessage(sprintf('%s %s required (you have %s %s).', $name, $minor, $name, $version), 'notice');
		return false;
	}
}
