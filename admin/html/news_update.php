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
$sql="select * from news where n_id={$_GET['n_id']}";
//执行sql语句
$result=mysqli_query($link,$sql);
//处理结果
if($result && $row=mysqli_fetch_assoc($result)){


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改新闻</title>
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
<script type="text/javascript" charset="utf-8" src="../../public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../../public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="../../public/ueditor/lang/zh-cn/zh-cn.js"></script>

</head>

<body>
<meta charset='utf8'/>
<div  id="main">
<h2>修改新闻&nbsp;
    <a href='./news_list.php'>新闻列表</a>
</h2>
<form name="login"  action="news_action.php?action=upd" method="post">
<table border="0"    cellspacing="10" cellpadding="0">
  <tr>
  	<input type="hidden" name="n_id" value="<?=$row['n_id']?>">
    <td>新闻标题：</td>
    <td><input   type="text" name="n_title" value="<?=$row['n_title']?>" class="txt"/>
        <span id="tspan"></span>
    </td>
  </tr>
  <tr>
    <td>新闻分类：</td>
    <td><select class="s1" name='c_id'>
      <?php
      //准备sql语句
      $sql1="select * from category where c_status=1";
      //执行sql语句
      $result1=mysqli_query($link,$sql1);
      //处理结果集
      if($result1){
        while($row1=mysqli_fetch_assoc($result1)){
          $select=$row1['c_id']==$row['c_id']?'selected':'';
          echo "<option {$select}  value='{$row1["c_id"]}'>{$row1['c_name']}</option>";
        }
      }
      ?>
	</select>
	</td>
  </tr>
  <tr>
    <td>新闻内容：</td>
    <td>
      <script id="editor" name="n_content" type="text/plain" style="width:400px;height:300px;"><?=$row['n_content']?></script>
    </td>
  </tr>
    <tr>
    <td>添加人：</td>
    <td><input   type="text"  name="n_man" value="<?=$row['n_man']?>"  class="txt"/>
        <span id="mspan"></span>
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

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');


    
    function getLocalData () {
        alert(UE.getEditor('editor').execCommand( "getlocaldata" ));
    }

    function clearLocalData () {
        UE.getEditor('editor').execCommand( "clearlocaldata" );
        alert("已清空草稿箱")
    }

    var n_title=document.getElementsByName('n_title')[0];
    var tspan=document.getElementById('tspan');
    var sub=document.getElementsByClassName('sub')[0];
    var flag=false;

    n_title.onblur=function(){
      n_title_empty();
    };

    function n_title_empty(){
      if(n_title.value==''){
        tspan.innerHTML="<i class='error'>新闻标题不能为空</i>";
        return false;
      }else{
        n_title_unique();
        return true;
      }
    };

    function n_title_unique(){
      var xhr=new XMLHttpRequest();
      var content=n_title.value;
      xhr.onreadystatechange=function(){
        if(xhr.readyState==4 && xhr.status==200){
          var res=xhr.responseText;
          // alert(res);
          if(res==1){
            tspan.innerHTML="<i class='error'>新闻标题已被占用</i>";
            flag=false;
          }else{
            tspan.innerHTML="<i class='success'>新闻标题可用</i>";
            flag=true;
          }
        }
      }

      xhr.open('get','./news_action.php?action=ajax&n_title='+content);

      xhr.send();
    };

    var n_man=document.getElementsByName('n_man')[0];
    var mspan=document.getElementById('mspan');

    n_man.onblur=function(){
      n_man_empty();
    };

    function n_man_empty(){
      if(n_man.value==''){
        mspan.innerHTML="<i class='error'>添加人不能为空</i>";
        return false;
      }else{
        mspan.innerHTML="<i class='success'>添加人可用</i>";
        return true;
      }
    };

    sub.onclick=function(){
      var res1=n_title_empty();
      var res2=n_man_empty()
      return flag && res1 && res2;
    };
</script>
</body>
</html>
<?php

}
?>
