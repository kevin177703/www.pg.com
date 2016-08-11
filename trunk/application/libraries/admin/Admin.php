<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 后台base
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 * 
 * @property Dinit $init
 */
class Admin{
	private $init;                           		//默认起始类
	public $token=null;								//令牌
	
	//**********************权限组********************/
	public $is_del = 'N'; 					 		//删除权限
	public $is_list = 'N'; 			         		//查看列表权限
	public $is_one = 'N'; 			         		//查看查看权限
	public $is_add = 'N'; 					 		//添加权限
	public $is_edit = 'N'; 							//编辑权限
	public $is_undo = 'N'; 					 		//冲正负权限
	public $is_exam = 'N'; 					 		//资金审核
	public $is_conf = 'N'; 					 		//资金确认
	
	//**********************后台参数*******************/
	public $user = array();							//用户
	public $group = array();						//用户组
	public $uid = 0;								//管理员id
	public $username = "";							//管理员账号
	public $group_id ="";							//管理员组id
	public $group_name = "";						//管理员组名称
	public $opener_name = "";						//操作员名称[组别][账号]
	public $is_admin_brand = false;					//是否是超级管理员品牌
	public $is_admin_group = false;					//是否是超级管理员
	public $brand_id = 0;							//品牌id
	
	function __construct(){
	}
	//装载后台基础数据
	function load($init){
		$this->init = $init;
		//设置cookie
		$token_name = md5("atoken".ROOT_HOST);
		$this->token = get_cookieI($token_name);
		if(empty($this->token)){
			$this->token = get_rand(32);
			set_cookieI($token_name, $this->token);
		}
		//获取用户session
		$session = $this->init->model->session->get_session($this->token,'Y');
		if(isset($session['user'])){
			$this->user = $session['user'];
			$this->group = $session['group'];
			$this->uid = $this->user['id'];
			$this->username = $this->user['username'];
			$this->group_id = $this->group['id'];
			$this->group_name = $this->group['name'];
			$this->opener_name = "[{$this->group_name}]{$this->username}";
			if($this->init->brand_id == ADMIN_BRAND_ID)$this->is_admin_brand = true;
			if($this->group_id == ADMIN_GROUD_ID) $this->is_admin_group = true;
		}
		//是否需要做登录判断
		$url = ex($this->init->url,"-");
		if($this->uid<1 && !in_array($url[1],array("login","logout"))){
			if($this->init->is_ajax){
				json_error("您的登录已超时");
			}else{
				skip("/admin/login");
			}
		}
		$this->brand_id = $this->init->brand_id;
		//全局模板变量
		$assign = array(
				"third"=>"/public/third/",
				"ico" =>"/public/{$this->init->template_name}/",
				"css"=>"/public/{$this->init->template_name}/css/",
				"js"=>"/public/{$this->init->template_name}/js/",
				"image"=>"/public/{$this->init->template_name}/image/",
				"img"=>"/public/{$this->init->template_name}/img/",
				"web_title"=>$this->init->brand_name,
				"web_date"=>date("Y-m-d"),
				"group"=>$this->group,
		);
		$this->init->assign($assign);
	}
	//权限处理
	private function _authority(){
		
	}
}