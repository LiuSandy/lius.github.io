<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 模型
 */
class View_model extends CI_Model
{
    /**
     * 展示所有数据
     */
    public function show($nsid, $index, $date)
    {
        // 获得所有记录信息
        $date = strtotime($date);
//        echo $date;die;
        $this->db->where('nsid', $nsid);
        $this->db->where('date', $date);
        $data = $this->db->where('layoutindex', $index)->get('show')->result_array();
        return $data;
    }

    public function test($nsid,$index,$date)
    {
        $nsid = trim($nsid);
        $index = trim($index);
        $date = strtotime(trim($date));
//        var_dump($nsid,$index,$date);die;
        $this->db->where('nsid', $nsid);
        $this->db->where('date', $date);
        $this->db->where('layoutindex', $index);
        $data = $this->db->get('show')->result_array();
        return $data;
    }

    public function count($nsid,$date)
    {
        $nsid = trim($nsid);
//        echo $nsid;die;
        $date = strtotime(trim($date));
//        echo $date;die;
        $this->db->where('nsid', $nsid);
        $this->db->where('date', $date);
//        $this->db->where('layoutindex', $index);
        $data = $this->db->get('show')->result_array();
//        p($data);die;
        $data = count($data);
        return $data;
    }



    public function check($nsid)
    {

        // $data = $this->db->where('layout', $nsid)->get('show')->result_array();
        $data = $this->db->get_where('show', array('nsid' => $nsid))->result_array();
        return $data;
    }


    public function layout($nsid,$date)
    {
              $nsid = trim($nsid);
              $date = strtotime(trim($date));
              $this->db->where('nsid', $nsid);
              $this->db->where('date', $date);
              $data = $this->db->get('show')->result_array();
              return $data;
    }
}