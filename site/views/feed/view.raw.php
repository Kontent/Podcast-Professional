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

jimport( 'joomla.application.component.view');
jimport('joomla.filesystem.file');

class PodcastViewFeed extends JView
{
	function display($tpl = null)
	{
		$params =& JComponentHelper::getParams('com_podcastpro');

		$document =& JFactory::getDocument();
		$document->setMimeEncoding('application/rss+xml');

		if($params->get('cache', true)) {
			$cache =& JFactory::getCache('com_podcastpro', 'output');
			if($cache->start('feed', 'com_podcastpro')) {
				return;
			}
		}

		$xw = new xmlWriter();
		$xw->openMemory();
		$xw->setIndent(true);
		$xw->setIndentString("\t");

		$xw->startDocument('1.0','UTF-8');

		$xw->startElement('rss');
		$xw->writeAttribute('xmlns:itunes', 'http://www.itunes.com/dtds/podcast-1.0.dtd');
		// $xw->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');
		$xw->writeAttribute('version','2.0');

		$xw->startElement('channel');

		$xw->startElement('atom:link');
		$xw->writeAttribute('href', JRoute::_('index.php?option=com_podcastpro&view=feed&format=raw', false));
		$xw->writeAttribute('rel', 'self');
		$xw->writeAttribute('type', 'application/rss+xml');
		$xw->endElement();

		$xw->writeElement('title', $params->get('title', ''));
		$xw->writeElement('link', JURI::base()); // may want to make configurable as param

		$newurl = $params->get('newurl', '');
		if($newurl) {
			$xw->writeElement('itunes:new-feed-url', $newurl);
		}

		$lang =& JFactory::getLanguage();
		$xw->writeElement('language', $lang->getTag());

		$xw->writeElement('copyright', $params->get('copyright', ''));

		$xw->writeElement('itunes:subtitle', $params->get('itSubtitle', ''));
		$xw->writeElement('itunes:author', $params->get('itAuthor', ''));

		$itBlock = $params->get('itBlock', 0);

		if ($itBlock) {
			$xw->writeElement('itunes:block', 'yes');
		}

		$itExplicit = $params->get('itExplicit', 0);

		if ($itExplicit == 2) {
			$xw->writeElement('itunes:explicit', 'clean');
		} elseif ($itExplicit == 1) {
			$xw->writeElement('itunes:explicit', 'yes');
		} else {
			$xw->writeElement('itunes:explicit', 'no');
		}

		$xw->writeElement('itunes:keywords', $params->get('itKeywords', ''));

		$xw->writeElement('itunes:summary', $params->get('description', ''));

		$xw->writeElement('description', $params->get('description', ''));

		$xw->startElement('itunes:owner');
		$xw->writeElement('itunes:name', $params->get('itOwnerName', ''));
		$xw->writeElement('itunes:email', $params->get('itOwnerEmail', ''));
		$xw->endElement();

		$imageURL = $params->get('itImage', '');
		if ($imageURL) {
			$xw->startElement('itunes:image');
			if (!preg_match('/^http/', $imageURL))
			{
				$imageURL = JURI::root(false) . $imageURL;
			}
			$xw->writeAttribute('href', $imageURL);
			$xw->endElement();
		}

		$this->setCategories($xw, $params);

		$this->setItems($xw, $params);

		$xw->endElement(); // channel
		$xw->endElement(); // rss

		echo $xw->outputMemory(true);

		if(isset($cache))
			$cache->end(); // cache output
	}

	private function setCategories(&$xw, &$params)
	{
		$cats = array('itCategory1', 'itCategory2', 'itCategory3');

		foreach ($cats as $cat) {
			$pieces = explode('>', $params->get($cat, ''));

			if ($pieces[0] != '') {
				$xw->startElement('itunes:category');
				$xw->writeAttribute('text', trim($pieces[0]));

				if (count($pieces) > 1) {
					$xw->startElement('itunes:category');
					$xw->writeAttribute('text', trim($pieces[1]));
					$xw->endElement();
				}

				$xw->endElement();
			}
		}
	}

	private function setItems(&$xw, &$params)
	{
		$items =& $this->get('data');

		$content =& $items['content'];
		$metadata =& $items['metadata'];

		foreach ($metadata as $filename => &$data) {
			if (!isset($content[$filename])) continue;
			$pcast =& $content[$filename];

			if(preg_match('/^http/', $filename)) { // external url
				$fileFullPath = $fileURL = $filename;
			} else {
				$fileFullPath = JPATH_ROOT . DS . $params->get('mediapath', 'media/com_podcastpro/episodes') . DS . $filename;
				if(!JFile::exists($fileFullPath)) {
					$fileFullPath = JPATH_ROOT . DS . $filename; // try fallback
					if(!JFile::exists($fileFullPath))
						continue;
					$fileURL = JURI::root() . $filename;
				} else {
					$fileURL = JURI::root() . $params->get('mediapath', 'media/com_podcastpro/episodes') . '/' . $filename;
				}
			}

			$xw->startElement('item');

			$xw->writeElement('title', $pcast->title);
			$xw->writeElement('itunes:author', $metadata[$filename]->itAuthor);
			$xw->writeElement('itunes:subtitle', $metadata[$filename]->itSubtitle);
			$xw->writeElement('itunes:summary', $this->cleanSummary($pcast->introtext));

			$this->addEnclosure($xw, $pcast, $params, $fileURL, $fileFullPath);
			$xw->writeElement('guid', $fileURL);

			if ($metadata[$filename]->itBlock) {
				$xw->writeElement('itunes:block', 'yes');
			}

			$itExplicit = $metadata[$filename]->itExplicit;
			if ($itExplicit == 2) {
				$xw->writeElement('itunes:explicit', 'clean');
			} elseif ($itExplicit == 1) {
				$xw->writeElement('itunes:explicit', 'yes');
			} else {
				$xw->writeElement('itunes:explicit', 'no');
			}

			$xw->writeElement('pubDate', date('r', strtotime($pcast->publish_up)));

			$xw->writeElement('itunes:duration', $metadata[$filename]->itDuration);
			$xw->writeElement('itunes:keywords', $metadata[$filename]->itKeywords);

			$xw->endElement(); // item
		}
	}

	private function addEnclosure(&$xw, &$pcast, $params, $fileURL, $fileFullPath)
	{
		preg_match('/\{enclose\s+([^\}]+)\}/u', $pcast->introtext, $matches);
		$pieces = $matches ? explode(' ', $matches[1]) : array();

		if (count($pieces) < 3) {
			$pieces[1] = filesize($fileFullPath);
			$pieces[2] = $params->def('mimetype', 'audio/mpeg');
		}

		$xw->startElement('enclosure');
		$xw->writeAttribute('url', $fileURL);
		$xw->writeAttribute('length', $pieces[1]);
		$xw->writeAttribute('type', $pieces[2]);
		$xw->endElement();
	}

	private function cleanSummary($text)
	{
		preg_match_all('/\{enclose\s+([^\}]+)\}/u', $text, $matches);
		$text = $matches ? str_replace($matches[0], '', $text) : $text;
		$text = preg_replace('/\s+/', ' ', $text);

		return trim(strip_tags($text));
	}
}
