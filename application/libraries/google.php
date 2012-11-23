<?php

require_once 'google/Google_Client.php';
require_once 'google/contrib/Google_PlusService.php';

/**
* Created for Codeigniter compatibility
* Author: Bryan Estrito
*/
class Google extends Google_Client
{
	public $google_plus;

	public function __construct($config='')
	{
		parent::__construct();

		if (!session_id()) {
      		session_start();
    	}

		if (!$config) { // Fetch config from app_keys.php if parameter is null
      		$this->ci =& get_instance();
      		$this->ci->config->load('app_keys', TRUE);
      		$config = $this->ci->config->item('google', 'app_keys'); 
    	}

		$this->setApplicationName($config['appname']);
		
		$this->setClientId($config['clientid']);
		
		$this->setClientSecret($config['clientsecret']);
		
		$this->setRedirectUri($config['redirecturi']);
		
		$this->setDeveloperKey($config['developerkey']);

		$this->google_plus = new Google_PlusService($this);		
	}
}
