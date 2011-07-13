<?php 

 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @version 	$Id: default.php
 * @package 	Podcast Professional
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @copyright 	(c) 2005-2008 Joseph L. LeBlanc
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
 
 
defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::title( JText::_( 'COM_PODCASTPRO_ABOUT_PODCASTPRO' ), 'podcastpro.png' );

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'components/com_podcastpro/media/css/podcastpro.css');

?>

<div id="pp-help">
	<h2>Getting Started</h2>
	<p>Podcast Professional is the easiest way for you to join the world of podcasting. Ever since the introduction of the iPod and other portable audio players, podcasting has been the best way for experiencing great content no matter where you are.</p>
	<p>Originally, podcasting was just audio recordings (like a radio show) with embedded images as chapter markers. Using a tool like Apple's Garageband you can have images show up at specific times throught the podcast to give the listener an idea of who or what is being discussed.
	<p>Lately, podcasting has expanded into the video format. These vodcasts are the equivalent of video on demand and can be used for anything from a series of educational lectures to a professionally shot regular program.</p>

	<h2>Setting Up Podcast Professional</h2>
	
	<p>First, go to the <a href="">configuration</a> to define the settings for all of your podcast episodes.</p>
	
	
	<p>Podcast Professional is integrated with Joomla's core content and podcasts are embedded in Joomla articles. You can add podcasts to any of your articles using the special tag, but we recommend you create a specific Joomla category for your podcasts. <a href="/administrator/index.php?option=com_categories&section=com_content">Click here to go to your Category Manager</a> (or <a href="/administrator/index.php?option=com_categories&extension=com_content">here</a> in Joomla 1.6).</p>
	
	<p>The default directory for uploading your episode files is:</p>
	
	<p><strong>media/com_podcastpro/episodes</strong></p>
	
	<!--  TO DO: Add the folder path below  -->
	<p>The path for this directory on your server is: <strong><?php JText::printf($this->folder); ?></strong></p>
	
	<p>You can change this in the configuration. Currently, your system supports a <strong>maximum upload size of <?php echo ini_get('upload_max_filesize');?></strong>. If you want to upload files larger than that, you will need to increase it or upload your episode files via FTP to this directory.</p>
	
	
	<h2>Create a New Podcast</h2>
	
	<p>Clicking the file name in the Episode Manager will create a new Joomla article with the episode tag included:</p>
	
	<p><strong>{enclose filenamehere.mp3}</strong></p>
	
	<p>Podcast Professional recognizes these tags and adds them to your podcast feed. It also changes them into player links so your site visitors can preview/play the podcasts directly in their browser. 
	
	<p>If your episode files are hosted on a different server, you can customize the episode tag:</p>
	
	<p><strong>{enclose http://www.anotherwebsite.com/mypodcast_episode12.mp3 6328373 audio/mpeg}</strong></p>
	
	<p>Be sure to include the full URL (including the prefix and file name), the file size (in bytes), and the file encoding type. iTunes supports the following files and encoding types:</p>
	
	<ul>
		<li>.mp3&nbsp;&nbsp;&nbsp;audio/mpeg</li>
		<li>.m4a&nbsp;&nbsp;&nbsp;audio/x-m4a</li>
		<li>.mp4&nbsp;&nbsp;&nbsp;video/mp4</li>
		<li>.m4v&nbsp;&nbsp;&nbsp;video/x-m4v</li>
		<li>.mov&nbsp;&nbsp;&nbsp;video/quicktime</li>
		<li>.pdf&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;application/pdf</li>
		<li>.epub&nbsp;&nbsp;&nbsp;document/x-epub</li>
	</ul>
	
	<p>Add a title for this episode and any other details to the editor area. 
	
	<h2>Publicizing Your Podcast</h2>
	
	<p>Use <a href="http://www.feedvalidator.org/" target="_blank">FeedValidator</a> to be sure that your podcast feed passes the validation process before distributing it. We recommend you use a service like <a href="http://feedburner.google.com" target="_blank">Feedburner</a> to distribute your episode feed. It ensures your feed is always available and gives you nice troubleshooting and tracking options. You can test your feed by opening iTunes, going to Advanced > Subscribe to Podcast, and entering your feed URL.</p>
		
	<p>Adding your podcast to iTunes is pretty straightforward. You'll need an iTunes account and a 300px by 300px JPG. <a href="https://phobos.apple.com/WebObjects/MZFinance.woa/wa/publishPodcast" target="_blank">
	Click here</a> to visit the podcast submission page.</p>
	
	<p>Each time you publish an episode, it will take up to 48 hours for iTunes to ping your podcast feed and add the new episode to iTunes.</p>
	
	<p>There are a number of great resources where you can submit your podcast to reach a wider audience:</p>
	
	<ul>
		<li><a href="http://www.podcast.com/" target="_blank">http://www.podcast.com/</a></li>
		<li><a href="http://www.podcastdirectory.com/" target="_blank">http://www.podcastdirectory.com/</a></li>
		<li><a href="http://www.podcastalley.com/" target="_blank">http://www.podcastalley.com/</a></li>
		<li><a href="http://www.podfeed.net/" target="_blank">http://www.podfeed.net/</a></li>
	</ul>
	
	
	<h2>More Information</h2>
	<p>Apple has a <a href="https://discussions.apple.com/community/itunes/producing_podcasts?forumID=1107" target="_blank">discussion forum</a> for helping users create and distribute podcasts. Here are a few additional resources:</p>
	<ul>
		<li><a href="http://www.apple.com/itunes/podcasts/specs.html" target="_blank">http://www.apple.com/itunes/podcasts/specs.html</a></li>
		<li><a href="http://www.apple.com/itunes/podcasts/creatorfaq.html" target="_blank">http://www.apple.com/itunes/podcasts/creatorfaq.html</a></li>
		<li><a href="http://en.wikipedia.org/wiki/Uses_of_podcasting" target="_blank">http://en.wikipedia.org/wiki/Uses_of_podcasting</a></li>
	</ul>
			
	<h2>Kontent Extensions</h2>
	<p>Visit <a href="http://extensions.kontent.com/" target="_blank">Kontent Extensions</a> to see our other great extensions.</p>

</div>

<?php include_once(JPATH_ADMINISTRATOR."/components/com_podcastpro/footer.php");
