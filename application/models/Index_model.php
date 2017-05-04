<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 留言库管理模型
 */
class Index_model extends CI_Model {

	/**
	 * 显示所有数据
	 */
	public function show($nsid)
	{
		// $data=$this->db->get('newspaper')->where('nsid',$nsid)->result_array();
		$data=$this->db->where('nsid',$nsid)->get('newspaper')->result_array();
		// var_dump($data); die;
		return $data;
	}
}