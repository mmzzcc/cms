<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加分类</title>
<link rel="stylesheet" type="text/css" href="../css/public.css">
<style type="text/css">
	.success{
		color:green;
		font-size:14px;
	}
	.error{
		color:red;
		font-size:14px;
	}
</style>
</head>

<body>
<div  id="main">
<h2>添加分类&nbsp;
	<a href='./cate_list.php'>分类列表</a>
</h2>
<form name="login"  action="cate_action.php?action=ins" method="post">
	<table border="0"    cellspacing="10" cellpadding="0">
		  <tr>
			<td>分类名称：</td>
			<td><input   type="text" name="c_name" class="txt"/>
				<span id='n_span'></span>
			</td>
		  </tr>
			<tr>
			<td>添加人：</td>
			<td><input   type="text"  name="c_man"  class="txt" />
				<span id='m_span'></span>
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
	var c_name=document.getElementsByName('c_name')[0];
	var n_span=document.getElementById('n_span');
	var sub=document.getElementsByClassName('sub')[0];
	var flag=false;

	c_name.onblur=function(){
		c_name_empty();
	};

	function c_name_empty(){
		var a=c_name.value;
		if(a==''){
			n_span.innerHTML="<i class='error'>分类名不能为空</i>";
			return false;
		}else{
			c_name_unique();
			return true;
		}
	};

	function c_name_unique(){
		var content=c_name.value;
		var xhr=new XMLHttpRequest();
		xhr.onreadystatechange=function(){

			if(xhr.readyState==4 && xhr.status==200){
				var res=xhr.responseText;
				if(res==1){
					n_span.innerHTML="<i class='error'>分类名以被占用</i>";
					flag=false;
				}else{
					n_span.innerHTML="<i class='success'>分类名可用</i>";
					flag=true;
				}
				//alert(res);
			}

			
		};

		xhr.open('get','./cate_action.php?action=ajax&c_name='+content);

		xhr.send();
	};

	var c_man=document.getElementsByName('c_man')[0];
	var m_span=document.getElementById('m_span');
	c_man.onblur=function(){
		c_man_empty();
	};

	function c_man_empty(){
		var b=c_man.value;
		if(b==''){
			m_span.innerHTML="<i class='error'>添加人不能为空</i>";
			return false;
		}else{
			m_span.innerHTML="<i class='success'>添加人可用</i>";
			return true;
		}
	};

	sub.onclick=function(){
		res1=c_name_empty();
		res2=c_man_empty();

		return flag && res1 && res2;
	};
</script>
</body>
</html>
