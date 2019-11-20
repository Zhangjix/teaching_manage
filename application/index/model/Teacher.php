<?php

namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Teacher extends Model
{
    //导入软删除方法集
    use SoftDelete;
    //设置软删除字段
    //只有该字段为NULL,该字段才会显示出来
    protected $deleteTime = 'delete_time';

    //设置当前表默认日期时间显示格式
    protected $dateFormat = 'Y-m-d';

    // 开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';

    protected $updateTime = 'update_time';

    //入职时间
    protected $type = [
        'hiredate'=>'timestamp'
    ];
  
    // 定义自动完成的属性
    protected $insert = ['status' => 1];

     //设置与grade表的反关联
     public function grade()
     {
         // 教师表teacher BELONGS TO 关联班级grade
         return $this->belongsTo('Grade');
     }

     //学历
     protected function getDegreeAttr($value)
     {
        $degree = [
            '0' => '专科',
            '1' => '本科',
            '2' => '研究生'
        ];
        return $degree[$value];
     }

}