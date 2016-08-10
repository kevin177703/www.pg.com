<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 日志类
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
class Dlog {
	private $brand_no = "Brand000";
	private $path = "";
	private $title = "";
	function __construct() {
		$this->path = ROOT_DATA."{$this->brand_no}/";
		$this->title = date("Ym")."/log_".date("d").".php";
	}
	function set_brand_no($brand_no){
		$this->brand_no = empty($brand_no)?$this->brand_no:$brand_no;
		$this->path = ROOT_DATA."{$this->brand_no}/";
	}
	/**
	 * 404日志
	 */
	function w404($content){
		$path = "{$this->path}404/{$this->title}";
		$content = "{$content};访问地址:".ROOT_URL.";访问参数:GET".json_encode($_GET).";POST=".json_encode($_POST);
		echo $content;
		$this->_write($content, $path);
	}
	/**
	 * 浏览日志
	 * @param $username
	 * @param $uid
	 */
	function view(){
		$path = "{$this->path}view/{$this->title}";
		$content = "访问地址:".ROOT_URL.";访问参数:GET".json_encode($_GET).";POST=".json_encode($_POST);
		$this->_write($content, $path);
	}
	/**
	 * 普通日志
	 */
	function log($content){
		$path = "{$this->path}log/{$this->title}";
		$this->_write($content, $path);
	}
	/**
	 * api日志
	 * @param string $content 说明
	 * @param string $url api
	 * @param array $data 参数
	 */
	function api($content,$url=null,$data=null){
		$path = "{$this->path}api/{$this->title}";
		if(is_array($data))$data = json_encode($data);
		$content = "{$content};url={$url};参数{$data}";
		$this->_write($content, $path);
	}
	/**
	 * 支付日志
	 */
	function pay($content,$type="bank"){
		$path = "{$this->path}pay/{$type}/{$this->title}";
		$content = "[{$type}]".$content;
		$this->_write($content, $path);
	}
	/**
	 * 金钱审核日志
	 */
	function cash($content){
		$path = "{$this->path}cash/{$this->title}";
		$this->_write($content, $path);
	}
	/**
	 * 数据库日志
	 * @param string $sql sql语句
	 * @param float $time 执行时间
	 * @param string $message 语句说明
	 */
	function sql($sql,$time=0,$message=""){
		$path = "{$this->path}sql/{$this->title}";
		$content = "[{$message}][{$time}]{$sql}";
		$this->_write($content, $path);
	}
	/**
	 * 日志写入
	 */
	private function _write($content,$path){
		if(is_array($content))$content = json_encode($content);
		$data = "[".date("Y-m-d H:i:s")."][".ROOT_HOST."][".ip()."]{$content}\r\n";
		write($path, $data);
	}
}