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
?>
<table width="100%" class="paramlist admintable" cellspacing="1">
	<?php foreach ($this->params->getParams() as $item): ?>
	<tr>
		<?php if ($item[0]) : ?>
		<td width="40%" class="paramlist_key">
			<?php echo $item[0] ?>
		</td>
		<td class="paramlist_value">
			<?php echo $item[1] ?>
		</td>
		<?php else : ?>
		<td class="paramlist_value" colspan="2">
			<?php echo $item[1] ?>
		</td>
		<?php endif ?>
	</tr>
	<?php endforeach ?>
</table>
<?php
echo $pane->endPanel();

//Second slider panel
echo $pane->startPanel( JText::_( 'COM_PODCASTPRO_CONFIGURATION_ITUNES_LABEL' ), 'itunes' );
?>
<table width="100%" class="paramlist admintable" cellspacing="1">
	<?php foreach ($this->params->getParams('params' ,'itunes') as $item): ?>
	<tr>
		<?php if ($item[0]) : ?>
		<td width="40%" class="paramlist_key">
			<?php echo $item[0] ?>
		</td>
		<td class="paramlist_value">
			<?php echo $item[1] ?>
		</td>
		<?php else : ?>
		<td class="paramlist_value" colspan="2">
			<?php echo $item[1] ?>
		</td>
		<?php endif ?>
	</tr>
	<?php endforeach ?>
</table>
<?php
echo $pane->endPanel();

echo $pane->endPane();
?>
</form>
<?php
include_once(JPATH_ADMINISTRATOR."/components/com_podcastpro/footer.php");
