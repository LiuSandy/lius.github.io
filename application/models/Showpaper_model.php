<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Showpaper_model extends CI_Model {
    /**
     * 查看转换后资源（资源管理）
     */

    public function LookerPaper()
    {
        $data = $this->db->get('show')->result_array();
        return $data;
    }

    /**
     * 查询数据库
     */
    public function Select()
    {
        $data = $this->db->get('show')->result_array();
        return $data; 
    }

    /**
     * 添加数据
     */
    public function add($data)
    {
        $this->db->insert('show',$data);
    }

    /**
     * 查询nsid
     */
    public function show()
    {
        $data = array();   
        $query = $this->db->get('show')->result_array();
        foreach ($query as $row)
        {   
            Array_push($data, $row['nsid']);

        }
        return $data;
    }

    /**
     * 查询date
     */
    public function date()
    {
        $data = array();   
        $query = $this->db->get('show')->result_array();
        foreach ($query as $row)
        {   
            Array_push($data, $row['date']);

        }
        return $data;
    }

}

