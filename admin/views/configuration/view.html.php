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

class PodcastViewConfiguration extends JView {
	public function display($tpl = null) {
		$this->option = $option = JRequest::getCmd('option');
		$params =& JComponentHelper::getParams($option);
		// Joomla 1.6 to JParameter conversion
		if (!$params instanceof JParameter) {
			$params = new JParameter($params->toString('INI'));
		}
		$params->loadSetupFile(JPATH_COMPONENT.'/config.xml');

		$this->assignRef('params', $params);
		parent::display($tpl);
	}
}
