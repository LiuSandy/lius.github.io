<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 用户管理默认控制器
 */
class Adminyonghu extends MY_Controller {
	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Yonghu_model', 'yonghu');
	}

	//默认方法
	public function index() {
		//载入辅助函数
		$this->load->helper('form');

		//获得数据库中用户信息
		$data['username'] = $this->yonghu->show();
		//载入界面
		$this->load->view('admin/Userman.html', $data);
	}

	/**
	 * 添加数据-用户信息
	 */
	public function usermanadd() {
		$this->load->library('form_validation');
		$this->load->view('admin/Usermanadd.html');
		$status = $this->form_validation->run('yonghu');

		if($status) {
			// 获得页面中的数据
			$data = array(
				'username' => $this->input->post('username')
				);

			//查询数据库中的用户名
			$username = $this->yonghu->check('username');
			p($username);die;
			$this->yonghu->add($data);
			// 数据加载完成，重新加载页面。
			$this->index();
			
		} else {
			// 如果条件验证失败，重新加载页面。
			$this->index();
		}// end if
	}

	/**
	 * 删除数据
	 */
	public function del() {
		// 在URL中获得uid
		$uid = $this->uri->segment(3);
		// 数据库操作，删除数据
		$this->yonghu->del($uid);
		// 刷新页面
		$this->index();
	}

}