<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * curl封装
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
class Dcurl {
	protected $Resource;
	protected $ErrorNum;
	protected $Result;
	private $path=null;
	protected $Options = array (
			CURLOPT_VERBOSE => 0,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_FOLLOWLOCATION => 1 
	);
	
	public function __construct(){
		$this->Resource = curl_init();
	}
	
	/**
	 * 发送一个 post 请求
	 */
	public function post($url, $params = array()) {
		$this->setOptions ( array (
				CURLOPT_URL => $url,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $params 
		) );
		return $this->exec ();
	}
	
	/**
	 * 以原始数据形式发送一个post请求
	 * 如 params是一个数组，会被转换成JSON格式的字符串
	 */
	public function rawPost($url, $params = array()) {
		$queryString = is_array ( $params ) ? json_encode ( $params ) : $params;
		$this->setOptions ( array (
				CURLOPT_URL => $url,
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $queryString,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false 
		) );
		return $this->exec ();
	}
	
	/**
	 * 发送一个 get 请求
	 */
	public function get($url) {
		$this->setOptions ( array (
				CURLOPT_URL => $url,
				CURLOPT_POST => 0,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false 
		) );
		return $this->exec ();
	}
	
	/**
	 * 设置 curl 选项      	
	 */
	public function setOption($key, $value) {
		$this->Options [$key . ''] = $value;
	}
	
	/**
	 * 设置 curl 选项   	
	 */
	public function setOptions($options) {
		foreach ( $options as $key => $value ) {
			$this->Options [$key . ''] = $value;
		}
	}
	
	/**
	 * 获取 curl 当前的错误代码
	 */
	public function getErrorNum() {
		return $this->ErrorNum;
	}
	
	/**
	 * 获取 curl 当前的错误信息
	 */
	public function getError() {
		return curl_error ( $this->Resource );
	}
	
	/**
	 * 设置等待超时时间，单位为秒   	
	 */
	public function setTimeout($second) {
		$this->setOption ( CURLOPT_TIMEOUT, $second );
	}
	
	/**
	 * 设置请求超时时间，单位为秒     	
	 */
	public function setConnTimeout($second) {
		$this->setOption ( CURLOPT_CONNECTTIMEOUT, $second );
	}
	
	/**
	 * 判断 curl 执行结果是否为超时
	 */
	public function isTimeout() {
		return $this->ErrorNum == 28;
	}
	
	/**
	 * 执行一个curl 请求，并返回结果
	 */
	protected function exec() {
		curl_setopt_array ( $this->Resource, $this->Options );
		$result = curl_exec($this->Resource);
		$info = curl_getinfo($this->Resource);
		$this->ErrorNum = curl_errno($this->Resource);
		$error = curl_error($this->Resource);
		$content = "Options:".$this->Options.";Error Num:".$this->ErrorNum.";error:{$error};info:".json_encode($info);
		
		$data = array('result' =>'ok','code' =>'200','data' =>array());
		$data['data'] = trim($result);
		$data['code'] = isset($info['http_code']) ? $info ['http_code'] : 999;
		$data['result'] = $data['code'] == '200' ? 'ok' : 'error';
		$this->Result = $result;
		return $data;
	}
	
	/**
	 * 返回当前的 curl 执行结果
	 */
	public function getResult() {
		return $this->Result;
	}
	public function __toString() {
		$params = $this->Options [CURLOPT_POSTFIELDS];
		if (is_array ( $params )) {
			$params = json_encode ( $params );
		}
		$msg = array (
				'url: ' . $this->Options [CURLOPT_URL],
				'params: ' . $params,
				'curl_err: ' . curl_error ( $this->Resource ) . '(' . $this->ErrorNum . ')',
				'result: ' . $this->Result 
		);
		$msg = preg_replace ( '/<password>.*?<\/password>/msi', '<password>******</password>', $msg );
		$msg = preg_replace ( '/[\"\']password(2)?[\"\']:[\"\'](.*?)[\"\']/msi', '"password$1":"******"', $msg );
		$msg = join ( ', ', $msg );
		return $msg;
	}
}
