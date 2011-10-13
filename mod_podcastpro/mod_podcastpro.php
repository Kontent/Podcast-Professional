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

$params = ( object ) $params;
$params->def('moduleclass_sfx', '');
$params->def('text_prefix', '');
$params->def('text_suffix', '');
$params->def('urischeme', 'http');
$params->def('showlink', 1);
$params->def('rsslink', 1);
$params->def('showimg', 1);

$itunesidlink = $params->def('itunesid', '');
$showlink = $params->get('otherlink', '');
$img = $params->get('otherimage', '');

$itunesidurl= "http://www.itunes.com/podcast?id=" . $itunesidlink ;

if(!$showlink)
	$showlink = JRoute::_(JURI::root(false) . 'index.php?option=com_podcastpro&view=feed&format=raw');

if($img)
	$img = JHTML::_('image', $img, 'Podcast Feed');
else
	$img = JHTML::_('image', 'modules/mod_podcastpro/media/podcast-subscribe.png', 'Podcast Feed');

if($params->get('urischeme') == 'http')
	$link = $showlink;
else
	$link = str_replace(array('http:', 'https:'), $params->get('urischeme') . ':', $showlink);

require(JModuleHelper::getLayoutPath('mod_podcastpro'));
