<?php 
	/*
	function getfiles($path){ 
	foreach(glob($path) as $afile){ 
		if(is_dir($afile)) 
		{ 
			getfiles($afile.'/*pdf'); 
			} else {
			echo $afile.'<br />'; 
			} 
	} 
} //简单的demo,列出当前目录下所有的文件
getfiles("D:/wamp/www/pdf");



	
	
	
	
	
	
	
	
	
	
	//下载pdf保存到数组中
	$data = system("D://wamp/www/pdftohtmlsys/zhuan/downloadPDFyzwb.exe");
	var_dump($data)
	
	
	
	
	
	//将下载的pdf逐个放到装换器中

	foreach($data as $v)
	{
		$cate = sys("D:\wamp\www\pdf\pdf2htmlEX.exe $v")->result_array();
		var_dump($cate);
	}*/

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$data = "D:\wamp\www\pdf\abc.pdf";
	$cate = "D:\wamp\www\pdf\abc.html";
	system("D:\wamp\www\pdf\pdf2htmlEX.exe $data $cate" , $exe);
	if($exe == 0) {
		echo "D:\wamp"; 
	}else{
		echo "D\\";die;
	}
	
	
?>