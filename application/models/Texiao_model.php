<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 特效数据库管理模型
 */
class Texiao_model extends CI_Model {
	/**
	 * 展示所有数据
	 */
	public function show() {
		// 获得所有记录信息
		$data = $this->db->get('skin')->result_array();

		return $data;
	}

	/**
	 * 添加特效数据
	 */
	public function add($data) {
		$this->db->insert('skin', $data);
	}

	/**
	 * 查询对应栏目
	 */
	public function check_cate($sid) {
		$data = $this->db->where(array('sid'=>$sid))->get('skin')->result_array();
		return $data;
	}

	/**
	 * 修改特效
	 */
	public function update_cate($sid, $data)
	{
		$this->db->update('skin', $data, array('sid' => $sid));
	}

	/**
	 * 删除特效数据
	 */
	public function del($sid) {
		$this->db->delete('skin', array('sid'=>$sid));
	}	
}