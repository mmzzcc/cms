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
	//验证内容是否完整
	if(empty($_POST['c_name']) || empty($_POST['c_man'])){
		abort('请输入完整信息','./cate_add.php');
		die;
	}
	//接收值
	$c_name=$_POST['c_name'];
	$c_man=$_POST['c_man'];
	//写入添加时间
	$c_time=time();
	//准备sql语句
	$sql="insert into category(c_name,c_man,c_time) values('{$c_name}','{$c_man}','{$c_time}')";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('添加成功','./cate_list.php');
		die;
	}else{
		abort('分类名已被占用','cate_add.php');
		die;
	}
	break;

	case 'del':
	//准备sql语句
	$sql="delete from category where c_id={$_GET['c_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('删除成功','./cate_recycle.php');
		die;
	}else{
		abort('该信息已被其他用户删除','./cate_recycle.php');
		die;
	}

	break;

	case 'upd':
	//验证内容是否完整
	if(empty($_POST['c_name']) || empty($_POST['c_man'])){
		abort('请输入完整信息','./cate_add.php');
		die;
	}
	//接收值
	$c_name=$_POST['c_name'];
	$c_man=$_POST['c_man'];
	//准备sql语句
	$sql="update category set c_name='{$c_name}',c_man='{$c_man}' where c_id={$_POST['c_id']} ";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('修改成功','./cate_list.php');
		die;
	}else{
		abort('信息没有被修改',"./cate_update.php?c_id={$_POST['c_id']}");
		die;
	}
	break;

	case 'inrecycle':
	//准备sql语句
	$sql="update category set c_status=2 where c_id={$_GET['c_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('放入成功','./cate_list.php');
		die;
	}else{
		abort('该信息已被其他用户放入','./cate_list.php');
		die;
	}

	break;

	case 'outrecycle':
	//准备sql语句
	$sql="update category set c_status=1 where c_id={$_GET['c_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('还原成功','./cate_recycle.php');
		die;
	}else{
		abort('该信息已被其他用户删除','./cate_recycle.php');
		die;
	}
	break;

	case 'ajax':

	// echo 11;
	$c_name=$_GET['c_name'];
	//准备sql语句
	$sql="select * from category where c_name='{$c_name}'";
	// echo $sql;
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && $row=mysqli_fetch_assoc($result)){
		echo 1;
	}else{
		echo 0;
	}
	default:

	break;
}
?>