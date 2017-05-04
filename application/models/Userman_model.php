<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 报社数据库管理模型
 */
class userman_model extends CI_Model {
	/**
	 * 添加数据
	 */
	public function add($data) {
		$this->db->insert('users', $data);
	}

	/**
	 * 展示所有数据
	 */
	public function show() {
		// 获得所有记录信息
		$data = $this->db->get('users')->result_array();
		return $data;
	}

	/**
	 * 删除数据
	 */
	public function del($uid) {
		$this->db->delete('users', array('uid'=>$uid));
	}

	/**
	 * 查询后台用户数据
	 */
	public function check($username) {
		$data = $this->db->get_where('users', array('username'=>$username))->result_array();
		return $data;
	}

	/**
	 * 修改密码 权限修改
	 */
	public function change($uid,$data)
	{
		// p($data);die;
		$this->db->update('users',$data,array('uid'=>$uid));
	}

	/**
	 * 查询对应栏目
	 */
	public function check_cate($uid) {
		$data = $this->db->where(array('uid'=>$uid))->get('users')->result_array();
		return $data;
	}

	// /**
	//  * 权限修改
	//  */
	// public function update_cate($sid, $data)
	// {
	// 	p($data);die;
	// 	$this->db->update('users', $data, array('uid' => $uid));
	// }
}