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

JTable::addIncludePath( JPATH_COMPONENT.'/tables' );

class PodcastController extends JController
{
	public function __construct($config = array()) {
		parent::__construct($config);
		$this->registerTask( 'edit', 'display');
		$this->registerTask( 'add' , 'display' );
	}

	function upload() {
		$format = JRequest::getString('format', 'html');
		if ($format !== 'json') {
			return $this->setRedirect('index.php?option=com_podcastpro&view=files&layout=upload');
		}
		$params =& JComponentHelper::getParams('com_podcastpro');
		$mediapath = $params->get('mediapath', 'media/com_podcastpro/episodes');

		require_once JPATH_COMPONENT.'/classes/upload.php';
		$upload = PodcastProUpload::getInstance();
		$upload->ajaxUpload($mediapath);
	}

	function delete() {
		JRequest::checkToken('GET') or jexit( 'Invalid Token' );

		jimport('joomla.filesystem.file');

		$params =& JComponentHelper::getParams('com_podcastpro');
		$mediapath = $params->get('mediapath', 'media/com_podcastpro/episodes');

		$cid = JRequest::getVar ( 'cid', array (), 'get', 'array' );
		$success = false;
		if (empty($cid)) {
			$message = JText::_('COM_PODCASTPRO_NO_FILES_SELECTED');
		} else foreach ($cid as $filename) {
			$fileclean = JFile::makeSafe((string) $filename);
			if ($fileclean == $filename) {
				$filepath = JPATH_ROOT.'/'.$mediapath.'/'.$filename;
				if (file_exists($filepath)) {
					if (JFile::delete($filepath)) {
						$message = JText::sprintf('COM_PODCASTPRO_FILE_DELETED', $filename);
						$db =& JFactory::getDBO();
						$query = "DELETE FROM #__podcast WHERE filename={$db->quote($filename)}";
						$db->setQuery($query);
						$db->query();

						$success = true;
					} else {
						$message = JText::sprintf('COM_PODCASTPRO_FILE_DELETE_FAILED', $filename);
					}
				} else {
					$message = JText::sprintf('COM_PODCASTPRO_FILE_NOT_FOUND', $filename);
				}
			} else {
				$message = JText::sprintf('COM_PODCASTPRO_FILE_NOT_CLEAN', $filename);
			}
		}
		$this->setRedirect('index.php?option=com_podcastpro', $message, $success ? null : 'notice');
	}

	function &save()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$row =& JTable::getInstance('podcast', 'Table');

		$post = JRequest::get('post');

		if(!$row->bind($post)) {
			JError::raiseError(500, $row->getError());
		}

		if(!$row->podcast_id) // undefined or empty string or 0
			$row->podcast_id = null; // new podcast: let auto_increment take care of it

		if(!$row->check() || !$row->store()) {
			JError::raiseError(500, $row->getError());
		}

		$this->setRedirect('index.php?option=com_podcastpro', JText::_('COM_PODCASTPRO_METADATA_SAVED'));

		// clear cache
		$cache =& JFactory::getCache('com_podcastpro', 'output');
		$cache->clean('com_podcastpro');

		return $row;
	}

	function orderup()
	{
		$this->order(-1);
	}
	function orderdown()
	{
		$this->order(1);
	}
	/**
	* Moves the order of a record
	* @param integer The increment to reorder by
	*/
	function order($direction)
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db		= & JFactory::getDBO();

		$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );

		if (isset( $cid[0] ))
		{
			JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_podcastpro/tables');
			$row = & JTable::getInstance('podcast','table');
			$row->load( (int) $cid[0] );
			$row->move($direction );
		}

		$this->setRedirect('index.php?option=com_podcastpro&view=files');
	}

	function saveOrder()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize variables
		$db			= & JFactory::getDBO();

		$cid		= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$order		= JRequest::getVar( 'order', array (0), 'post', 'array' );
		$total		= count($cid);
		$conditions	= array ();

		JArrayHelper::toInteger($cid, array(0));
		JArrayHelper::toInteger($order, array(0));

		// Instantiate an article table object
		JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_podcastpro/tables');
		$row = & JTable::getInstance('podcast','table');

		// Update the ordering for items in the cid array
		for ($i = 0; $i < $total; $i ++)
		{
			$row->load( (int) $cid[$i] );
			if (!$row->podcast_id) continue;
			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->check() || !$row->store()) {
					JError::raiseError( 500, $db->getErrorMsg() );
					return false;
				}
			}
		}

		$msg = JText::_('New ordering saved');
		$this->setRedirect('index.php?option=com_podcastpro&view=files', $msg);
	}

	function publish()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$db =& JFactory::getDBO();

		// Save the metadata first, will override the redirect below
		$podcast =& $this->save();

		$query = "SELECT id FROM #__content WHERE introtext LIKE '%{enclose %{$podcast->filename}%}%' AND state > '-1'";
		$db->setQuery($query);
		$id = $db->loadResult();

		$msg = JText::_('COM_PODCASTPRO_METADATA_SAVED') . ' ' . JText::_('COM_PODCASTPRO_ADD_PUBLISH_ARTICLE_WITH_NOTES');

		if ($id) {
			$this->setRedirect('index.php?option=com_content&task=edit&cid[]=' . $id, $msg);
		} else {
			$row =& $this->saveArticle($podcast);
			$this->setRedirect('index.php?option=com_content&task=edit&cid[]=' . $row->id, $msg);
		}
	}

	// This is a bootstrap function to get an article in the database
	// for the podcast episode. This should only be used for new
	// episiodes; existing ones should be loaded through the content
	// component.
	private function &saveArticle(&$podcast)
	{
		$row =& JTable::getInstance('content');

		$row->title = JRequest::getString('title', '');
		if (!trim($row->title)) $row->title = $podcast->filename;
		$row->introtext = JRequest::getVar( 'text', '', 'post', 'string', JREQUEST_ALLOWRAW );

		$config =& JFactory::getConfig();
		$tzoffset = $config->getValue('config.offset');
		$date =& JFactory::getDate($row->created, $tzoffset);
		$row->created = $date->toMySQL();

		$date =& JFactory::getDate($row->publish_up, $tzoffset);
		$row->publish_up = $date->toMySQL();

		if (!$row->check()) {
			JError::raiseError( 500, $row->getError() );
		}

		// Store the content to the database
		if (!$row->store()) {
			JError::raiseError( 500, $row->getError() );
		}

		return $row;
	}

	function display()
	{
		$view = JRequest::getVar('view', null);

		if (!$view) {
			$task = $this->getTask();

			if ($task == 'add' || $task == 'edit') {
				JRequest::setVar('view', 'podcast');
			} elseif ($task == 'info') {
				JRequest::setVar('view', 'info');
			} else {
				JRequest::setVar('view', 'files');
			}
		}

		parent::display();
	}
}
