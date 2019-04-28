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

$user_id=empty($_GET['user_id'])?'':$_GET['user_id'];
//设置每页显示条数
$tiao=2;
//求出总条数
$sqlCount="select count(*) as count from category,news,comment where comment.user_id like '%{$user_id}%' and comment.n_id=news.n_id and news.c_id=category.c_id and news.n_recycle=1";
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
<title>评论列表</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
</head>

<body>
<div  id="main">
  <form method="get">
    搜索评论：
    <input type="text" value="<?=$user_id?>" name="user_id" placeholder="请输入搜索评论人...">
    <button>搜索</button>
  </form>
<table  width="80%" border="0" cellspacing="0" cellpadding="0" class="news_table">
  <caption>
    评论列表&nbsp;
    <!---<a href='./comment_recycle.php'>回收站</a>--->
  </caption>
  <tr>
    <th scope="col">编号</th>
    <th scope="col" width="100">评论人</th>
    <th scope="col">所属分类</th>
    <th scope="col">所属新闻</th>
    <th scope="col">评论时间</th>
    <th scope="col">评论内容</th>
    <th scope="col">操作</th>
  </tr>
  <?php
  //准备sql语句
  $sql="select * from category,news,comment where comment.user_id like '%{$user_id}%' and comment.n_id=news.n_id and news.c_id=category.c_id and news.n_recycle=1 order by comment.t_time desc limit {$start},{$tiao}";
  //执行sql语句
  $result=mysqli_query($link,$sql);
  //处理结果集
  if($result){
  	//设置编号
  	$num=$start+1;
  	while($row=mysqli_fetch_assoc($result)){
  		//显示评论时间
  		$t_time=date('Y-m-d H:i:s',$row['t_time']);
  		echo "<tr>
  				<td>{$num}</td>
  				<td>{$row['user_id']}</td>
  				<td>{$row['c_name']}</td>
  				<td>{$row['n_title']}</td>
  				<td>{$t_time}</td>
  				<td>{$row['t_content']}</td>
  				<td>
  					<a href='./comment_action.php?t_id={$row["t_id"]}&action=del'>删除</a>
  				</td>
  			</tr>";
  	$num++;
  	}
  	echo "<tr>
  			<td colspan='2'><a href='./comment_list.php?p=1&user_id={$user_id}'>首页</a></td>
  			<td><a href='./comment_list.php?p={$prev}&user_id={$user_id}'>上一页</a></td>
  			<td><a href='./comment_list.php?p={$next}&user_id={$user_id}'>下一页</a></td>
  			<td><a href='./comment_list.php?p={$maxPage}&user_id={$user_id}'>尾页</a></td>
        <td>一共有{$total}条</td>
  			<td>一共有{$maxPage}页</td>
  		</tr>";
  }
  ?>

</table>

</div>
</body>
</html>
