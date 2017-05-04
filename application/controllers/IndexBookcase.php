<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台书架控制器
 */

class IndexBookcase extends CI_Controller {

	/**
	 * 构造同一函数
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Baozhi_model', 'baozhi');
		$this->load->model('Showpaper_model', 'show');
//        $this->load->model('View_model', 'view');
	}

	//书架展示界面
	public function Bookcase()
	{
		

		$data['news'] = $this->baozhi->show();
		// p($data);die;
//        $count = $this->view->count(4,"2016-08-23");
//        p($count);die;
//        $date =trim($_GET['date']);
//        $data['news'] = $this->baozhi->seach($keyword,$date);
		$this->load->helper('form');
		$this->load->view('index/IndexBookcase.html', $data);
	}

	/**
	 * 站内搜索
	 */
	public function seach()
	{
        $this->load->helper('form');
        $this->load->library('form_validation');
        $status = $this->form_validation->run('search');
       // var_dump($status);die;

     //   if($status){
        $keyword =trim($_GET['keyword']);
        $date =trim($_GET['date']);
        // $nsid = 11;
        // $date = date("Y-m-d",time());
        // echo $nsname;die;
        $data['news'] = $this->baozhi->seach($keyword,$date);
//            var_dump($data);
//             p($data);die;
        $this->load->view('index/IndexBookcase.html', $data);
      //  }else{
//            $data['news'] = $this->baozhi->show();
//            // p($data);die;
//
//            $this->load->helper('form');
//            $this->load->view('index/IndexBookcase.html', $data);
         //   redirect('IndexBookcase/Bookcase');
        }


	}
