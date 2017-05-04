<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 笔记
 */
class Note_model extends CI_Model {

	//查询数据
	public function show()
	{
		$data = $this->db->get('notes')->result_array();
		return $data;
	}
	//添加笔记
    public function store($data)
    {
        $this->db->insert('notes', $data);
    }

    //查询特定数据
    public function check($usname)
    {
    	$data = $this->db->get_where('notes', array('usname'=>$usname))->result_array();
		return $data;
    }

}