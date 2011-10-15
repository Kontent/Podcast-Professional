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
		$this->params = $params;
		$this->params->def('moduleclass_sfx', '');
		$this->params->def('text_prefix', '');
		$this->params->def('text_suffix', '');
		$this->params->def('urischeme', 'http');
		$this->params->def('showlink', 1);
		$this->params->def('rsslink', 1);
		$this->params->def('showimg', 1);
	}

	function display() {
		$itunesidlink = $this->params->def('itunesid', '');
		$showlink = $this->params->get('otherlink', '');
		$showlink = $showlink ? $showlink : JRoute::_(JURI::root(false) . 'index.php?option=com_podcastpro&view=feed&format=raw');
		$img = $this->params->get('otherimage', '');
		$img = $img ? $img : 'modules/mod_podcastpro/media/podcast-subscribe.png';

		$itunesidurl= "http://www.itunes.com/podcast?id=" . $itunesidlink ;

		$this->text_prefix = $this->params->get('text_prefix');
		$this->text_suffix = $this->params->get('text_suffix');
		$this->plainlink = $this->params->get('plainlink');

		$this->img = JHTML::_('image', $img, 'Podcast Feed');

		if($this->params->get('urischeme') == 'http')
			$this->link = $showlink;
		else
			$this->link = str_replace(array('http:', 'https:'), $this->params->get('urischeme') . ':', $showlink);

		require(JModuleHelper::getLayoutPath('mod_podcastpro'));
	}
}
