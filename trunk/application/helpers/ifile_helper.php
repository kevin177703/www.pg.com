<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 文件处理方法  
 * @version 1.0.0
 * @author kevin email:kevin177703@gmail.com
 */
if(!function_exists('make_dir')){
	/**
	 * 创建目录
	 * @param $path 写入地址
	 * @param $is_file 是否有文件
	 */
	function make_dir($path,$is_file=false){
		$path = str_replace('\\','/',$path);
		$info = explode('/', $path);
		$_path = '';
		$len = count($info);
		for($i=0;$i<$len;$i++){
			$_path .= $info[$i];
			if($i==$len-1 && $is_file)continue;
			$_path .= '/';
			if(file_exists($_path))continue;
			@chmod($_path, 0777);
			@mkdir($_path);
			//每层添加index.html,防止目录读取
			if(!file_exists($_path.'index.html')){
				$content = '<!DOCTYPE html><html><head><title>403 Forbidden</title><meta charset="UTF-8">'
						.'</head><body><h1>Directory access is forbidden.</h1></body></html>';
						write($_path.'index.html',$content,'w+');
			}
		}
	}
}
if(!function_exists('write')){
	/**
	 * 文件写入
	 * @param $path  文件路径
	 * @param $data  文件内容
	 * @param $mode  写入方式
	 */
	function write($path,$data,$mode="a+"){
		make_dir($path,true);
		if ( ! $fp = @fopen($path, $mode)){
			return FALSE;
		}
		@flock($fp, LOCK_EX);
		@fwrite($fp, $data);
		@flock($fp, LOCK_UN);
		@fclose($fp);
		return TRUE;
	}
}