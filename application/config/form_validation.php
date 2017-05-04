<?php 
	$config = array(
		'article' => array(
			array(
				'field' => 'title',
				'label' => '标题',
				'rules' => 'required|min_length[5]'
			),
			array(
				'field' => 'type',
				'label' => '类型',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'cid',
				'label' => '栏目',
				'rules' => 'integer'
			),
			array(
				'field' => 'info',
				'label' => '摘要',
				'rules' => 'required|max_length[155]'
			),
			array(
				'field' => 'content',
				'label' => '内容',
				'rules' => 'required|max_length[2000]'
			)
		),

		'cate' => array(
			array(
				'field' => 'cname',
				'label' => '栏目名称 ',
				'rules' => 'required|max_length[20]'
			)
		),

		'texiao' => array(
			array(
				'field' => 'sname',
				'label' => '名称',
				'rules' => 'required|max_length[20]'
			),
			array(
				'field' => 'spath',
				'label' => '代码 ',
				'rules' => 'required|min_length[2]'
			)
		),

		'article' => array(
			array(
				'field' => 'title',
				'label' => '标题',
				'rules' => 'required|min_length[5]'
			),
			array(
				'field' => 'type',
				'label' => '类型',
				'rules' => 'required|integer'
			),
			array(
				'field' => 'cid',
				'label' => '栏目',
				'rules' => 'integer'
			),
			array(
				'field' => 'info',
				'label' => '摘要',
				'rules' => 'required|max_length[155]'
			),
			array(
				'field' => 'content',
				'label' => '内容',
				'rules' => 'required|max_length[2000]'
			)
		),

		'cate' => array(
			array(
				'field' => 'cname',
				'label' => '栏目名称 ',
				'rules' => 'required|max_length[20]'
			)
		),

		'baoshe' => array(
			array(
				'field' => 'noname',
				'label' => '报社名称 ',
				'rules' => 'required|min_length[2]'
			)
		),

		'baozhi' => array(
			array(
				'field' => 'nsname',
				'label' => '报纸名称 ',
				'rules' => 'required|min_length[2]'
			),
			array(
				'field' => 'zqurl',
				'label' => '抓取地址 ',
				'rules' => 'required'
			),
			array(
				'field' => 'zyabout',
				'label' => '摘要',
				'rules' => 'required'
			)
		),

		'zhuce' => array(
			array(
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'required|min_length[3]'
			),
			array(
				'field' => 'password',
				'label' => '密码',
				'rules' => 'required|min_length[6]'
			)
		),
		//前台注册
		'Azhuce' => array(
			array(
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'required|min_length[3]'
				),
			array(
				'field' => 'password',
				'label' => '密码',
				'rules' => 'required|min_length[6]'
				),
			array(
				'field' => 'email',
				'label' => '邮箱',
				'rules' => 'required'
				),
			),
		//前台留言内容
		'mess'=> array(
			array(
				'field' => 'content',
				'label' => '内容',
				'rules' => 'required|min_length[1]'
				)
			),
		//密码修改
		'passwd' => array(
			array(
				'field' => 'passwdF',
				'label' => '内容',
				'rules' => 'required|min_length[6]'
				),
			array(
				'field' => 'passwdS',
				'label' => '内容',
				'rules' => 'required|min_length[6]'
				)
			),
		//留言列表
		'message' => array(
			array(
				'field' => 'mess',
				'label' => '用户名',
				'rules' => 'required'
				)
			),
		//权限修改
		'power' => array(
			array(
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'required'
			),
			array(
				'field' => 'power',
				'label' => '权限 ',
				'rules' => 'required'
			)
		),
		//修改基本信息
		'infor' => array(
			array(
				'field' => 'username',
				'label' => '用户名',
				'rules' => 'required'
			),
			array(
				'field' => 'sex',
				'label' => '性别 ',
				'rules' => 'required'
			),
			array(
				'field' => 'QQ',
				'label' => 'QQ',
				'rules' => 'required'
			)
		),

        //搜索报纸
        'search' => array(
            array(
                'field' => 'keyword',
                'label' => '报纸名',
                'rules' => 'required'
            ),
            array('field'=>'date',
                'label'=>'日期',
                'rules'=>'required'

            )
        ),
	);
?>