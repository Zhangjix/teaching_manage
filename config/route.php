<?php
think\Route::rule('user/login','index/user/login');  //登录界面
think\Route::rule('user/checkLogin','index/user/checkLogin'); //验证登录

//用户管理渲染模板
think\Route::rule('user/admin_list','index/user/admin_list');//管路员管理中的管理员列表渲染
think\Route::rule('user/admin_add','index/user/admin_add');  //管理员列表中的添加管理员渲染
think\Route::rule('user/admin_edit','index/user/admin_edit'); //管理列表中修改管理员渲染
//用户管理方法
think\Route::rule('user/editUser','index/user/editUser'); //编辑修改用户
think\Route::rule('user/add','index/user/add'); //管理员列表中增加用戶
think\Route::rule('user/setStatus','index/user/setStatus'); //管理员列表中改变用户状态
think\Route::rule('user/deleteUser','index/user/deleteUser'); //管理员列表中软删除用户
think\Route::rule('user/unDelete','index/user/unDelete'); //管理员列表中恢复删除的用户
think\Route::rule('user/checkUserName','index/user/checkUserName'); //检查用户是否重复
think\Route::rule('user/checkUserEmail','index/user/checkUserEmail'); //检查邮箱是否重复


//教师渲染模板
think\Route::rule('teacher/teacher_list','index/teacher/teacher_list'); //教师管理模板渲染
think\Route::rule('teacher/teacher_add','index/teacher/teacher_add'); //增加教师模板渲染    
think\Route::rule('teacher/teacher_edit','index/teacher/teacher_edit'); //编辑教师模板渲染
//教师管理方法
think\Route::rule('teacher/doAdd','index/teacher/doAdd'); //添加教師
think\Route::rule('teacher/doEdit','index/teacher/doEdit'); //修改教師
think\Route::rule('teacher/setStatus','index/teacher/setStatus'); //教师管理模板中改变用户状态
think\Route::rule('teacher/deleteTeacher','index/teacher/deleteTeacher'); //教师管理模板中删除用户
think\Route::rule('teacher/unDelete','index/teacher/unDelete'); //教师列表中恢复删除用户


//学生渲染模板
think\Route::rule('student/student_list','index/student/student_list'); //学生管理模板渲染
think\Route::rule('student/student_add','index/student/student_add'); //增加学生模板渲染    
think\Route::rule('student/student_edit','index/student/student_edit'); //编辑学生模板渲染 
//學生方法
think\Route::rule('student/setStatus','index/student/setStatus'); //学生列表中改变用户状态
think\Route::rule('student/deleteStudent','index/student/deleteStudent'); //学生列表中软删除用户
think\Route::rule('student/unDelete','index/student/unDelete'); //学生列表中恢复删除的用户
think\Route::rule('student/doAdd','index/student/doAdd'); //添加教師
think\Route::rule('student/doEdit','index/student/doEdit'); //修改教師


//班级模板渲染
think\Route::rule('grade/grade_list','index/grade/grade_list'); //班级管理模板渲染
think\Route::rule('grade/grade_add','index/grade/grade_add'); //增加班级模板渲染    
think\Route::rule('grade/grade_edit','index/grade/grade_edit'); //编辑班级模板渲染 
//班级方法
think\Route::rule('grade/setStatus','index/grade/setStatus'); //班级列表中改变用户状态
think\Route::rule('grade/deleteGrade','index/grade/deleteGrade'); //班级列表中软删除用户
think\Route::rule('grade/unDelete','index/grade/unDelete'); //班级列表中恢复删除的用户
think\Route::rule('grade/doAdd','index/grade/doAdd'); //添加班级
think\Route::rule('grade/doEdit','index/grade/doEdit'); //修改班级


think\Route::rule('user/logout','index/user/logout');  //退出

think\Route::rule('index','index/index/index'); //进入主页

think\Route::rule('welcome','index/welcome/welcome'); //主页的主体内容显示





