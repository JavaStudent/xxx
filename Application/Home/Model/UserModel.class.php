<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model {
	
	protected $dbName = 'xxx';
	protected $trueTableName = 'user';

	//注册验证规则
	protected $register_rules = array(
		array('username','6,20','用户名长度不够！',self::MUST_VALIDATE,'length'),
		array('username','','用户名已存在！',self::MUST_VALIDATE,'unique'),
		array('password','6,20','密码长度不够！',self::MUST_VALIDATE,'length'),
		array('email','email','邮箱错误！',self::MUST_VALIDATE),
		array('phone','checkPhone','手机号码错误！',self::MUST_VALIDATE,'callback')

	);

	//登陆验证规则
	protected $login_rules = array(
		array('username','6,20','用户名长度不够！',self::MUST_VALIDATE,'length',self::MODEL_INSERT),
		array('password','6,20','密码长度不够！',self::MUST_VALIDATE,'length',self::MODEL_INSERT),
	);


	public function checkRegister($data){

		if($this->getByUsername($data['username']) != null)
		{
			return 0;
		}else{
			return 1;
		}
	    
	}

	public function register($data){

		if($this->create($data)){
			$uid = $this->add();
			return $uid ? $uid : 0;
		}else{
			return $this->getError();
		}
	}

	public function getByUsername($username){
		$result = $this->where("username='%s'",array($username))->find();
		return $result;
	}

	public function checkLogin($username, $password){
		$result = $this->where("username='%s' and password='%s'",array($username, $password))->find();
		
		if($result)
		{
			session('user_auth',$result["id"]);
			session('user_info',$result);
			return $result;
		}else{
			return 0;
		}
	}

	public function getUserPage($num){
		$id = session('user_auth');
		$result = $this->where("id != %d",array($id))->page($num.',5')->select();
		return $result;
	}

	public function getUserCount(){
		return $this->count();
	}

	public function deleteUser($id){
		return $this->where("id = %d",array($id))->delete();
	}

	public function updateUser($data){
		return $this->save($data);
	}

}