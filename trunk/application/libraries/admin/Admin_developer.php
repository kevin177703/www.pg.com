<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 开发管理
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 * 
 * @property Dinit $init
 * @property Admin $admin
 */
class Admin_developer{
	private $init;                           //默认类
	private $admin;                          //后台base
	function __construct($init){
		$this->init = $init;
		$this->admin = library("admin","admin");
		$this->admin->load($init);
	}
	//菜单管理
	function get_menus(){
		if($this->admin->action=='list'){
			$this->init->display("developer/menus_list");
		}elseif($this->admin->action=='edit'){
			
		}elseif($this->admin->action=='add'){
			
		}elseif($this->admin->action=='del'){
			
		}
	}
	//菜单管理-ajax
	function ajax_menus(){
		if($this->admin->action=='edit'){
			
		}elseif($this->admin->action=='add'){
			
		}
	}
}