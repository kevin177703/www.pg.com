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
}