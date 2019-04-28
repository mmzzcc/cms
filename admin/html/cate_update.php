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
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
//准备sql语句
$sql="select * from category where c_id={$_GET['c_id']}";
//执行sql语句
$result=mysqli_query($link,$sql);
//处理结果
if($result && $row=mysqli_fetch_assoc($result)){


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改分类</title>
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
<link rel="stylesheet" type="text/css" href="../css/public.css">
</head>

<body>
<div  id="main">
<h2>修改分类&nbsp;
	<a href='./cate_list.php'>分类列表</a>
</h2>
<form name="login"  action="cate_action.php?action=upd" method="post">
	<table border="0"    cellspacing="10" cellpadding="0">
		  <tr>
		  		<input type="hidden" name="c_id" value="<?=$row['c_id']?>" >
			<td>分类名称：</td>
			<td><input   type="text" name="c_name" value="<?=$row['c_name']?>" class="txt"/>
				<span id="nspan"></span>
			</td>
		  </tr>
			<tr>
			<td>添加人：</td>
			<td><input   type="text"  name="c_man"  value="<?=$row['c_man']?>" class="txt"/>
				<span id="mspan"></span>
			</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><input  type="submit" value="修 改"  class="sub"/><input  type="reset" value="重 置"  class="res"/></td>
		  </tr>
	</table>
</form>
</div>
<script type="text/javascript">
	var c_name=document.getElementsByName('c_name')[0];
	console.log(c_name);
	var nspan=document.getElementById('nspan');
	var sub=document.getElementsByClassName('sub')[0];
	var flag=false;

	c_name.onblur=function(){
		c_name_empty();
	};

	function c_name_empty(){
		if(c_name.value==''){
			nspan.innerHTML="<i class='error'>分类名称不能为空</i>";
			return false;
		}else{
			c_name_unique();
			return true;
		}
	};

	function c_name_unique(){
		var content=c_name.value;
		var xhr=new XMLHttpRequest();
		xhr.onreadystatechange=function(){
			if(xhr.readyState==4 && xhr.status==200){
				var res=xhr.responseText;
				// alert(res);
				if(res==1){
					nspan.innerHTML="<i class='error'>分类名称已被占用</i>";
					flag=false;
				}else{
					nspan.innerHTML="<i class='success'>分类名可用</i>";
					flag=true;
				}
			}
		}

		xhr.open('get','./cate_action.php?action=ajax&c_name='+content);

		xhr.send();
	};

	var c_man=document.getElementsByName('c_man')[0];
	var mspan=document.getElementById('mspan');

	c_man.onblur=function(){
		c_man_empty();
	}

	function c_man_empty(){

		if(c_man.value==''){
			mspan.innerHTML="<i class='error'>添加人不能为空</i>";
			return false;
		}else{
			mspan.innerHTML="<i class='success'>添加人可用</i>";
			return true;
		}
	};

	sub.onclick=function(){
		var res1=c_name_empty();
		var res2=c_man_empty();

		return flag && res1 && res2;
		
	};
</script>
</body>
</html>
<?php

}
?>