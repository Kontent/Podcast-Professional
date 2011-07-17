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
	<p>Originally, podcasting was just audio recordings (like a radio show) with embedded images as chapter markers. Later images were added and the ability have them show up at specific times throughout the podcast to give the listener an idea of who or what is being discussed.
	<p>In recent years, podcasting has expanded into the video format. These vodcasts are the equivalent of video on demand and can be used for anything from a series of educational lectures to a professionally shot regular program.</p>

	<h2>Recording a Podcast</h2>

	<p>All you need to record a podcast is a computer with a microphone and recording software. There are several good free options you can try out to get your feet wet. <a href="http://audacity.sourceforge.net/" target="_blank">Audacity</a> is a multi-platform solution that's easy to learn. On Mac OS X, you can use <a href="http://www.apple.com/ilife/garageband/" target="_blank">Apple's Garageband</a>, which has a lot of great features (like embedding images) and is well worth the money if you're serious about podcasting. On Windows, you can use <a href="http://www.adobe.com/products/audition.html" target="_blank">Adobe Audition</a>, which is a more professional audio application with lots of features (some might say overkill for most).</p>
	
	<p>Once you're all set up, don't forget to plan your podcast. It's really a live program once you start recording so you want to be well prepared with what you're going to say and do. If you're interviewing someone, make sure you have all of your questions ready beforehand. If you're reciting Shakespeare or playing music, make sure you rehearse before turning on the microphone. Make sure the pace moves enough to engage the listener. If you don't, your podcast will appear unprofessional and people will usually get bored.</p>

	<h2>Recording a Vodcast</h2>

	<p>The term "vodcast" came from the merging of "video" and "podcast" when video started to become more prevalent on the Internet. While you can include images in podcasts, vodcasts are better when you need to show what's going on. There's a fine line between vodcasts and vlogs ("video blogs") because both are usually episodic.</p>
	
	<p>Naturally, for vodcasting, you'll need a camera to record your show. Production values range from the person who shoots a few minutes in their bedroom sitting in front of the computer (with no editing at all), to full-blown high-quality production values (with professional editing). That means you decide how serious you are and scale accordingly.</p>
	<p>On Mac OS X, you can use <a href="http://www.apple.com/ilife/imovie/" target="_blank">iMovie</a> or even <a href="http://www.apple.com/finalcutpro/" target="_blank">Final Cut Pro</a> On Windows, you can use <a href="http://explore.live.com/windows-live-movie-maker?os=other" target="_blank">Windows Live Movie Maker</a> or even <a href="http://www.adobe.com/products/premiere.html" target="_blank">Adobe Premiere Pro</a> for more professional features. You should start with the simple and free applications and work your way up to the more complex ones if you need more features and power.</p>
	
	<h2>Setting Up Podcast Professional</h2>
	
	<!--  TO DO: Add the path below  -->
	<p>First, go to the <a href="">configuration</a> to define the settings for all of your podcast episodes.</p>
	
	<!--  TO DO: Add check for Joomla version number and display correct link  -->
	<p>Podcast Professional is integrated with Joomla's core content and podcasts are embedded in Joomla articles. You can add podcasts to any of your articles using the special tag, but we recommend you create a specific Joomla category for your podcasts. <a href="/administrator/index.php?option=com_categories&section=com_content">Click here to go to your Category Manager</a> (or <a href="/administrator/index.php?option=com_categories&extension=com_content">here</a> in Joomla 1.6).</p>
	
	<p>The default directory for uploading your episode files is:</p>
	
	<p><strong>media/com_podcastpro/episodes</strong></p>
	
	<!--  TO DO: Add the folder path below  -->
	<p>The path for this directory on your server is: <strong><?php JText::printf($this->folder); ?></strong></p>
	
	<!--  TO DO: Add link below  -->
	<p>You can change this in the <a href="#">Podcast Pro configuration</a>. Currently, your system supports a <strong>maximum upload size of <?php echo ini_get('upload_max_filesize');?></strong>. If you want to upload files larger than that, you will need to increase it or upload your episode files via FTP to this directory.</p>
		
	
	<h2>Setting Up Your New Podcast</h2>
	
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
	
	<h2>Promoting Your Podcast or Vodcast</h2>
	
	<p>Use <a href="http://www.feedvalidator.org/" target="_blank">FeedValidator</a> to be sure that your podcast feed passes the validation process before distributing it. We recommend you use a service like <a href="http://feedburner.google.com" target="_blank">Feedburner</a> to distribute your episode feed. It ensures your feed is always available and gives you nice troubleshooting and tracking options. You can test your feed by opening iTunes, going to Advanced &gt; Subscribe to Podcast, and entering your feed URL.</p>
		
	<p>Adding your podcast to iTunes is pretty straightforward. You'll need an iTunes account (an <a href="https://appleid.apple.com/cgi-bin/WebObjects/MyAppleId.woa/" target="_blank">Apple ID</a>) and a 300px by 300px JPG. <a href="https://phobos.apple.com/WebObjects/MZFinance.woa/wa/publishPodcast" target="_blank">
	
	
	
	
	
	Click here</a> to visit the podcast submission page.</p>
	
	<p>Each time you publish an episode, it will take up to 48 hours for iTunes to ping your podcast feed and add the new episode to iTunes.</p>
	
	<p>There are a number of great resources where you can submit your podcast to reach a wider audience:</p>
	
	<ul>
		<li>Podcast.com: <a href="http://www.podcast.com/" target="_blank">http://www.podcast.com/</a></li>
		<li>Podcast Directory: <a href="http://www.podcastdirectory.com/" target="_blank">http://www.podcastdirectory.com/</a></li>
		<li>Podcast Alley: <a href="http://www.podcastalley.com/" target="_blank">http://www.podcastalley.com/</a></li>
		<li>Podfeed.net: <a href="http://www.podfeed.net/" target="_blank">http://www.podfeed.net/</a></li>
		<li>Blip.tv: <a href="http://blip.tv/" target="_blank">http://blip.tv/</a></li>
		<li>DigitalPodcast: <a href="http://www.digitalpodcast.com/" target="_blank">http://www.digitalpodcast.com/forums/</a></li>
		<li>Podcast Pickle: <a href="http://www.podcastpickle.com/" target="_blank">http://www.podcastpickle.com/</a></li>
		<li>Pod Lounge: <a href="http://www.thepodlounge.com.au/" target="_blank">http://www.thepodlounge.com.au/</a></li>
		<li>Feed Shark: <a href="http://feedshark.brainbliss.com/" target="_blank">http://feedshark.brainbliss.com/</a></li>
		<li>Videocasting Station: <a href="http://www.videocasting-station.com/" target="_blank">http://www.videocasting-station.com/</a></li>
		<li>Zencast: <a href="http://www.zencast.com/" target="_blank">http://www.zencast.com/</a></li>
		<li>Revision3: <a href="http://revision3.com/" target="_blank">http://revision3.com/</a></li>
	</ul>
	
	<h2>Making Money With Your Podcast</h2>
	
	<p>Once you build up your listenership, selling advertising is a great way to make your podcast pay off. Companies like <a href="http://www.radiotail.com/" target="_blank">RadioTail</a>, <a href="http://podtrac.com/" target="_blank">Podtrac</a>, or <a href="http://www.limelightnetworks.com/mobile-advertising-video-ads/" target="_blank">Limelight</a> can connect you with advertisers. You can get the word out yourself on your website and in the podcast itself. If you're using Feedburner, you'll be able to track how many subscribers you have and that will be a big selling point for potential advertisers.</p>
	
	
	<h2>Legal Considerations</h2>
	
	<p>Since you'll be distributing recordings, you should think about how you want to license your material. Some people are willing to release their podcasts into the <a href="http://en.wikipedia.org/wiki/Public_domain" target="_blank">public domain</a> while others want strict copyright control. Creative Commons has a great resource called the <a href="http://wiki.creativecommons.org/Podcasting_Legal_Guide" target="_blank">Podcasting Legal Guide</a> to help you wade through the complexities.</p>
	
	<h2>More Information</h2>
	<p>Apple has a <a href="https://discussions.apple.com/community/itunes/producing_podcasts?forumID=1107" target="_blank">discussion forum</a> for helping users create and distribute podcasts. Here are a few additional resources:</p>
	<ul>
		<li>Apple's Podcast Specifications: <a href="http://www.apple.com/itunes/podcasts/specs.html" target="_blank">http://www.apple.com/itunes/podcasts/specs.html</a></li>
		<li>Apple's Podcast Creator FAQs <a href="http://www.apple.com/itunes/podcasts/creatorfaq.html" target="_blank">http://www.apple.com/itunes/podcasts/creatorfaq.html</a></li>
		<li>Wikipedia: Uses of Podcasting: <a href="http://en.wikipedia.org/wiki/Uses_of_podcasting" target="_blank">http://en.wikipedia.org/wiki/Uses_of_podcasting</a></li>
		
		<li>Learning in Hand: Podcasting for Teachers &amp; Students: <a href="http://learninginhand.com/podcasting-booklet/" target="_blank">http://learninginhand.com/podcasting-booklet/</a></li>
		
		<li>Podcast Alley Discussion Forum: <a href="http://www.podcastalley.com/forum/" target="_blank">http://www.podcastalley.com/forum/</a></li>
		
		<li>Podcasting News: <a href="http://www.podcastingnews.com/" target="_blank">http://www.podcastingnews.com/</a></li>
		<li>Podcasting Tools: <a href="http://www.podcasting-tools.com" target="_blank">http://www.podcasting-tools.com</a></li>
	</ul>
	<br />
	<br />
	<hr />		
	<div class="klogo"><a href="http://extensions.kontentdesign.com/" target="_blank"><img src="components/com_podcastpro/media/images/klogo.jpg" alt="Visit Kontent Extensions"/></a></div>
	
	<p class="credit">All information &copy;2010-2011 by Kontent Design. Kontent Design takes no responsibility for the information, websites or services contained herein. Information is subject to change.</p>
</div>

<?php include_once(JPATH_ADMINISTRATOR."/components/com_podcastpro/footer.php");
