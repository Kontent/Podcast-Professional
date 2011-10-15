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

jimport('joomla.application.component.controller');

class PodcastController extends JController
{
	function display()
	{		
		$view = JRequest::getVar('view', '');
		
		if ($view == '') {
			JRequest::setVar('view', 'feed');
		}
		
		parent::display();
	}
}

$document =& JFactory::getDocument();
$document->setType('raw');

$controller = new PodcastController();
$controller->execute(JRequest::getVar('task', null));
$controller->redirect();