<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 检查处理方法  
 * @version 1.0.0
 * @author kevin email:kevin177703@gmail.com
 */
if(!function_exists('skip')){
	/**
	 * 跳转
	 * @param $url
	 * @param $param
	 */
	function skip($url="/",$message=""){
		$message = empty($message)?"":"alert('{$message}');";
		$url = url($url);
		$skip = '页面跳转中...若没跳转，请<a href="'.$url.'">点击这里</a><script>window.location= "'.$url.'";'.$message.'</script>';
		echo $skip;
		exit();
	}
}
if(!function_exists('url')){
	/**
	 * 生成url
	 * @param $url
	 * @param $param
	 */
	function url($url,$param=null){
		if(is_array($param)){
			$str = "";
			foreach ($param as $k=>$v){
				$str .= "&{$k}={$v}";
			}
			$param = ltrim($str,'&');
		}
		$param = empty($param)?"":"?".$param;
		$url = ($url=="/" || empty($url))?"/":$url.".html";
		$url = $url.$param;
		return $url;
	}
}
if(!function_exists('safe_sql')){
	/**
	 * 安全检查sql语句
	 * @param $data  要检查的数据
	 */
	function safe_sql($data,$need="[被屏蔽的字符]"){
		if(is_array($data)){
			$info = array();
			foreach ($data as $k=>$v){
				$k = safe_sql($k);
				$info[$k]=safe_sql($v);
			}
			return $info;
		}
		$sql = array("select","delete","insert","update","union","into","load_file","outfile");
		foreach ($sql as $v){
			$v = "{$v}";
			$data = str_replace($v,$need,$data);
		}
		return $data;
	}
}
if(!function_exists('check_ip')){
	/**
	 * 检查ip
	 * @param $ips ip段
	 * @param $ip 要检查的ip
	 * @param $empty 若ip段为空时返回bool
	 */
	function check_ip($ips,$ip=null,$empty=true){
		if(empty($ip))$ip=ip();
		$ips = trim($ips);
		if(empty($ips))return $empty;
		$ips = explode("\r\n",$ips);
		$data= null;
		foreach($ips as $v){
			$v = trim($v);
			if(!empty($v))$data[]=$v;
		}
		$ipregexp = implode('|', str_replace( array('*','.'), array('\d+','\.') ,$data));
		return preg_match("/^(".$ipregexp.")$/", $ip);
	}
}