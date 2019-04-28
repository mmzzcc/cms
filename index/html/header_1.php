<?php
//开启session
session_start();
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
// var_dump($_SERVER);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>前台首页</title>
<style type="text/css">
    .error{
        color:red;
        font-size:14px;
    }

    .success{
        color:green;
        font-size:14px;
    }
</style>
<link rel="stylesheet" type="text/css" href="../css/index.css">

</head>

<body>
<div id="header">
<img src="../images/logo1.png" alt="logo"/>
<ul>
	<?php
	//验证用户是否登录
	if(empty($_SESSION['userInfo'])){
		echo "<li><a href='./register.php'>会员注册</a>/</li>
    		  <li><a href='./login.php'>登陆</a></li>";
	}else{
        $time=date('Y-m-d H:i:s',$_SESSION['userInfo']['login_time']);
		echo "<li>欢迎{$_SESSION['userInfo']['user_name']}</li>
			  <li><a href='./login_action.php?action=outlogin'>退出</a></li>";
        echo "</ul>";
        echo "<ol style='clear:both;float:right;'>
                <li>上次登录时间：{$time}</li>
                <li>上次登录ip：{$_SESSION['userInfo']['login_ip']}</li>
            </ol>";
	}

    
	?>
	
</ul>
</div>

<div id="nav">
<ul>
	<li ><a href="./index.php"  class="<?php empty($_GET['c_id'])?'active':'' ?>">首页</a></li>
    <?php
    //准备sql语句
    $sql="select * from category where c_status=1";
    //执行sql语句
    $result=mysqli_query($link,$sql);
    //处理结果集
    if($result){
    	while($row=mysqli_fetch_assoc($result)){
    		if(!empty($_GET['c_id']) && $_GET['c_id']==$row['c_id']){
    			$active='active';
    			 $c_name=$row['c_name'];
    		}else{
    			$active='';
    		}
    		echo "<li ><a class='{$active}' href='./index_list.php?c_id={$row["c_id"]}'>{$row['c_name']}</a></li>";
    	}
    }
    ?>
</ul>
</div>