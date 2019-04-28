<?php
//引用第一部分
include './header_1.php';
//引用第二部分文件
include './header_2.php';
?>

<div class="news">
	<div class="title"><h3><?=$c_name ?></h3><a href="#">更多&gt;&gt;</a></div>
            <ul class="width">
            <?php
            //准备sql语句
            $nsql="select * from news where c_id={$_GET['c_id']} order by n_time desc limit 5";
            //执行sql语句
            $nresult=mysqli_query($link,$nsql);
            //处理结果集
            if($nresult){
                while($nrow=mysqli_fetch_assoc($nresult)){
                //显示添加时间
                $n_time=date('Y-m-d H:i:s',$nrow['n_time']);
                    echo "<li><span>{$n_time}</span>  <a  href='./news_content.php?n_id={$nrow["n_id"]}'>{$nrow['n_title']}</a></li>";
                }
            }
            ?>
        </ul>
</div>

<?php
//引用底部文件
include './footer.php';
?>

