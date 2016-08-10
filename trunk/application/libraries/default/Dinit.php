<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 默认处理方法  
 * @version 1.0.0
 * @author kevin email:kevin177703@gmail.com
 */
/**
 * @property Dmodel $model
 * @property Dcurl $curl
 * @property Dmemcache $memcache
 * @property Dlog $log
 * @property Dsmarty $smarty
 */
class Dinit{
	//*******************CI*************************/
	private $ci = null;
	
	//*******************自定义***********************/
	public $is_ajax = false;						//是否是ajax
	public $url = "";								//url
	
	//*******************自定义类**********************/
	public $model = null;							//数据库模型类
	public $smarty = null;             				//smarty类
	public $curl = null;                    		//数据链接类
	public $log = null;                     		//文件日志类
	public $memcache = null;                		//缓存类
	
	//******************网站基础数据********************/
	public $brand_name = "";						//品牌名字
	public $brand_id = 0;							//品牌id
	public $agent_id = 0;							//代理id
	public $template_name = "";						//获取模板名称
	//构造函数
	function __construct(){
		$this->ci = ci();
		$this->smarty = library("dsmarty");
		$this->model = library("dmodel");
		$this->curl = library("dcurl");
		$this->log = library("dlog");
		$this->memcache = library("dmemcache");
		$this->init();
	}
	//引导方法
	function init(){
		$host = $this->model->brand->get_brand_for_host(ROOT_HOST);
		if(!isset($host['id'])){
			$this->log->w404("host查询失败");
			show_404();
		}
		
		//分析url
		$url_one = $this->ci->uri->segment(1);
		$url_two = $this->ci->uri->segment(2);
		$url_one = strtolower($url_one);
		$url_two = strtolower($url_two);
		$url_one = empty($url_one)?"index":$url_one;
		$this->url = $url_one;
		if($url_one=="ajax"){
			$this->url = $url_two;
			$this->is_ajax = true;
		}
		if(strpos($this->url,"-")==false)$this->url="main-{$this->url}";
		
		//设置品牌编码
		$brand_no = $host['id']<10?"Brand00{$host['id']}":($host['id']<100?"Brand0{$host['id']}":"Brand{$host['id']}");
		$this->smarty->set_brand_no($brand_no);
		$this->log->set_brand_no($brand_no);
		$this->memcache->set_brand_no($brand_no);
		$this->model->set_class($this->log,$this->memcache);
		
		$this->brand_id = $host['id'];
		$this->brand_name = $host['name'];
		$this->agent_id = $host['agent_id'];
		
		//设置模板地址
		$template = $this->model->brand->get_brand_template_for_id($host['template_id']);
		if(!isset($template['id'])){
			$this->log->w404("没有设置模板");
			show_404();
		}
		$this->template_name = $template['name'];
		if(!file_exists(ROOT_PUBLIC."{$this->template_name}/html")){
			$this->log->w404("模板路径不存在");
			show_404();
		}
		$this->smarty->set_brand_template($this->template_name);
		
		if($host['app'] != APP){
			if($this->is_ajax){
				$this->log->w404("ajax地址异常");
				show_404();
			}
			if($host['app']=="home"){
				header("Location:/");
			}else{
				header("Location:/{$host['app']}/");
			}
		}
	}
	/**
	 * 引入smarty模版，带参数
	 * @param $html
	 * @param $data
	 */
	function display($html, $data = array()) {
		$this->smarty->dassign($data);
		$this->smarty->ddisplay($html.'.html');
	}
	/**
	 * 引入smarty模版参数
	 * @param $data
	 */
	function assign($data){
		$this->smarty->dassign($data);
	}
	/**
	 * 直接返回smarty模版数据,带参数
	 * @param $html
	 * @param $data
	 */
	function fetch($html, $data = array()) {
		$this->smarty->dassign($data);
		return $this->smarty->dfetch($html.'.html');
	}
}