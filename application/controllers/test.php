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
        $content = array(
            'blog_entries' => array(
                array('title' => 'Title 1', 'body' => 'Body 1'),
                array('title' => 'Title 2', 'body' => 'Body 2'),
                array('title' => 'Title 3', 'body' => 'Body 3'),
                array('title' => 'Title 4', 'body' => 'Body 4'),
                array('title' => 'Title 5', 'body' => 'Body 5')
            )
        );

        // $content = (object) $content;

        $data['content'] = $content;
        $data['page'] = 'test_view';
        $data['layout'] = 'none';

        $data = (object) $data;

        $this->load->view('template', $data);
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
        $x['1'] = 'asd';
        $x['2'] = 'ddd';
        print_r($x);
    }

    public function export()
    {
        //ENTER THE RELEVANT INFO BELOW
        $mysqlDatabaseName ='xcode';
        $mysqlUserName ='root';
        $mysqlPassword ='root';
        $mysqlHostName ='localhost';
        $mysqlExportPath ='/tmp/chooseFilenameForBackup.sql';

        //DONT EDIT BELOW THIS LINE
        //Export the database and output the status to the page
        $command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
        exec($command,$output=array(),$worked);
        switch($worked){
            case 0:
                echo 'Database <b>' .$mysqlDatabaseName .'</b> successfully exported to <b>~/' .$mysqlExportPath .'</b>';
            break;
            case 1:
                echo 'There was a warning during the export of <b>' .$mysqlDatabaseName .'</b> to <b>~/' .$mysqlExportPath .'</b>';
            break;
            case 2:
                echo 'There was an error during export. Please check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr></table>';
            break;
        }
    }

    public function import()
    {
        //ENTER THE RELEVANT INFO BELOW
        $mysqlDatabaseName ='xcode';
        $mysqlUserName ='root';
        $mysqlPassword ='root';
        $mysqlHostName ='localhost';
        $mysqlImportFilename ='/home/bryan/yourMysqlBackupFile.sql';

        //DONT EDIT BELOW THIS LINE
        //Export the database and output the status to the page
        $command='mysql -h' .$mysqlHostName .' -u' .$mysqlUserName .' -p' .$mysqlPassword .' ' .$mysqlDatabaseName .' < ' .$mysqlImportFilename;
        exec($command,$output=array(),$worked);
        switch($worked){
            case 0:
                echo 'Import file <b>' .$mysqlImportFilename .'</b> successfully imported to database <b>' .$mysqlDatabaseName .'</b>';
            break;
            case 1:
                echo 'There was an error during import. Please make sure the import file is saved in the same folder as this script and check your values:<br/><br/><table><tr><td>MySQL Database Name:</td><td><b>' .$mysqlDatabaseName .'</b></td></tr><tr><td>MySQL User Name:</td><td><b>' .$mysqlUserName .'</b></td></tr><tr><td>MySQL Password:</td><td><b>NOTSHOWN</b></td></tr><tr><td>MySQL Host Name:</td><td><b>' .$mysqlHostName .'</b></td></tr><tr><td>MySQL Import Filename:</td><td><b>' .$mysqlImportFilename .'</b></td></tr></table>';
            break;
        }
    }

    public function outfile()
    {
        $tableName  = 'mypet';
        $backupFile = 'backup/mypet.sql';
        $query      = "SELECT * INTO OUTFILE '$backupFile' FROM $tableName";
        $result = mysql_query($query);
    }

    public function infile()
    {
        $tableName  = 'mypet';
        $backupFile = 'mypet.sql';
        $query      = "LOAD DATA INFILE 'backupFile' INTO TABLE $tableName";
        $result = mysql_query($query);
    }

    public function testoma5()
    {
        $this->load->library('encrypt');

        $msg = 'Thequickbrownfoxjumpsoverthelazydog';

        $encrypted_string = $this->encrypt->encode($msg);

        $encrypt_to_md5 = md5($encrypted_string);
        
        echo $encrypt_to_md5;
    }

    public function testmail()
    {
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        
        $this->email->from('xcode.test.project@gmail.com', 'Xcode Project');
        $this->email->to('bryan.estrito@gmail.com');     
        $this->email->subject('Test Mail with attachment');     
        $this->email->message('new msg');
        
        $path = $this->config->item('server_root');
        $file = $path . '/xcode/attach/sample.txt';
        
        $this->email->attach($file);

        if($this->email->send())
        {
            echo 'Your email was sent, fool. baka!';
        }
        else
        {
            show_error($this->email->print_debugger());
        }
    }

    public function date()
    {
        // $this->load->model('test_model');

        // $data['date'] = date('Y-m-d h:i:s', time());

        // echo $data['date'];

        // $this->test_model->insert_date($data);

        echo date("Y-m-d H:i:s", time());
    }

    public function arrtest()
    {
        $x['asd'] = 'asd';


    }

    public function reduce_array($array, $keys, $i = 0)
    {
        if (is_array($array))
        {
            if (isset($keys[$i]))
            {
                if (isset($array[$keys[$i]]))
                {
                    $array = $this->_reduce_array($array[$keys[$i]], $keys, ($i+1));
                }
                else
                {
                    return NULL;
                }
            }
            else
            {
                return $array;
            }
        }

        return $array;
    }

    public function throwkey()
    {
        echo $this->reduce_array();
    }
}

/* End of file test.php */
/* Location: ./application/controllers/test.php */
