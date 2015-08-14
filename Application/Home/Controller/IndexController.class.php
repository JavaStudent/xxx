<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    public function index(){
    	if(!$this->is_login()){
    		$this->redirect('Index/login');
    	}else{
            $user_info = session('user_info');
            // var_dump($user_info);
            $Page = $this->userPage($_GET['p']?$_GET['p']:1);

            $this->assign('list',$Page['list']);
            $this->assign('count',$Page['count']);
            $this->assign('show',$Page['show']);
            $this->assign('nowPage',$_GET['p']?$_GET['p']:1);
            $this->assign('user_info',$user_info);
    		$this->display("index");
    	}
       
    }

    public function login(){

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
	    		$this->ajaxReturn($this->ajaxReturnMessage(4));
	    	}else{
	    		$this->ajaxReturn($this->ajaxReturnMessage(3));
	    	}

    	}
        if(!$this->is_login()){
            $this->display("login");
        }else{
            $this->redirect("index");
        }
    }

    public function logout(){
    	session('user_auth', null);
        session('user_info', null);
        $this->redirect('index');
    }

    public function register(){

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
        if(!$this->is_login()){
            $this->display("register");
        }else{
            $this->redirect("index");
        }
    	
    }

    public function delUser(){
        $id = $_GET['id'];
        $User = new \Home\Model\UserModel();
        if($User->deleteUser($id) > 0)
        {
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }

    //使用post传送数据
    public function uptUser($id, $email, $phone){
        
        $User = new \Home\Model\UserModel();
        $data['id'] = $id;
        $data['email'] = $email;
        $data['phone'] = $phone;
        if($User->updateUser($data))
        {
            $this->success("更新成功");
        }else{
            $this->error("更新失败");
        }
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
    			return array('status'=>3,'message'=>'用户名或密码错误！');
    			break;
            case 4:
                return array('status'=>4,'message'=>'登录成功','url'=>U('Index/index'));
                break;
            case 5:
                return array('status'=>5,'message'=>'删除成功');
                break;
            case 6:
                return array('status'=>6,'message'=>'删除失败');
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

    public function userPage($num){
        $User = new \Home\Model\UserModel();
        $list = $User->getUserPage($num);
        $count = $User->getUserCount();
        $page = new \Think\Page($count,5);
        $show = $page->show();

        $data = array(
            'list' => $list,
            'count' => $count,
            'show'  => $show,
        );

        return $data;
    }
}