<?php
// var_dump($_POST);
//引用函数文件
include './functions.php';
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
/*
	根据用户的行为执行操作数据库的代码
		ins:添加;
		del:删除;
		upd:修改;
		inrecycle:冻结
		outrecycle:恢复
 */
switch($_GET['action']){
	case 'ins':
	//验证内容是否为空
	foreach($_POST as $k => $v){
		if(empty($v)){
			abort('请输入完整信息','./admin_add.php');
			die;
		}else{
			//接收值
			$$k=$v;
		}
	}
	//验证密码是否一致
	if($pwd!=$repwd){
		abort('输入密码不一致','./admin_add.php');
		die;
	}
	//密码加密
	$pwd=md5($pwd);
	//验证性别是否选择
	if(!isset($sex)){
		abort('请输入完整信息','./admin_add.php');
		die;
	}
	//验证爱好是否选择
	if(!isset($hobby)){
		abort('请输入完整信息','./admin_add.php');
		die;
	}
	//将爱好转为字符串
	$hobby=implode('☆',$hobby);
	//准备sql语句
	$sql="insert into admin(username,pwd,sex,hobby,city) values('{$username}','{$pwd}','{$sex}','{$hobby}','{$city}')";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('添加成功','./admin_list.php');
		die;
	}else{
		abort('用户名已被占用','./admin_add.php');
		die;
	}
	break;

	case 'upd':
	//验证内容是否为空
	foreach($_POST as $k => $v){
		if(empty($v)){
			abort('请输入完整信息','./admin_add.php');
			die;
		}else{
			//接收值
			$$k=$v;
		}
	}
	//验证性别是否选择
	if(!isset($sex)){
		abort('请输入完整信息','./admin_add.php');
		die;
	}
	//验证爱好是否选择
	if(!isset($hobby)){
		abort('请输入完整信息','./admin_add.php');
		die;
	}
	//将爱好转为字符串
	$hobby=implode('☆',$hobby);
	//准备sql语句
	$sql="update admin set username='{$username}',sex='{$sex}',hobby='{$hobby}',city='{$city}' where id={$_POST['id']} ";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('修改成功','./admin_list.php');
		die;
	}else{
		abort('信息没有被修改',"./admin_update.php?id={$_POST['id']}");
		die;
	}

	break;

	case 'del':
	//准备sql语句
	$sql="delete from admin where id={$_GET['id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('删除成功','./admin_recycle.php');
		die;
	}else{
		abort('该信息已被其他用户删除','./admin_recycle.php');
		die;
	}
	break;

	case 'inrecycle':
	//准备sql语句
	$sql="update admin set status=2 where id={$_GET['id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('冻结成功','./admin_list.php');
		die;
	}else{
		abort('该信息已被其他用户冻结或删除','./admin_list.php');
		die;
	}

	break;

	case 'outrecycle':
	//准备sql语句
	$sql="update admin set status=1 where id={$_GET['id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('恢复成功','./admin_recycle.php');
		die;
	}else{
		abort('该信息已被其他用户删除','./admin_recycle.php');
		die;
	}

	break;

	case 'ajax':
	$username=$_GET['username'];
	//准备sql语句
	$sql="select * from admin where username='{$username}'";
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