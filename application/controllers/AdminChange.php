<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 密码修改默认控制器
 */
class AdminChange extends MY_Controller {

	/**
	 * 构造函数
	 */
	public function __construct()
    {
        parent::__construct();
        $this->load->model('Userman_model', 'use');
    }
	/**
	 * 修改密码
	 */
	public function change()
	{
		//载入辅助函数
		$this->load->helper('form');

		$this->load->view('admin/Change_passwd.html');
	}

	/**
	 * 修改动作
	 */
	public function change_passwd()
	{
		//载入辅助函数
		$this->load->helper('form');
		
		//载入表单验证类
		$this->load->library('form_validation');
		//执行验证
    	$status = $this->form_validation->run('passwd');
    	// var_dump($status) ;die;
    	if($status){
    		//数据库操作
    		//当前用户名
			$username = $this->session->userdata('username');
			// echo $username;die;
			//查询当前用户名的信息
			$userData = $this->use->check($username);
			p($userData);
			
			//原始密码
			$passwd = $this->input->post('passwd');
			echo md5($passwd);die;
			//对比
			if(md5($passwd) != $userData[0]['password']){
				error('原密码错误');
			}		
			//新输入的信息
			$passwdF = $this->input->post('passwdF');
			$passwdS = $this->input->post('passwdS');
			//判断两次密码是否相同
			if($passwdF != $passwdS) error('两次密码不相同');

			$uid = $this->session->userdata('uid');
			//修改内容
			$data = array(
				'password' => md5($passwdF)
				);
			//传入数据
			$this->use->change($uid, $data);
			success('AdminChange/change', '修改成功');
    	}else{
    		// echo "你不好";die;
    		$this->load->helper('form');
            $this->load->view('admin/Change_passwd.html');
    	}
		
	}
	
}