<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 模型
 */
class Skin_model extends CI_Model {
	/**
	 * 展示所有数据
	 */
	public function show()
	{
		// 获得所有记录信息
		$data = $this->db->get('skin')->result_array();
		return $data;
	}
	//查询翻页名称
	public function check($sid)
	{
		//获得相应的数据
		$data = $this->db->where('sid',$sid)->get('skin')->result_array();
		return $data;
	}
	public function spath()
	{
		$data = $this->db->select('spath')->from('skin')->get()->result_array();
		return $data;
	}
}