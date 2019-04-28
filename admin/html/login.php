<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>登陆</title>
<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>

<body>
<div id="login">
<form name="login"  action="login_action.php?action=islogin" method="post">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>用户名：</td>
    <td><input  name='username' type="text" class="login_txt" id="n"/></td>
  </tr>
  <tr>
    <td>密&nbsp;码：</td>
    <td><input name='pwd' type="password"  class="login_txt" id="p" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="checkbox"  checked="checked" />一周免登陆     <a href="./admin_add.php">忘记密码？</a>    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input  type="submit" value="登 陆" class="sub"/><input  type="reset" value="重 置"  class="res"/></td>
  </tr>
</table>

</form>
</div>
</body>
</html>

