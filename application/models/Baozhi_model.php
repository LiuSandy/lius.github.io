<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 报社数据库管理模型
 */
class Baozhi_model extends CI_Model {
	/**
	 * 展示所有数据
	 */
	public function show() {
		
		// 获得所有记录信息
		$data = $this->db->select('nsid,noname,nsname,imgPath,url,way,about,createdata')->from('newspaper')->join('newsoffice', 'newsoffice.noid=newspaper.noid')->order_by('nsid', 'asc')->get()->result_array();

		// $datd = $this->db->where('nsid',$nsid)->get('newspaper')->result_array();

		return $data;
	}

	public function check($nsid)
	{
		$data = $this->db->where('nsid',$nsid)->get('newspaper')->result_array();
		return $data;
	}

	/**
	 * 添加数据
	 */
	public function add($data) {
		$this->db->insert('newspaper', $data);
	}

	/**
	 * 删除数据
	 */
	public function del($nsid) {
		$this->db->delete('newspaper', array('nsid'=>$nsid));
	}

	/**
	 * 查询报纸名
	 */
	public function seach($nsname)
	{
		$data = $this->db->select('*')->from('newspaper')
            ->group_start()
                ->where('nsname', $nsname)
            ->group_end()
        ->get()->result_array();
        return $data;
	}
}