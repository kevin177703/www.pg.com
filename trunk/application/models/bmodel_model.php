<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 基础数据调用
 * @author kevin email:kevin177703@gmail.com
 * @version 0.0.1
 */
class Bmodel_model extends Base_Model{
	function __construct(){
		parent::__construct();
	}
	/**
	 * 设置返水
	 * @param $data
	 * @param $agent_id
	 */
	function add_extend($data,$agent_id){
		$this->db->trans_begin();
		if(!$this->tdel($this->table_agent_extend, array("agent_id"=>$agent_id))){
			$this->db->trans_rollback();
			return false;
		}
		if($this->insert($this->table_agent_extend, $data)==false){
			$this->db->trans_rollback();
			return false;
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();
		return true;
	}
	/**
	 * 添加代理
	 * @param $data
	 */
	function add_agent($data){
		$this->db->trans_begin();
		$user = $this->get($this->table_admin, array("username"=>$data['username']));
		if(isset($user['uid']))return "same"; //帐号相同
		$info = array(
				"username"=>$data['username'],
				"password"=>set_user_pass($data['username'],$data['password']),
				"group_id"=>$data['group_id'],
				"agent_id"=>"0",
				"operatettime"=>time(),
				"logintime"=>time()
		);
		$uid = $this->save($this->table_admin, $info);
		if($uid<1){
			$this->db->trans_rollback();
			return "error";    //添加帐号表失败
		}
		$info = array(
				"uid"=>$uid,
				"username"=>$data['username'],
				"game_type"=>$data['game_type'],
				"code"=>$data['code'],
				"email"=>$data['email'],
				"phone"=>$data['phone'],
				"addtime"=>time()
		);
		$id = $this->save($this->table_agent, $info);
		if($id<1){
			$this->db->trans_rollback();
			return "error";    //添加代理表失败
		}
		if($this->edit($this->table_admin, array("agent_id"=>$id), array("uid"=>$uid))==false){
			$this->db->trans_rollback();
			return "error";     //代理表和帐号表绑定失败
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return "error";     //存储过程有失败
		}
		$this->db->trans_commit();
		return "success";
	}
	/**
	 * 编辑设置表
	 * @param $data 设置数据
	 * @param $type 设置类型
	 * @param $agent_id 代理id
	 */
	function edit_setting($data,$type,$agent_id){
		$this->db->trans_begin();
		$info = array();
		$i=0;
		foreach ($data as $k=>$v){
			$info[$i]['skey']=$k;
			$info[$i]['svalue']=$v;
			$info[$i]['type']=$type;
			$info[$i]['agent_id']=$agent_id;
			$i++;
		}
		if($this->db->delete($this->table_setting,array('type'=>$type,'agent_id'=>$agent_id))==false
				|| $this->db->insert_batch($this->table_setting,$info)==false){
			$this->db->trans_rollback();
			return false;
		}
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		$this->db->trans_commit();
		$cache_key = $this->memcache->key_agent_setting_agent.$agent_id;
		$this->memcache->setNo($cache_key);
		return true;
	}
	/**
	 * 获取配置信息
	 * @param $agent_id 代理id
	 * @param $type 配置类型
	 */
	function get_setting($agent_id,$type=""){
		$cache_key = $this->memcache->key_agent_setting_agent.$agent_id;
		$cache_no = $this->memcache->getNo($cache_key);
		$cache_key = "model_dmodel_get_setting_type_{$type}_{$cache_key}_{$cache_no}_{$agent_id}";
		$cache = $this->memcache->get($cache_key);
		if(empty($cache) || $this->model->memcache->status==false){
			$cache = null;
			$info = array();
			if(empty($type)){
				$data1 = $this->get_list( $this->table_setting, array('agent_id'=>0),1000);
				foreach($data1['rows'] as $v){
					$info[$v['type']][$v['skey']]=$v['svalue'];
				}
				$data2 = $this->get_list( $this->table_setting, array('agent_id'=>$agent_id),1000);
				foreach($data2['rows'] as $v){
					$info[$v['type']][$v['skey']]=$v['svalue'];
				}
			}else{
				$data = $this->get_list( $this->table_setting, array('agent_id'=>$agent_id,'type'=>$type),1000);
				foreach($data['rows'] as $v){
					$info[$v['skey']]=$v['svalue'];
				}
			}
			if(!empty($info) && count($info)>0){
				$cache = $info;
				$this->memcache->set($cache_key,$cache);
			}
		}
		return $cache;
	}
	/**
	 * 资金确认，资金审核
	 * @param $money 资金金额
	 * @param $id 资金记录id
	 * @param $opuid 操作员uid
	 * @param $status 操作后状态
	 * @param $opnote 操作说明
	 * @param $type_log 日志记录类型
	 */
	function op_money_note($money,$id,$opuid,$status,$opnote,$type_log){
		$this->db->trans_begin();
		//查询资金记录
		$note = $this->get($this->table_money_note,array("id"=>$id));
		if(!isset($note))return "data";//数据错误
		//查询管理员
		$admin = $this->get($this->table_admin,array("id"=>$opuid));
		if(!isset($admin['id']))return "data";//数据错误
		//查询用户
		$user = $this->get($this->table_users,array("id"=>$note['uid']));
		if(!isset($user['id']))return "data";//数据错误
		//判断管理员是否有操作金额额度
		$date = date('Y-m-d');
		$date = strtotime($date);
		$operatemoney = $admin['operatettime']<$date?0:$admin['operatemoney'];
		if($operatemoney+$moeny>=$admin['maxmoney'])return "max";   //超过每日最大限额
		//修改管理员表信息
		$data = array("operatemoney"=>$operatemoney+$moeny,"operatettime"=>time());
		if($this->edit($this->table_admin, $data, array("id"=>$opuid))==false){
			$this->db->trans_rollback();
			return "error";
		}
		//添加资金日志
		$data = array("agent_id"=>$note['agent_id'],"money"=>$money,"opuid"=>$opuid,"orderid"=>$note['orderid'],"uid"=>$note['uid'],"type"=>$type_log,"addtime"=>time());
		if($this->save($this->table_money_log, $data)<1){
			$this->db->trans_rollback();
			return "error";
		}
		//修改记录状态
		if($this->edit($this->table_money_note,array("status"=>$status,"opnote"=>$opnote),array("id"=>$id))==false){
			$this->db->trans_rollback();
			return "error";
		}
		//当状态改为完成的时候，需要修改资金金额
		if($status==MONEY_STATUS_SUCCESS){
			//获取优惠信息
			$sale = $this->get_setting($note['agent_id'],"sale");
			//假如是首存，添加首存确认
			if($user['firsttime']<1 && $money>0 && isset($sale['sale_first']) && $sale['sale_first']>0){
				$_moeny = $money*$sale['sale_first']/100;
				$orderid = get_rand(10,"firstbonus");
				if(isset($sale['sale_first_money']) && $sale['sale_first_money']>0){
					$_moeny = $sale['sale_first_money']<$_moeny?$sale['sale_first_money']:$_moeny;
				}
				$beishu = isset($sale['sale_times'])?$sale['sale_times']:1;
				if($this->add_money_note($_moeny,MONEY_TYPE_FIRST_BONUS,"首存红利","首存{$beishu}倍流水",$orderid,MONEY_STATUS_CONFIRM,$note['uid'],$note['agent_id'])==false){
					$this->db->trans_rollback();
					return "error";
				}
			}
			$bank_bonus_money = 0;
			//假如是银行转账,并且目标状态是接受资金,添加转账手续费
			if($note['money_type']==MONEY_TYPE_BANK && isset($sale['sale_transfer']) && $sale['sale_transfer']>0){
				$bank_bonus_money = $money*$sale['sale_transfer']/100;
				$orderid = get_rand(11,"bankbonus");
				if(isset($sale['sale_transfer_money']) && $sale['sale_transfer_money']>0){
					$bank_bonus_money = $sale['sale_transfer_money']<$bank_bonus_money?$sale['sale_transfer_money']:$bank_bonus_money;
				}
				$opnote = date("Y-m-d H:i:s")." 银行转账手续费，系统添加";
				if($this->add_money_note($bank_bonus_money,MONEY_TYPE_BANK_BONUS,"转账手续费","转账手续费",$orderid,MONEY_STATUS_SUCCESS,$note['uid'],$note['agent_id'],$opnote)==false){
					$this->db->trans_rollback();
					return "error";
				}
			}
			//修改用户表
			$data = array("money"=>$user['money']+$money+$bank_bonus_money);
			//判断是否是首存,只有目标状态为接受资金才判断是否首存
			if($user['firsttime']<1 && $money>0){
				$data['firstmoney']=$money;
				$data['firsttime']=time();
				$is_first = true;
			}
			//修改用户表记录
			if($this->edit($this->table_users, $data, array("id"=>$note['uid']))==false){
				$this->db->trans_rollback();
				return "error";
			}
		}
		//存储过程报错
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return "error";
		}
		//成功
		$this->db->trans_commit();
		return "success";
	}
	/**
	 * 添加资金记录
	 * @param $money 金额
	 * @param $money_type 资金类型
	 * @param $bank 银行信息
	 * @param $note 存款信息
	 * @param $orderid 订单编号
	 * @param $status 目标状态
	 * @param $uid 用户uid
	 * @param $agent_id 代理id
	 * @param $opnote 操作信息
	 */
	function add_money_note($money,$money_type,$bank,$note,$orderid,$status,$uid,$agent_id,$opnote=""){
		$info = array();
		$info['orderid'] = $orderid;
		$info['uid']=$uid;
		$info['agent_id']=$agent_id;
		$info['money']=$money;
		$info['money_type']=$money_type;
		$info['status']=$status;
		$info['bank']=$bank;
		$info['note']=$note;
		$info['opnote']=$opnote;
		$info['addtime']=time();
		$id = $this->save($this->table_money_note, $info);
		if($id>0)return true;
		return false;
	}
	/**
	 * 冲正负
	 * @param $uid 用户uid
	 * @param $agent_id 代理id
	 * @param $money 冲正负金额
	 * @param $note 冲正负说明
	 * @param $opuid 操作人uid
	 */
	function undo($uid,$agent_id,$money,$note,$opuid){
		$this->db->trans_begin();
		//查询账户余额
		$user = $this->get($this->table_users, array("id"=>$uid,"agent_id"=>$agent_id));
		if(!isset($user['id']))return "data";//数据错误
		if($user['money']+$money<0)return "money";//账户余额不足
		//查询管理员
		$admin = $this->get($this->table_admin,array("id"=>$opuid));
		if(!isset($admin['id']))return "data";//数据错误
		//判断管理员是否有操作金额额度
		$date = date('Y-m-d');
		$date = strtotime($date);
		//获取金额的绝对值
		$_money = abs($money);
		$operatemoney = $admin['operatettime']<$date?0:$admin['operatemoney'];
		if($operatemoney+$_money>=$admin['maxmoney'])return "max";   //超过每日最大限额
		//修改管理员表信息
		$data = array("operatemoney"=>$operatemoney+$_money,"operatettime"=>time());
		if($this->edit($this->table_admin, $data, array("id"=>$opuid))==false){
			$this->db->trans_rollback();
			return "error";
		}
		$orderid = get_rand(16,"undo");
		$opnote = "{$admin['username']}操作冲正负,<br/>说明:{$note}";
		//添加资金记录
		if($this->add_money_note($money,MONEY_TYPE_UNDO,"冲正负","冲正负",$orderid,MONEY_STATUS_SUCCESS,$uid,$agent_id,$opnote)==false){
			$this->db->trans_rollback();
			return "error";
		}
		//添加资金日志
		$data = array("agent_id"=>$agent_id,"money"=>$money,"opuid"=>$opuid,"orderid"=>$orderid,"uid"=>$uid,"type"=>"冲正负","addtime"=>time());
		if($this->save($this->table_money_log, $data)<1){
			$this->db->trans_rollback();
			return "error";
		}
		//修改用户表记录
		if($this->edit($this->table_users, array("money"=>$user['money']+$money), array("id"=>$uid))==false){
			$this->db->trans_rollback();
			return "error";
		}
		//存储过程报错
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return "error";
		}
		//成功
		$this->db->trans_commit();
		return "success";
	}
}