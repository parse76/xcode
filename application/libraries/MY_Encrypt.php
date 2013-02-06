<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Encrypt extends CI_Encrypt
{
	public function mycrypt($salt)
	{
		return md5(sha1($this->encode($salt)));
	}
}

/* End of file MY_Encrypt.php */
/* Location: ./application/libraries/MY_Encrypt.php */