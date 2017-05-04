<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * 后台添加用户管理默认控制器
 */
class UserManAdmin extends MY_Controller {
	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Userman_model', 'userman');
		$this->load->model('Yonghu_model', 'yonghu');
	}

	/**
	 * 默认方法
	 */
	public function index() {
		// 载入辅助函数
		$this->load->helper('form');
		// 获得数据库中的用户名
		$data['users'] = $this->userman->show();
		// 载入页面
		$this->load->view('admin/Userman.html', $data);
	}

	/**
	 * 用于添加页面使用
	 * @return [type] [description]
	 */
	public function gotoadd() {
		// 载入辅助函数
		$this->load->helper('form');
		// 加载添加用户的页面
		$this->load->view('admin/Useradd.html');
	}

	/**
	 * 添加用户信息
	 */
	public function add() {
		// 载入表单验证类
		$this->load->library('form_validation');
		// 执行验证
		$status = $this->form_validation->run('zhuce');

		if($status) {
			$power = $this->input->post('qxsel');
			if($power == "管理员"){
				$power = 0;
			}else{
				$power = 1;
			}
			// echo $power;die;
			// 获得页面中的数据
			$data = array(
				'username'   => $this->input->post('username'),
				'password'   => md5($this->input->post('password')),
				'power'      => $power,
				'sex'        => $this->input->post('sex'),
				'QQ'         => $this->input->post('QQ'),
				'createdate' => time()
				);
			// p($data);die;
			//输入用户名
			$userData = $data['username'];

			//查询数据库中的用户名
			$username = $this->yonghu->check($userData);
			// p($username);die;
			if(!$username){
				// 数据库操作
				$this->userman->add($data);
				// 数据加载完成，重新加载页面。
				$this->index();			
			} else {
				//错误提示
				error('用户名重复，请修改！');
				// 返回到添加的页面。
				$this->gotoadd();
			}
			
		} else {
			// 返回到添加的页面。
			$this->gotoadd();
		}//end if
	}


	/**
	 * 根据ID删除用户信息
	 * @return [type] [description]
	 */
	public function del() {
		// 在URL中获得noid
		$uid = $this->uri->segment(3);
		// 数据库操作，删除数据
		$this->userman->del($uid);
		// 刷新页面
		$this->index();
	}

	/**
	 * 修改用户信息
	 *将普通用户提升为管理员
	 */
	public function update()
	{
		//载入辅助函数
		$this->load->helper('form');
		//获得修改的id
		$uid = $this->uri->segment(3);
		// echo $uid;die;
		// 查询数据库
		$data['user'] = $this->userman->check_cate($uid);
		$this->load->view('admin/User_edit.html', $data);
	}

	/**
	 * 修改动作
	 */
	public function edit()
	{
		$this->load->library('form_validation');

		$status = $this->form_validation->run('power');

		if($status){
			//获得用户输入
			$uid = $this->input->post('uid');
			$data = array(
				'username' => $this->input->post('username'),
				'power'    => $this->input->post('power')
				);
			// p($data);die;
			$data['user'] = $this->userman->change($uid, $data);
			$this->index();
		}else{
			$this->load->helper('form');
			// 如果条件验证失败，重新加载页面。
			$this->index();
		}
	}
}