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

$username=empty($_GET['username'])?'':$_GET['username'];
//设置每页条数
$tiao=2;
//求出总条数
$sqlCount="select count(*) as count from admin where username like '%{$username}%' and status=1";
$res=mysqli_query($link,$sqlCount);
$a=mysqli_fetch_assoc($res);
$total=$a['count'];
// var_dump($a);
// var_dump($total);
//求出总页数
$maxPage=ceil($total/$tiao);
// var_dump($maxPage);
//求出当前页数
$page=empty($_GET['p'])?1:$_GET['p'];
//给当前页数一个合理的条件
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
<title>管理员列表</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
</head>

<body>
<div  id="main">
  <form>
    搜索管理员:
    <input type="text" name="username" value="<?=$username?>" placeholder="请输入搜索名称...">
    <button>搜索</button>
  </form>
<table  width="80%" border="0" cellspacing="0" cellpadding="0" class="news_table">
  <caption>
    管理员列表&nbsp;
    <a href='./admin_add.php'>添加管理员</a>&nbsp;
    <a href='./admin_recycle.php'>冻结列表</a>
  </caption>
  <tr>
    <th scope="col">编号</th>
    <th scope="col" width="100">名称</th>
    <th scope="col">性别</th>
    <th scope="col">爱好</th>
    <th scope="col">城市</th>
    <th scope="col">操作</th>
  </tr>
 <?php
 //准备sql语句
 $sql="select * from admin where username like '%{$username}%' and status=1 limit {$start},{$tiao}";
 //执行sql语句
 $result=mysqli_query($link,$sql);
 //处理结果集
 if($result){
    //设置编号
    $num=$start+1;
    while($row=mysqli_fetch_assoc($result)){
      $sex=$row['sex']=='nan'?'男':'女';
      //将城市转为中文
      $cityArr=[1=>'北京',2=>'上海',3=>'南京'];
      $city=$cityArr[$row['city']];
      //将爱好转为中文
      $hobbyArr=['web'=>'上网','sport'=>'体育','study'=>'学习'];
      $hobbyStr=explode('☆',$row['hobby']);
      $hobby='';
      foreach($hobbyStr as $v){
        $hobby.=$hobbyArr[$v].'&nbsp;';
      }
      echo "<tr>
              <td>{$num}</td>
              <td>{$row['username']}</td>
              <td>{$sex}</td>
              <td>{$hobby}</td>
              <td>{$city}</td>
              <td>
                <a href='./admin_action.php?action=inrecycle&id={$row["id"]}'>冻结用户</a>
                <a href='./admin_update.php?id={$row["id"]}'>修改用户</a>
              </td>
          </tr>";
    $num++;
    }
    echo "<tr>
            <td><a href='./admin_list.php?p=1&username={$username}'>首页</a></td>
            <td><a href='./admin_list.php?p={$prev}&username={$username}'>上一页</a></td>
            <td><a href='./admin_list.php?p={$next}&username={$username}'>下一页</a></td>
            <td><a href='./admin_list.php?p={$maxPage}&username={$username}'>尾页</a></td>
            <td>一共有{$total}条</td>
            <td>一共有{$maxPage}页</td>
        </tr>";
 }
 ?>
</table>



</div>
</body>
</html>
