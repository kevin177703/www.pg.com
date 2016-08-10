<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 前台base
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 * 
 * @property Dinit $init
 */
class Home{
	private $init;                           //默认类
	function __construct(){
	}
	function init($init){
		$this->init = $init;
	}
}