<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 公共处理方法  
 * @version 1.0.0
 * @author kevin email:kevin177703@gmail.com
 */
if(!function_exists('ci')){
	/**
	 * 获取ci对象
	 */
	function ci(){
		$CI =& get_instance();
		return $CI;
	}
}
if(!function_exists('post')){
	/**
	 * 获取post数据
	 * @param $name 参数
	 * @param $type 强制类型
	 */
	function post($name,$type=null){
		$data = ci()->input->post($name,true);
		$data = trim($data);
		if($type=='int')$data = intval($data);
		return $data;
	}
}
if(!function_exists('get')){
	/**
	 * 获取get数据
	 * @param $name 参数
	 * @param $type 强制类型
	 */
	function get($name,$type=null){
		$data = ci()->input->get($name,true);
		$data = trim($data);
		if($type=='int')$data = intval($data);
		return $data;
	}
}
if(!function_exists('get_data')){
	/**
	 * 获取post或get数据
	 * @param $name 参数
	 * @param $type 强制类型
	 */
	function get_data($name,$type=null){
		if(isset($_POST[$name]))return post($name,$type);
		if(isset($_GET[$name]))return get($name,$type);
		return null;
	}
}
if(!function_exists('library')){
	/**
	 * 加载library
	 * @param $library library文件名
	 * @param $file library目录
	 */
	function library($library,$file='default',$data=array()) {
		$ci = ci();
		$library = strtolower($library);
		$path = ucfirst($library);
		if(!empty($file)){
			$path = strtolower($file)."/".$path;
		}
		$ci->load->library($path,$library);
		return $ci->$library;
	}
}
if(!function_exists('model')){
	/**
	 * 加载model
	 * @param $model model文件名
	 */
	function model($model){
		$ci = ci();
		$model = strtolower($model)."_model";
		$ci->load->model($model);
		return $ci->$model;
	}
}
if(!function_exists('ip')){
	/**
	 * 获取ip
	 */
	function ip(){
		if (isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])){
			$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
		}elseif (isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])){
			$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
		}elseif (isset($HTTP_SERVER_VARS["REMOTE_ADDR"])){
			$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
		}elseif (getenv("HTTP_X_FORWARDED_FOR")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}elseif (getenv("HTTP_CLIENT_IP")){
			$ip = getenv("HTTP_CLIENT_IP");
		}elseif (getenv("REMOTE_ADDR")){
			$ip = getenv("REMOTE_ADDR");
		}elseif(isset($_SERVER['REMOTE_ADDR'])){
			$ip = $_SERVER['REMOTE_ADDR'];
		}else{
			$ip = "";
		}
		preg_match("/[\d\.]{7,15}/", $ip, $cips);
		$ip = isset($cips[0]) ? $cips[0] : 'unknown';
		unset($cips);
		return $ip;
	}
}