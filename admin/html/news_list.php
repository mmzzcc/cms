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

$n_title=empty($_GET['n_title'])?'':$_GET['n_title'];

//设置每页显示条数
$tiao=2;
//求出总条数
$sqlCount="select count(*) as count from news,category where news.n_title like '%{$n_title}%' and news.c_id=category.c_id and news.n_recycle=1 ";
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
<title>新闻列表</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
</head>

<body>
<meta charset='utf8'/>
<div  id="main">
  <form method="get">
      搜索新闻:
      <input type="text" name="n_title" value="<?= $n_title?>"  placeholder="输入标题查询...">
      <button>查询</button>
  </form>
<table width="90%" border="0" cellspacing="0" cellpadding="0" class="news_table">
  <caption>
    <a href='./news_add.php'>添加新闻</a>&nbsp;
    新闻列表&nbsp;
    <a href='./news_recycle.php'>回收站</a>
  </caption>
  <tr>
    <th scope="col">编号</th>
    <th scope="col" width="100">新闻标题</th>
    <th scope="col">所属分类</th>
    <th scope="col">添加人</th>
    <th scope="col">添加时间</th>
    <th scope="col">操作</th>
  </tr>
  <?php
  //准备sql语句
  $sql="select * from news,category where news.n_title like '%{$n_title}%' and news.c_id=category.c_id and news.n_recycle=1  order by news.n_time desc limit {$start},{$tiao}";
  //执行sql语句
  $result=mysqli_query($link,$sql);
  //处理结果集
  if($result){
    //设置编号
    $num=$start+1;
    while($row=mysqli_fetch_assoc($result)){
      //显示添加时间
      $n_time=date('Y-m-d H:i:s',$row['n_time']);
      echo "<tr>
              <td>{$num}</td>
              <td>{$row['n_title']}</td>
              <td>{$row['c_name']}</td>
              <td>{$row['n_man']}</td>
              <td>{$n_time}</td>
              <td>
                <a href='./news_action.php?action=inrecycle&n_id={$row["n_id"]}'>放入回收站</a>
                <a href='./news_update.php?n_id={$row["n_id"]}'>修改</a>
              </td>
          </tr>";
    $num++;
    }
    echo "<tr>
            <td><a href='./news_list.php?p=1&n_title={$n_title}'>首页</a></td>
            <td><a href='./news_list.php?p={$prev}&n_title={$n_title}'>上一页</a></td>
            <td><a href='./news_list.php?p={$next}&n_title={$n_title}'>下一页</a></td>
            <td><a href='./news_list.php?p={$maxPage}&n_title={$n_title}'>尾页</a></td>
            <td>一共有{$total}条</td>
            <td>一共有{$maxPage}页</td>
        </tr>";
  }
  ?>

</table>
</div>
</body>
</html>
