<?php 
$link = mysqli_connect("localhost","test","test","test") or die ("错误：连接数据库失败");   //一次为：服务器，用户名，密码，库名
mysqli_query($link,"set names 'utf8'"); //输出的编码方式，这句一定要有。
//连接表:
session_start();
if($_SESSION["user"]==''){
	header('Location: http://202.114.71.171/~2015g7/PreX/mine.html');
}
else{
$user = $_SESSION["user"];
$sql0="CREATE VIEW history_view (username, articleID, articleTitle)
AS SELECT PreX_history.username, PreX_history.number, Prex_topic_new.title
	FROM PreX_history, Prex_topic_new
    WHERE PreX_history.number = Prex_topic_new.number AND PreX_history.username = '$user';";
$sqlcount0 = mysqli_query($link,$sql0) or die ("查询失败0");  //将其输出.
$sql = "SELECT * FROM history_view order by articleID desc limit 15";
$sqlcount = mysqli_query($link,$sql) or die ("查询失败");
$row = mysqli_fetch_array($sqlcount); 
$i = 0;
do{
	$rows[$i] = $row;
	$i++;
}
while($row = mysqli_fetch_array($sqlcount));
mysqli_query($link,"DROP VIEW history_view");//以上把用户的浏览记录提取出来
$sql1 = "SELECT id FROM PreX_user WHERE username = '$_SESSION[user]'";
$sqlcount1 = mysqli_query($link,$sql1)  or die ("查询失败");
$row1 = mysqli_fetch_array($sqlcount1); 
$sql2 = "SELECT * FROM PreX_mine1 WHERE id = '$row1[0]'";
$sqlcount2 = mysqli_query($link,$sql2) or die ("查询失败");
$row2 = mysqli_fetch_array($sqlcount2); //以上把用户的个人信息提取出来
//以下为竞猜记录显示
$sql6 = "SELECT id FROM PreX_user WHERE username = '$_SESSION[user]'";
$sqlcount6 = mysqli_query($link,$sql6) or die ("查询失败");
$row6 = mysqli_fetch_array($sqlcount6); 
//获得用户的id
$sqlcount3_2 = mysqli_query($link,"SELECT id FROM PreX_user WHERE username = '$_SESSION[user]'") or die("查询用户id失败");
$row3_2 = mysqli_fetch_array($sqlcount3_2);
$sql4="CREATE view urlB (url, team)
AS SELECT PreX_teams.url, PreX_teams.team
FROM PreX_teams;";
$sql4_2="CREATE view history (no, guest, home, guest1, home1)
AS SELECT PreX_cookie.raceNumber, PreX_teams.url, urlB.url, PreX_game.point_g, PreX_game.point_h
From PreX_cookie, PreX_teams, urlB, PreX_game
Where PreX_cookie.userID = '$row6[0]' and PreX_cookie.raceNumber = PreX_game.num and PreX_teams.team = PreX_game.guest and urlB.team =PreX_game.home ;";//建立当前用户历史竞猜记录的临时表，分别显示比赛场次，客队
$sqlcount4 = mysqli_query($link,$sql4) or die ("查询失败4");
$sqlcount4_2 = mysqli_query($link,$sql4_2) or die ("查询失败4_2");
$sql5="SELECT * FROM history limit 5";
$sqlcount5 = mysqli_query($link,$sql5) or die ("查询失败5");
$row5 = mysqli_fetch_array($sqlcount5); 
$i = 0;
do{
	$rows5[$i] = $row5;
	$i++;
}
while($row5 = mysqli_fetch_array($sqlcount5));
mysqli_query($link,"DROP view history");
mysqli_query($link,"DROP view urlB");//以上竞猜记录；
mysqli_close($link);
}
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>我的PreX</title>
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
						<a href="index.html" style="margin-left:-10px">首页</a>
					</li>								
					<li>
						<a href="guess.php">竞猜</a>
					</li>
					<li>
						<a href="topic.html">话题</a>						
					</li>
					<li>
						<a href="#">我的PreX</a>						
					</li>					
				</ul>	
		</div>
		<div class="main-content">
			<div class="PreXtopMainbar">
				<div style="width:100%;height:160px;background: url('img/titlebg2.jpeg');background-position: center;">
				</div>
				<div class="header_index">PreX
				</div>
				<div class="header_content">
					<p>在这里了解当前赛季所有比赛的资讯。</p>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="column_L">
				<div style="margin-top: 38px; margin-bottom: 38px;">
						<div class="title-hori title-box" style="width: 690px">
							<img src="img/icon/资讯.png">
						我的PreX
						</div>
				</div>
					<div class="mine_main">
						<div class="box_title" style="width: 56px; margin-top: -37px">
							基本信息
						</div>
						<div class="guess_mine_pic" style="margin-left: 50px; margin-top: 60px">
							<?php $imgcode = '<img src="'.$row2['picture'].'" style="width: 80px; border-radius: 20px">';
							echo $imgcode; ?>
						</div>
						<div class="guess_mine_inf" style="margin-top: 60px">
							ID：<span><?php echo $row2["ID"]; ?></span>
							<br>昵称：<span><?php echo $_SESSION["user"]; ?></span>
							<br>位次：<span><?php echo $row2["ranking"]; ?></span>
						</div>
						<div class="guess_mine_inf2" style="margin-top: 40px">
							场次
							<br>
							<span style="color:green"><?php echo $row2["gamenumber"]; ?></span>／<span>1230</span>
						</div>
						<div class="guess_mine_inf3" style="margin-top: 40px">
							正负值
							<br>
							<span style="color:green"><?php echo $row2["outcome"]; ?></span>
						</div>
						<div class="guess_mine_inf4" style="margin-top: 40px">
							积分
							<br>
							<span><?php echo $row2["points"]; ?></span>
						</div>
						<div class="guess_mine_inf2">
							浏览
							<br>
							<span style="color:green"><?php echo $row2["scan"]; ?></span>／<span>189</span>
						</div>
						<div class="guess_mine_inf3">
							收藏
							<br>
							<span style="color:green"><?php echo $row2["like"]; ?></span>
						</div>
						<div class="guess_mine_inf4">
							回复
							<br>
							<span><?php echo $row2["message"]; ?></span>
						</div>			
					</div>
					<div class="mine_main" style="margin-top: 40px">
						<div class="box_title" style="width: 56px; margin-top: -37px">
							浏览历史
						</div>
						<div>
							<ul class="mine_history">
								<?php foreach($rows as $val)  {?>
								<li><a href="news.php?number='<?php echo $val['articleID']?>'" target="_blank"><?php echo $val['articleTitle']; ?></a></li>
								<?php } ?>
							</ul>
						</div>
					</div>
					<div class="mine_main" style="margin-top: 40px">
						<div class="box_title" style="width: 56px; margin-top: -37px;">
							竞猜记录
						</div>
						<?php foreach ($rows5 as $key => $val) { 
						$imgcode_guest = '<img src="'.$val['guest'].'" style="width: 30px">';
						$imgcode_home = '<img src="'.$val['home'].'" style="width: 30px">';
						?>
						<div class="reply_box_one" style="height: 50px; float: left; margin-left: 14px; margin-right: 14px;">
							<div class="guess_mine_text" style="width: 70px; margin-left: 20px">
								<?php echo $val['no'] ?>
							</div>
							<div class="guess_mine_team">
								<?php echo $imgcode_guest ?>
							</div>
							<div class="guess_mine_text">
								<span><?php echo $val['guest1'] ?></span>
								<span>:</span>
								<span><?php echo $val['home1'] ?></span>
							</div>
							<div class="guess_mine_team2">
								<?php echo $imgcode_home ?>
							</div>
							<div class="guess_mine_text">
								121
							</div>
							<div class="guess_mine_text">
								+39
							</div>
						</div>
						<?php } ?>
						</div>				
			</div>
			<div class="column_R">
				<div class="title-hori title-box" style="width: 330px; margin-bottom: 25px; margin-top: 38px">
					<img src="img/icon/排名.png">
					荣誉室
				</div>
				<div class="reply_box">
					<div class="reply_box_one" style="height: 100px">
						<div class="reply_box_one_cuppicture" ><img src="img/cup/trophy1.png" style="width:60px"></div>
						<div class="reply_box_one_cupname" > 百步穿杨</div>
						<div class="reply_box_one_cuptime" > 17.1.1获得</div>
						<div class="reply_box_one_cupdescribe" > 在同一赛季中连续猜中5场比赛</div>
					</div>
					<div class="reply_box_one" style="height: 100px">
						<div class="reply_box_one_cuppicture" ><img src="img/cup/trophy2.png" style="width:60px"></div>
						<div class="reply_box_one_cupname" > 大富翁</div>
						<div class="reply_box_one_cuptime" > 16.10.23获得</div>
						<div class="reply_box_one_cupdescribe" > 用户历史所得积分最高超过10000点</div>
					</div>
					<div class="reply_box_one" style="height: 100px">
						<div class="reply_box_one_cuppicture" ><img src="img/cup/trophy3.png" style="width:60px"></div>
						<div class="reply_box_one_cupname" > 天选之人</div>
						<div class="reply_box_one_cuptime" > 16.2.27获得</div>
						<div class="reply_box_one_cupdescribe" >历史获胜比赛场数超过100场 </div>
					</div>
					<div class="reply_box_one" style="height: 100px">
						<div class="reply_box_one_cuppicture" ><img src="img/cup/trophy4.png" style="width:60px"></div>
						<div class="reply_box_one_cupname" > 悬崖勒马</div>
						<div class="reply_box_one_cuptime" > 16.5.2获得</div>
						<div class="reply_box_one_cupdescribe" > 有一场竞猜的赔率超过1:10</div>
					</div>
					<div class="reply_box_one" style="height: 100px">
						<div class="reply_box_one_cuppicture" ><img src="img/cup/trophy5.png" style="width:60px"></div>
						<div class="reply_box_one_cupname" > 呼朋引伴</div>
						<div class="reply_box_one_cuptime" > 16.3.19获得</div>
						<div class="reply_box_one_cupdescribe" > 老用户成功邀请超过15名新用户参与竞猜</div>
					</div>
					<div class="reply_box_one" style="height: 100px">
						<div class="reply_box_one_cuppicture" ><img src="img/cup/trophy6.png" style="width:60px"></div>
						<div class="reply_box_one_cupname" > 衰神上身</div>
						<div class="reply_box_one_cuptime" > 17.9.7获得</div>
						<div class="reply_box_one_cupdescribe" > 连续竞猜失败超过10场</div>
					</div>
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