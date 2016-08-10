<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 配置常量
 * kevin177703@gmail.com
 */
$config= array();
//************************************地址配置*****************************************/
define("ROOT_APP_THIRD_PARTY", ROOT."application/third_party/");					//第三方类路径
define("ROOT_APP_LIBRARIES", ROOT."application/libraries/");						//自定义类地址

//***********************************常量配置******************************************/
define("ADMIN_BRAND_ID", 1);														//超管所在品牌id,
define("ADMIN_GROUD_ID", 1);														//超管级管理员组,
define("BRAND_GROUD_ID", 2);														//品牌管理员组