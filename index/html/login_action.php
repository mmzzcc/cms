<?php
// var_dump($_POST);
//开启session
session_start();
//引用函数文件
include './functions.php';
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
/*
	根据用户的行为执行操作数据库的代码
	islogin:登录
	outlogin:退出
 */
switch($_GET['action']){
	case 'islogin':
	//验证内容是否完整
	if(empty($_POST['user_name']) || empty($_POST['user_pwd'])){
		abort('请输入完整信息','./login.php');
		die;
	}
	//接收值
	$user_name=$_POST['user_name'];
	//加密密码
	$user_pwd=md5($_POST['user_pwd']);
	//准备sql语句
	$sql="select * from user where user_name='{$user_name}' and user_pwd='{$user_pwd}'";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && $row=mysqli_fetch_assoc($result)){
		if($row['user_recycle']==2){
			abort('该用户已被冻结','./login.php');
			die;
		}
	//写入登录时间
	$login_time=time();
	//写入登录ip
	$login_ip=$_SERVER['REMOTE_ADDR'];
	//准备sql语句
	$lsql="update  user set login_time='{$login_time}',login_ip='{$login_ip}' where user_id={$row['user_id']}";
	//执行sql语句
	mysqli_query($link,$lsql);
	//记录用户信息
	$_SESSION['userInfo']=$row;
	abort('登录成功','./index.php');
	die;
	}else{
		abort('用户名或密码错误','./login.php');
		die;
	}

	break;

	case 'outlogin':
	unset($_SESSION['userInfo']);
	abort('退出成功','./index.php');
	die;
	break;

	default:

	break;
}
?>