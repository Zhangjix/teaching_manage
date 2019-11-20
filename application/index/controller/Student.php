<?php
namespace app\index\controller;

use think\Request;
use app\index\model\Student as StudentModel;

class Student extends Base
{
    //渲染学生列表模板
    public function student_list()
    {
        $this->view->assign('title','学生列表');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');

        $student = StudentModel::paginate(5);

        foreach($student as $value){
            $data = [
                'id' => $value->id,  //主键
                'name' => $value->name,  //姓名
                'sex' => $value->sex,  //学历
                'age' => $value->age,  //毕业学校
                'mobile' => $value->mobile,  //手机号
                'email' => $value->email,  //入职时间
                'start_time' => $value->start_time,  //当前启用状态
                //用关联方法grade属性方式访问grade表中数据
                'status' => $value->status,
                'grade' => isset($value->grade->name)? $value->grade->name : '<span style="color:red;">未分配</span>',
            ];
            $studentList[] = $data;
        }
        //给结果集对象数组中的每个模板对象添加班级关联数据,
        // foreach ($studentList as $value) {
        //     isset($value->grade->name)? $value->grade->name : '<span style="color:red;">未分配</span>';
        // }
        // // $this->assign('student',\app\index\model\Grade::all());
    //    var_dump($studentList);
    //    exit;
        // $product = empty($student) ? array():$student->toArray();
        // var_dump($product);
        // exit;

        $page = $student->render();
        $this->assign('page', $page);
        $count = StudentModel::count();
        $this ->assign('count',$count);

        $this ->assign('studentList',$studentList); 
        return $this ->fetch();
    }

    //添加学生渲染模板
    public function student_add()
    {   
        $this->view->assign('title','添加学生');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');

        $this->assign('gradeList',\app\index\model\Grade::all());
        return $this->fetch();
    }

    //添加学生方法
    public function doAdd(Request $request)
    {
        $data = $request -> post();
        
        $result = StudentModel::create($data);

        $status = '0';
        $message = '更新失败';

        if($result == true){
            $status = '1';
            $message = '更新成功~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //编辑学生模板
    public function student_edit(Request $request)
    {
        $this->view->assign('title','编辑学生');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');
        
        $data = $request ->param('id');
        $student_info = StudentModel::get($data);
        // $student_info -> grade = $student_info -> grade->name;
        // var_dump($student_info);
        // exit;
        $this ->assign('student_info',$student_info);
        $this ->assign('gradeList',\app\index\model\Grade::all());
        return $this ->fetch();
    }

    //编辑学生方法

    public function doEdit(Request $request)
    {
        $data = $request -> post();
       
        $id = $data['id'];

        $result = StudentModel::update($data,$id);

        $status = '0';
        $message = '更新失败';
        if($result == true){
            $status = '1';
            $message = '更新成功~~';
        }
        return ['status'=>$status,'message'=>$message];

    }

    //更改状态
    public function setStatus(Request $request)
    {
        $id = $request ->param('id');

        $result = StudentModel::get($id);

        if($result ->getData('status') ==1){
            StudentModel::update(['status'=>'0'],['id'=>$id]);
        }else{
            StudentModel::update(['status'=>'1'],['id'=>$id]);
        }

    }

    //软删除
    public function deleteStudent(Request $request)
    {
        $id = $request ->param('id');
        StudentModel::update(['is_delete'=>'1'],['id'=>$id]);
        StudentModel::destroy($id);
    }

    //软恢复
    public function UnDelete()
    {
        StudentModel::update(['delete_time'=>NULL],['is_delete'=>'1']);
    }


}