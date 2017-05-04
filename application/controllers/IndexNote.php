<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class IndexNote extends MY_Controller {

    /**
     * 构造函数 为统一加载的方法载入
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('Note_model', 'note');
        $this->load->model('Send_model', 'mess');
        $this->load->model('Userman_model', 'use');
    }

    /**
     * 载入视图
     */
    public function note()
    {
        $uid=isset($_POST['username'])?$_POST['username']:FALSE;

        // 载入辅助函数
        $this->load->helper('form');

        // 获得数据库中的留言内容
        $data['content'] = $this->mess->show();
        //获得数据库笔记内容
        $usname = $this->session->userdata('username');
        $data['note'] = $this->note->check($usname);
        // p($data);die;
        // 载入报纸页面
        $this->load->view('index/Note.html', $data);
    }

    /**
     * 添加笔记
     */
    public function store()
    {
        $this->load->library('form_validation');

        $data= array(
            'usname'=>$this->session->userdata('username'),
            'note'=>$this->input->post('note'),
            'date'=>time()
            );
        // p($data);die;
        //传入数据
        $this->note->store($data);
    }

    /**
     * 向数据库中添加留言
     */
    public function add() {
        // 加载辅助函数
        $this->load->library('form_validation');
        $status = $this->form_validation->run('mess');


        if($status) {

            $username = $this->input->post('username');


            // 获得页面中的数据
            $data = array(
                'username' => $this->session->userdata('username'),
                'content' => $this->input->post('content'),
                );

            // 数据库操作
            $this->mess->add($data);

            // 数据加载完成，重新加载页面。
            $this->note();
            
        } else {
            // 如果条件验证失败，重新加载页面。
            $this->note();
        }// end if
    }

    /**
     * 修改密码
     */
    public function change_passwd()
    {
        // echo "hello world";die;
        //载入辅助函数
        $this->load->helper('form');
        
        //载入表单验证类
        $this->load->library('form_validation');
        //执行验证
        $status = $this->form_validation->run('passwd');
        // var_dump($status) ;die;
        if($status){

            //数据库操作
            $username = $this->session->userdata('username');
            //查询当前用户名的信息
            $userData = $this->use->check($username);
            //原始密码
            // $passwd = $this->input->post('passwd');

            // if(md5($passwd) != $userData[0]['password']){
            //     error('原密码错误');
            // }       
            //新输入的信息
            $passwdF = $this->input->post('passwdF');
            $passwdS = $this->input->post('passwdS');
            //判断两次密码是否相同
            if($passwdF != $passwdS) error('两次密码不相同');

            $uid = $this->session->userdata('uid');
            //修改内容
            $data = array(
                'password' => md5($passwdF)
                );
            //传入数据
            $this->use->change($uid, $data);
            $this->note();
           success('IndexNote/note', '修改成功');
        }else{
            $this->load->helper('form');
            $this->note();
        }
    }

}