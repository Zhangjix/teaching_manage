<?php
namespace app\index\controller;

use app\index\model\Grade as GradeModel;
use think\Request;

class Grade extends Base
{
    //渲染班级列表
    public function grade_list()
    {
        $this->view->assign('title','班级列表');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');

        $grade = GradeModel::all();

        foreach($grade as $value){
            $data = [
                'id' => $value->id,
                'name' => $value->name,
                'length' => $value->length,
                'price' => $value->price,
                'status' => $value->status,
                'create_time' => $value->create_time,
                //用关联方法teacher属性方式访问teacher表中数据
                'teacher' => isset($value->teacher->name) ? $value->teacher->name :  '<span style="color:red;">未分配</span>',
            ];
            $gradeList[] = $data;
        }
        
        
        // $gradeList = GradeModel::paginate(5);
        // foreach ($gradeList as $value) {
        //     isset($value->teacher->name) ?  $value->teacher->name :  '<span style="color:red;">未分配</span>';
           
        //     // var_dump($sql);
        //     // exit;
        // // } 
        
       

        $this ->assign('gradeList',$gradeList);

        $count = GradeModel::count();
        $this ->assign('count',$count);

        return $this ->fetch();
    }

    //添加班级渲染
    public function grade_add()
    {
        $this->view->assign('title','添加班級列表');
        $this->view->assign('keywords','php');
        $this->view->assign('desc','PHP开发实战课程');

        return $this -> fetch();
    } 

    //编辑班级渲染
    public function grade_edit(Request $request)
    {
        $this->view->assign('title','编辑班级');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP开发实战课程');

        $id = $request -> param('id');

        $result = GradeModel::get($id);

        
        $grade_id = $result['teacher_id'];
        // var_dump($grade_id);
        // exit;

        //关联查询,获取与当前班级对应的教师姓名
        // $result -> teacher = $result -> teacher->name;  //(没启动报非对象模型，找不到数据)

        $this -> assign('teacher',\app\index\model\Teacher::get($grade_id));

        $this -> assign('grade_info',$result);

        return $this -> fetch();
    }

    //班級方法
    public function doAdd(Request $request)
    {  
        $data = $request -> post();
       
        $status = '0';
        $message = '添加失敗';

        $result = GradeModel::create($data);
        if($result == true){
            $status = '1';
            $message = '添加成功~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //更改班级状态
    public function setStatus(Request $request)
    {
        $id = $request ->param('id');

        $result = GradeModel::get($id);

        if($result ->getData('status') == '1'){
            GradeModel::update(['status' => '0'],['id' =>$id]);
        }else{
            GradeModel::update(['status' => '1'],['id' =>$id]);
        }
    }

    //软删除
    public function deleteGrade(Request $request)
    {
        $id = $request ->param('id');
        GradeModel::update(['is_delete' => '1'],['id'=>$id]);
        GradeModel::destroy($id);

    }

    //软恢复
    public function unDelete()
    {
        GradeModel::update(['delete_time' => NULL],['is_delete' => '1']);
    }
}