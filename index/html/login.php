<?php
//引用第一部分
include './header_1.php';
?>
<div>
<div  id="main">
<h2 align="center">欢迎登录</h2>
<div class="article">

<form name="login"  action="./login_action.php?action=islogin" method="post">

<table border="0"    cellspacing="20" cellpadding="0" align="center">
  <tr>
    <td>用户名：</td>
    <td><input   type="text" name="user_name" class="txt" width="2"/></td>
  </tr>
  <tr>
    <td>密码：</td>
    <td><input  type="password" name="user_pwd"  class="txt"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input  type="submit" value="登 录"  class="sub"/><input  type="reset" value="重 置"  class="res"/></td>
  </tr>
</table>

</form>

</div>
</div>

<?php
//引用底部文件
include './footer.php';
?>

  
