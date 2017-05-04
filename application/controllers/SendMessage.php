<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 系统管理默认控制器
 */
class SendMessage extends MY_Controller {

	//构造同一函数
	public function __construct() {
		parent::__construct();
		$this->load->model('Send_model', 'message');
		$this->load->model('Yonghu_model', 'Login');
		
	}

	/**
	 * 默认方法
	 */
	public function index() {
		// 载入辅助函数
		$this->load->helper('form');
		// 获得数据库中的留言内容
		
		$uid=isset($_POST['username'])?$_post['username']:FALSE;

		
		$data['content'] = $this->message->show();
		$data['uid'] = $this->Login->check($uid);

		// 载入报纸页面
		$this->load->view('index/Viewer.html', $data);
	}



}