<?php

/**
 * This controller listens to any file-request which is requested by /download/FILENAME.EXT
 * If the file exists in the Database, it generated a Donwload page and tries to start the Download within some seconds.
 *
 * @package silverstripe-delayeddownload
 * @author Alexander Frenzel <alex[at]relatedworks[dot]com>
 */
class DownloadController extends Page_Controller {
	
	static $url_handlers = array(
		'' => 'index',
		'get/$File' => 'get',
        '$File' => 'index'
    );
    
    static $allowed_actions = array(
		'index',
		'get'
    );
    
    public function Title() {
    	return 'Download';
    }
       
    // adjust the Metatag Title and add the automatic download 
    public function MetaTags() {
    	$tags = parent::MetaTags();
    	if ($this->File()) {
    		$tags = preg_replace("/<title>.*?<\/title>/is", '<title>Downloading '.$this->File()->Name.'</title>', $tags);
    		$tags.= "\n".'<meta http-equiv="refresh" content="3; URL='.$this->File()->DownloadURL().'">';
    	}
    	return $tags;
    }
     
    // get the requested File from DB
    public function File() {
    	if (!$this->file) {
    		$request = $this->getRequest();

    	   	$filename = Convert::raw2sql($request->param('File')).'.'.Convert::raw2sql($request->getExtension());
    		$this->file = DataObject::get_one('File', 'Name = \''.$filename.'\'');
    	}
    	return $this->file;
    }
    
    // download wrapper
    public function index($request) { 
    	if ($this->File())
    		return $this->renderWith(array('DownloadController', 'Page'));
    	return $this->httpError(404);    	
    }

    // Download file
	public function get($request) {
		if ($this->File())
			return SS_HTTPRequest::send_file(file_get_contents($this->File()->getFullPath()), $this->File()->Name);			
		return $this->httpError(404);
	}
}

/**
 * File-Decorator, which provides an direct URL to the delayed download page.
 *
 * @package silverstripe-delayeddownload
 * @author Alexander Frenzel <alex[at]relatedworks[dot]com>
 */
class FileDownloadURL extends DataObjectDecorator {
	public function DelayedDownloadURL() {
		$file = $this->owner;		
		return Director::baseURL().'download/get/'.$file->Name;    
	}
}