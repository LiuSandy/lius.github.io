<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$username = $this->session->userdata('username');
		$uid = $this->session->userdata('uid');
		//获取跳转页的权限
		$use = isset($_GET['power'])?$_GET['power']:8;

		if((!$username || !$uid) && ($use == 1)){
			redirect('IndexRelogin/index');
		}
		elseif(!$username || !$uid){
			redirect('LoginAdmin/index');
		}
	}
}
