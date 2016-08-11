<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台设置
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 * 
 * @property Dinit $init
 * @property Admin $admin
 */
class Admin_setting{
	private $init;                           //默认类
	private $admin;                          //后台base
	function __construct($init){
		$this->init = $init;
		$this->admin = library("admin","admin");
		$this->admin->load($init);
	}
	//菜单列表
	function get_menu(){
	}
	function get_group(){
	}
}