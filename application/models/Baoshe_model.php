<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 报社数据库管理模型
 */
class Baoshe_model extends CI_Model {
	/**
	 * 展示所有数据
	 */
	public function show() {
		// 获得所有记录信息
		$data = $this->db->get('newsoffice')->result_array();

		return $data;
	}

	/**
	 * 添加数据
	 */
	public function add($data) {
		$this->db->insert('newsoffice', $data);
	}

	/**
	 * 删除数据
	 */
	public function del($noid) {
		$this->db->delete('newsoffice', array('noid'=>$noid));
	}

	public function check($noid)
	{
		$data = $this->db->where('noid',$noid)->get('newsoffice')->result_array();
		return $data;
	}
}