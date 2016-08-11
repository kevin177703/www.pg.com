<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台默认操作
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 * 
 * @property Dinit $init
 * @property Admin $admin
 */
class Admin_main{
	private $init;                           //默认类
	private $admin;                          //后台base
	function __construct($init){
		$this->init = $init;
		$this->admin = library("admin","admin");
		$this->admin->load($init);
	}
	//后台首页
	function get_index(){
		$data = array();
		$data['menu'] = $this->init->model->admin->get_menu($this->admin->token);
		$data['username']= $this->admin->username;
		$data['group_name']=$this->admin->group_name;
		$data['now']=time();
		$data['web_year']=date("Y");
		$this->init->assign($data);
		$this->init->display("main/index");
	}
	//后台登录页
	function get_login(){
		if($this->admin->uid > 0){
			skip();
		}
		$this->init->display("main/login");
	}
	//后台登陆页ajax
	function ajax_login(){
		if($this->admin->uid>0)json_ok("您已经登录，请不要重复登录");
		$username = post("username");
		$password = post("password");
		if(empty($username))json_error("账号不能为空");
		if(empty($password))json_error("密码不能为空");
		$username = strtolower($username);
		$password = strtolower($password);
		
		$operate_no = get_rand(18);
		$this->init->model->log->login($username,$operate_no,$this->admin->brand_id,"登录失败",'Y');
		
		$user = $this->init->model->admin->get_user_for_username($username,$this->admin->brand_id);
		if(!isset($user['id'])){
			$this->init->model->log->login($username,$operate_no,$this->admin->brand_id,"账号不存在",'Y');
			json_error("登录账号不存在,请重试");
		}
		$unlucktime = $user['unlucktime'];
		if(empty($unlucktime) || $unlucktime<time()-24*3600){
			$unlucktime = time()-24*3600;
		}
		if($user['is_luck']=='Y'){
			$time = time()-$user['lucktime'];
			if($time>24*3600){
				//当前解锁
				$unlucktime = time();
				//超过24小时自动解锁
				$this->init->model->admin->edit_user_for_uid(array("is_luck"=>'N',"lucktime"=>null,"unlucktime"=>$unlucktime),$user['id']);
			}else{
				$num = ceil((24*3600-$time)/3600);
				json_error("您的账号已被锁定，请{$num}小时后再试");
			}
		}
		//获取解锁时间后的登录错误次数
		$login_total = $this->init->model->log->login_num(array("addtime >"=>$unlucktime));
		if($login_total>=5){
			$this->init->model->admin->edit_user_for_uid(array("is_luck"=>'Y',"lucktime"=>time(),"unlucktime"=>time()),$user['id']);
			json_error("您的密码错误次数超过5次，账号被锁定，请联系管理员");
		}
		if($user['password']!=get_admin_password($username, $password)){
			$this->init->model->log->login($username,$operate_no,$this->admin->brand_id,"密码错误",'Y');
			json_error("登录密码错误，请重试");
		}
		//登陆成功后查询用户所在组
		$group = $this->init->model->admin->get_group_for_id($user['group_id']);
		if(!isset($group['id'])){
			$this->init->model->log->login($username,$operate_no,$this->admin->brand_id,"用户组错误",'Y');
			json_error("登录失败,请重试或联系管理员001");
		}
		unset($user['password']);
		$session = array("user"=>$user,"group"=>$group);
		if($this->init->model->session->add_session($session, $this->admin->token,"Y")==false){
			$this->init->model->log->login($username,$operate_no,$this->init->brand_id,"session错误",'Y');
			json_error("登录失败,请重试或联系管理员002");
		}
		//正确登录后重置登录错误次数
		if($login_total>0){
			$this->init->model->admin->edit_user_for_uid(array("is_luck"=>'N',"lucktime"=>null,"unlucktime"=>time()),$user['id']);
		}
		//登录成功后记录登录信息
		$this->init->model->log->login($username,$operate_no,$this->admin->brand_id,'登录成功','Y','Y');
		json_ok("登录成功");
	}
	//修改登录密码
	function ajax_editpass(){
		$password = post("password");
		$new_password = post("new_password");
		$c_new_password = post("c_new_password");
		if(empty($password))json_error("请输入原始密码");
		if(empty($new_password))json_error("请输入新密码");
		if($new_password != $c_new_password)json_error("两次新密码不一致");
		$user = $this->init->model->admin->get_user_for_uid($this->admin->uid);
		if(!isset($user['id']))json_error("用户查询失败，请重试");
		if($user['password'] != get_admin_password($this->admin->username, $password))json_error("原始密码不正确");
		$password = get_admin_password($this->admin->username, $new_password);
		if($this->init->model->admin->edit_user_for_uid(array("password"=>$password), $this->admin->uid)){
			$this->init->model->log->notes($this->init->brand_id, $this->admin->uid, $this->admin->opener_name,"修改登录密码");
			json_ok("密码修改成功");
		}
		json_error("密码修改失败");
		
	}
	//退出登录
	function ajax_logout(){
		del_all_cookie();
		json_ok();
	}
}