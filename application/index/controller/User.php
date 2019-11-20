<?php
namespace app\index\controller;

use think\Request;
use app\index\model\User as UserModel;
use think\Session;

class User extends Base 
{
    public function login(){

       return $this->fetch();
    }

    //验证用户登录
    public function checkLogin(Request $request)
    {
        $result = '';
        $status = 0;
        $data = $request->param();
        
         $rule = [
             'name|用户名' => 'require',
             'password|密码' => 'require'
         ];

         $msg = [
            'name' => ['require'=>'用户名不能为空,请检查'],
            'password' => ['require'=>'密码不能为空,请检查'],
            'verify' => [
                'require'=> '验证码不能为空,请检查',
                'captcha'=> '验证码错误',
                 ]
         ];

         $result = $this->validate($data,$rule,$msg);

         if($result ===true){
             $map = [
                 'name' => $data['name'],
                 'password' => md5($data['password'])
             ];

             $user = UserModel::get($map);
             if($user == null){
                 $result = '没有该用户';
             }else{
                 $status = 1 ;
                 $result = '验证通过，点击[确认]';
                 Session::set('user_id',$user->id);
                 Session::set('user_info',$user->getData());
            
             }  
                 $user -> setInc('login_count');
             
         }
         return['status'=>$status,'message'=>$result,'data'=>$data];
    }

    //管理员渲染列表
    public function admin_list()
    {
        $this -> view ->assign('title', '管理员列表xxx');
        $this -> view ->assign('keywords', 'cx');
        $this -> view ->assign('dsec', 'xxx');
        //统计数量
        $this -> view ->count = UserModel::count();
        //先判断当前是不是admin用户
        $userName = Session::get('user_info.name');

        // $list = User::all(function($query){
        //     $query->where('status', 1)->limit(3)->order('id', 'asc');
        // });


        if($userName == 'admin'){
            $list = UserModel::all();
        }else{
            $list = UserModel::all(['name'=>$userName]);
           
        }

        $this -> assign('list',$list);
        //渲染管理员列表
        return $this -> view -> fetch('/user/admin_list');
    }

    //增加用户渲染
    public function admin_add(){
        $this -> view ->assign('title', '增加');
        $this -> view ->assign('keywords', 'yy');
        $this -> view ->assign('dsec', 'xxx');
        return  $this -> fetch();
    }

    //用户增加
    public function add(Request $request){
        $data = $request -> param();
        // $data->password = md5($data['password']); error
        $status = '1';
        $message = '添加成功';
        
        $rule = [
            'name|用户名' => "require|min:3|max:10",
            'password|密码' => "require|min:3|max:10",
            'email|邮箱' => 'require|email'
        ];

        $result = $this -> validate($data,$rule,$message);
    
        if($result == true){
            $data = [
                'name' => $data['name'],
                'password' => md5($data['password']),
                'email' => $data['email']
            ];
            // var_dump($data);
            // exit;
            $user = UserModel::create($data);
            if ($user === null) {
                $status = 0;
                $message = '添加失败~~';
            }
        }
        return ['status'=>$status,'message'=>$message];
    }

    //设置状态变更
    public function setStatus(Request $request){
        $user_id = $request ->param('id');
        $result = UserModel::get($user_id);
        if($result->getData('status') == 1){
            UserModel::update(['status'=>'0'],['id'=>$user_id]);
        }else{
            UserModel::update(['status'=>'1'],['id'=>$user_id]);
        }
    }

    //渲染编辑用户信息列表
    public function admin_edit(Request $request){
        $user_id = $request -> param('id');
        $result = UserModel::get($user_id);
        $this -> view ->assign('title', '管理员编辑');
        $this -> view ->assign('keywords', 'xx');
        $this -> view ->assign('dsec', 'xxx');
        $this->assign('user_info',$result->getData());
        return $this->fetch();
    }


    //编辑修改用户
    public function editUser(Request $request)
    {
        $param = $request->post();
        
        //去掉表单中为空的数据,即没有修改的内容 
        foreach($param as $key=>$value){
            if(isset($value)){
                $data[$key] = $value;
            }
        }
    
      
        $user_id = ['id' =>$data['id']];
        $result = UserModel::update($data,$user_id);
        
            //如果是admin用户,更新当前session中用户信息user_info中的角色role,供页面调用
        if (Session::get('user_info.name') == 'admin') {
            Session::set('user_info.role', $param['role']);
        }

        if($result == true){
            return ['status'=>'1','message'=>'更新成功'];
        }else{
            return ['status'=>'0','message'=>'更新失败'];
        }

    }

    //检查用户是否重复
    public function checkUserName(Request $request)
    {
        $userName = trim($request ->param('name'));
        
        $status = '1';
        // $message = '改用户可以使用，请继续~~';
        if(UserModel::get(['name' =>$userName])){
            $status = '0';
            $message = '用户已重复，请重新输入~~';
        }
        return ['status' =>$status,'message' =>$message];
    }

     //检查邮箱是否重复
     public function checkUserEmail(Request $request)
     {
         $userEmail = trim($request ->param('email'));
         
         $status = '1';
        //  $message = '改邮箱可以使用，请继续~~';
         if(UserModel::get(['email' =>$userEmail])){
             $status = '0';
             $message = '用邮箱已使用，请重新输入~~';
         }
         return ['status' =>$status,'message' =>$message];
     }
 

    //退出登录
    public function logout(){
        Session::delete('user_id');
        Session::delete('user_info');
        $this -> success('注销登录','/user/login');
    }

    //删除用户
    public function deleteUser(Request $request)
    {
        $user_id = $request -> param('id');
        UserModel::update(['is_delete'=>0],['id'=> $user_id]);
        UserModel::destroy($user_id);
    }

     //恢复删除操作
     public function unDelete()
     {
         UserModel::update(['delete_time'=>NULL],['is_delete'=>1]);
     }

}