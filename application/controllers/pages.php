<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page'] = 'home_view';
		$this->load->view('template', $data);
	}

	public function about_us()
	{
		echo 'asd';
	}

	public function contact_us()
	{
		
	}

	public function site_map()
	{
		
	}

	public function page_missing()
	{
		$this->load->view('page_missing');
	}
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */
