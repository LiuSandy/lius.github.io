<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 用户基本信息修改默认控制器
 */
class ChangeInfor extends MY_Controller {
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Userman_model', 'use');
	}
	/**
	 * 修改
	 */
	public function edit_cate()
	{
		$uid = $this->uri->segment(3);
		// echo $uid;die;
		// 查询数据库

		$data['user'] = $this->use->check_cate($uid);
		// p($data);die;

		$this->load->helper('form');
		$this->load->view('admin/Change_infor.html', $data);
	}

	/**
	 * 修改动作
	 */
	public function edit()
	{
		//载入表单验证类
		$this->load->library('form_validation');
		$status = $this->form_validation->run('infor');

		if($status){
			// echo "数据库操作";
			$uid = $this->input->post('uid');
			$data = array(
				'username' => $this->input->post('username'),
				'sex'     => $this->input->post('sex'),
				'QQ'      => $this->input->post('QQ')
				);
			// p($data);die;
			$data['user'] = $this->use->change($uid, $data);
			// p($data);die;
			$this->load->view('admin/Change_passwd.html');
		}else{
			$this->load->helper('form');
			$this->load->view('admin/Change_passwd.html');
		}
	}
}