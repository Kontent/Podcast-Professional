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

$editor =& JFactory::getEditor();
?>
<tr>
	<td width="110" class="key">
		<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_EPISODE_TITLE');?>::<?php echo JText::_('COM_PODCASTPRO_EPISODE_TITLE_DESC');?>">
			<?php echo JText::_( 'COM_PODCASTPRO_EPISODE_TITLE' ); ?>:
		</label>
	</td>
	<td>
		<input type="text" name="title" value="<?php echo $this->title; ?>" size="60"  />
	</td>			
</tr>
<tr>
	<td width="110" class="key">
		<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_EPISODE_SUMMARY_LABEL');?>::<?php echo JText::_('COM_PODCASTPRO_EPISODE_SUMMARY_DESC');?>">
			<?php echo JText::_( 'COM_PODCASTPRO_EPISODE_SUMMARY_LABEL' ); ?>:
		</label>
	</td>
	<td>
		<?php echo $editor->display( 'text',  $this->text , '100%', '250', '75', '20' ); ?>
	</td>			
</tr>
