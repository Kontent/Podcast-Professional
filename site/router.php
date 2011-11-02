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

/**
 * Build SEF URL
 *
 * @param $query
 * @return segments
 */
function PodcastproBuildRoute(&$query) {
	$segments = array ();

	// Get menu item
	if (isset ( $query ['Itemid'] )) {
		static $menuitems = array();
		$Itemid = $query ['Itemid'] = (int) $query ['Itemid'];
		if (!isset($menuitems[$Itemid])) {
			$menuitems[$Itemid] = JFactory::getApplication()->getMenu ()->getItem ( $Itemid );
			if (!$menuitems[$Itemid]) {
				// Itemid doesn't exist or is invalid
				unset ($query ['Itemid']);
			}
		}
		$menuitem = $menuitems[$Itemid];
	}

	// Check all URI variables and remove those which aren't needed
	foreach ( $query as $var => $value ) {
		if ( isset ( $menuitem->query [$var] ) && $value == $menuitem->query [$var] && $var != 'Itemid' && $var != 'option' && $var != 'format' ) {
			// Remove URI variable which has the same value as menu item
			unset ( $query [$var] );
		}
	}

	return $segments;
}

/**
 * Parse SEF URL
 *
 * @param $segments
 * @return array Query variables
 */
function PodcastproParseRoute($segments) {
	$vars = array();

	return $vars;
}
