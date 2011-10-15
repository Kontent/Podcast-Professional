<?php 
 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @version 	$Id: default_error.php
 * @package 	Podcast Professional
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @copyright 	(c) 2005-2008 Joseph L. LeBlanc
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined( '_JEXEC' ) or die(); 

JToolBarHelper::title( JText::_( 'Error' ), 'addedit.png' );
JToolBarHelper::back();

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . '/administrator/components/com_podcastpro/media/css/podcastpro.css');

?>
<div class="alert">
	<p><?php echo JText::_('COM_PODCASTPRO_FILENAME_HAS_SPACES'); ?></p>
</div>