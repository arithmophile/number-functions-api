<?php
class Output {
    protected $_debug;
    protected $_data;
    protected $_title;
    protected $_template;

    public function __construct()
    {
        $this->_title = 'Another Avocational Arithmophile Adventure';
        $this->_template = null;
    }

    public function output()
    {
        $host = $_SERVER['HTTP_HOST'];
        $outmode = substr($host, 0, strpos($host, '.'));

        switch ($outmode) {
            case 'json':
                $this->_output_json();
                break;
            default:
                $this->_output_default();
        }
    }

    private function _output_json()
    {
        $output = json_encode($this->_data);
        $callback = $_GET['callback'];
        print $callback . "($output)";
    }

    private function _output_default()
    {
        global $app;
        $output = array_merge(array('title' => $this->_title), $this->_data);
        
        if ($this->_template) {
            $app->render($this->_template, $output);
            if ($this->_debug) {
                print '<pre>';
                print_r($output);
                print '</pre>';
            }
        }
        else {
            print '<pre>';
            print_r($output);
            print '</pre>';
        }
    }
}

?>

