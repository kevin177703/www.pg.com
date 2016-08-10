<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台管理员相关
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
/**
 * @property Bmodel_model $model
 */
class Madmin{
	private $ci;   
	private $model;
	function __construct(){
		$this->ci = ci();
	}
	function set_bmodel($model){
		$this->model = $model;
	}
	/**
	 * 根据账号获取用户信息
	 * @param $username 登录账号
	 * @param $brand_id 品牌id
	 */
	function get_user_for_username($username,$brand_id){
		return $this->model->get($this->model->table_admin,array("username"=>$username,"brand_id"=>$brand_id));
	}
	/**
	 * 根据账号id获取用户信息
	 * @param $uid 用户uid
	 */
	function get_user_for_uid($uid){
		return $this->model->get($this->model->table_admin,array("id"=>$uid));
	}
	/**
	 * 根据账号id修改账号信息
	 * @param $data
	 * @param $uid
	 */
	function edit_user_for_uid($data,$uid){
		return $this->model->edit($this->model->table_admin,$data,array("id"=>$uid));
	}
	/**
	 * 根据id获取用户组
	 * @param $id 组id
	 */
	function get_group_for_id($id){
		return $this->model->get($this->model->table_admin_group,array("id"=>$id));
	}
	/**
	 * 获取菜单
	 */
	function get_menu($token){
		$key = "admin_menu_{$token}";
		$info = $this->model->memcache->get($key);
		if(empty($info)){
			$info = null;
			$sucess = false;
			$where = array('status'=>'Y');
			$data = $this->model->get_list($this->model->table_admin_menu,$where,1000,0,array ('sort'));
			$data = $data ['rows'];
			$_data=array();
			$rsort=array();
			//$group=ex($group_list['menus_list']);
			foreach ( $data as $v ) {
				if ($v ['parent_id'] == 0) {
					$_data[$v['id']]['sort']=$v['sort'];
					$_data[$v['id']]['menuid']=$v['id'];
					$_data[$v['id']]['menuname']=$v['name'];
				} else {
					//正常用户权限
					//if(!in_array($v['id'],$group) && $group_id> $this->init->default_admin_group_id)continue;
					//管理员操作其他代理权限
					//if(!in_array($v['id'],$group) && $this->init->group_id == $this->init->default_admin_group_id && $this->init->op_agent_id>0)continue;
					$menus = array('menuid'=>$v['id'],'menuname'=>$v['name'],'url'=>$v['url']);
					$_data[$v['parent_id']]['menus'][] = $menus;
				}
			}
			foreach($_data as $k=>$v){
				if(!isset($v['menus']))unset($_data[$k]);    //不显示无子菜单的菜单项
				if(!isset($v['menuname']))unset($_data[$k]); //不显示无父菜单的菜单项
			}
			if(count($_data)>0 && !empty($_data))$sucess=true;
			$_data = array2sort ($_data, 'sort');
			$data = '{"menus":[';
			foreach ( $_data as $v ){
				$data .= '{';
				$data .= '"menuid":"'.$v['menuid'].'",';
				$data .= '"menuname":"'.$v['menuname'].'",';
				$data .= '"menus":[';
				foreach ( $v ['menus'] as $vv) {
					$data .='{"menuid":"'.$vv['menuid'].'","menuname":"'.$vv['menuname'].'","url":"'.$vv ['url'].'"},';
				}
				$data .= ']},';
			}
			$data .= ']}';
			if($sucess){
				$info = $data;
				$this->model->memcache->set($key, $info);
			}
		}
		return $info;
	}
}