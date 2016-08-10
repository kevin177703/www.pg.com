<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * memcache缓存 
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
class Dmemcache {
	private $ci;
	private $config = null;
	private $cache = null;
	private $cache_prefix = null;
	private $cache_expire = null;
	
	//是否启用memcache缓存
	public $status = false;
	
	//**********************缓存额外参数名称***************************/
	public $mem_brand = "brand";							//品牌相关
	public $mem_session = "session";						//session相关
	
	function __construct() {
		$this->ci = ci();
		$this->ci->config->load('memcache');
		$this->config = $this->ci->config->config['default'];
		$cache_prefix = isset($this->config['prefix'])?$this->config['prefix']:'kevin_';
		$this->cache_expire = isset($this->config['expire'])?$this->config['expire']:60*30;
		$this->cache_prefix = $cache_prefix."_";
		$this->content();
	}
	//添加网站编码前缀
	function set_brand_no($brand_no){
		$this->cache_prefix = $this->cache_prefix.$brand_no."_";
	}
	//链接缓存
	function content(){
		if($this->status==false)return null;
		try {
			if (empty($this->cache) && isset($this->config['host'])){
				$cache = @new Memcache();
				if ($cache->connect($this->config['host'], $this->config['port'])){
					$this->cache = $cache;
				}
			}
		}catch(Exception $e){
			$this->cache = null;
		}
	}
	//设置缓存
	function set($key, $value, $expire = 0) {
		if(empty ( $this->cache ))return false;
		$key = $this->getKey($key);
		if($expire == 0)$expire = $this->cache_expire;
		return @$this->cache->set($key, $value, MEMCACHE_COMPRESSED, $expire );
	}
	//获取缓存
	function get($key) {
		if (empty($this->cache))return null;
		$key = $this->getKey($key);
		return @$this->cache->get($key);
	}
	// 删除缓存
	function delete($key, $timeout = 0) {
		if (empty($this->cache))return null;
		$key = $this->getKey($key);
		@$this->cache->delete($key, $timeout);
	}
	//更新关键编号
	function setNo($key){
		if (empty($this->cache))return null;
		$key = "cache_no_".$key;
		$no = $this->get($key);
		$no = $no>0?$no+1:2;
		$this->set($key, $no);
	}
	//获取关键编号
	function getNo($key){
		if(empty ( $this->cache ))return false;
		$key = "cache_no_".$key;
		$no = $this->get($key);
		if($no<1)$no=1;
		return $no;
	}
	//使所有缓存失效
	function clean() {
		if (empty($this->cache))return null;
		return $this->cache->flush();
	}
	//获取key
	function getKey($key){
		$key = $this->cache_prefix.'_'.md5($key);
		return $key;
	}
}