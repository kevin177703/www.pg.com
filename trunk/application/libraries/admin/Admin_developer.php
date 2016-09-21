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
	private $action_list =array();			 //操作类型
	function __construct($init){
		$this->init = $init;
		$this->admin = library("admin","admin");
		$this->admin->load($init);
		$this->init->template_html = "developer";
	}
	//菜单管理
	function get_menus(){
		$this->admin->lock_admin();
		$data = array();
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
				$hsubmit = post("hsubmit");
				$id = get("id");
				if($hsubmit == 1){
					$name = post("name");
					$parent_id = post("parent_id");
					$url = post("url");
					$action = post("action");
					$sort = post("sort");
					if(empty($name))json_error("请输入菜单名称");
					if($parent_id==0){
						$url="";
						$action = "";
					}else{
						if(empty($url))json_error("请输入菜单链接");
						if(empty($action))json_error("请输入操作权限");
					}
					$data = array("name"=>$name,"parent_id"=>$parent_id,"url"=>$url,"action"=>$action,"sort"=>$sort);
					if($this->init->model->developer->save_menus($data,$id)){
						$this->admin->sys_message("修改菜单{$name}成功", "developer-menus.html?action=list");
					}
					$this->admin->sys_message("修改菜单{$name}失败", "history",false);
				}
				$data['info'] = $this->init->model->developer->get_menu_one(array("id"=>$id));
				if(empty($data['info'])){
					$this->admin->sys_message("编辑错误，数据不存在", "history",false);
				}
				$data['menus'] = $this->init->model->developer->get_menus($this->admin->token,true);
				$data['id']=$id;
				$this->init->display("menus_edit",$data);
				break;
			case "add":
				$hsubmit = post("hsubmit");
				if($hsubmit == 1){
					$name = post("name");
					$parent_id = post("parent_id");
					$url = post("url");
					$action = post("action");
					$sort = post("sort");
					if(empty($name))json_error("请输入菜单名称");
					if($parent_id==0){
						$url="";
						$action = "";
					}else{
						if(empty($url))json_error("请输入菜单链接");
						if(empty($action))json_error("请输入操作权限");
					}
					$data = array("name"=>$name,"parent_id"=>$parent_id,"url"=>$url,"action"=>$action,"sort"=>$sort);
					if($this->init->model->developer->save_menus($data)){
						$this->admin->sys_message("添加菜单{$name}成功", "developer-menus.html?action=list");
					}
					$this->admin->sys_message("添加菜单{$name}失败", "history",false);
				}
				$data['menus'] = $this->init->model->developer->get_menus($this->admin->token,true);
				$this->init->display("menus_add",$data);
				break;
			default:
				$this->admin->sys_message("请问你找谁？", "history",false);
				break;
		}
	}
	//菜单管理-ajax
	function ajax_menus(){
		$this->admin->lock_admin();
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
					if(!in_array($status, array("Y","N")))json_error("数据错误");
					if($this->init->model->developer->edit_menus_one(array("status"=>$status), array("id"=>$id))){
						json_ok();
					}
					json_error("修改失败");
				}
				break;
			case "del":
				$id = post("id");
				if($this->init->model->developer->del_menus($id)){
					json_ok();
				}else{
					json_error("删除失败");
				}
				break;
			default:
				break;
		}
	}
}