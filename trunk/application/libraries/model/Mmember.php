<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 用户相关
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
/**
 * @property Bmodel_model $model
 */
class Mmember{
	private $ci;   
	private $model;
	function __construct(){
		$this->ci = ci();
	}
	function set_bmodel($model){
		$this->model = $model;
	}
}