<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台默认操作
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 * 
 * @property Dinit $init
 */
class Home_main{
	private $init;                           //默认类
	function __construct($init){
		$this->init = $init;
	}
	function index(){
		echo "home";
	}
	function login(){
		
	}
	function ajax_login(){
		
	}
}