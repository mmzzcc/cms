<?php
//开启session
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>顶部</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
</head>

<body>
<div id="header">
<img src="../images/logo1.png" />
<h3>欢迎<?=$_SESSION['username']?>登陆</h3>
<a href="./login_action.php?action=outlogin">退出</a>
</div>
</body>
</html>
