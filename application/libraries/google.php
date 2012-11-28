<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'google/Google_Client.php';
require_once 'google/contrib/Google_PlusService.php';
require_once 'google/contrib/Google_Oauth2Service.php';

/**
* Library: Google Client Library with services
* Description: Created for Codeigniter compatibility
* Author: Bryan Estrito
*/
class Google extends Google_Client
{
	public $plus;
	public $oauth2;

	public function __construct($config='')
	{
		parent::__construct();

		if (!session_id()) {
      		session_start();
    	}

    	// Fetch config from application/config/app_keys.php if parameter is null
		if (!$config) {
      		$this->ci =& get_instance();
      		$this->ci->config->load('app_keys', TRUE);
      		$config = $this->ci->config->item('google', 'app_keys'); 
    	}

		// Connection requirements
		$this->setApplicationName($config['appname']);
		$this->setClientId($config['clientid']);
		$this->setClientSecret($config['clientsecret']);
		$this->setRedirectUri($config['redirecturi']);
		$this->setDeveloperKey($config['developerkey']);

		// Important/Optionals
		$this->setScopes(
			array(
				'https://www.googleapis.com/auth/userinfo.email',
				'https://www.googleapis.com/auth/userinfo.profile',
				'https://www.googleapis.com/auth/plus.me'
			)
		);
		$this->setApprovalPrompt("auto");

		// Extended services
		$this->plus = new Google_PlusService($this);
		$this->oauth2 = new Google_Oauth2Service($this);
	}
}

/* End of file google.php */
/* Location: ./application/libraries/google.php */
