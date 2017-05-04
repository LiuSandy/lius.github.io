<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台视图控制器
 */

class IndexSkin extends CI_Controller {
/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Skin_model', 'choose');
	}


	//加载翻页方式
	public function skin()
	{
		//载入辅助函数
		$this->load->helper('form');
		//获取相应翻页方式
		$data['sid'] = $this->choose->show();
		var_dump($data['sid']);die;
		
		//载入视图。
		$this->load->view('index/Viewer.html', $data);
	}	
}