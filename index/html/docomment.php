<?php
// var_dump($_POST);
//开启session
session_start();
//引用跳转函数
include './functions.php';
	if(empty($_SESSION['userInfo'])){
		abort('登陆后才能评论','./login.php');
		die;
	}
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
//验证内容是否为空
if(empty($_POST['t_content'])){
	abort('请输入评论内容',"./news_content.php?n_id={$_POST["t_id"]}");
	die;
}
//写入评论时间
$t_time=time();
//评论人
$user_id=$_SESSION['userInfo']['user_name'];
//评论新闻
$n_id=$_POST['t_id'];
//评论内容
$t_content=$_POST['t_content'];
//准备sql语句
$sql="insert into comment(user_id,t_time,n_id,t_content) values('{$user_id}','{$t_time}','{$n_id}','{$t_content}')";
//执行sql语句
$result=mysqli_query($link,$sql);
//处理结果
if($result && mysqli_affected_rows($link)>0){
	abort('评论成功',"./news_content.php?n_id={$_POST['t_id']}");
	die;
}else{
	abort('出现未知错误',"./news_content.php?n_id={$_POST['t_id']}");
	die;
}
?>