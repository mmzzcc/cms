<?php
//引用第一部分
include './header_1.php';
?>
<div class="article">
<?php
//准备sql语句
$sqln="select * from news where n_id={$_GET['n_id']} and n_recycle=1";
//执行sql语句
$resultn=mysqli_query($link,$sqln);
//处理结果
if($resultn){
	while($rown=mysqli_fetch_assoc($resultn)){
		echo "<h3>{$rown['n_title']}</h3>
				<p>{$rown['n_content']}</p>";
	}
}

echo "<hr/>";
//准备sql语句
$comsql="select * from comment where n_id={$_GET['n_id']}";
//执行sql语句
$comres=mysqli_query($link,$comsql);
//处理结果集
if($comres){
	while($crow=mysqli_fetch_assoc($comres)){
		//显示评论时间
		$t_time=date('Y-m-d H:i:s',$crow['t_time']);
		echo "<p><b>评论人:</b>{$crow['user_id']}</p>
			  <p><b>评论内容:</b>{$crow['t_content']}</p>
			  <p><b>评论时间:</b>{$t_time}</p>
			  <hr/>";
	}
}
?>

</div>
<script type="text/javascript" charset="utf-8" src="../../public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../../public/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="../../public/ueditor/lang/zh-cn/zh-cn.js"></script>

<form action='./docomment.php' method='post'>
<input type="hidden" name="t_id" value="<?=$_GET['n_id']?>" >
<script id="editor" name="t_content" type="text/plain" style="width:400px;height:300px;"></script>

<button>提交评论</button>
</form>
</div>

<?php
//引用底部文件
include './footer.php';

//准备sql语句
$sqlNum="update news set n_num=n_num+1 where n_id={$_GET['n_id']}";
//执行sql语句
mysqli_query($link,$sqlNum);
?>
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
</script>

