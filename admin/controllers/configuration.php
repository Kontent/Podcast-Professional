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

class PodcastControllerConfiguration extends JController
{
	function apply()
	{
		$this->_save();
		$this->setRedirect( 'index.php?option=com_podcastpro&view=configuration' );
	}

	function save()
	{
		$this->_save();
		$this->setRedirect( 'index.php?option=com_podcastpro' );
	}

	function _save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		if (version_compare(JVERSION, '1.6', '>')) {
			$table = JTable::getInstance('extension');
			$success = $table->load(array('type'=>'component', 'element'=>'com_podcastpro'));
		} else {
			$table =& JTable::getInstance('component');
			$success = $table->loadByOption( 'com_podcastpro' );
		}
		if (!success)
		{
			JError::raiseWarning( 500, 'Not a valid component' );
			return false;
		}

		$post = JRequest::get( 'post' );
		$post['option'] = $table->option;
		$table->bind( $post );

		// pre-save checks
		if (!$table->check()) {
			JError::raiseWarning( 500, $table->getError() );
			return false;
		}

		// save the changes
		if (!$table->store()) {
			JError::raiseWarning( 500, $table->getError() );
			return false;
		}
	}

	/**
	 * Cancel operation
	 */
	function cancel()
	{
		$this->setRedirect( 'index.php?option=com_podcastpro' );
	}
}
