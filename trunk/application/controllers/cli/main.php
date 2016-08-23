<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Main extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		//查看是否是计划任务执行
		if(is_cli()==false){
			die();
		}
	}
}
