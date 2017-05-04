<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台登录控制器
 */
class LoginAdmin extends CI_Controller {
	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Userman_model', 'userman');
	}

	/**
	 * 默认登录方法
	 * @return [type] [description]
	 */
	public function index() {
		$this->load->view('admin/Login.html');
	}

	/**
	 * 验证码
	 */
	public function code() {
		$config = array(
			'width' => 80,
			'height' => 35, 
			'codeLen' => 4,
			'fontSize' => 16
			);

		$this->load->library('code', $config);
		$this->code->show();
	}

	public function login_in() {
		$code = $this->input->post('captcha');

		if(!isset($_SESSION)) {
			session_start();
		}

		// 将验证码变为大写并进行比较
		if(strtoupper($code) != $_SESSION['code'])error('验证码输入错误');

		// 验证用户名及密码
		$username = $this->input->post('userName');
		$userData = $this->userman->check($username);
		// p($userData);die;
		// echo $userData[0]['password'];die;
		$passwd = $this->input->post('passwd');
		// echo md5($passwd);die;
		if(!$userData || $userData[0]['password'] != md5($passwd))
			error('用户名或者密码不正确');
			
		
		
		$sessionData = array(
			'username' => $username, 
			'uid' => $userData[0]['uid'], 
			'logintime' => date("Y-m-d",$userData[0]['createdate']),
			'power'    => $userData[0]['power'],
			'sex'      => $userData[0]['sex'],
			'QQ'       => $userData[0]['QQ']
			);
		// p($sessionData);die;
		// 获取验证权限
		$power = $userData[0]['power'];
		if($power == 1)
			error('权限错误');
		$this->session->set_userdata($sessionData);
		// p($data);die;
		//查看session中的用户
		$use = $this->session->userdata('username');
		//查询数据库查看权限
		$data['use'] = $this->userman->check($use);
		// echo $data[0]['power'];die;
		// p($data);die;


	//	$this->load->view('admin/index.html', $data);

       redirect('IndexAdmin/index');
	}

	/**
	 * 退出登陆
	 */
	public function login_out() {
		$this->session->sess_destroy();
		$this->load->view('admin/Login.html');
	}

}