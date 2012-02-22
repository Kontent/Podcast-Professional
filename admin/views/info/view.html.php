<?php
 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @copyright 	(c) 2005-2008 Joseph L. LeBlanc
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined( '_JEXEC' ) or die();

jimport( 'joomla.application.component.view');
jimport( 'joomla.filesystem.path');
jimport( 'joomla.filesystem.folder');

class PodcastViewInfo extends JView {
	public function display()
	{
		$option = $option = JRequest::getCmd('option');
		$params =& JComponentHelper::getParams($option);
		// Joomla 1.6 to JParameter conversion
		if (!$params instanceof JParameter) {
			$params = new JParameter($params->toString('INI'));
		}

		$mediapath = $params->get('mediapath', 'media/com_podcastpro/episodes');

		$this->folder = JPATH_ROOT . '/' . JFolder::makeSafe(JPath::clean($mediapath));
		parent::display();
	}
}
