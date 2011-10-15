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

class PodcastViewFiles extends JView {
	public function display($tpl = null) {
		$option = JRequest::getCmd('option');
		$params =& JComponentHelper::getParams($option);
		$app =& JFactory::getApplication();

		$filter_state		= $app->getUserStateFromRequest( $option.'filter_state',		'filter_state',		'',				'word' );
		$filter_order		= $app->getUserStateFromRequest( $option.'filter_order',		'filter_order',		'filename',	'cmd' );
		$filter_order_Dir	= $app->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'asc',				'word' );
		$search				= $app->getUserStateFromRequest( $option.'search',			'search',			'',				'string' );
		if (strpos($search, '"') !== false) {
			$search = str_replace(array('=', '<'), '', $search);
		}
		$search = JString::strtolower($search);

		// sanitize $filter_order
		if (!in_array($filter_order, array('filename', 'published', 'metadata'))) {
			$filter_order = 'filename';
		}

		if (!in_array(strtoupper($filter_order_Dir), array('asc', 'desc'))) {
			$filter_order_Dir = 'asc';
		}
		
		$filter_published = $app->getUserStateFromRequest($option . 'filter_published', 'filter_published', '*', 'word');
		$filter_metadata = $app->getUserStateFromRequest($option . 'filter_metadata', 'filter_metadata', '*', 'word');

		$filter = array();
		$filter['published'] = PodcastViewFiles::filter($filter_published, JText::_('COM_PODCASTPRO_PUBLISHED'), JText::_('COM_PODCASTPRO_UNPUBLISHED'), JText::_('COM_PODCASTPRO_PUBLISHED'), 'filter_published');
		$filter['metadata'] = PodcastViewFiles::filter($filter_metadata, JText::_('COM_PODCASTPRO_HAS_METADATA'), JText::_('COM_PODCASTPRO_NO_METADATA'), JText::_('COM_PODCASTPRO_METADATA'), 'filter_metadata');

		// state filter
		$lists['state']	= JHTML::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['search']= $search;
		
		
		$data =& $this->get('data');
		$folder = $this->get('folder');
		$pagination =& $this->get('pagination');
		$hasSpaces = $this->get('hasSpaces');
		
		$this->assignRef('params', $params);
		$this->assignRef('filter', $filter);
		$this->assignRef('lists', $lists);
		$this->assignRef('data', $data);
		$this->assignRef('folder', $folder);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('hasSpaces', $hasSpaces);

		parent::display($tpl);
	}

	// based on JHTMLGrid::state
	private static function filter($filter_state = '*', $state1, $state2, $desc, $requestVar = 'filter_state') {
		$state[] = JHTML::_('select.option', '*', '- ' . $desc . ' -');
		$state[] = JHTML::_('select.option', 'on', $state1);
		$state[] = JHTML::_('select.option', 'off', $state2);
		
		return JHTML::_('select.genericlist', $state, $requestVar, 'class="inputbox" size="1" onchange="submitform( );"', 'value', 'text', $filter_state);
	}
}
