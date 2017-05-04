<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台首页控制器
 */

class IndexPage extends CI_Controller {

	/**
	 * 构造同一函数
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Index_model', 'center');
		$this->load->model('Yonghu_model', 'Login');
		$this->load->model('Baozhi_model', 'baozhi');	
	}
	//显示
	public function index()
	{	
		$this->load->helper("form");
		//显示日历配置
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
		//载入摘要页面
		// p($data);die;
		$data['news']= $this->baozhi->show();
		// p($data);die;
		$this->load->view('index/Index-bg.html', $data);

	}

}