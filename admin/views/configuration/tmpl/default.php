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

JToolBarHelper::title( JText::_( 'COM_PODCASTPRO_CONFIGURATION_GLOBAL_LABEL' ), 'podcast.png' );

JToolBarHelper::save();
JToolBarHelper::cancel();

JFactory::getDocument()->addStyleSheet(JURI::base() . 'components/com_podcastpro/media/css/podcastpro.css');

JHTML::_('behavior.tooltip');

jimport('joomla.html.pane');

$pane =& JPane::getInstance( 'tabs' );
?>
<form autocomplete="off" name="adminForm" method="post" action="index.php">
<input type="hidden" name="option" value="com_podcastpro" />
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="task" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
<?php
echo $pane->startPane( 'content-pane' );

// First slider panel
echo $pane->startPanel( JText::_( 'COM_PODCASTPRO_CONFIGURATION_GLOBAL_LABEL' ), 'global' );
echo $this->params->render( 'params' );
echo $pane->endPanel();

//Second slider panel
echo $pane->startPanel( JText::_( 'COM_PODCASTPRO_CONFIGURATION_ITUNES_LABEL' ), 'itunes' );
echo $this->params->render( 'params', 'itunes' );
echo $pane->endPanel();

echo $pane->endPane();
?>
</form>
<?php
include_once(JPATH_ADMINISTRATOR."/components/com_podcastpro/footer.php");
