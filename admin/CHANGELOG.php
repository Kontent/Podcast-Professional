<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
/**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
?>
<!--

Changelog
------------

Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

------------

19-Oct-2011 Matias
+ Add plupload JavaScript library
- Administrator: Remove empty select view
# Add missing index.html files
+ Add file uploader and upload layout
^ Usability improvements

17-Oct-2011 Matias
# Fix fatal error in getid3 library
+ iTunes Explicit setting: Add third option of "clean"
# Administrator: Fix a bug in files view where search changes URL
+ Add iTunes ClosedCaptioned setting
^ Change component configuration to normal page (J! 1.5)
^ Change component configuration to normal page (J! 1.6)

15-Oct-2011 Matias
# Joomla 1.7 compatibility: Use always JFactory::getApplication() and local $option
# Joomla 1.7 compatibility: Make global configuration to work
# Joomla 1.7 compatibility: Add basic backend access control
# Joomla 1.7 compatibility: Add view parameters to view=feed
# Make mod_podcastpro to work in Joomla! 1.5
# Small fixes and improvements
# Joomla 1.7 compatibility: Make plugin to work (barely)
- Remove sample layout from feed view
# Joomla 1.7 compatibility: Fix public article detection
# Allow more than one media file in each artricle
# Allow metadata creation also if article exists
^ Module: Use feed URL from component if no URL has been defined
# Fixes to feed content
# Remove feed item description tags (data is already in summary)
# Fix invalid content in various feed item tags
# Improve {enclose} detection

14-Oct-2011 Matias
# Add all missing files to manifest.xml
# Hide index.html and htaccess.txt from the file list

13-Oct-2011 Matias
^ Added doctype to all xml files
^ Changed file headers (removed @version $Id)
# Fixed PHP Notice (undefined $params) in PodcastModelPodcast::buildQuery()
# Joomla 1.7 compatibility: Use JFactory instead of $mainframe in plg_podcapro
# Fill value from configuration into <itunes:new-feed-url>

18-Jul-2011 Severdia
^ Updated version number in footer
+ Added version file

17-Jul-2011 Severdia
^ Updated info page
# Fixed metadata link bug & language key
^ Changed column order
- Removed hiding help setting
- Removed checkboxes in EM
+ Added placeholder images for delete and upload

13-Jul-2011 Severdia
# Fixed language key

12-June-2011 Severdia
^ Language fixes
+ Added tooltips on backend
^ Changed "show" to "episode"
+ Added backend footer
^ Changes to RSS feed, disabled Atom tag
+ Added third option to explicit setting (needs to be added to feed)

11-June-2011 Severdia
^ Minor cleanup

8-June-2011 Severdia
+ Added new module parameters
+ Added new CSS file for module
^ New button image
+ Added prefix and suffix options
+ Added Feedburner and iTunes ID fields
^ Changed RSS link option
+ Rewrote all language keys and strings
^ General module UI cleanup

31-May-2011 Severdia
+ Added new icons
^ CSS changes for highlighted row
^ Made files that are already episodes not clickable
^ Changed links
+ Added footer
+ New icons for backend: metadata, edit article, view article
^ New language strings, disabled alert in header of file names with spaces

31-May-2011 Arvind
# Fixed error "Table podcast not supported" by Renaming the file administrator/tables/podcastpro.php to podcast.php
# Corrected paths to admin images in manifest.xml (might need to change values in jos_components for it to work on existing installation)
^ Changed Toolbar icons
+ Clickable headers to sort episode name, title, metadata
^ Changed a couple of language strings
# Fixed mis-spelling of language strings in plugin

30-May-2011 Severdia
^ Removed instructions on backend, visual tweaks
+ Added new icons
+ Added new About/Help page
^ Updated language strings
+ Added new param for new podcast URL
+ Added new param for Feedburner podcast URL

29-May-2011 Severdia
# Fixed bad URL for JS and CSS files on backend
+ Added new icon files in various sizes
^ Relocated JS files on backend to media folder


-------------------- 1.0 Pre-release [17-May-2011] ------------------

17-May-2011 Severdia
! Here we go.


-->