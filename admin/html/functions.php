<?php
/*
	设置跳转函数
		$msg:提示信息
		$url:跳转页面
 */
function abort($msg,$url)
{
	echo "<script>alert('{$msg}');location.href='{$url}';</script>";
}
?>