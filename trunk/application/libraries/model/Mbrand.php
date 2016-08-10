<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 品牌相关
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
/**
 * @property Bmodel_model $model
 */
class Mbrand{
	private $ci;   
	private $model;
	function __construct(){
		$this->ci = ci();
	}
	function set_bmodel($model){
		$this->model = $model;
	}
	/**
	 * 根据域名获取网站信息
	 * @param string $host 网站域名
	 */
	function get_brand_for_host($host){
		//此方法未例外，必须另外获取mode和memcache对象,其他所有方法都引用Dinit对象中的
		if(empty($this->model))$this->model = model("bmodel");
		if(empty($this->model->memcache))$this->model->memcache = library("dmemcache");
		$no = $this->model->memcache->getNo($this->model->memcache->mem_brand);
		$key = "brand_get_brand_for_host_{$this->model->memcache->mem_brand}_{$host}_{$no}";
		$info = $this->model->memcache->get($key);
		if(empty($info)){
			$info = null;
			$sql = "SELECT b.id,b.`name`,bh.`host`,bh.template_id,bh.app,bh.agent_id FROM  "
				  ."{$this->model->table($this->model->table_brand)} b LEFT JOIN  "
				  ."{$this->model->table($this->model->table_brand_host)} bh ON b.id=bh.brand_id "
				  ."where b.del='N' and bh.del='N' and bh.host='{$host}'";
			$data = $this->model->one($sql);
			if(isset($data['id'])){
				$info = $data;
				$this->model->memcache->set($key, $info);
			}
		}
		return $info;
	}
	/**
	 * 根据模板id获取模板名称
	 * @param $id
	 */
	function get_brand_template_for_id($id){
		$no = $this->model->memcache->getNo($this->model->memcache->mem_brand);
		$key = "brand_get_brand_template_for_id_{$this->model->memcache->mem_brand}_{$id}_{$no}";
		$info = $this->model->memcache->get($key);
		if(empty($info)){
			$info = null;
			$data = $this->model->get($this->model->table_brand_template, array("id"=>$id));
			if(isset($data['id'])){
				$info = $data;
				$this->model->memcache->set($key, $info);
			}
		}
		return $info;
	}
}