<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
    protected $pubkey;
    protected $privkey;
    protected $asd = 2;
    protected $params;
    protected $data;

    public function __construct()
    {
        parent::__construct();

        $this->data['sample1'];
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

        $data2 = array('data' => $data);
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

    public function sv1()
    {
        session_start();

        $_SESSION['time'] = time();

        session_cache_expire(1);

        echo session_cache_expire();

        echo anchor('test/sv2', 'linkname');        
    }

    public function sv2()
    {
        session_start();

        echo session_cache_expire();

        // echo $_SESSION['time'];        

        // $test = $_SESSION ? 'alis ka muna' : 'wala na'; 

        // echo $test;
    }

    public function testoma()
    {
        $data = array();

        $data['1'] = '1';
        $data['2'] = '2';

        $this->data['data'] = $data;

        print_r($this->data);
    }

    public function continue_test()
    {
        // for ($i = 0; $i < 5; ++$i) {
        //     if ($i == 2)
        //         continue;
        //     print "$i\n";
        // }

        $x = TRUE;
        $y = TRUE;

        if ($x && $y) {
            echo 'good';
        } else {
            echo 'bad';
        }
    }

    public function testoma2()
    {
        $this->twitter_login();
    }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */
