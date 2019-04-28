<?php
//引用第一部分
include './header_1.php';
?>

<div>
<div  id="main">
<h2 align="center">欢迎注册新用户</h2>
<div class="article">

<form name="login"  action="doregister.php?action=ins" method="post">

<table border="0"    cellspacing="20" cellpadding="0" align="center">
  <tr>
    <td>用户名：</td>
    <td><input   type="text" name="user_name" class="txt" width="2"/>
        <span id="uspan"></span>
    </td>
  </tr>
  <tr>
    <td>密码：</td>
    <td><input  type="password" name="user_pwd"  class="txt"/>
        <span id="pspan"></span>
    </td>
  </tr>
  <tr>
    <td>确认密码：</td>
    <td>
      <input type="password" name="user_repwd">
      <span id="respan"></span>
    </td>
  </tr>
  <tr>
    <td>手机号：</td>
    <td>
      <input type="text" name="user_tel">
      <span id="tspan"></span>
    </td>
  </tr>
  <tr>
    <td>邮箱：</td>
    <td>
      <input type="text" name="user_email">
      <span id='espan'></span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input  type="submit" value="注 册"  class="sub"/><input  type="reset" value="重 置"  class="res"/></td>
  </tr>
</table>

</form>

</div>
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
      // console.log(user_name.value);
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
          user_name_test();
          flag=true;
        }
      }
    }

    xhr.open('get','./doregister.php?action=ajax&user_name='+content);

    xhr.send();

  };

  function user_name_test(){
    var str1=user_name.value;
    var result1=/^[a-z_]\w{5,17}$/i;
    if(result1.test(str1)){
      uspan.innerHTML="<i class='success'>用户名可用</i>";
      return true;
    }else{
      uspan.innerHTML="<i class='error'>用户名格式不正确</i>";
      return false;
    }
  };

  var user_pwd=document.getElementsByName('user_pwd')[0];
  var pspan=document.getElementById('pspan');

  user_pwd.onblur=function(){
    user_pwd_empty();
  };

  function user_pwd_empty(){

    if(user_pwd.value==''){
      pspan.innerHTML="<i class='error'>密码不能为空</i>";
      return false;
    }else{
      user_pwd_test();
      return true;
    }
  };

  function user_pwd_test(){
    var str2=user_pwd.value;
    var result2=/^\w{6,}$/i;
    if(result2.test(str2)){
      pspan.innerHTML="<i class='success'>密码可用</i>";
      return true;
    }else{
      pspan.innerHTML="<i class='error'>密码格式不正确</i>";
      return false;
    }
  };

  var user_repwd=document.getElementsByName('user_repwd')[0];
  var respan=document.getElementById('respan');

  user_repwd.onblur=function(){
    user_repwd_empty();
  };

  function user_repwd_empty(){

    if(user_repwd.value==''){
      respan.innerHTML="<i class='error'>确认密码不能为空</i>";
      return false;
    }else if(user_pwd.value!=user_repwd.value){
      respan.innerHTML="<i class='error'>输入密码不一致</i>";
      return false;
    }else{
      user_repwd_test();
      return true;
    }
  };

  function user_repwd_test(){
    var str3=user_repwd.value;
    var result3=/^\w{6,}$/i;
    if(result3.test(str3)){
      respan.innerHTML="<i class='success'>密码可用</i>";
      return true;
    }else{
      respan.innerHTML="<i class='error'>密码格式不正确</i>";
      return false;
    }
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
      user_tel_test();
      return true;
    }
  };

  function user_tel_test(){
    var str4=user_tel.value;
    var result4=/^1[0-9]\d{9}$/;
    if(result4.test(str4)){
      tspan.innerHTML="<i class='success'>手机号可用</i>";
      return true;
    }else{
      tspan.innerHTML="<i class='error'>手机号格式不正确</i>";
      return false;
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
      user_email_test();
      return true;
    }
  };

  function user_email_test(){
    var str5=user_email.value;
    var result5=/^[1-9]\d{4,10}@qq\.com$/i;
    if(result5.test(str5)){
      espan.innerHTML="<i class='success'>邮箱可用</i>";
      return true;
    }else{
      espan.innerHTML="<i class='error'>邮箱格式不正确</i>";
      return false;
    }
  };

  sub.onclick=function(){
    var res1=user_name_empty();
    var res2=user_pwd_empty();
    var res3=user_repwd_empty();
    var res4=user_tel_empty();
    var res5=user_email_empty();

    return flag && res1 && res2 && res3 && res4 && res5;
  }
</script>

<?php
//引用底部文件
include './footer.php';
?>
