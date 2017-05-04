<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台默认控制器
 */
class IndexAdmin extends MY_Controller {

		
	/**
	 * 默认方法
	 */
	public function index() {
		$this->load->view('admin/Index.html');
		//$this->loadhead();
	}

	/**
	 * 默认欢迎界面
	 */
	public function copy() {
		$this->load->view('admin/CopyAdmin.html');
	}

	public function loadhead() {

		$this->load->view('admin/Head.html');
	}

	public function loadmain() {
		//载入用户数据库模板
		$this->load->model('Userman_model', 'userman');
		$data['users'] = $this->userman->show();
		//载入留言数据库模板
		$this->load->model('Send_model', 'send');
		$data['send'] = $this->send->show();
		//载入特效数据库模板
		$this->load->model('Skin_model', 'skin');
		$data['skin'] = $this->skin->show();
		//载入报纸数据库模板
		$this->load->model('Baozhi_model', 'baozhi');
		$data['baozhi'] = $this->baozhi->show();
		$this->load->view('admin/Main.html', $data);
	}

	public function loadleft() {
		 $this->load->view('admin/Left.html');
		//$this->load->view('admin/starter.html');
	}


	/**
	 * 统计数量
	 */
	public function count()
	{
		$data = 0;
		return $data;
	}
	
}