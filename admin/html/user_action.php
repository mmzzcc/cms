<?php
//var_dump($_POST);
//引用函数文件
include './functions.php';
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
/*
	根据用户的行为执行操作数据库的代码
		inrecycle:冻结
		outrecylce:恢复
		del:删除
		upd:修改
 */
switch($_GET['action']){
	case 'inrecycle':
	//准备sql语句
	$sql="update user set user_recycle=2 where user_id={$_GET['user_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('冻结成功','./user_list.php');
		die;
	}else{
		abort('该用户已被冻结或删除','./user_list.php');
		die;
	}
	break;

	case 'outrecycle':
	//准备sql语句
	$sql="update user set user_recycle=1 where user_id={$_GET['user_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('恢复成功','./user_recycle.php');
		die;
	}else{
		abort('该用户已被恢复或删除','./user_recycle.php');
		die;
	}

	break;

	case 'del':
	//准备sql语句
	$sql="delete from user where user_id={$_GET['user_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('删除成功','./user_recycle.php');
		die;
	}else{
		abort('该用户已被删除','./user_recycle.php');
		die;
	}
	break;

	case 'upd':
	//验证内容是否完整
	foreach($_POST as $k => $v){
		if(empty($v)){
			abort('请输入完整信息',"./user_update.php?user_id={$_POST['user_id']}");
			die;
		}else{
			//接收值
			$$k=$v;
		}
	}
	//准备sql语句
	$sql="update user set user_name='{$user_name}',user_tel='{$user_tel}',user_email='{$user_email}' where user_id={$_POST['user_id']} ";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('修改成功','./user_list.php');
		die;
	}else{
		abort('信息没有被修改',"./user_update.php?user_id={$_POST['user_id']}");
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