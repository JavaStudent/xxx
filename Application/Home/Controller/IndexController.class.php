<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    public function index(){
    	if(!$this->is_login()){
    		$this->redirect('Index/login');
    	}else{
    		$this->display("index");
    	}
       
    }

    public function login(){
    	if(!$this->is_login()){
    		$this->display("login");
    	}else{
    		$this->redirect("index");
    	}

    	if(IS_POST){
    		$data['username'] = $_POST['username'];
    		$data['password'] = $_POST['password'];
    		$verify = $_POST['verify'];

    		$User = new \Home\Model\UserModel();

    		if(!$this->checkVerify($verify))
    		{
    			$this->ajaxReturn($this->ajaxReturnMessage(2));
    		}

	    	if($User->checkLogin($data['username'],$data['password']))
	    	{
	    		$this->redirect("index");
	    	}else{
	    		$this->ajaxReturn($this->ajaxReturnMessage(3));
	    	}

    	}
    }

    public function logout(){
    	session('user_auth', null);
    }

    public function register(){

    	if(!$this->is_login()){
    		$this->display("register");
    	}else{
    		$this->redirect("index");
    	}

    	if(IS_POST){
    		$data['username'] = $_POST['username'];
    		$data['password'] = $_POST['password'];
    		$data['email'] = $_POST['email'];
    		$data['phone'] = $_POST['phone'];
    		$verify = $_POST['verify'];

    		$User = new \Home\Model\UserModel();

    		if(!$this->checkVerify($verify))
    		{
    			$this->ajaxReturn($this->ajaxReturnMessage(2));
    		}
	    	
	    	if(!$User->checkRegister($data))
	    	{
	    		$this->ajaxReturn($this->ajaxReturnMessage(1));
	    	}

	    	if($User->register($data))
	    	{
	    		$this->ajaxReturn($this->ajaxReturnMessage(0));
	    	}

    	}
    	
    }

    public function delUser(){

    }

    public function uptUser(){

    }

    public function verify(){
    	$verify = new \Think\Verify();
    	$verify->entry();
    }

    public function is_login(){
    	$user = session('user_auth');
    	if(empty($user)){
    		return 0;
    	}else{
    		return 1;
    	}
    }

    public function ajaxReturnMessage($num){
    	switch ($num) {
    		case 0:
    			return array('status'=>0,'message'=>'注册成功');
    			break;
    		case 1:
    			return array('status'=>1,'message'=>'注册用户已经存在！');
    			break;
    		case 2:
    			return array('status'=>2,'message'=>'验证码输入错误！');
    			break;
    		case 3:
    			return array('status'=>3,'message'=>'用户名或密码错误');
    			break;
    		default:
    			# code...
    			break;
    	}
    }

    public function checkVerify($code, $id=1){
    	$verify = new \Think\Verify();
		return $verify->check($code);
    }
}