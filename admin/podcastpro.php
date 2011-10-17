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

// Access check.
if (version_compare(JVERSION, '1.6', '>')) {
	if (!JFactory::getUser()->authorise('core.manage', 'com_podcastpro')) {
		return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	}
}

jimport('joomla.application.component.controller');

// Require specific controller if it exists
$controller = JRequest::getWord('view', 'files');
$path = JPATH_COMPONENT."/controllers/{$controller}.php";
if (file_exists($path)) {
	require_once $path;
} else {
	require_once JPATH_COMPONENT."/controllers/podcastpro.php";
	$controller = '';
}
$controllername = 'PodcastController'.$controller;
$controller = new $controllername();
$controller->execute( JRequest::getCmd ( 'task' ) );
$controller->redirect();
