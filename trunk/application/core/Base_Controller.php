<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Base_Controller 
 * @version 1.0.0
 * @author kevin177703@gmail.com 
 */
/**
 * 实现代码提示功能
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_Calendar $calendar
 * @property Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Language $language
 * @property CI_Log $log
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Unit_test $unit
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Zip $zip
 * @property CI_Form $form_validation
 * @property Dinit $init
 */
class Base_Controller extends CI_Controller {
	public $init = null;               //起始类
	public function __construct() {
		parent::__construct ();
		$this->init = library("dinit");
		$this->init();
	}
	function init(){
		$url = ex($this->init->url,"-");
		echo $this->init->url;
		exit();
		if(!isset($url[0]) || empty($url[0])){
			$url = "main-index";
			$url = ex($url,"-");
		}
		if(count($url)!=2){
			$this->init->log->w404("链接为空{$this->init->url}");
			show_404();
		}
		//对应文件夹
		$model = strtolower(APP);
		//判断类
		$class = $model."_".strtolower($url[0]);
		$class = ucfirst($class);
		
		$path = ROOT_APP_LIBRARIES."{$model}/{$class}.php";
		if(!file_exists($path)){
			$this->init->log->w404("{$path}不存在");
			show_404();
		}
		require_once $path;
		if(!class_exists($class)){
			$this->init->log->w404("{$path}的类{$class}不存在");
			show_404();
		}
		//判断类的方法
		$class = new $class($this->init);
		$method = strtolower($url[1]);
		$method = $this->init->is_ajax?"ajax_{$method}":"get_{$method}";
		if(!method_exists($class, $method)){
			$this->init->log->w404("{$path}的类{$class}的方法{$method}不存在");
			show_404();
		}
		$class->$method();
	}
}