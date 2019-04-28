<?php
//开启session
session_start();
//引用函数文件
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

$user_name=empty($_GET['user_name'])?'':$_GET['user_name'];
//设置每页条数
$tiao=2;
//求出总条数
$sqlCount="select count(*) as count from user where  user_name like '%{$user_name}%' and user_recycle=1";
$res=mysqli_query($link,$sqlCount);
$a=mysqli_fetch_assoc($res);
$total=$a['count'];
//求出总页数
$maxPage=ceil($total/$tiao);
//求出当前页数
$page=empty($_GET['p'])?1:$_GET['p'];
//给当前页数一个合法的设置
$page=$page<1?1:$page;
$page=$page>$maxPage?$maxPage:$page;
//求出上一页
$prev=$page-1<1?1:$page-1;
//求出下一页
$next=$page+1>$maxPage?$maxPage:$page+1;
//求出起始位置
$start=($page-1)*$tiao;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户列表</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
</head>

<body>
<div  id="main">
  <form>
    搜索用户
    <input type="text" name="user_name" value="<?=$user_name?>" placeholder="请输入关键字搜索..." >
    <button>搜索</button>
  </form>
<table  width="80%" border="0" cellspacing="0" cellpadding="0" class="news_table">
  <caption>
    用户列表&nbsp;
    <a href='./user_recycle.php'>冻结列表</a>
  </caption>
  <tr>
    <th scope="col">编号</th>
    <th scope="col" width="100">名称</th>
    <th scope="col">手机号</th>
    <th scope="col">邮箱</th>
    <th scope="col">注册时间</th>
    <!---<th scope="col">最后登录时间</th>--->
    <th scope="col">操作</th>
  </tr>

  <?php
  //准备sql语句
  $sql="select * from user where user_name like '%{$user_name}%' and user_recycle=1 order by register_time desc limit {$start},{$tiao}";
  //执行sql语句
  $result=mysqli_query($link,$sql);
  //处理结果集
  if($result){
  	//设置编号
  	$num=$start+1;
  	while($row=mysqli_fetch_assoc($result)){
  		//显示注册时间
  		$register_time=date('Y-m-d H:i:s',$row['register_time']);
  		//显示最后登录时间
  		//$login_time=date('Y-m-d H:i:s',$row['login_time']);
  		echo "<tr>
  				<td>{$num}</td>
  				<td>{$row['user_name']}</td>
  				<td>{$row['user_tel']}</td>
  				<td>{$row['user_email']}</td>
  				<td>{$register_time}</td>
  				
  				<td>
  					<a href='./user_action.php?action=inrecycle&user_id={$row["user_id"]}'>冻结用户</a>
  					<a href='./user_update.php?user_id={$row["user_id"]}'>修改</a>
  				</td>
  			</tr>";
  	$num++;		
  	}
  	echo "<tr>
  			<td><a href='./user_list.php?p=1&user_name={$user_name}'>首页</a></td>
  			<td><a href='./user_list.php?p={$prev}&user_name={$user_name}'>上一页</a></td>
  			<td><a href='./user_list.php?p={$next}&user_name={$user_name}'>下一页</a></td>
  			<td><a href='./user_list.php?p={$maxPage}&user_name={$user_name}'>尾页</a></td>
        <td>一共有{$total}条</td>
  			<td>一共有{$maxPage}页</td>
  		</tr>";
  }
  ?>

</table>

</div>
</body>
</html>
