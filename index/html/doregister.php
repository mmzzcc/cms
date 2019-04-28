<?php
//var_dump($_POST);
//引用函数文件
include './functions.php';
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');

switch($_GET['action']){
	case 'ins':
	//验证填写内容是否完整
	foreach($_POST as $k => $v){
		if(empty($v)){
			abort('请输入完整信息','./register.php');
			die;
		}else{
			//接收值
			$$k=$v;
		}
	}
	//验证密码是否一致
	if($user_pwd!=$user_repwd){
		abort('输入密码不一致','./register.php');
		die;
	}
	//加密密码
	$user_pwd=md5($user_pwd);
	//写入注册时间
	$register_time=time();
	//准备sql语句
	$sql="insert into user(user_name,user_pwd,user_tel,user_email,register_time) values('{$user_name}','{$user_pwd}','{$user_tel}	','{$user_email}','{$register_time}')";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('注册成功','./index.php');
		die;
	}else{
		abort('用户名已被占用','./register.php');
		die;
	}

	break;

	case 'ajax':
	$user_name=$_GET['user_name'];
	//准备sql语句
	$sql="select * from user where user_name='{$user_name}'";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && $row=mysqli_fetch_assoc($result)){
		echo 1;
	}else{
		echo 0;
	}


	break;

	default:

	break;
}
?>