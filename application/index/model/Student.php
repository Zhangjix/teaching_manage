<?php

namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Student  extends Model
{
    //引用软删除方法集
    use SoftDelete;

    //设置当前表默认日期时间显示格式
    protected $dateFormat = 'Y/m/d';

    //定义表中的删除时间字段,来记录删除时间
    protected $deleteTime = 'delete_time';

    // 开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    protected $createTime = 'create_time';

    protected $updateTime = 'update_time';

    // 保存自动完成列表
    protected $auto = [
    'delete_time' => NULL,
    'is_delete' => 1, //1:允许删除 0:禁止删除
    ];

    protected $type = [
        'start_time'=>'timestamp',
    ];


    public function getSexAttr($value)
    {
        $sex = [
            0=>'女',
            1=> '男'
        ];
        return $sex[$value];
    }
// 定义与学生表student的一对多关联
    public function grade()
    {
        return $this->belongsTo('grade');
    }

}