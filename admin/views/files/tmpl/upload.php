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

JToolBarHelper::title( JText::_( 'COM_PODCASTPRO_PODCAST_EPISODE_MANAGER' ), 'podcast.png' );

// The parameters button will go away once it's moved to the submenu.
if (version_compare(JVERSION, '1.6', '>')) {
	JToolBarHelper::preferences('com_podcastpro', '550');
}

// This button isn't hooked up yet.
JToolBarHelper::custom( 'upload' , 'podcastfileupload.png', '', JText::_( 'COM_PODCASTPRO_UPLOAD_FILE'), 0, 0 );

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_podcastpro/media/css/podcastpro.css');

$document->addStyleSheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css');
$document->addStyleSheet(JURI::base() . 'components/com_podcastpro/media/css/plupload.css');

JHTML::_('behavior.tooltip');
require_once JPATH_COMPONENT.'/classes/file.php';
PodcastProFile::uploader('upload');
?>

<form action="index.php?option=com_podcastpro" method="post" name="adminForm">
	<div id="upload"><input name="file" type="file" /></div>
	<input type="hidden" name="task" value="" />
</form>
<br />

<?php include_once(JPATH_ADMINISTRATOR."/components/com_podcastpro/footer.php");
