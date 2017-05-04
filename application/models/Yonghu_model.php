<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 特效数据库管理模型
 */
class Yonghu_model extends CI_Model{
	/**
	 * 展示所有数据
	 */
	public function show()
	{
		// 获得所有记录信息
		$data = $this->db->get('users')->result_array();
		return $data;
	}

	/**
	 * 添加用户、用户注册
	 */
	public function add($data) 
	{
		$this->db->insert('users', $data);
	}

	/**
	 * 删除用户
	 */
	public function del($noid) {
		$this->db->delete('users', array('uid'=>$uid));
	}

	/**
	 * 修改用户
	 */
	public function update_cate($cid, $data) {
		$this->db->update('users', $data, array('uid' => $uid));
	}

	/**
	 * 查询数据库
	 */
	public function check($username) {
		
		$data = $this->db->get_where('users', array('username'=>$username))->result_array();	
		return $data;
	}
}