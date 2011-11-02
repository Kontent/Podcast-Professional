<?php
 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined ( '_JEXEC' ) or die ();

/**
 * Utility class for creating Upload HTML
 */
abstract class PodcastProFile
{
	public static function uploader($name = 'file') {
		// Load the behavior.
		self::behavior();

		$uploadUri = 'index.php?option=com_podcastpro&view=files&task=upload&'.JUtility::getToken().'=1&format=json';
		$textRemove = JText::_('COM_KUNENA_GEN_REMOVE_FILE');
		$textInsert = JText::_('COM_KUNENA_EDITOR_INSERT');

		$js = <<<JS
window.addEvent('domready', function() {
	var uploader = new PodcastPro.Uploader('{$name}', {
		url: '{$uploadUri}',
		filters : [
			{title : "Media files", extensions : "mp3,m4a,mp4,m4v,mov,pdf,epub"},
		],
		max_file_size : '1gb',
		chunk_size : '1mb',
	});
});
JS;

		// Add the uploader initialization to the document head.
		$document = JFactory::getDocument();
		$document->addScriptDeclaration($js);
	}

	public static function behavior() {
		static $loaded = false;

		if (!$loaded)
		{
			$document = JFactory::getDocument();
			$document->addScript ( JURI::base() . 'components/com_podcastpro/media/js/plupload/plupload.js' );
			$document->addScript ( JURI::base() . 'components/com_podcastpro/media/js/uploader.js' );

			$loaded = true;
		}
	}
}