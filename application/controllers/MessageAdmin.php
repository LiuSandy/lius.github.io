<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 留言列表后台默认控制器
 */
class MessageAdmin extends MY_Controller {
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Send_model', 'send');
	}

	/**
	 * 载入界面
	 */
	public function index()
	{
		//载入辅助函数
		$this->load->helper('form');
		$data['mess'] = $this->send->show();
		// p($data);die;
		$this->load->view('admin/Message.html', $data);
	}

	/**
	 * 删除信息
	 */
	public function del()
	{
		//获得id
		$mid = $this->uri->segment(3);

		//操作数据库
		$this->send->del($mid);
		//载入界面
		$this->index();
	}

}