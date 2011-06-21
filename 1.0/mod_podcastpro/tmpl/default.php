<?php 

 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @version 	$Id: default.php
 * @package 	Podcast Professional Module
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
 
defined('_JEXEC') or die('Restricted access'); 

// Attach the stylesheet to the document head
JHTML::stylesheet('podcastpro.css', 'modules/mod_podcastpro/media/');

?>
<div class="podpro<?php echo $params->get('moduleclass_sfx'); ?>">
	
	<?php if (!$text_prefix) { ?>
		<p class="podpro-prefix"><?php echo $params->get('text_prefix'); ?></p>
	<?php } ?>
	
	<div><a href="<?php echo $link; ?>"><?php echo $img; ?></a></div>

	<?php if($params->get('plainlink')) { ?>
		<p><a href="<?php echo $plainlink; ?>"><?php echo JText::_('MOD_PODCASTPRO_FULL_FEED'); ?></a></p>
	<?php } ?>
	
	<?php if (!$text_suffix) { ?>
		<p class="podpro-suffix"><?php echo $params->get('text_suffix'); ?></p>
	<?php } ?>
</div>