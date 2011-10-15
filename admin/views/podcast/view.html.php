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

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');

class PodcastViewPodcast extends JView
{
	function display($tpl = null)
	{
		$option = JRequest::getCmd('option');
		
		$params =& JComponentHelper::getParams($option);
		$app =& JFactory::getApplication();
		
		$cid = JRequest::getVar('cid', array(0), '', 'array');
		$id = (int)$cid[0];
		
		$row =& JTable::getInstance('podcast', 'Table');
		
		// TODO: may need to prefill this with article information
		$title = '';
		
		$filename = JRequest::getVar('filename', null, '', 'array');
		
		if (!$filename && !$id) {
			// move on
		} else if(!$id || !$row->load($id)) { // metadata hasn't been added yet or the given id is invalid
			
			if(!$filename) { // this should never happen if user uses interface
				$app->redirect("index.php?option=$option", JText::_('COM_PODCASTPRO_INVALID_ID_FILENAME'), 'error');
				return;
			}
			
			$row->filename = JFile::makeSafe($filename[0]);
			if($row->filename !== $filename[0]) { // either they're messing with us or the OS is allowing filenames that Joomla isn't
				$app->redirect("index.php?option=$option", JText::_('COM_PODCASTPRO_FILENAME_SPECIAL_CHARACTERS'), 'error'); // either way, let's stay safe
				return;
			}

			$this->fillMetaID3($row, $title);
		} else {
			// TODO: fill $title with article information? it's not currently used by the template anyway.
		}
		
		if (stristr($row->filename, ' ')) {
			$tpl = 'error';
		}
		
		$explicit = JHTML::_('select.booleanlist', 'itExplicit', '', $row->itExplicit);
		$block = JHTML::_('select.booleanlist', 'itBlock', '', $row->itBlock);
		
		$this->assign('text', '{enclose ' . $row->filename . '}');
		$this->assign('explicit', $explicit);
		$this->assign('block', $block);
		$this->assignRef('podcast', $row);
		$this->assignRef('title', $title);
		$this->assignRef('params', $params);
		
		parent::display($tpl);
	}
	
	private function fillMetaID3(&$row, &$title)
	{
		define('GETID3_HELPERAPPSDIR', JPATH_COMPONENT . DS . 'getid3');
		include JPATH_COMPONENT . DS . 'getid3' . DS . 'getid3.php';
		
		$params =& JComponentHelper::getParams('com_podcastpro');
		$mediapath = $params->get('mediapath', 'media/com_podcastpro/episodes');
		
		$filename = JPATH_ROOT . DS . $mediapath . DS . $row->filename;
		
		if (!JFile::exists($filename)) {
			$filename = JPATH_ROOT .  DS . $row->filename;
		}
		
		$getID3 = new getID3($filename);
		$fileInfo = $getID3->analyze($filename);
		
		
		if(isset($fileInfo['tags_html'])) {
			$t = $fileInfo['tags_html'];
			$tags = isset($t['id3v2']) ? $t['id3v2'] : (isset($t['id3v1']) ? $t['id3v1'] : (isset($t['quicktime']) ? $t['quicktime'] : null));
			if($tags) {
				
				if (isset($tags['title'])) {
					$title = $tags['title'][0];
				}
				
				if (isset($tags['album'])) {
					$row->itSubtitle = $tags['album'][0];
				}
				
				if (isset($tags['artist'])) {
					$row->itAuthor = $tags['artist'][0];
				}
			}
		}
		
		if (isset($fileInfo['playtime_string'])) {
			$row->itDuration = $fileInfo['playtime_string'];
		}
	}
}