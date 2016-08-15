<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Base_Model
 * @version 1.0.0
 * @author kevin177703@gmail.com 
 */
/**
 * 实现代码提示功能
 * @property CI_Loader $load
 * @property CI_DB_mysql_driver $db
 * @property CI_Calendar $calendar
 * @property Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Language $language
 * @property CI_Log $log
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Unit_test $unit
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Zip $zip
 * @property CI_Form $form_validation
 * @property Dmemcache $memcache
 * @property Dlog $log
 */
class Base_Model extends CI_Model {
	//*************************自定义变量***************************/
	public $db_no = null;          							 	//数据库操作编号
	
	//*************************自定义类****************************/
	public $memcache = null;                					//缓存类
	public $log = null;                     					//文件日志类
	
	//*************************品牌相关表**************************/
	public $table_brand = "brand";								//品牌表
	public $table_brand_host = "brand_host";					//品牌域名表
	public $table_brand_template = "brand_template";			//网站模板
	
	//*************************session相关表**********************/
	public $table_session = "session";							//session表
	
	//*************************管理员相关表*************************/
	public $table_admin = "admin";								//管理员表
	public $table_admin_group = "admin_group";					//管理员组表
	
	//*************************开发相关表*************************/
	public $table_developer_menu = "developer_menu";			//后台菜单
	
	//*************************会员相关表**************************/
	public $table_member = "member";							//会员表
	public $table_member_monitor = "member_monitor";			//会员监控表
	
	//*************************设置相关表**************************/
	public $table_setting = "setting";							//设置表
	
	//*************************日志相关表**************************/
	public $table_log_login = "log_login";						//登陆日志表
	public $table_log_view = "log_view";						//浏览日志表
	public $table_log_notes = "log_notes";						//操作记录表
	
	function __construct() {
		parent::__construct ();
		$this->load->database();
		$this->db_no = get_rand(18);
	}
	/**
	 * 获取带前缀的表名
	 * @param $table
	 */
	function table($table) {
		return $this->db->protect_identifiers($table,TRUE);
	}
	/**
	 * 获取数据总条数
	 * @param $table
	 * @param array $where
	 */
	function total($table,$where = array()){
		$begin_time = microtime(true);
		if(is_array($where)){
			$where['del']='N';
		}
		$query = $this->db->get_where($table,$where);
		$total = $query->num_rows();
		$this->last_sql($begin_time,"base_total");
		return $total;
	}
	/**
	 * 获取数据总条数-sql
	 * @param $sql
	 */
	function total_sql($sql){
		$begin_time = microtime(true);
		$query = $this->db->query($sql);
		$total = $query->num_rows();
		$this->last_sql($begin_time,"base_total_sql");
		return $total;
	}
	/**
	 * sql查询
	 * @param $sql
	 * @param $limit
	 * @param $offset
	 * @param $order
	 */
	function query($sql, $limit, $offset = 0,$order="") {
		$begin_time = microtime(true);
		$data = array('total'=>0,'rows'=>array());
		$data['total'] = $this->total_sql($sql);
		$this->last_sql($begin_time,"base_query_total");
		if($data['total']>0){
			if(!empty($order))$order = " order by {$order} desc";
			$sql .=" {$order} limit {$offset},{$limit}";
			$query=$this->db->query($sql);
			$data['rows']=$query->result_array();
			$this->last_sql($begin_time,"base_query_rows");
		}
		return $data;
	}
	/**
	 * 获取一条数据的sql查询
	 * @param $sql
	 */
	function one($sql) {
		$begin_time = microtime(true);
		$query = $this->db->query($sql);
		$info = array();
		if ($query->num_rows()>0){
			$info = $query->row_array();
		}
		$this->last_sql($begin_time,"base_one");
		return $info;
	}
	/**
	 * 保存单条数据
	 * @param $table
	 * @param $data
	 */
	function insert($table,$data){
		$begin_time = microtime(true);
		$bol = $this->db->insert($table,$data);
		$this->last_sql($begin_time,"base_insert");
		return $bol;
	}
	/**
	 * 保存多条数据
	 * @param $table
	 * @param $data
	 */
	function insert_batch($table,$data){
		$begin_time = microtime(true);
		$bol = $this->db->insert_batch($table,$data);
		$this->last_sql($begin_time,"insert_batch");
		return $bol;
	}
	/**
	 * 保存单条数据返回id
	 * @param $table
	 * @param $data
	 */
	function save($table, $data) {
		$begin_time = microtime(true);
		$id = 0;
		if ($this->db->insert($table,$data)) {
			$id = $this->db->insert_id();
		}
		$this->last_sql($begin_time,"base_save");
		return $id;
	}
	/**
	 * 修改数据表
	 * @param $table
	 * @param $data
	 * @param $where
	 */
	function edit($table, $data, $where) {
		$begin_time = microtime(true);
		$bol = $this->db->update($table, $data, $where);
		$this->last_sql($begin_time,"base_edit");
		return $bol;
	}
	/**
	 * 非真实删除,只是改变状态，不影响其他，所有表字段必须有del字段
	 * @param $table
	 * @param $where
	 */
	function del($table, $where) {
		$begin_time = microtime(true);
		$bol = $this->db->update($table,array('del'=>'Y'),$where);
		$this->last_sql($begin_time,"base_del");
		return $bol;
	}
	/**
	 * 真实删除,测试删除数据，而非改变状态
	 * @param $table
	 * @param $where
	 */
	function tdel($table, $where) {
		$begin_time = microtime(true);
		$bol = $this->db->delete($table, $where);
		$this->last_sql($begin_time,"base_tdel");
		return $bol;
	}
	/**
	 * 清空表
	 * @param $table
	 */
	function del_all($table) {
		$begin_time = microtime(true);
		$bol = $this->db->empty_table($table);
		$this->last_sql($begin_time,"base_del_all");
		return $bol;
	}
	/**
	 * 查询单条数据
	 * @param $table
	 * @param $where
	 * @param $select
	 */
	function get($table, $where,$select="*") {
		$begin_time = microtime(true);
		if(is_array($where))$where['del']='N';
		$this->db->select($select);
		$query = $this->db->get_where($table,$where);
		$info = array();
		if($query->num_rows()> 0) {
			$info = $query->row_array();
		}
		$this->last_sql($begin_time,"base_get");
		return $info;
	}
	/**
	 * 数据列表
	 * @param $table
	 * @param $where
	 * @param $limit
	 * @param $offset
	 * @param array $order
	 */
	function get_list($table, $where, $limit, $offset = 0, $order = array()) {
		$begin_time = microtime(true);
		if(is_array($where)){
			$where['del']='N';
		}
		$data = array('total'=>0,'rows'=>array());
		$data['total'] = $this->total($table,$where);
		$this->last_sql($begin_time,"base_get_list_total");
		if($data['total']>0){
			if(isset($order[0]) && !empty($order[0])){
				$order[1]= isset($order[1])?$order[1]:'desc';
				$this->db->order_by($order[0],$order[1]);
			}
			$query = $this->db->get_where($table,$where,$limit,$offset );
			$data['rows']=$query->result_array();
			$this->last_sql($begin_time,"base_get_list_rows");
		}
		return $data;
	}
	/**
	 * 打开链接
	 */
	function db() {
		if(empty($this->db)){
			$this->load->database();
		}
		return $this->db;
	}
	/**
	 * 获取最后的数据库查询语句,若time大于0，则会写入日志
	 * @param $time
	 * @param $message
	 */
	function last_sql($time=0,$message=""){
		$sql = $this->db->last_query();
		$sql = str_replace("\n"," ",$sql);
		if($time>0){
			$time = microtime(true)-$time;
			if(empty($this->log))$this->log = library("Dlog");
			$this->log->sql("[{$this->db_no}]\r\n{$sql}",$time,$message);
		}
		return $sql;
	}
	/**
	 * 设置类方法
	 * @param $log
	 * @param $memcache
	 */
	function set_class($log,$memcache){
		$this->log = $log;
		$this->memcache = $memcache;
	}
}