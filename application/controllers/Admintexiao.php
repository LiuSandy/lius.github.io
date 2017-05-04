<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 特效修改默认控制器
 */
class Admintexiao extends MY_Controller {

	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Texiao_model', 'texiao');
	}

	//默认方法
	public function index() {
		//载入辅助函数
		$this->load->helper('form');

		//获得数据库中特效分类
		$data['sname'] = $this->texiao->show();
		//载入界面
		$this->load->view('admin/Texiaoman.html', $data);
	}

	/**
	 * 添加数据-特效数据
	 */
	public function add() {
		$this->load->library('form_validation');
		$status = $this->form_validation->run('texiao');

		if($status) {
			// 获得页面中的数据
			$data = array(
				//'noname' => $_POST['noname']
				'sname' => $this->input->post('sname'),
				'spath' => $this->input->post('spath')
				);
			// p($data);die;

			$this->texiao->add($data);
			// 数据加载完成，重新加载页面。
			// $this->load->view('admin/texiaoman.html', $data);
			$this->index();
		} else {
			// 如果条件验证失败，重新加载页面。
			$this->index();
		}// end if
	}
	/**
	 * 修改
	 */
	public function edit_cate()
	{
		$sid = $this->uri->segment(3);
		// 查询数据库

		$data['skin'] = $this->texiao->check_cate($sid);

		$this->load->helper('form');
		$this->load->view('admin/Edit.html', $data);
	}

	/**
	 * 修改动作
	 */
	public function edit()
	{
		$this->load->library('form_validation');

		$status = $this->form_validation->run('texiao');

		if($status) {

			$sid = $this->input->post('sid');
			$sname = $this->input->post('sname');
			$spath = $this->input->post('spath');
			$data = array(
				'sname' => $sname,
				'spath' => $spath
				);

			$data['skin'] = $this->texiao->update_cate($sid, $data);

			$this->index();

		} else {
			$this->load->helper('form');
			// 如果条件验证失败，重新加载页面。
			$this->index();
		}// end if
	}

	/**
	 * 删除数据
	 */
	public function del() {
		// 在URL中获得sid
		$sid = $this->uri->segment(3);
		// 数据库操作，删除数据
		$this->texiao->del($sid);
		// 刷新页面
		$this->index();
	}

}