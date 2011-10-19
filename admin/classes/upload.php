<?php
 /**
 * Podcast Professional - The Joomla Podcast Manager
 * @package 	Podcast Professional
 * @copyright 	(C) 2010-2011 Kontent Design. All rights reserved.
 * @license 	http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link 		http://extensions.kontentdesign.com
 **/
defined ( '_JEXEC' ) or die ();

jimport ('joomla.filesystem.file');
/**
 * Class to handle file uploads.
 */

class PodcastProUpload extends JObject {
	protected $fileName = false;
	protected $fileTemp = false;

	protected $validExtensions = array();

	public function __construct($extensions = null) {
		if ($extensions) $this->setValidExtensions($extensions);
	}

	public function __destruct() {
		// Delete any left over files in temp
		if (is_file($this->fileTemp)) @unlink ( $this->fileTemp );
	}

	public function getInstance($extensions = null) {
		return new PodcastProUpload($extensions);
	}

	public function setValidExtensions($extensions=array()) {
		if (!is_array($extensions)) $extensions = explode ( ',', $extensions );
		foreach ($extensions as $ext) {
			$ext = trim((string)$ext);
			if (!$ext) continue;
			if ($ext[0] != '.') {
				$ext = '.'.$ext;
			}
			$this->validExtensions[$ext] = $ext;
		}
	}

	public function ajaxUpload($targetDir, $filename=null) {
		$chunk = JRequest::getInt ( 'chunk', 0 );
		$chunks = JRequest::getInt ( 'chunks', 0 );
		$this->fileName = JFile::makeSafe ( JRequest::getString ( 'name', $filename, 'POST' ) );

		if (!$this->fileName) {
			$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_NO_FILE' ));
		} elseif (! JRequest::checkToken ('get')) {
			$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_NOT_UPLOADED' ));
		}

		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		}
		if (isset($_SERVER["CONTENT_TYPE"])) {
			$contentType = $_SERVER["CONTENT_TYPE"];
		}

		if ($chunks && $chunk >= $chunks) {
			$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_EXTRA_CHUNK' ));
		}

		if (strpos($contentType, "multipart") !== false) {
			// Older WebKit browsers didn't support multipart in HTML5
			$this->fileTemp = $_FILES['file']['tmp_name'];
			$error = $this->checkUpload($_FILES['file']);
			$in = !$error ? fopen($this->fileTemp, "rb") : null;
		} else {
			// Multipart upload
			$error = null;
			$in = fopen("php://input", "rb");
		}
		if (!$in && !$this->getError()) {
			$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_NO_INPUT' ));
		}
		// Open temp file
		if (!$this->getError()) {
			$out = fopen(JPATH_ROOT."/{$targetDir}/{$this->fileName}", $chunk == 0 ? "wb" : "ab");
			if (!$out) $this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_CANT_WRITE' ));
		}
		if (!$this->getError()) {
			// 5 minutes execution time
			@set_time_limit(5 * 60);

			while (($buff = fread($in, 8192)) != '') {
				fwrite($out, $buff);
			}
		}

		if ($in) fclose($in);
		if ($out) fclose($out);

		// Return JSON-RPC response
		$this->sendResponse();
	}

	protected function sendResponse() {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		while(@ob_end_clean());
		$error = $this->getError();
		if ($error) {
			jexit('{"error": "'.JText::sprintf ( 'COM_PODCASTPRO_UPLOAD_FAILED', $error).'"}');
		}
		jexit('{"success": true}');
	}

	protected function checkUpload($file) {
		// Check for upload errors
		switch ($file ['error']) {
			case UPLOAD_ERR_OK :
				break;

			case UPLOAD_ERR_INI_SIZE :
			case UPLOAD_ERR_FORM_SIZE :
				$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_SIZE' ));
				break;

			case UPLOAD_ERR_PARTIAL :
				$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_PARTIAL' ));
				break;

			case UPLOAD_ERR_NO_FILE :
				$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_NO_FILE' ));
				break;

			case UPLOAD_ERR_NO_TMP_DIR :
				$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_NO_TMP_DIR' ));
				break;

			case UPLOAD_ERR_CANT_WRITE :
				$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_CANT_WRITE' ));
				break;

			case UPLOAD_ERR_EXTENSION :
				$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_PHP_EXTENSION' ));
				break;

			default :
				$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_UNKNOWN' ));
		}
		if (!$this->getError() && (!isset($file['tmp_name']) || !is_uploaded_file ($file['tmp_name']))) {
			$this->setError(JText::_ ( 'COM_PODCASTPRO_UPLOAD_ERROR_NOT_UPLOADED' ));
		}
		return $this->getError();
	}

	protected function splitFilename() {
		$ret = null;
		// Check if file extension matches any allowed extensions (case insensitive)
		foreach ( $this->validExtensions as $ext ) {
			$extension = substr($this->fileName, -strlen($ext));
			if (strtolower($extension) == strtolower($ext)) {
				// File must contain one letter before extension
				$ret[] = substr($this->fileName, 0, -strlen($ext));
				$ret[] = substr($extension, 1);
				break;
			}
		}
		return $ret;
	}
}