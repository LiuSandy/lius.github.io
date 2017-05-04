<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 前台用户登录控制器
 */

class IndexRelogin extends CI_Controller {

	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Yonghu_model', 'Login');
		$this->load->model('Index_model', 'center');
		$this->load->model('Baozhi_model', 'baozhi');	
	}

	/**
	 * 默认登录方法
	 * @return [type] [description]
	 */
	public function index()
	{
		$this->load->view('index/IndexLogin.html');
		
	}


	public function login_in() {

		// 验证用户名及密码
		$username = $this->input->post('username');
		$userData = $this->Login->check($username);

		$passwd = $this->input->post('password');
		if(!$userData || $userData[0]['password'] != md5($passwd))
			error('用户名或者密码不正确');
		
		$sessionData = array(
			'username' => $username, 
			'uid' => $userData[0]['uid'], 
			'logintime' => time(),
			'power'    => $userData[0]['power']
			);
	
		$this->session->set_userdata($sessionData);

		//获取报纸
		$nsid=isset($_GET['nsid'])?$_GET['nsid']:3;
		//获得用户名
		$uid=isset($_POST['username'])?$_POST['username']:FALSE;


		//载入辅助函数
		$this->load->helper('form');
		$prefs = array(
		    'start_day'    => 'Sunday',
		    'month_type'   => 'long',
		    'day_type'     => 'short'
		);
		$this->load->library('calendar', $prefs);
		//设置显示年份
		$year = date("Y", time());
		//设置显示月份
		$month = date("n", time());
		$data['Calendar'] = $this->calendar->generate($year, $month);
		//获得数据库中报纸摘要信息
		$data['about'] = $this->center->show($nsid);
		$data['uid'] = $this->Login->check($uid);
		$data['news'] = $this->baozhi->show();
		// var_dump($data['uid']);die;
		$uid = $this->session->userdata('uid');
		if($uid) {
			$data['ss'] = 'YES';
		}
		
		$this->load->view('index/Index-bg.html', $data);
	}

	/**
	 * 退出登陆
	 */
	public function login_out() {
		$this->session->unset_userdata('username');
		$prefs = array(
		    'start_day'    => 'Sunday',
		    'month_type'   => 'long',
		    'day_type'     => 'short'
		);
		$this->load->library('calendar', $prefs);
		//设置显示年份
		$year = date("Y", time());
		//设置显示月份
		$month = date("n", time());
		$data['Calendar'] = $this->calendar->generate($year, $month);
		$data['news'] = $this->baozhi->show();
		// p($data);die;

		$this->load->view('index/index-bg.html',$data);
	}
}