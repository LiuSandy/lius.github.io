<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 系统管理默认控制器
 */
class Adminxitong extends MY_Controller {
	/**
	 * 密码修改
	 * @return [type] [description]
	 */
	public function usermanadd2() {
		$this->load->view('admin/Usermanadd2.html');
	}

	/**
	 * 退出登录
	 * @return [type] [description]
	 */
	public function login() {
		$this->load->view('admin/Login.html');
	}
}