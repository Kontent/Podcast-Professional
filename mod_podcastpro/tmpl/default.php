<?php
 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional Module
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined('_JEXEC') or die();

// Attach the stylesheet to the document head
JHTML::stylesheet('podcastpro.css', 'modules/mod_podcastpro/media/');
?>
<div class="podpro<?php echo $this->params->get('moduleclass_sfx'); ?>">

	<?php if ($this->text_prefix) : ?>
		<p class="podpro-prefix"><?php echo $this->text_prefix ?></p>
	<?php endif ?>


	<?php if (empty($this->img)) : ?>
		<p><a href="<?php echo $this->link; ?>"><?php echo JText::_('MOD_PODCASTPRO_FULL_FEED'); ?></a></p>
	<?php else : ?>
		<div><a href="<?php echo $this->link ?>"><?php echo $this->img ?></a></div>
	<?php endif ?>

	<?php if ($this->text_suffix) : ?>
		<p class="podpro-suffix"><?php echo $this->text_suffix ?></p>
	<?php endif ?>
</div>
