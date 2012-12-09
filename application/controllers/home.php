<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
    {
        $data['page'] = 'home/home_view';
        $this->load->view('template', $data);
    }

    public function about_us()
    {
        $data['page'] = 'home/about_us_view';
        $this->load->view('template', $data);
    }

    public function contact_us()
    {
        $data['page'] = 'home/contact_us_view';
        $this->load->view('template', $data);
    }

    public function site_map()
    {
        $data['page'] = 'home/site_map_view';
        $this->load->view('template', $data);
    }

    public function page_missing()
    {
        $this->load->view('page_missing_view');
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
