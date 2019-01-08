<?php
$con = mysql_connect("localhost", "test", "test");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db_selected = mysql_select_db("test",$con);

$id = isset($_GET['number']) ? $_GET['number'] : 0;
mysql_query("set names 'utf8'")or die('字符集设置错误');
$sql = "SELECT * from Prex_topic_new where number=".$id."";
$paper = mysql_query($sql);
$rs = mysql_fetch_array($paper);
$imgcode = '<img src="'.$rs['picture'].'" width="450px">';
session_start();
$_SESSION['newsID'] = $id;
$sql1 = "SELECT * FROM PreX_news_user WHERE newsID = ".$id." order by no DESC limit 10";
$sqlcount1 = mysql_query($sql1);
$row1 = mysql_fetch_array($sqlcount1);
$i = 0;
do{
	$rows1[$i] = $row1;
	$i++;
}
while($row1 = mysql_fetch_array($sqlcount1));
?>

<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $rs['title'] ?></title>
		<script src="js/jquery-3.2.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/css1.css">
		<link rel="stylesheet" type="text/css" href="css/css2.css">
	</head>
	<body>
		<div class="header">
				<ul class="header-list">
					<li style="margin-top:-30px">
						<img src="img/logo.png" width="180px">
					</li>
					<li>
						<a href="index.html">首页</a>
					</li>								
					<li>
						<a href="guess.php">竞猜</a>
					</li>
					<li>
						<a href="#">话题</a>						
					</li>
					<li>
						<a href="mine.php">我的PreX</a>						
					</li>					
				</ul>				
		</div>
		<div class="main-content" style="height: auto">
			<div class="PreXtopMainbar">
				<div style="width:100%;height:160px;background: url('img/titlebg2.jpeg');background-position: center;">
				</div>
				<div class="header_index">话题
				</div>
				<div class="header_content">
					<p>在这里你可以畅所欲言。</p>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="column_L">
				<div style="margin-top: 38px; margin-bottom: 38px;">
						<div class="title-hori title-box" style="width: 690px">
							<img src="img/icon/资讯.png">
						<a href="news.html">资讯</a>
						</div>
				</div>
					<div class="news_box">
						<div class="news_box_title">
							<p style="font-size: 18px;"><?php echo $rs['title'] ?></p>
						</div>
						<div class="news_box_authorAndTime">
							<span>作者：</span><span><?php echo $rs['writer'] ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span>时间：</span><span><?php echo $rs['date'] ?></span>
						</div>
						<hr style="width:90% ">
						<div class="news_box_content" style="font-size: 15px">
							<div style="text-align: center">
							<?php echo $imgcode; ?>
							</div>
							<?php echo $rs['words']?>
						</div>
					</div>
			</div>
			<div class="column_R">
				<div class="title-hori title-box" style="width: 330px; margin-bottom: 25px; margin-top: 38px">
					<img src="img/icon/排名.png">
					排名
				</div>
				<div class="reply_box">
					<div class="reply_box_one">
						<form action="review.php" method="post" class="reply_box_form">
							<textarea name="content"></textarea>
							<input type="submit" value="提交" class="reply_box_form_submit" accept="middle">
						</form>						
					</div>
					<?php foreach($rows1 as $key=>$val) {  ?>
					<div class="reply_box_one">
						<div class="reply_box_one_inf">
							<span><?php echo $val['user']; ?></span><span style="float: right"><?php echo $val['time']; ?></span><span style="margin-left:5px"><?php echo $val['no']; ?></span><span>楼</span>
						</div>
						<hr style="width: 90%">
						<div class="reply_box_one_con">
							<?php echo $val['content']; ?>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="footer">
				<ul class="header-list">
					<li>
						<a href="document/46.docx">46号文件</a>
					</li>
					<li>
						<a href="faq.html">常见FAQ</a>						
					</li>
					<li>
						<a href="aboutus.html">关于我们</a>						
					</li>
					<li>
						<a href="advice.html">投诉建议</a>						
					</li>
					<li>
						<a href="jobs.html">招贤纳士</a>						
					</li>										
				</ul>
			<div class="container">
				<div class="footer-bottom">
					<p>
					Copyright&copy <span><a href="index.html">PreXgame.com</a></span> All rights reserved.
					</p>
				</div>
			</div>			
		</div>
	</body>
</html>