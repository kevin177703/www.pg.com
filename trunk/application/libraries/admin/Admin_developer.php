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
		$this->init->template_html = "developer";
	}
	//菜单管理
	function get_menus(){
		if($this->admin->action=='list'){
			$parent_id = get("parent_id","int");
			$level = get("level","int");
			if($level<1)$level = 1;
			if($parent_id<0)$parent_id = 0;
			$data = $this->init->model->developer->get_menus_list($parent_id,1000,0);
			$this->init->display("menus_list",array("data"=>$data['rows']));
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