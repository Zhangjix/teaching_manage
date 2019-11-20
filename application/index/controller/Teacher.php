<?php
namespace app\index\controller;

use think\Request;
use app\index\model\Teacher as TeacherModel;
use think\Session;

class Teacher extends Base
{
    //渲染教師列表
    public function teacher_list()
    {
        $this->view->assign('title','教師列表');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');

        //统计数量 
        // $this -> count = TeacherModel::count();
        $count = TeacherModel::count();
        $this -> assign('count',$count);
        
        $teacher = TeacherModel::all();
        foreach($teacher as $value){
            $data = [
                'id' => $value->id,  //主键
                'name' => $value->name,  //姓名
                'degree' => $value->degree,  //学历
                'school' => $value->school,  //毕业学校
                'mobile' => $value->mobile,  //手机号
                'hiredate' => $value->hiredate,  //入职时间
                'status' => $value->status,  //当前启用状态
                //用关联方法grade属性方式访问grade表中数据
                'grade' => isset($value->grade->name)? $value->grade->name : '<span style="color:red;">未分配</span>',
            ];
            $teacherList[] = $data;
        }
    
        // 先判断当前是不是admin用户

        $this ->view ->assign('teacherList',$teacherList);
        
        return $this -> fetch();
    }

    //更改状态
    public function setStatus(Request $request)
    {   
        $id = $request -> param('id');
        $result = TeacherModel::get($id);
        
        if($result->getData('status') == 1)
        {
            TeacherModel::update(['status'=>'0'],['id'=>$id]);
        }else{
            TeacherModel::update(['status'=>'1'],['id'=>$id]);
        }
    }

    //软删除用户
    public function deleteTeacher(Request $request)
    {
        $id = $request -> param('id');
        TeacherModel::update(['is_delete'=>'1'],['id'=>$id]);
        TeacherModel::destroy($id);
    }

    //软恢复
    public function unDelete()
    {
        TeacherModel::update(['delete_time'=>NULL],['is_delete'=>'1']);
    }


    //渲染增加教师模板
    public function teacher_add()
    {
        $this->view->assign('title','添加教師');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');
          
        //获取班级表中的数据
        $this->view->assign('gradeList',\app\index\model\Grade::all());
        return $this -> fetch();
    }

    //增加教师方法
    public function doAdd(Request $request)
    {
        $data = $request -> post();
        
        $result = TeacherModel::create($data);

        //放回数据
        $status = '0';
        $message = '添加失败';

        if($result == true){
            $status = '1';
            $message = '添加成功';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //编辑教师模板渲染
    public function teacher_edit(Request $request)
    {
        $id = $request ->param('id');
        $teacher = TeacherModel::get($id);
        $this -> assign('teacher_info',$teacher);

        $this->view->assign('title','編輯信息');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');

        $this ->assign('gradeList',\app\index\model\Grade::all());
        
        return $this -> fetch();
    }

    //编辑教师方法
    public function doEdit(Request $request)
    {  
        // $data = $request ->except('grade');
        $data = $request->post();
      
        $id = ['id'=>$data['id']]; 

        $result = TeacherModel::update($data,$id);
       
        $status = '0';
        $message = '更新失敗~~';
        
        if($result == true)
        {
            $status = '1';
            $message = '更新成功';
        }
        return ['status'=>$status,'message'=>$message];
    }

}