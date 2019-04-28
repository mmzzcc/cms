<?php
//引用第一部分
include './header_1.php';
//引用第二部分文件
include './header_2.php';
//链接数据库
$link=mysqli_connect('localhost','root','root','cms');
//设置通信字符集
mysqli_set_charset($link,'utf8');
?>

<div class="news">
	<div class="title"><h3>最新新闻</h3><a href="#">更多&gt;&gt;</a></div>
            <ul>
            <?php
            //准备sql语句
            $sql="select * from news  where n_recycle=1 order by n_time desc limit 10";
            //执行sql语句
            $result=mysqli_query($link,$sql);
            //处理结果集
            if($result){
                $num=0;
                while($row=mysqli_fetch_assoc($result)){
                //显示添加时间
                $n_time=date('Y-m-d H:i:s',$row['n_time']);
                    if($num==5){
                        echo "</ul><ul>";
                    }
                    echo "<li><span>{$n_time}</span>  <a  href='./news_content.php?n_id={$row["n_id"]}'>{$row['n_title']}</a></li>";
                $num++;
                }
            }
            ?>
            </ul>       
</div>

<div class="blank20"></div>

<div class="news">
	<div class="title"><h3>最热新闻</h3><a href="#">更多&gt;&gt;</a></div>
            <ul>
            <?php
            //准备sql语句
            $sql2="select * from news where n_recycle=1 order by n_num desc,n_time desc  limit 10";
            //执行sql语句
            $result2=mysqli_query($link,$sql2);
            //处理结果集
            if($result2){
                $num=0;
                while($row2=mysqli_fetch_assoc($result2)){
                    //显示添加时间
                    $n_time=date('Y-m-d H:i:s',$row2{'n_time'});
                    if($num==5){
                        echo "</ul><ul>";
                    }
                    echo "<li><span>{$n_time}</span>  <a  href='./news_content.php?n_id={$row2["n_id"]}'>{$row2['n_title']}</a></li>";
                $num++;
                }
            }
            ?>
            </ul>       
</div>
<?php
//引用底部文件
include './footer.php';
?>
