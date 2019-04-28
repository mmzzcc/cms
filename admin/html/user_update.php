<?php
//引用函数文件
include './functions.php';
//开启session
session_start();
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
$sql="select * from user where user_recycle=1 and user_id={$_GET['user_id']}";
//执行sql语句
$result=mysqli_query($link,$sql);
//处理结果
if($result && $row=mysqli_fetch_assoc($result)){

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改用户</title>
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
<h2>修改用户</h2>
<form name="login"  action="user_action.php?action=upd" method="post">
<table border="0"    cellspacing="20" cellpadding="0">
  <tr>
  	<input type="hidden" name="user_id" value="<?=$row['user_id']?>" >
    <td>用户名：</td>
    <td><input   type="text" name="user_name" value="<?=$row['user_name']?>" class="txt"/>
        <span id="uspan"></span>
    </td>
  </tr>
  <tr>
  	<td>手机号：</td>
  	<td>
  		<input type="text" name="user_tel" value="<?=$row['user_tel']?>" class="txt">
      <span id="tspan"></span>
  	</td>
  </tr>
  <tr>
  	<td>邮箱：</td>
  	<td>
  		<input type="text" name="user_email" value="<?=$row['user_email']?>" class="txt">
      <span id="espan"></span>
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
  var user_name=document.getElementsByName('user_name')[0];
  var uspan=document.getElementById('uspan');
  var sub=document.getElementsByClassName('sub')[0];
  var flag=false;

  user_name.onblur=function(){
    user_name_empty();
  };

  function user_name_empty(){

    if(user_name.value==''){
      uspan.innerHTML="<i class='error'>用户名不能为空</i>";
      return false;
    }else{
      user_name_unique();
      return true;
    }
  };

  function user_name_unique(){
    var content=user_name.value;
    var xhr=new XMLHttpRequest();

    xhr.onreadystatechange=function(){

      if(xhr.readyState==4 && xhr.status==200){
        var res=xhr.responseText;
        // alert(res);
        if(res==1){
          uspan.innerHTML="<i class='error'>用户名已被占用</i>";
          flag=false;
        }else{
          uspan.innerHTML="<i class='success'>用户名可用</i>";
          flag=true;
        }
      }
    }

    xhr.open('get','./user_action.php?action=ajax&user_name='+content);

    xhr.send();
  };

  var user_tel=document.getElementsByName('user_tel')[0];
  var tspan=document.getElementById('tspan');

  user_tel.onblur=function(){
    user_tel_empty();
  };

  function user_tel_empty(){
    if(user_tel.value==''){
      tspan.innerHTML="<i class='error'>手机号不能为空</i>";
      return false;
    }else{
      tspan.innerHTML="<i class='success'>手机号可用</i>";
      return true;
    }
  };


  var user_email=document.getElementsByName('user_email')[0];
  var espan=document.getElementById('espan');

  user_email.onblur=function(){
    user_email_empty();
  };

  function user_email_empty(){

    if(user_email.value==''){
      espan.innerHTML="<i class='error'>邮箱不能为空</i>";
      return false;
    }else{
      espan.innerHTML="<i class='success'>邮箱可用</i>";
      return true;
    }
  };

  sub.onclick=function(){
    var res1=user_name_empty();
    var res2=user_tel_empty();
    var res3=user_email_empty();

    return flag && res1 && res2 && res3;
  }
</script>
</body>
</html>

<?php

}
?>