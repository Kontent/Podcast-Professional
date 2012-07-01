<?php
 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional Module
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @copyright 	(c) 2005-2008 Joseph L. LeBlanc
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined( '_JEXEC' ) or die();

class ModPodcastPro {
	function __construct($params) {
		$this->cparams = &JComponentHelper::getParams( 'com_podcastpro' );
		$this->params = $params;
		$this->params->def('showimg', 1);
		$this->params->def('otherimage', '');
		$this->params->def('othertext', JText::_('MOD_PODCASTPRO_FULL_FEED'));
		$this->params->def('urischeme', 'http');
		$this->params->def('text_prefix', '');
		$this->params->def('text_suffix', '');
		$this->params->def('moduleclass_sfx', '');
	}

	function display() {
		$link = $this->cparams->get('mainurl');
		$link = $link ? $link : JRoute::_('index.php?option=com_podcastpro&view=feed&format=raw');

		if ($this->params->get('showimg')) {
			$img = ltrim($this->params->get('otherimage'), '/');
			$img = $img ? $img : 'modules/mod_podcastpro/media/podcast-subscribe.png';
			$this->html = JHTML::_('image', $img, 'Podcast Feed');
		} else {
			$this->html = $this->params->get('othertext');
		}

		if($this->params->get('urischeme') == 'http') {
			$this->link = $link;
		} else {
			if ($link[0] == '/') $link = JURI::base().substr($link,1);
			$this->link = preg_replace('#^http(s)?:\/\/#', $this->params->get('urischeme') . '://', $link);
		}

		$this->text_prefix = $this->params->get('text_prefix');
		$this->text_suffix = $this->params->get('text_suffix');
		$this->moduleclass_sfx = $this->params->get('moduleclass_sfx');

		require(JModuleHelper::getLayoutPath('mod_podcastpro'));
	}
}

