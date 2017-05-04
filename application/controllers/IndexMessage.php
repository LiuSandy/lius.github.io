<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台留言控制器
 */
class IndexMessage extends MY_Controller {

	//构造同一函数
	public function __construct() {
		parent::__construct();
		$this->load->model('Note_model', 'note');
		$this->load->model('Send_model', 'mess');
		$this->load->model('Userman_model', 'use');
		
	}

	/**
	 * 默认方法
	 */
	public function index() {
		//获得用户名
		$uid=isset($_POST['username'])?$_POST['username']:FALSE;

		// 载入辅助函数
		$this->load->helper('form');
		// 获得数据库中的留言内容
//		$data['uid'] = $this->use->check($uid);
		$usname = $this->session->userdata('username');
        $data['note'] = $this->note->check($usname);
		$data['content'] = $this->mess->show();
		// 载入报纸页面
		$this->load->view('index/Note.html', $data);
	}

	
	/**
	 * 向数据库中添加留言
	 */
	public function add() {
		// 加载辅助函数
		$this->load->library('form_validation');
		$status = $this->form_validation->run('mess');


		if($status) {

			$username = $this->input->post('username');


			// 获得页面中的数据
			$data = array(
				'username' => $this->session->userdata('username'),
				'content' => $this->input->post('content'),
				);

			// 数据库操作
			$this->mess->add($data);

			// 数据加载完成，重新加载页面。
			$this->index();
			
		} else {
			// 如果条件验证失败，重新加载页面。
			$this->index();
		}// end if
	}

}
