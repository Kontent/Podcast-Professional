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

class TablePodcast extends JTable {
	var $podcast_id;
	var $filename;
	var $itAuthor;
	var $itBlock;
	var $itCategory;
	var $itDuration;
	var $itClosedCaptioned;
	var $itExplicit;
	var $itKeywords;
	var $itSubtitle;
	var $ordering;

	function __construct( &$db )
	{
		parent::__construct( '#__podcast', 'podcast_id', $db );
	}

	/**
	 * Overloaded check function
	 *
	 * @return	boolean
	 * @see		JTable::check
	 * @since	1.5
	 */
	function check()
	{
		if (!$this->ordering) {
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder();
		}
		return true;
	}
}