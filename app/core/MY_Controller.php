<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ST_Controller extends CI_Controller
{
    protected $data = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $query = $this->db->query("select * from st_setting where id=1");
        $result = $query->row_array();
        if ($result['is_close'] == 1) {
            show_error($result['close_notice'], 500, "网站关闭");
            exit;
        }
        // if ($_SERVER['SERVER_ADDR'] != "120.25.72.224") {
        //     show_error($result['close_notice'], 500, "缃戠珯鍏抽棴");
        //     exit;
        // }
        $data['ptype'] = empty($_GET['t']) ? 1 : intval(trim($_GET['t']));
        $data['setting'] = $result;
        $setting = $result;
        $this->load->vars($data);
    }
    public function getsetting()
    {
        $query = $this->db->query("select * from st_setting where id=1");
        $result = $query->row_array();
        return $result;
    }
    function get_server_ip()
    {
        if (isset($_SERVER)) {
            if ($_SERVER['SERVER_ADDR']) {
                $server_ip = $_SERVER['SERVER_ADDR'];
            } else {
                $server_ip = $_SERVER['LOCAL_ADDR'];
            }
        } else {
            $server_ip = getenv('SERVER_ADDR');
        }
        return $server_ip;
    }
}