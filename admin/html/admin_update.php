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
$sql="select * from admin where id={$_GET['id']}";
//执行sql语句
$result=mysqli_query($link,$sql);
//处理结果
if($result && $row=mysqli_fetch_assoc($result)){
	$hobby=explode('☆',$row['hobby']);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改管理员</title>
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
<h2>修改管理员&nbsp;
  <a href='./admin_list.php'>管理员列表</a>
</h2>
<form name="login"  action="admin_action.php?action=upd" method="post">
<table border="0"    cellspacing="20" cellpadding="0">
  <tr>
  		<input type="hidden" name="id" value="<?=$row['id']?>">
    <td>用户名：</td>
    <td><input   type="text" name="username" value="<?=$row['username']?>" class="txt"/>
        <span id="uspan"></span>
    </td>
  </tr>
  <tr>
    <td>性别：</td>
    <td>
    <input   type="radio"  name="sex"  value='nan' <?=$row['sex']=='nan'?'checked':'' ?> />男
    <input   type="radio"  name="sex" value='nv' <?=$row['sex']=='nv'?'checked':'' ?> />女</td>
  </tr>
    <tr>
    <td>爱好：</td>
    <td>
    <input   type="checkbox" <?=in_array('web',$hobby)?'checked':'' ?> name='hobby[]' value="web"/>上网
    <input   type="checkbox" <?=in_array('sport',$hobby)?'checked':'' ?> name='hobby[]' value="sport"/>体育
    <input   type="checkbox" <?=in_array('study',$hobby)?'checked':'' ?> name='hobby[]'  value="study"/>学习
    </td>
  </tr>
      <tr>
    <td>城市：</td>
    <td>
    <select name="city"  class="s1">
    	<option <?=$row['city']=='1'?'selected':'' ?> value="1">北京</option>
        <option <?=$row['city']=='2'?'selected':'' ?> value="2">上海</option>
        <option <?=$row['city']=='3'?'selected':'' ?> value="3">南京</option>
    </select>
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
  var username=document.getElementsByName('username')[0];
  var uspan=document.getElementById('uspan');
  var sub=document.getElementsByClassName('sub')[0];
  var flag=false;
  username.onblur=function(){
    username_empty();
  };

  function username_empty(){

    if(username.value==''){
      uspan.innerHTML="<i class='error'>用户名不能为空</i>";
      return false;
    }else{
      username_unique();
      return true;   
    }
  };

  function username_unique(){
    var content=username.value;
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

    xhr.open('get','./admin_action.php?action=ajax&username='+content);

    xhr.send();
  };

  sub.onclick=function(){
    var res1=username_empty();

    return flag && res1;
  };
</script>
</body>
</html>
<?php
}
?>