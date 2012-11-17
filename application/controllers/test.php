<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
    protected $pubkey;
    protected $privkey;
    protected $asd = 2;

    public function __construct()
    {
        parent::__construct();


    }

    public function index()
    {
        $this->config->load('third_party_login', TRUE);
        $facebook = $this->config->item('facebook', 'third_party_login');

        var_dump($facebook);
    }

    public function sample()
    {
        $sample = $this->load->library('test_library');

        $sample = $this->test_library->sample();

        var_dump($sample);
    }

    public function parse_test()
    {
        
        $this->load->library('parser');

        $data['base_url'] = base_url();

        $this->parser->parse('test_view', $data);
    }

    public function parsing()
    {
        $data = array(
            'blog_entries' => array(
                array('title' => 'Title 1', 'body' => 'Body 1'),
                array('title' => 'Title 2', 'body' => 'Body 2'),
                array('title' => 'Title 3', 'body' => 'Body 3'),
                array('title' => 'Title 4', 'body' => 'Body 4'),
                array('title' => 'Title 5', 'body' => 'Body 5')
            )
        );

        $data2 = array('content' => $data);
        $data2['page'] = 'test_view';

        $this->load->view('template', $data2);
    }

    public function contest()
    {
        $this->load->view('test_view');
    }

    public function test1()
    {
        echo '1';
    }

    public function test2()
    {
        $this->test1();
    }

    public function test3()
    {
        $this->CI =& get_instance();
        $this->CI->config->load('third_party_login', TRUE);
        $config = $this->CI->config->item('recaptcha', 'third_party_login'); 

        $this->pubkey = $config['pubkey'];
        $this->privkey = $config['privkey'];
    }

    public function captchatest()
    {
        $this->test3();

        echo $this->pubkey;
        echo '<br>';
        echo $this->privkey;
        echo '<br>';
        echo $this->asd;
    }   
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */
