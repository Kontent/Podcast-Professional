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

if ($this->podcast->podcast_id) {
	JToolBarHelper::title( JText::_('COM_PODCASTPRO_EDIT_EPISODE_METADATA'), 'podcast.png' );
	JToolBarHelper::save();
} else {
	JToolBarHelper::title( JText::_('COM_PODCASTPRO_ADD_NEW_EPISODE'), 'podcastadd.png' );
	JToolBarHelper::publish('publish', JText::_('COM_PODCASTPRO_SAVE_AND_PUBLISH_IN_ARTICLE'));
}

JToolBarHelper::cancel();

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_podcastpro/media/css/podcastpro.css');

$document =& JFactory::getDocument();
$document->addScript(JURI::base() . 'components/com_podcastpro/media/js/podcast.js');

JHTML::_('behavior.tooltip');

?>
<form action="index.php" method="post" name="adminForm" id="pp-form">
<div class="col">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'COM_PODCASTPRO_EPISODE_DETAILS' ); ?></legend>
	<table class="admintable">
		<?php 
			if (!$this->podcast->podcast_id) {
				echo $this->loadTemplate('episodenotes');
			}
		?>
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_FILENAME_URL');?>::<?php echo JText::_('COM_PODCASTPRO_FILENAME_URL_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_FILENAME_URL' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="filename" id="filename" size="60" value="<?php echo $this->podcast->filename; ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_ITUNES_SUBTITLE');?>::<?php echo JText::_('COM_PODCASTPRO_ITUNES_SUBTITLE_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_ITUNES_SUBTITLE' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="itSubtitle" id="itSubtitle" size="60" value="<?php echo $this->podcast->itSubtitle; ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_ITUNES_CATEGORY');?>::<?php echo JText::_('COM_PODCASTPRO_ITUNES_CATEGORY_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_ITUNES_CATEGORY' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="itCategory" id="itCategory" size="60" value="<?php echo $this->podcast->itCategory; ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_ITUNES_KEYWORDS');?>::<?php echo JText::_('COM_PODCASTPRO_ITUNES_KEYWORDS_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_ITUNES_KEYWORDS' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="itKeywords" id="itKeywords" size="60" value="<?php echo $this->podcast->itKeywords; ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_ITUNES_AUTHOR_LABEL');?>::<?php echo JText::_('COM_PODCASTPRO_ITUNES_AUTHOR_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_ITUNES_AUTHOR_LABEL' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="itAuthor" id="itAuthor" size="60" value="<?php echo $this->podcast->itAuthor; ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_ITUNES_DURATION');?>::<?php echo JText::_('COM_PODCASTPRO_ITUNES_DURATION_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_ITUNES_DURATION' ); ?>:
				</label>
			</td>
			<td>
				<input class="inputbox" type="text" name="itDuration" id="itDuration" size="60" value="<?php echo $this->podcast->itDuration; ?>" />
			</td>
		</tr>
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_ITUNES_BLOCK');?>::<?php echo JText::_('COM_PODCASTPRO_ITUNES_BLOCK_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_ITUNES_BLOCK' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->block ?>
			</td>
		</tr>
		
		
		<tr>
			<td width="110" class="key">
				<label for="title" class="hasTip" title="<?php echo JText::_('COM_PODCASTPRO_ITUNES_EXPLICIT_LABEL');?>::<?php echo JText::_('COM_PODCASTPRO_ITUNES_EXPLICIT_DESC');?>">
					<?php echo JText::_( 'COM_PODCASTPRO_ITUNES_EXPLICIT_LABEL' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->explicit ?>
			</td>
		</tr>
		
		
	</table>
	</fieldset>
</div>
<div class="clr"></div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="option" value="com_podcastpro" />
	<input type="hidden" name="podcast_id" value="<?php echo $this->podcast->podcast_id; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>