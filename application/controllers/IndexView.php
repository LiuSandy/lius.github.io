<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台视图控制器
 */

class IndexView extends CI_Controller {
	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('View_model', 'dbview');
		$this->load->model('Skin_model', 'choose');
	}



	//默认视图界面
	public function view()
	{

		// 载入辅助函数
		$this->load->helper('form');

		//获得下一页的index
		$index = isset($_GET['index'])?$_GET['index']:1;
//        echo '<script>alert('.$index.')</script>';
//        die;
//		获得id
		$nsid = $this->uri->segment(3);
		// echo $nsid;die;
		 $date = date("Y-m-d",time());
		// echo $date;die;
		//从数据库中查询报纸id 下一页index；
		$data['nsid']= $this->dbview->show($nsid,$index,$date);
//        p($data);die;
        //翻页特效
        $data['sid'] = $this->choose->show();
      //  p($data);die;
		//从数据库中读取报纸所有的版面
		$data['layout'] = $this->dbview->check($nsid);
		$data['count'] = $this->dbview->count($nsid,$date);
		$this->load->view('index/Viewer.html', $data);
	}

	public function skin()
	{
		//获得翻页方式
		$data = $this->choose->spath();
		// p($data);
		$sid = array_rand($data,1);
		$sid +=2;
		echo $sid;
		$spath = $this->choose->check($sid);
		echo $spath[0]['spath'];

	}


	public function show()
    {

        $nsid = $this->uri->segment(3);
        $date = isset($_GET['date'])?trim($_GET['date']):date("Y-m-d",time());

        $index = isset($_GET['index'])?trim($_GET['index']):1;

        $data['nsid']= $this->dbview->show($nsid,$index,$date);
//        p($data);die;
        //翻页特效
        $data['sid'] = $this->choose->show();
        //从数据库中读取报纸所有的版面
       $data['count'] = $this->dbview->count($nsid,$date);
      //  $data['count'] = 0;

//var_dump($data);die;
        //所有版面
//        $data['layout'] = $this->dbview->check($nsid);
        $data['layout'] = $this->dbview->layout($nsid,$date);
//        var_dump($data);die;
        $this->load->view('index/Viewer.html', $data);
        //var_dump($data);
    }
}