<?php
/**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional Content Plugin
 * @copyright 	(C) 2010-2012 Kontent Design. All rights reserved.
 * @copyright 	(c) 2005-2008 Joseph L. LeBlanc
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined( '_JEXEC' ) or die();

class PlgContentPodcastproInstallerScript {
	function postflight($type, $parent) {
		// Rename manifest file
		$path = $parent->getParent()->getPath('extension_root');
		$name = preg_replace('/^plg_[^_]*_/', '', $parent->get('name'));
		if (JFile::exists("{$path}/{$name}.j25.xml")) {
			if ( JFile::exists("{$path}/{$name}.xml")) JFile::delete("{$path}/{$name}.xml");
			JFile::move("{$path}/{$name}.j25.xml", "{$path}/{$name}.xml");
		}
	}
}
