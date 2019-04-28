<?php
// var_dump($_POST);
//开启session
session_start();
//引用跳转函数
include './functions.php';
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
/*
	根据用户的行为执行操作数据库的代码
	islogin:登录
	outlogin:注销
 */
switch($_GET['action']){
	case 'islogin':
	//验证内容是否为空
	if(empty($_POST['username']) || empty($_POST['pwd'])){
		abort('请输入完整信息','./login.php');
		die;
	}
	//接收值
	$username=$_POST['username'];
	//加密密码
	$pwd=md5($_POST['pwd']);
	//准备sql语句
	$sql="select * from admin where username='{$username}' and pwd='{$pwd}'";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && $row=mysqli_fetch_assoc($result)){
		//验证状态是否正常
		if($row['status']==2){
			abort('该用户已被冻结','./login.php');
			die;
		}
		$_SESSION['islogin']=1;
		//获取用户名
		$_SESSION['username']=$row['username'];
		abort('登录成功','./admin.php');
		die;
	}else{
		abort('用户名或密码错误','./login.php');
		die;
	}

	break;

	case 'outlogin':
	unset($_SESSION['islogin']);
	abort('注销成功','./login.php');
	break;

	default:

	break;
}
?>