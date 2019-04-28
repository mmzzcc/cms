<?php
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加新闻</title>
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
<h2>添加新闻&nbsp;
    <a href='./news_list.php'>新闻列表</a>
</h2>
<form name="login"  action="news_action.php?action=ins" method="post">
<table border="0"    cellspacing="10" cellpadding="0">
  <tr>
    <td>新闻标题：</td>
    <td><input   type="text" name="n_title" class="txt"/>
      <span id='tspan'></span>
    </td>
  </tr>
  <tr>
    <td>新闻分类：</td>
    <td><select class="s1" name='c_id'>
      <?php
      //准备sql语句
      $sql="select * from category where c_status=1";
      //执行sql语句
      $result=mysqli_query($link,$sql);
      //处理结果集
      if($result){
        while($row=mysqli_fetch_assoc($result)){
          echo "<option value='{$row["c_id"]}'>{$row['c_name']}</option>";
        }
      }
      ?>
	</select>
	</td>
  </tr>
  <tr>
    <td>新闻内容：</td>
    <td>
      <script id="editor" name="n_content" type="text/plain" style="width:400px;height:300px;"></script>
      <span id="cspan"></span>
    </td>
  </tr>
    <tr>
    <td>添加人：</td>
    <td><input   type="text"  name="n_man"  class="txt"/>
        <span id="mspan"></span>
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
    var sub=document.getElementsByClassName('sub')[0];
    var tspan=document.getElementById('tspan');
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

    var n_content=document.getElementsByName('n_content')[0];
    //console.log(n_content);
    var cspan=document.getElementById('cspan');

    n_content.onblur=function(){
      n_content_empty();
    };

    function n_content_empty(){

      if(n_content==''){
        cspan.innerHTML="<i class='error'>新闻内容不能为空</i>";
        return false;
      }else{
        cspan.innerHTML="<i class='success'>新闻内容可用</i>";
        return true;
      }
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
        n_man_test();
        return true;
      }
    };

    function n_man_test(){
      var str4=n_man.value;
      var result4=/^[\u4e00-\u9fa5]{2,17}$/;
      if(result4.test(str4)){
        mspan.innerHTML="<i class='success'>添加人可用</i>";
        return true;
      }else{
        mspan.innerHTML="<i class='error'>添加人格式不正确</i>";
        return false;
      }
    }

    sub.onclick=function(){
      res1=n_title_empty();
      res2=n_content_empty();
      res3=n_man_empty();
      return flag && res1 && res2 && res3;
    };
</script>
</body>
</html>
