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
<div class="podpro<?php echo $this->moduleclass_sfx; ?>">

	<?php if ($this->text_prefix) : ?>
		<p class="podpro-prefix"><?php echo $this->text_prefix; ?></p>
	<?php endif ?>

	<p><a href="<?php echo $this->link; ?>"><?php echo $this->html; ?></a></p>

	<?php if ($this->text_suffix) : ?>
		<p class="podpro-suffix"><?php echo $this->text_suffix; ?></p>
	<?php endif ?>
</div>
