<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 留言库管理模型
 */
class Send_model extends CI_Model {

	/**
	 * 显示所有数据
	 */
	public function show()
	{
		// 获得所有记录信息
		// $data = $this->db->select('mid,content,message.createdate')->from('message')->join('users', 'users.uid=message.uid')->order_by('message.createdate', 'asc')->get()->result_array();

		// return $data; 
		$data = $this->db->get('message')->result_array();
		// var_dump($data);die;
		return $data;
	}


	/**
	 * 添加数据
	 */
	public function add($data) 
	{
		$this->db->insert('message', $data);
	}

	/**
	 * 删除数据
	 */
	public function del($mid)
	{
		$this->db->delete('message', array('mid'=>$mid));
	}
}