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

$c_name=empty($_GET['c_name'])?'':$_GET['c_name'];
//设置每页显示条数
$tiao=2;
//求出总条数
$sqlCount="select count(*) as count from category where c_name like '%{$c_name}%' and c_status=1";
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
//求出当前位置
$start=($page-1)*$tiao;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新闻分类列表</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
</head>

<body>
<div  id="main">
  <form>
    搜索分类
    <input type="text" name="c_name" value="<?=$c_name?>" placeholder="请输入分类名称...">
    <button>搜索</button>
  </form>
<table width="80%"  border="0" cellspacing="0" cellpadding="0" class="news_table">
  <caption>
    新闻分类列表&nbsp;
    <a href='./cate_add.php'>添加分类</a>&nbsp;
    <a href='./cate_recycle.php'>回收站</a>
  </caption>
  <tr>
    <th scope="col">编号</th>
    <th scope="col" width="100">分类名称</th>
    <th scope="col">添加人</th>
    <th scope="col">时间</th>
    <th scope="col">操作</th>
  </tr>
  <?php
  //准备sql语句
  $sql="select * from category where c_name like '%{$c_name}%' and c_status=1 limit {$start},{$tiao}";
  //执行sql语句
  $result=mysqli_query($link,$sql);
  //处理结果集
  if($result){
    //设置编号
    $num=$start+1;
    while($row=mysqli_fetch_assoc($result)){
      //显示添加时间
      $time=date('Y-m-d H:i:s',$row['c_time']);
      echo "<tr>
              <td>{$num}</td>
              <td>{$row['c_name']}</td>
              <td>{$row['c_man']}</td>
              <td>{$time}</td>
              <td>
                  <a href='./cate_action.php?action=inrecycle&c_id={$row["c_id"]}'>放入回收站</a>
                  <a href='./cate_update.php?c_id={$row["c_id"]}'>修改</a>
              </td>
          </tr>";
    $num++;      
    }
    echo "<tr>
            <td><a href='./cate_list.php?p=1&c_name={$c_name}'>首页</a></td>
            <td><a href='./cate_list.php?p={$prev}&c_name={$c_name}'>上一页</a></td>
            <td><a href='./cate_list.php?p={$next}&c_name={$c_name}'>下一页</a></td>
            <td><a href='./cate_list.php?p={$maxPage}&c_name={$c_name}'>尾页</a></td>
            <td>一共有{$maxPage}页</td>
        </tr>";
  }

  ?>
</table>



</div>
</body>
</html>
