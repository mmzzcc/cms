<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员添加</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
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
</head>

<body>
<div  id="main">
<h2>管理员添加&nbsp;
  <a href='./admin_list.php'>管理员列表</a>
</h2>
<form name="login"  action="admin_action.php?action=ins" method="post">
<table border="0"    cellspacing="20" cellpadding="0">
  <tr>
    <td>用户名：</td>
    <td><input   type="text" name="username" class="txt"/>
      <span id="uspan"></span>
    </td>
  </tr>
  <tr>
    <td>密码：</td>
    <td><input  type="password" name="pwd"  class="txt"/>
        <span id="pspan"></span>
    </td>
  </tr>
  <tr>
    <td>确认密码：</td>
    <td><input  type="password" name="repwd"  class="txt"/>
        <span id='respan'></span>
    </td>
  </tr>
  <tr>
    <td>性别：</td>
    <td>
    <input   type="radio"  name="sex"  value='nan' checked />男
    <input   type="radio"  name="sex" value='nv' />女</td>
  </tr>
    <tr>
    <td>爱好：</td>
    <td>
    <input   type="checkbox" name='hobby[]' value="web"/>上网
    <input   type="checkbox" name='hobby[]' value="sport"/>体育
    <input   type="checkbox" name='hobby[]'  value="study"/>学习
    </td>
  </tr>
      <tr>
    <td>城市：</td>
    <td>
    <select name="city"  class="s1">
    	<option value="1">北京</option>
        <option value="2">上海</option>
        <option value="3">南京</option>
    </select>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input  type="submit" value="添 加"  class="sub"/><input  type="reset" value="重 置"  class="res"/></td>
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
    var xhr=new XMLHttpRequest();
    var content=username.value;
    xhr.onreadystatechange=function(){
        if(xhr.readyState==4 && xhr.status==200){
          var res=xhr.responseText;
          // alert(res);
            if(res==1){
              uspan.innerHTML="<i class='error'>用户名已被占用</i>";
              flag=false;
            }else{
             uspan.innerHTML="<i class='success'>用户名可以使用</i>";
             flag=true;
            }
       }
   };  

        xhr.open('get','./admin_action.php?action=ajax&username='+content);

        xhr.send();
  };

  var pwd=document.getElementsByName('pwd')[0];
  var pspan=document.getElementById('pspan');

  pwd.onblur=function(){
    pwd_empty();
  };

  function pwd_empty(){
    if(pwd.value==''){
      pspan.innerHTML="<i class='error'>密码不能为空</i>";
      return false;
    }else{
      pspan.innerHTML="<i class='success'>密码可用</i>";
      return true;
    }
  };

  var repwd=document.getElementsByName('repwd')[0];
  var respan=document.getElementById('respan');

  repwd.onblur=function(){
    repwd_empty();
  };

  function repwd_empty(){

    if(repwd.value==''){
      respan.innerHTML="<i class='error'>确认密码不能为空</i>";
      return false;
    }else if(pwd.value!=repwd.value){
      respan.innerHTML="<i class='error'>输入密码不一致</i>";
      return false;
    }else{
      respan.innerHTML="<i class='success'>确认密码可用</i>";
      return true;
    }
  };

  var sex=document.getElementsByName('sex');
  console.log(sex);

  sub.onclick=function(){

    res1=username_empty();
    res2=pwd_empty();
    res3=repwd_empty();

    return flag && res1 && res2 && res3;
  };
</script>
</body>
</html>
