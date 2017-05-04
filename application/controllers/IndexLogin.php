<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台用户登录控制器
 */

class IndexLogin extends CI_Controller {

	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Yonghu_model', 'zhuce');
		$this->load->model('Index_model', 'center');
		$this->load->model('Baozhi_model', 'baozhi');	
	}

	/**
	 * 显示阅读界面
	 */
	public function index()
	{
		// $username=isset($_POST['username'])?$_POST['username']:FALSE;
		//载入辅助函数
		$this->load->helper('form');
		$this->load->view('index/IndexUnLogin.html');
	}

	/**
	 * 添加数据-用户注册
	 */
	public function register() {
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$status = $this->form_validation->run('Azhuce');

		if($status) {
			// 获得页面中的数据
			$power = 1;
			$username = $this->input->post('username');
//			查询数据库是否存在此用户
//            echo $username;die;
			$userDate = $this->zhuce->check($username);
			// p($userDate);
			// echo $userDate[0]['username'];die;
			if($userDate) error('此用户已注册');
			// p($userDate);die;
			
			$password = md5($this->input->post('password'));
			// $passwordN = md5($this->input->post('passwordN'));
			// if($password != $passwordN) error('两次密码输入不一样');
			$power = 1;
			$data = array(
				'username' => $username,
				'password' => $password,
				'power'    => $power,
				'QQ'       => $this->input->post('email'),
//				'sex'      => $this->input->post('sex'),
				'createdate' => time()
				);
			// p($data);die;
			$this->zhuce->add($data);


			$nsid=isset($_GET['nsid'])?$_GET['nsid']:3;
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

			$data['about'] = $this->center->show($nsid);
			$data['uid'] = $this->zhuce->check($uid);
			$data['news'] = $this->baozhi->show();

			// $data['thing'] = "退出"；
			//载入摘要页面
			$this->load->view('index/Index-bg.html', $data);
			
		} else {
			// 如果条件验证失败，重新加载页面。
			$this->index();
		}// end if
	}
}