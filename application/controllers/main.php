<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
    {
        $data['page'] = 'main/home_view';
        $data['layout'] = 'default';
        $this->load->view('template', $data);
    }

    public function about()
    {
        $data['page'] = 'main/about_view';
        $data['layout'] = 'default';
        $this->load->view('template', $data);
    }

    public function contact()
    {
        $data['page'] = 'main/contact_view';
        $data['layout'] = 'default';
        $this->load->view('template', $data);
    }

    public function site_map()
    {
        $data['page'] = 'main/site_map_view';
        $data['layout'] = 'default';
        $this->load->view('template', $data);
    }

    public function page_missing()
    {
        $this->load->view('page_missing_view');
    }
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
