<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 字符处理方法  
 * @version 1.0.0
 * @author kevin email:kevin177703@gmail.com
 */
if(!function_exists('ex')){
	/**
	 * 分割字符串为数组
	 * @param  $data 需要分割的字符串
	 * @param  $l    分割符
	 */
	function ex($data,$l=','){
		if(empty($data))return array();
		$data = explode($l, $data);
		return $data;
	}
}
if(!function_exists('array2sort')){
	/**
	 * 按指定字段排序
	 * @param $data 要排序的数组
	 * @param $sort 要排序的字段
	 * @param $desc 是否倒序
	 */
	function array2sort($data,$sort,$desc=true){
		$info = array();
		$_key = "array2sort_desc_key";
		foreach ($data as $k=>$v){
			$v[$_key]=$k;
			$info[]=$v;
		}
		$num=count($info);
		if(!$desc){
			for($i=0;$i<$num;$i++){
				for($j=0;$j<$num-1;$j++){
					if($info[$j][$sort] > $info[$j+1][$sort]){
						foreach ($info[$j] as $key=>$temp){
							$t=$info[$j+1][$key];
							$info[$j+1][$key]=$info[$j][$key];
							$info[$j][$key]=$t;
						}
					}
				}
			}
		}
		else{
			for($i=0;$i<$num;$i++){
				for($j=0;$j<$num-1;$j++){
					if($info[$j][$sort] < $info[$j+1][$sort]){
						foreach ($info[$j] as $key=>$temp){
							$t=$info[$j+1][$key];
							$info[$j+1][$key]=$info[$j][$key];
							$info[$j][$key]=$t;
						}
					}
				}
			}
		}
		$data = array();
		foreach ($info as $v){
			$data[$v[$_key]]=$v;
			unset($data[$v[$_key]][$_key]);
		}
		return $data;
	}
}
if(!function_exists('merge')){
	/**
	 * 合并两个数组
	 * @param  $one
	 * @param  $two
	 */
	function merge($one,$two){
		if(empty($one) || count($one)<1)return $two;
		if(empty($two) || count($two)<1)return $one;
		$info = array();
		$i = 0;
		foreach ($one as $v){
			$info[$i]=$v;
			$i++;
		}
		foreach ($two as $v){
			$info[$i]=$v;
			$i++;
		}
		return $info;
	}
}
if(!function_exists('json_error')){
	/**
	 * 失败
	 * @param $data 参数
	 * @param $msg 提示
	 */
	function json_error($msg="error",$data=array()){
		$data=array("result"=>false,"msg"=>$msg,"data"=>$data);
		echo json_encode($data);
		exit();
	}
}
if(!function_exists('json_ok')){
	/**
	 * 成功
	 * @param $data 参数
	 * @param $msg 提示
	 */
	function json_ok($msg="success",$data=array()){
		$data=array("result"=>true,"msg"=>$msg,"data"=>$data);
		echo json_encode($data);
		exit();
	}
}
if(!function_exists('ex_string')){
	/**
	 * 截取字符串为数组
	 * @param $string  字符串
	 * @param $delimiter  截取的符号
	 */
	function ex_string($string,$delimiter){
		$str = explode($delimiter, $string);
		$len = count($str);
		if(empty($str[$len-1]) && $len-1>0){
			unset($str[$len-1]);
		}
		return $str;
	}
}
if(!function_exists('get_rand')){
	/**
	 * 创建随机字符
	 * @param  $len 长度
	 * @param  $title 首字符
	 * @param  $istoupper 是否大写
	 */
	function get_rand($len,$title='',$istoupper=false){
		$rand = get_rand_chr(18).microtime().get_rand_num(18);
		$rand = get_rand_chr(32,1).md5($rand).get_rand_num(32);
		$rand = str_shuffle($rand);
		$max = strlen($rand)-$len;
		$min = $max-rand(1, $max);
		$rand = $title.substr($rand,$min,$len);
		if($istoupper)$rand=strtoupper($rand);
		return $rand;
	}
}
if(!function_exists('get_rand_num')){
	/**
	 * 创建随机数字串
	 * @param $len 长度
	 */
	function get_rand_num($len){
		$a = mt_rand(100000000,999999999);
		$b = mt_rand(100000000,999999999);
		$c = mt_rand(100000000,999999999);
		$d = mt_rand(100000000,999999999);
		$e = mt_rand(100000000,999999999);
		$f = mt_rand(1,9);
		$rand = $a.$b.$c.$d.$e;
		$rand = str_shuffle($rand);
		$max = strlen($rand)-$len;
		$min = $max-rand(1, $max);
		$rand = $f.substr($rand,$min,$len-1);
		return $rand;
	}
}
if(!function_exists('get_rand_chr')){
	/**
	 * 创建随机字符串
	 * @param  $len 长度
	 * @param  $min 0大小写混合，1全小写，2全大写
	 */
	function get_rand_chr($len,$min=0){
		$rand = array_merge(range('a','z'),range('A','Z'));
		shuffle($rand);
		$rand = implode('',array_slice($rand,0,$len));
		if($min==1)$rand=strtolower($rand); //全部小写
		if($min==2)$rand=strtoupper($rand); //全部大写
		return $rand;
	}
}
if(!function_exists('set_user_pass')){
	/**
	 * 设置用户的密码
	 * @param $username  用户名
	 * @param $password  密码
	 */
	function set_user_pass($username,$password){
		$password = strtolower($username).'|'.strtolower($password);
		$password = md5($password);
		$password = strtolower($password);
		return $password;
	}
}
if(!function_exists('color')){
	/**
	 * 设置字体颜色
	 * @param $data 需要设置的文字
	 * @param $color 颜色css
	 */
	function color($data,$color='red'){
		$html = "<span class='{$color}'>{$data}</span>";
		return $html;
	}
}
if(!function_exists('time_red')){
	/**
	 * 判断指定时间是否是当天时间，当天时间，颜色变为红色
	 * @param $time
	 */
	function time_red($time){
		$_date = date('Y-m-d');
		$date = date("y-m-d H:i:s",$time);
		if($time>strtotime($_date)){
			$date = color($date);
		}
		return $date;
	}
}
if(!function_exists('set_md5')){
	/**
	 * 设置md5
	 * @param string $value 需要md5的数据
	 * @param string $is_name  是否是name值
	 * @param string $key  md5加密密钥
	 * @param string $is_ip  是否启用ip加密
	 * @return string
	 */
	function set_md5($value,$is_name=false,$is_ip=true){
		$key = "^D0Fs)83&^bd9*vd42wet?.17yua(23*df5er";
		$ip = $is_ip?ip():"";
		$md5 = md5($value.$ip.$key.ROOT_HOST);
		$md5 = $is_name?substr($md5,11,20):substr($md5,2,23);
		return strtoupper($md5);
	}
}
if(!function_exists('set_cookieI')){
	/**
	 * 设置cookie
	 * @param $name key
	 * @param $value value
	 * @param $expire 时间，默认浏览器时间
	 */
	function set_cookieI($name,$value,$expire=0){
		setcookie($name,$value,$expire,'/');
		$value = set_md5($value.$name);
		$name = set_md5($name,true);
		setcookie($name,$value,$expire,'/');
	}
}
if(!function_exists('get_cookieI')){
	/**
	 * 获取cookie
	 * @param $name key
	 */
	function get_cookieI($name){
		$value = isset($_COOKIE[$name])?$_COOKIE[$name]:null;
		if(empty($value))return $value;
		$_name = set_md5($name,true);
		$_value = isset($_COOKIE[$_name])?$_COOKIE[$_name]:null;
		if($_value==set_md5($value.$name)){
			return $value;
		}
		return null;
	}
}
if(!function_exists('del_cookieI')){
	/**
	 * 删除cookie
	 * @param $name key
	 */
	function del_cookieI($name){
		$_name = set_md5($name,true);
		$time = time()-100;
		setcookie($name,null,$time,'/');
		setcookie($_name,null,$time,'/');
	}
}
if(!function_exists('del_all_cookie')){
	/**
	 * 删除所有的cookie
	 * @param $exception 不需要删除的cookie
	 */
	function del_all_cookie($exception=array()){
		if(!is_array($_COOKIE) || count($_COOKIE)<1)return false;
		$time = time()-100;
		foreach ($_COOKIE as $k=>$v){
			if(in_array($k, $exception))continue;
			setcookie($k,null,$time,'/');
		}
	}
}
if(!function_exists('get_admin_password')){
	/**
	 * 设置后台登录密码加密方式
	 * @param $username
	 * @param $password
	 */
	function get_admin_password($username,$password){
		return md5("[{$username}|{$password}]");
	}
}
if(!function_exists('get_web_password')){
	/**
	 * 设置网站登录密码加密方式
	 * @param $username
	 * @param $password
	 */
	function get_web_password($username,$password){
		return md5("[{$username}|kevin|{$password}]");
	}
}