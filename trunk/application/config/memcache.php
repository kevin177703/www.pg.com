<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 设置memcache配置  2015.07.17
 * @version 1.0.0
 * @author kevin177703@gmail.com 
 */
$config ['default']=array(
	'host'=>"43.240.51.2",
	'port'=>'11211',
	'expire'=>30*60,        //失效时间,秒
	'prefix'=>'kevin_',
);