<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 报社后台默认控制器
 */
class BaosheAdmin extends MY_Controller {
	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Baoshe_model', 'baoshe');
	}

	/**
	 * 默认方法
	 */
	public function index() {

		// 载入辅助函数
		$this->load->helper('form');
		// 获得数据库中的报社分类
		$data['noname'] = $this->baoshe->show();
		// 载入页面
		$this->load->view('admin/Baosheman.html', $data);
	}

	/**
	 * 添加数据-报社数据
	 */
	public function add() {
		$this->load->library('form_validation');
		$status = $this->form_validation->run('baoshe');

		if($status) {
			// 获得页面中的数据
			$data = array(
				//'noname' => $_POST['noname']
				'noname' => $this->input->post('noname')
				);
			
			// 数据库操作
			$this->baoshe->add($data);
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
		// 在URL中获得noid
		$noid = $this->uri->segment(3);
		// 数据库操作，删除数据
		$this->baoshe->del($noid);
		// 刷新页面
		$this->index();
	}
}