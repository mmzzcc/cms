<?php
//开启session
session_start();
//引用跳转函数
include './functions.php';
//验证用户是否登录
if(empty($_SESSION['islogin'])){
	abort('请登录','./login.php');
	die;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台主页</title>
</head>

<frameset rows="92,*"   border="0"  frameborder="0">
	<frame src="top.php"  />
    <frameset cols="240,*">
    	<frame src="left.php" />
        <frame src="news_add.php" name="right" />
    </frameset>
</frameset>
</html>
