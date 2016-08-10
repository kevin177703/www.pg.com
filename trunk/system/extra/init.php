<?php
/**
 * @author kevin email:kevin177703@gmail.com
 */
define('SUFFIX', '.html');//设置后缀
if(!isset($_SERVER['REQUEST_URI']) || !isset($_SERVER['HTTP_HOST'])){
	header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
	echo 'Please open the SERVER';
	exit(3);
}
$root_url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
define('ROOT_URL', $root_url);
define("ROOT_HOST", $_SERVER['HTTP_HOST']);
$url = parse($root_url);
$app = isset($url['expath'][1])?$url['expath'][1]:'';
$path = $url['path'];
$apps = array('admin','agent');
define("ROOT_APPS",json_encode($apps));  //APP列表
if(in_array($app,$apps)){
	unset($url['expath'][1]);
	$path = "";
	foreach ($url['expath'] as $v){
		$path .='/'.$v;
	}
	$path = substr($path,1);
	if(empty($path)) {
		$path="/";
	}
}else{
	$app='home';
}
define('APP', $app);
//添加参数
$query = isset($url['query'])?"?".trim($url['query']):"";
$_SERVER['REQUEST_URI'] = $path.$query;
//-------------------------------------------------方法区------------------------------
/**
 * 分解url
 * @param $url
 */
function parse($url){
	$info = parse_url($url);
	if(isset($info['path']))$info['path']=strtolower($info['path']);
	$path = isset($info['path'])&&!empty($info['path'])?explode('/', $info['path']):"";
	foreach ($path as $v){
		if($v=='index.php')continue;
		$v = str_replace(SUFFIX,'',$v);
		$info['expath'][] = $v;
	}
	return $info;
}