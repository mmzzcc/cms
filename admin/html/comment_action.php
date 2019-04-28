<?php
//引用函数文件
include './functions.php';
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
/*
	根据用户的行为执行操作数据库的代码
		del:删除
 */
switch($_GET['action']){
	case 'del':
	//准备sql语句
	$sql="delete from comment where t_id={$_GET['t_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('删除评论成功','./comment_list.php');
		die;
	}else{
		abort('该评论已被其他用户删除','./comment_list.php');
		die;
	}

	break;

	default:

	break;
}
?>