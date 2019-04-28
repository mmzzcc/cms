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
	//验证填写内容是否完整
	foreach($_POST as $k => $v){
		if(empty($v)){
			abort('请填写完整内容','./news_add.php');
			die;
		}else{
			//接收值
			$$k=$v;
		}
	}
	//写入添加时间
	$n_time=time();
	//准备sql语句
	$sql="insert into news(n_title,n_content,n_man,c_id,n_time) values('{$n_title}','{$n_content}','{$n_man}',{$c_id},'{$n_time}')";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('添加成功','./news_list.php');
		die;
	}else{
		abort('标题已被占用','./news_add.php');
		die;
	}
	break;

	case 'del':
	//准备sql语句
	$sql="delete from news where n_id={$_GET['n_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('删除成功','./news_recycle.php');
		die;
	}else{
		abort('该信息已被其他用户删除','./news_recycle.php');
		die;
	}

	break;

	case 'upd':
	//验证填写内容是否完整
	foreach($_POST as $k => $v){
		if(empty($v)){
			abort('请填写完整内容','./news_add.php');
			die;
		}else{
			//接收值
			$$k=$v;
		}
	}
	//准备sql语句
	$sql="update news set n_title='{$n_title}',c_id={$c_id},n_man='{$n_man}',n_content='{$n_content}' where n_id={$_POST['n_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('修改成功','./news_list.php');
		die;
	}else{
		abort('信息没有被修改',"./news_update.php?n_id={$_POST['n_id']}");
		die;
	}

	break;

	case 'inrecycle':
	//准备sql语句
	$sql="update news set n_recycle=2 where n_id={$_GET['n_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('放入成功','./news_list.php');
		die;
	}else{
		abort('该信息已被其他用户放入或删除','./news_list.php');
		die;
	}

	break;

	case 'outrecycle':
	//准备sql语句
	$sql="update news set n_recycle=1 where n_id={$_GET['n_id']}";
	//执行sql语句
	$result=mysqli_query($link,$sql);
	//处理结果
	if($result && mysqli_affected_rows($link)>0){
		abort('还原成功','./news_recycle.php');
		die;
	}else{
		abort('该信息已被其他用户删除','./news_recycle.php');
		die;
	}
	break;


	case 'ajax':
	$n_title=$_GET['n_title'];
	//准备sql语句
	$sql="select * from news where n_title='{$n_title}'";
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