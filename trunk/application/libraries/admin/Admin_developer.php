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
		switch ($this->admin->action){
			case "list":
				$parent_id = get("parent_id","int");
				$level = get("level","int");
				if($level<1)$level = 1;
				if($parent_id<0)$parent_id = 0;
				$data = $this->init->model->developer->get_menus_list($parent_id,1000,0,array("sort"=>"ASC"));
				$this->init->display("menus_list",array("data"=>$data['rows'],"parent_id"=>$parent_id));
				break;
			case "edit":
				$this->init->display("menus_edit");
				break;
			case "add":
				$this->init->display("menus_add");
				break;
			case "del":
				break;
			default:
				break;
		}
	}
	//菜单管理-ajax
	function ajax_menus(){
		switch ($this->admin->action){
			case "list":
				$branch = get("branch");
				if($branch=="sort"){
					$ids = post("ids");
					$sorts = post("sorts");
					$ids = rtrim($ids,",");
					$sorts = rtrim($sorts,",");
					if(empty($ids)||empty($sorts))json_error("数据为空");
					$ids = ex($ids,',');
					$sorts = ex($sorts,",");
					if(count($ids) != count($sorts))json_error("数据错误");
					$data = array();
					foreach ($ids as $k=>$v){
						$data[$k]['id']=$v;
						$data[$k]['sort']=$sorts[$k];
					}
					$this->init->model->developer->edit_menus_more($data);
					json_ok();
				}elseif($branch=="status"){
					$id=post("id","int");
					$status = post("status");
					if($id<1)json_error("参数错误");
					$status = $status==true?"N":"Y";
					if($this->init->model->developer->edit_menus_one(array("status"=>$status), array("id"=>$id))){
						json_ok();
					}
					json_error("修改失败");
				}
				break;
			case "edit":
				break;
			case "add":
				break;
			case "del":
				break;
			default:
				break;
		}
	}
}