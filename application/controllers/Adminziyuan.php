<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 资源管理后台默认控制器
 */

class Adminziyuan extends CI_Controller {
	/**
	 * 构造函数 为统一加载的方法载入
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('Showpaper_model', 'ziyuan');
		$this->load->model('Baozhi_model', 'baozhi');
		$this->load->model('Baoshe_model', 'baoshe');
	}

	
	/**
	 * 查看资源
	 */
	public function index()
	{
		//分页——————————————
        //载入分页类
        $data['noname'] = $this->ziyuan->LookerPaper();
        $this->load->view('admin/Lookres.html', $data);
	}



	/**
	 * pdf转html函数
	 */
	public function zhuan()
	{
		$Zpath = getcwd() . '\pdf\pdf2htmlEX.exe';
		
		//遍历后进行转换
		foreach (glob("*.pdf") as $key) {
			// 1 PDF -> HTML
			system("$Zpath $key");

		}
		foreach (glob("*.PDF") as $key) {

			system("$Zpath $key");
		}



	}

	/**
	 * 删除文件里面的pdf文件
	 */
	public function delpdf()
	{
		foreach (glob("*.pdf") as $key) {
			//echo $key . '<br>';
			unlink($key);
		}
		foreach (glob("*.PDF") as $key) {
			//echo $key . '<br>';
			unlink($key);
		}
	}

	/**
	 * PDF转换
	 * @return [type] [description]
	 */
	public function pdftohtml() {  
		$this->load->helper('form'); 		
		$this->load->view('admin/pdftohtml.html');
	}


	/**
	 * PDF转化
	 */
	public function tran()
	{
		// $nsid = $this->uri->segment(3);
		$nsid = 12;
		$Zpath = getcwd() . '\zhua\downloadjlrb.exe';
		// echo $Zpath;die;
		$stratus = system("$Zpath");
		// echo $stratus;die;
		if($stratus){
			$this->zhuan();									//pdf的转换
			$this->delpdf();								//删除转换后的pdf文件
			$this->DealHtml($nsid) ;								//枚举当前的所有html文件
			// $this->delhtml();								//删除所有的处理前HTML文件
		}
	}

	/**
	 * 删除所有的处理前HTML文件
	 */
	public function delhtml()
	{
		foreach (glob("*.html") as $key) {
			//echo $key . '<br>';
			unlink($key);
		}
	}



	/**
	 * 将base64的内容，写入到图片中。
	 * @param [type] $base64 [description]
	 * @param [type] $path   [description]
	 */
	public function Base64ToImg($base64) {					//将base64的内容，写入到图片中。
		// 解码
		$img = base64_decode($base64);

		// 写入到文件
		return $img;
	}

	/**
	 * 获得HTML头部
	 */
	public function GetHeader() {								// 获得HTML头部
		$HtmlHeader = '
<!DOCTYPE html>
<!-- Created by pdf2htmlEX (https://github.com/coolwanglu/pdf2htmlex) -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8"/>
<meta name="generator" content="pdf2htmlEX"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		';

		return $HtmlHeader;
	}

	public function GetFooter() {								//获得尾部
		$HtmlFooter = '
</body>
</html>
		';

		return $HtmlFooter;
	}

	/**
	 * 获得HTML样式内容，返回样式所在文件的位置
	 * @param [type] $HtmlContext [HTML全文内容]
	 * 路径位置：
	 * 		html
	 * 			|--style
	 * 				|--文件名1
	 * 					|--CSS
	 * 						|--style.css
	 * 					|--images
	 * 				|--文件名2
	 * 					|--CSS
	 * 						|--style.css
	 * 					|--images
	 * 	返回值：返回style.css在网站中的URL位置
	 */
	public function SplitStyle($HtmlContext, $fileNoExt,$nsid) {						//获得样式
		// echo $nsid;die;
		// 查找串定义
		$fBegStr = '<style type="text/css">';
		$fEndStr = '<title></title>';

		//获得报纸id
		// $nsid = $this->uri->segment(3);
		// $nsid = 12;
		// 在内容中取出style信息
		$begPos = strpos($HtmlContext, $fBegStr);
		$endPos = strpos($HtmlContext, $fEndStr);

		if($endPos > $begPos) {
			// 获取样式内容
			$htmlStyle = substr($HtmlContext, $begPos, $endPos - $begPos);
			// 将样式内容写入文件
			
			$cssPath = getcwd() . '\DHB\\' . $nsid . '\css\\' . $fileNoExt . '.css';
			// echo $cssPath;die;
			file_put_contents($cssPath, $htmlStyle);
		}//end if

		// 整理返回的style的代码
		// <link rel="stylesheet" type="text/css" href="css.css" />
		$retStyle = '<link rel="stylesheet" type="text/css" href="';
		$retStyle = $retStyle . base_url() . 'DHB\\'. $nsid . '\css\\' . $fileNoExt . '.css';
		$retStyle = $retStyle . '"/>';
		// echo $retStyle;die;
		return $retStyle;
	}

	/**
	 * [SplitStyle description]
	 * @param [type] $HtmlContext [description]
	 * @param [type] $fileNoExt   [description]
	 */
	public function SplitContext($HtmlContext, $fileNoExt, $nsid) {			//取出特定的字符串
		// 取出串内容
		$begPos = strpos($HtmlContext, '<title></title>');
		$Context = substr($HtmlContext, $begPos);
		$retContext = '';

		//将字符串转化为数组
		$allLine = preg_split ("/[\n]/", $Context, 0, PREG_SPLIT_NO_EMPTY);

		//获得报纸id
		// $nsid = $this->uri->segment(3);
		// $nsid = 12;
		// 解析行内数据内容
		$fBaseStr = 'data:image/png;base64,';
		$num = 1;
		foreach($allLine as $line) {
			$begPos = strpos($line, $fBaseStr);
			// 存在特征信息
			if($begPos) {
				// 查找结束点
				$endPos = strpos($line, '"/>', $begPos);
				// 取出base64内容
				$base64 = substr($line, $begPos + strlen($fBaseStr), $endPos - $begPos - strlen($fBaseStr));
				// 解码
				$base64 = $this->Base64ToImg($base64);
				// 整理图片存储位置
				$imgPath = getcwd() . '\DHB\\' . $nsid . '\images\\' .$fileNoExt . $num . '.png';
				// 写入文件
				file_put_contents($imgPath, $base64);

				// 将内容重新整理
				$temp = substr($line, 0, $begPos);
				$temp = $temp . base_url() . 'DHB/' . $nsid . '/images/' .$fileNoExt . $num . '.png';
				$temp = $temp . substr($line, $endPos);

				$retContext = $retContext . $temp . "\n";

				// 图片名称加1
				$num++;
			} else {
				$retContext = $retContext . $line . "\n";
			}//end if
		}//end foreach

		return $retContext;
	}

	/**
	 * 切分HTML
	 * @param [type] $htmlPath [description]
	 */
	public function SplitHtml($htmlPath,$nsid) {										//切分html文件
		
		// 1. 读取文件内容
		$HtmlContext = '';
		if(file_exists($htmlPath)) {
			if($fp = fopen($htmlPath, "r")) {
				//读取文件内容
				$HtmlContext = fread($fp, filesize($htmlPath));
			}//end if
		}//end if

		// 2. 切分样式内容
		$retStyle = $this->SplitStyle($HtmlContext, basename($htmlPath, ".html"), $nsid);

		// 3. 取内容部分
		$retContext = $this->SplitContext($HtmlContext, basename($htmlPath, ".html"), $nsid);

		// 4. 整合内容
		$AllPage = $this->GetHeader() . "\n" . $retStyle . "\n" . $retContext;
		
		// $nsid = $this->uri->segment(3);
		// $nsid = 12;
		// 5. 写出文件到指定目录下
		$filePath = getcwd() . '\DHB\\' . $nsid . '\\' . basename($htmlPath);
		// echo $filePath;die;

		
		file_put_contents($filePath, $AllPage);
		// return $nsid;
	}


	/**
	 * [DealHtml 处理HTML]
	 * @param [type] $path [某一个HTML在服务器中的位置]
	 */
	public function DealHtml($nsid) {							//在文件夹中找到转换后的html文件
		// 获得当前路径内容
		// $nsid = $this->uri->segment(3);
		// echo $nsid;die;
		$dirpath = getcwd();
		// 获得当前路径下所有HTML文件。
		foreach (glob("*.html") as $filename) {

			// 1. 建立文件所需要的目录
			// html
			//	|--style
			//		|--文件名1
			//			|--CSS
			//			|--images
			//		|--文件名2
			//			|--CSS
			//			|--images
			$fileNoExt = basename($filename, ".html");
			$cssPath = $dirpath . '\DHB\\' . $nsid . '\css';
			$imgPath = $dirpath . '\DHB\\' . $nsid . '\images';
			if(!is_dir($cssPath)) {
				mkdir($cssPath, 0777, true);
			}//end if
			if(!is_dir($imgPath)) {
				mkdir($imgPath, 0777, true);
			}//end if

			// 切分HTML
			$this->SplitHtml($dirpath . '\\' . $filename,$nsid);
			// return $nsid;
		}
	}





	/**
	 * 查看资源
	 * @return [type] [description]
	 */
	public function lookres() {
		$this->load->helper('form');
		$data['noname'] = $this->ziyuan->LookerPaper();
		$this->load->view('admin/lookres.html', $data);
	}


	/**
	 * 添加数据-报社数据
	 */
	public function add()
	{
		$id = 1;
		$lid = 1;
		//打开指定文件夹
		$hostdir = getcwd() . "\\DHB";
		//打开文件夹
		$dir = opendir($hostdir);
		//循环获得文件名
		while (($file = readdir($dir)) !== false)
	    {
	        if($file !="." && $file !="..")
	        {
        		//获得id
	        	$nsid = $file;
	        	$data = $this->ziyuan->show();
	        	//根据id获得相应名称
				$sname = $this->baozhi->check($nsid);
				$nsname = $sname[0]['nsname'];
				$noid = $sname[0]['noid'];
				$oname = $this->baoshe->check($noid);
				$noname = $oname[0]['noname'];
				// echo $noname;die;
				$name = getcwd() . "\\dhb\\" . $nsid . "\\";
				foreach(glob($name.'*html') as $ipath)
				{
					$path = substr($ipath,25);
					// echo $path;die;
					$data = array(
						'nsid'   => $nsid,
						'nsname' => $nsname,                            //报纸名
						'noname' => $noname,                            //报社名
						'path' => $path,                                //存放位置
						'layout' => "第" . $id++ . "版" ,               //版面名称
						'layoutindex' => $lid++,                         //版面索引
						'date'        => time()
					);
					// p($data);
					$this->ziyuan->add($data);
				}
				
	        }
	    }
	    closedir($dir);
	}


/*
	public function insertData()
	{
		$noid = 1;                   //报社id
		$nsid = 3;                   //报纸id
		$id = 1;                     //展示id
		$layout_id = 1;              //版面索引
		$dir="D:\\wamp\\www\\pdftohtmlsys\html";
		if($handle = opendir($dir))
		{
			while ($file = readdir($handle)) 
			{
				 if ( $file != '.' && $file != '..' )
				 {
				 	 if ( preg_match( "/\.(html)$/i" , $file)) {
				 
					 	$path="html/".$file;
					 	echo $path;die;
					 	$layout=$layout_id++."版";
					 	$arr = $arrayName = array(
					 		'noid' => $noid,
					 		'nsid' => $nsid,
					 		'layout' =>$layout , 
					 		'path' =>$path , 
					 		'layoutindex' => $id++, 
					 		);
					 	var_dump($arr);die;
						$this->ziyuan->store($arr);

	     //                echo $file ."<br>";
	                	}
				 }

				
			}
		}
	}*/
}






