<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 开发管理
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
/**
 * @property Bmodel_model $model
 */
class Mdeveloper{
	private $ci;   
	private $model;
	function __construct(){
		$this->ci = ci();
	}
	function set_bmodel($model){
		$this->model = $model;
	}
	/**
	 * 保存菜单
	 * @param $data
	 * @param $id
	 */
	function save_menus($data,$id=0){
		if($id>0){
			return $this->model->edit($this->model->table_developer_menu, $data, array("id"=>$id));
		}else{
			return $this->model->save($this->model->table_developer_menu, $data);
		}
	}
	/**
	 * 删除菜单
	 */
	function del_menus($id){
		return $this->model->del($this->model->table_developer_menu, array("id"=>$id));
	}
	/**
	 * 获取对应条件的菜单列表
	 * @param $parent_id 菜单父类id
	 * @param $limit 个数
	 * @param $offset 起始
	 * @param $order 排序
	 */
	function get_menus_list($parent_id,$limit,$offset=0,$order=array()){
		if($parent_id>=0)$where['parent_id'] = $parent_id;
		return $this->model->get_list($this->model->table_developer_menu,$where,$limit,$offset,$order);
	}
	/**
	 * 根据域名获取菜单信息
	 * @param $url url
	 * @param $action 操作
	 */
	function get_menu_for_url($url,$action){
		$where = array('status'=>'Y','url'=>$url,'action'=>$action);
		return $this->model->get($this->model->table_developer_menu,$where);
	}
	/**
	 * 根据条件获取一条菜单数据
	 * @param $where
	 */
	function get_menu_one($where){
		return $this->model->get($this->model->table_developer_menu,$where);
	}
	/**
	 * 获取菜单
	 */
	function get_menus($token,$showparent=false){
		$key = "admin_menu_{$token}";
		$info = $this->model->memcache->get($key);
		if(empty($info)){
			$info = null;
			$where = array('status'=>'Y','level <'=>3);
			$data = $this->model->get_list($this->model->table_developer_menu,$where,1000,0,array('sort'=>'ASC'));
			$data = $data['rows'];
			if(count($data)<1)return null;
			$_data=array();
			//$group=ex($group_list['menus_list']);
			foreach ( $data as $v ) {
				if ($v ['parent_id'] == 0) {
					$_data[$v['id']]['sort']=$v['sort'];
					$_data[$v['id']]['menuid']=$v['id'];
					$_data[$v['id']]['menuname']=$v['name'];
					$_data[$v['id']]['parent_id']=$v['parent_id'];
				} else {
					//正常用户权限
					//if(!in_array($v['id'],$group) && $group_id> $this->init->default_admin_group_id)continue;
					$url = empty($v['action'])?$v['url']:$v['url']."?action=".$v['action'];
					$menus = array('menuid'=>$v['id'],'menuname'=>$v['name'],'url'=>$url,"parent_id"=>$v['parent_id']);
					$_data[$v['parent_id']]['menus'][] = $menus;
				}
			}
			foreach($_data as $k=>$v){
				if(!isset($v['menus']) && $showparent==false)unset($_data[$k]);    //不显示无子菜单的菜单项
				if(!isset($v['menuname'])){
					unset($_data[$k]); //不显示无父菜单的菜单项
				}
			}
			$data = array2sort ($_data, 'sort',false);
			if(count($data)>0 && !empty($data)){
				$info = $data;
				$this->model->memcache->set($key, $info);
			}
		}
		return $info;
	}
	/**
	 * 修改单条数据
	 * @param $data 数据内容
	 * @param $where 条件
	 */
	function edit_menus_one($data,$where){
		return $this->model->edit($this->model->table_developer_menu, $data, $where);
	}
	/**
	 * 根据id修改多条数据
	 * @param $data 数据内容
	 * @param $index weher键
	 */
	function edit_menus_more($data,$index="id"){
		return $this->model->edit_batch($this->model->table_developer_menu, $data, $index);
	}
}