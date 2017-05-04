<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 后台默认控制器
 */
class BaozhiAdmin extends CI_Controller {
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
	 * 默认方法
	 */
	public function index()
	{

		//获得报纸id
		$nsid=isset($_GET['nsid'])?$_GET['nsid']:3;
		// 载入辅助函数
		$this->load->helper('form');
		$data['baoshe'] = $this->baoshe->show();	
		$data['baozhi'] = $this->baozhi->show();
		// 载入报纸页面
		$this->load->view('admin/Baozhiman.html', $data);
	}



	/**
	 * PDF转化
	 */
	public function tran()
	{	
		//获得id
		$nsid = $this->uri->segment(3);
		// echo $nsid;die;
		$this->zhua($nsid);							     //pdf的抓取
		$this->change();                                 //pdf转化为html
		$this->delpdf();								//删除转换后的pdf文件
		$this->DealHtml($nsid);						//处理当前的所有html文件
		$this->delhtml();							    //删除所有的处理前HTML文件
		$this->addhtml();								//向数据库中添加转换后的html
	}


	/**
	 * 抓取pdf报纸文件转换
	 */
	public function zhua($nsid)
	{	

		// $nsid = $this->uri->segment(3);
		// echo $nsid;
		switch ($nsid) {
			case 3:
				$Zpath = '.\zhua\downloadPDFxhrb.exe';
				system("$Zpath");
				break;
			
			case 4:
				$Zpath = '.\zhua\downloadgsrb.exe';
				system("$Zpath");
				break;

			case 5:
				$Zpath = '.\zhua\downloadlnrb.exe';
				system("$Zpath");
				break;

			case 6:
				$Zpath = '.\zhua\downloadPDFfzrb.exe';
				system("$Zpath");
				break;

			case 7:
				$Zpath = '.\zhua\downloadjfrb.exe';
				system("$Zpath");
				break;

			case 8:
				$Zpath = '.\zhua\downloadqlwb.exe';
				system("$Zpath");
				break;

			case 9:
				$Zpath ='.\zhua\downloadzghjb.exe';
				system("$Zpath");
				break;

			case 10:
				$Zpath = '.\zhua\downloadzgwhb.exe';
				system("$Zpath");
				break;

			case 11:
				$Zpath = '.\zhua\downloadzgjyb.exe';
				system("$Zpath");
				break;

			case 12:
				$Zpath = '.\zhua\downloadjlrb.exe';
				system("$Zpath");
				break;

			case 13:
				$Zpath = '.\zhua\downloaddhb.exe';
				system("$Zpath");
				break;

			case 14:
				$Zpath =  '.\zhua\downloadPDFyzwb.exe';
				system("$Zpath");
				break;				
			default:
				break;

		}

		$this->index();
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
	 * pdf转换html
	 */
	public function change()
	{
		$Zpath = '.\pdf\pdf2htmlEX.exe';
		
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
	public function GetHeader()                           // 获得HTML头部
	{								
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
            $cssPath = '.\\NEW\\' . date("Y-m-d",time()) ."\\" . $nsid . '\css\\' . $fileNoExt . '.css';


			// echo $cssPath;die;
			file_put_contents($cssPath, $htmlStyle);
		}//end if

		// 整理返回的style的代码
		// <link rel="stylesheet" type="text/css" href="css.css" />
		$NewCss = "<link rel=\"stylesheet\" href=\"../../css/bootstrap.min.css\">";
		$retStyle = '<link rel="stylesheet" type="text/css" href="';
		$retStyle = $retStyle . 'css/' . $fileNoExt . '.css';
		$retStyle = $retStyle . '">';
		return $NewCss . "\n" . $retStyle;
	}

/**
	 * [InsertJs 插入js]
	 */
	public function InsertJs(){

	    $NewJs = "<script src=\"../../js/jquery.min.js\"></script>" . "\n" . "<script src=\"../../js/bootstrap.min.js\"></script>";


	    $Code = "<script type=\"text/javascript\">
	    document.onmouseup = document.ondbclick= function(){
	        var txt;
	        if(document.selection){
	            txt = document.selection.createRange().text
	        }else{
	            txt = window.getSelection()+'';
	        }
	        if(txt){
	            $('#note-body').text(txt);
	            $('#add-note').modal();
	        }
	    }
	</script>";
    	return $NewJs . "\n" . $Code;
	}

	/**
	 * 插入from表单
	 */
	public function InsertFrom(){
		$from = '<div class="modal fade" id="add-note">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">添加笔记</h4>
	      </div>
	       <form action="http://127.0.0.1/index.php/IndexNote/store" method="POST">
	      <div class="modal-body">
	       <textarea style="width:100%;min-height:200px;resize:none;" name="note" id="note-body"></textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	        <button type="submit" class="btn btn-primary">添加</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>';
	    return $from;
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
				$imgPath ='.\NEW\\' . date("Y-m-d",time()) ."\\" . $nsid . '\images\\' .$fileNoExt . $num . '.png';
				// 写入文件
				file_put_contents($imgPath, $base64);

				// 将内容重新整理
				$temp = substr($line, 0, $begPos);
				$temp = $temp .  '.\images\\' .$fileNoExt . $num . '.png';
				$temp = $temp . substr($line, $endPos);

				$retContext = $retContext . $temp . "\n";

				// 图片名称加1
				$num++;
			} else {
				$retContext = $retContext . $line . "\n";
			}//end if
		}//end foreach

		return $retContext . $this->InsertFrom();
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
		$AllPage = $this->GetHeader() . "\n" . $retStyle . "\\" . $this->InsertJs() . "\n" . $retContext;
		
		// 5. 写出文件到指定目录下
		$filePath = '.\NEW\\' .  date("Y-m-d",time()) . "\\" . $nsid . '\\' . basename($htmlPath);
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
		$dirpath = '.';
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
			$cssPath = $dirpath . '\NEW\\' .  date("Y-m-d",time()) . "\\" . $nsid . '\css';
			$imgPath = $dirpath . '\NEW\\' .  date("Y-m-d",time()) . "\\" . $nsid . '\images';

	        if(!is_dir($cssPath)) {
	            mkdir($cssPath, 0777, true);
	        }//end if
	        if(!is_dir($imgPath)) {
	            mkdir($imgPath, 0777, true);
	        }

			// 切分HTML
			$this->SplitHtml($dirpath . '\\' . $filename,$nsid);
			// return $nsid;
		}
	}



	/**
	 * 添加数据-报社数据
	 */
	public function addhtml()
	{
		
		//打开指定文件夹
		$hostdir = ".\\NEW\\" . date("Y-m-d", time());
		// echo $hostdir;die;
		//打开文件夹
		$dir = opendir($hostdir);
		//循环获得文件名
		while (($file = readdir($dir)) !== false)
	    {
	        if($file !="." && $file !="..")
	        {
	        	$id = 1;
				$lid = 1;
        		//获得id
	        	$nsid = $file;
	        	// echo $nsid;
	        	//查询数据库中是否含有此nsid或者date
	        	$data = $this->ziyuan->show();
//                p($data);die;
	        	$time = $this->ziyuan->date();
//                p($time);die;
                date("Y-m-d",$time[0]);
//	        	系统当前日期
	        	$date = date("Y-m-d",time());
	        	//如果存在此id那这份报纸不添加
//	        	if(!in_array($nsid,$data)){
	        		// echo "还没有！请添加";die;
	        		//根据id获得相应名称
					$sname = $this->baozhi->check($nsid);
					// p($sname);
					$nsname = $sname[0]['nsname'];
					$noid = $sname[0]['noid'];
					$oname = $this->baoshe->check($noid);
					$noname = $oname[0]['noname'];
					// echo $noname;die;
					$name = ".\\NEW\\" . date("Y-m-d", time()) . "\\" . $nsid . "\\";
					// echo $name;die;
					foreach(glob($name.'*html') as $ipath)
					{
						// echo $ipath;die;
						$path = substr($ipath,2);
						// echo $path;die;
						$data = array(
							'nsid'   => $nsid,
							'nsname' => $nsname,                            //报纸名
							'noname' => $noname,                            //报社名
							'path' => $path,                                //存放位置
							'layout' => "第" . $id++ . "版" ,               //版面名称
							'layoutindex' => $lid++,                         //版面索引
							'date'        => strtotime(date("Y-m-d", time()))
						);
						// echo base_url();
						// p($data);
						$this->ziyuan->add($data);
					}
//	        	}
								
	        }
	    }
	    closedir($dir);
	}





	/**
	 * 添加数据-报纸数据
	 */
	public function add() {
		// 加载辅助函数
		$this->load->library('form_validation');
		$status = $this->form_validation->run('baozhi');

		if($status) {
			// 在编号中获得报纸ID(3|aaaa)
			$noname = $this->input->post('noname');
			$pos = strpos($noname, '|');
			$noid = substr($noname, 0, $pos);

			// 获得页面中的数据
			$data = array(
				//'noname' => $_POST['noname']
				'noid' => $noid,
				'nsname' => $this->input->post('nsname'),
				'url' => $this->input->post('zqurl'),
				'way' => $this->input->post('zqway'),
				'about' => $this->input->post('zyabout'),
				'createdata' => time()
				);

			// 数据库操作
			$this->baozhi->add($data);
			// 数据加载完成，重新加载页面。
			$this->index();
			
		} else {
			// 如果条件验证失败，重新加载页面。
			$this->index();
		}// end if
	}

	/**
	 * 删除报纸
	 */
	public function del() {
		// 在URL中获得noid
		$nsid = $this->uri->segment(3);
		// 数据库操作，删除数据
		$this->baozhi->del($nsid);
		// 刷新页面
		$this->index();
	}

}