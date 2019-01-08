<?php
$con = mysql_connect("localhost", "test", "test");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db_selected = mysql_select_db("test",$con);
error_reporting(E_ERROR); 
ini_set("display_errors","Off");//取消警告
$id = isset($_GET['num']) ? $_GET['num'] : 0;//获取比赛的编号
mysql_query("set names 'utf8'")or die('字符集设置错误');//设置字符
$sql = "SELECT * FROM PreX_game WHERE num = ".$id."";
$paper = mysql_query($sql);
$rs = mysql_fetch_array($paper);//把比赛所有数据提取出来
$sql1 = "SELECT url FROM PreX_teams, PreX_game WHERE PreX_teams.team = PreX_game.home AND PreX_game.num = ".$id."";
$sql2 = "SELECT url FROM PreX_teams, PreX_game WHERE PreX_teams.team = PreX_game.guest AND PreX_game.num = ".$id."";
$sqlcount1 = mysql_query($sql1) or die ("查询失败1");
$sqlcount2 = mysql_query($sql2) or die ("查询失败2");
$home = mysql_fetch_array($sqlcount1);
$guest = mysql_fetch_array($sqlcount2);
$imgcode_home = '<img src="'.$home['url'].'" width="100px">';
$imgcode_guest = '<img src="'.$guest['url'].'" width="100px">';//以上是为了获得球队的logo
$odds = $rs['home_p'] / $rs['guest_p'];
$rate_g = $rs['guest_n'] / ($rs['guest_n'] + $rs['home_n']);
$rate_h = $rs['home_n'] / ($rs['guest_n'] + $rs['home_n']);
$checkbox_g = '<input type="checkbox" name="会获胜的球队" value="g"></input>';
$checkbox_h = '<img src="'.$guest['url'].'" width="100px">';//以上是左边的数据显示
session_start();
$_SESSION["raceNumber"] = $id;
//
$sql6 = "SELECT id FROM PreX_user WHERE username = '$_SESSION[user]'";
$sqlcount6 = mysql_query($sql6) or die ("查询失败");
$row6 = mysql_fetch_array($sqlcount6); 
//获得用户的id
$sqlcount3_2 = mysql_query("SELECT id FROM PreX_user WHERE username = '$_SESSION[user]'") or die("查询用户id失败");
$row3_2 = mysql_fetch_array($sqlcount3_2);
$sql4="CREATE view urlB (url, team)
AS SELECT PreX_teams.url, PreX_teams.team
FROM PreX_teams;";
$sql4_2="CREATE view history (no, guest, home, guest1, home1)
AS SELECT PreX_cookie.raceNumber, PreX_teams.url, urlB.url, PreX_game.point_g, PreX_game.point_h
From PreX_cookie, PreX_teams, urlB, PreX_game
Where PreX_cookie.userID = '$row6[0]' and PreX_cookie.raceNumber = PreX_game.num and PreX_teams.team = PreX_game.guest and urlB.team =PreX_game.home ;";//建立当前用户历史竞猜记录的临时表，分别显示比赛场次，客队
$sqlcount4 = mysql_query($sql4) or die ("查询失败4");
$sqlcount4_2 = mysql_query($sql4_2) or die ("查询失败4_2");
$sql5="SELECT * FROM history";
$sqlcount5 = mysql_query($sql5) or die ("查询失败5");
$row5 = mysql_fetch_array($sqlcount5); 
$i = 0;
do{
	$rows5[$i] = $row5;
	$i++;
}
while($row5 = mysql_fetch_array($sqlcount5));
mysql_query("DROP view history");
mysql_query("DROP view urlB");//以上是把页面左边的竞猜数据的处理
//以下是为了把用户信息显示出来
$sql7 = "SELECT * FROM PreX_mine1 WHERE id = '$row6[0]'";
$sqlcount7 = mysql_query($sql7) or die ("查询失败");
$row7 = mysql_fetch_array($sqlcount7); 
//以上把用户的个人信息提取出来
$sql8 = "CREATE view guess (guess, result, gp, hp, points)
AS SELECT PreX_cookie.guess, PreX_game.result, PreX_game.guest_p, PreX_game.home_p, PreX_cookie.points
FROM PreX_cookie, PreX_game
WHERE PreX_cookie.userID = '$row6[0]' and PreX_cookie.raceNumber = PreX_game.num";
$sqlcount8_0 = mysql_query($sql8) or die ("查询失败8_0");
$sqlcount8 = mysql_query("SELECT * FROM guess") or die ("查询失败8");
$row8 = mysql_fetch_array($sqlcount8); 
mysql_query("drop view guess");//删除正负值计算临时表
$n = 0;
do{
	$rows8[$n] = $row8;
	$n++;
}
while($row8 = mysql_fetch_array($sqlcount8)); 
//以上提取计算正负值的数据
$pan = 0;
foreach ($rows8 as $key => $val) {
	if($val['guess'] == 1 && $val['result'] == 1)
	{
		$pan = $pan + round($val['hp'] * $val['points'] / $val['gp'], 0);
	}
	else if($val['guess'] == 0 && $val['result'] == 0)
	{
		$pan = $pan + round($val['gp'] * $val['points'] / $val['hp'], 0);
	}
	else if($val['result'] == 2)
	{
		$pan = $pan;
	}
	else{
		$pan = $pan - $val['points'];
	}
}
//计算正负值,但是无法暂时无法在历史记录中把正负值显示出来
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>PreX赛事竞猜官方网站</title>
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
						<a href="mine.php">我的PreX</a>						
					</li>					
				</ul>
		</div>
		<div class="main-content">
			<div class="PreXtopMainbar">
				<div style="width:100%;height:160px;background: url('img/titlebg2.jpeg');background-position: center;">
				</div>
				<div class="header_index">竞猜
				</div>
				<div class="header_content">
					<p>竞猜赛事，获取积分，通过正负值反映你对比赛的了解。</p>
				</div>
			</div>
		</div>
		<div class="container" style="height: 1000px">
			<div class="column_L">
				<div style="margin-top: 38px; margin-bottom: 28px;">
					<div class="title-hori title-box" style="width: 690px">
						<img src="img/icon/资讯.png">
					<a href="news.html">资讯</a>
					</div>
				</div>
				<div class="guess_box_4">
					<div class="guess_box_4_team1"><?php echo $imgcode_guest; ?></div>
					<div class="guess_box_4_name1"><?php echo $rs['guest']; ?></div>
					<div class="guess_box_4_team2"><?php echo $imgcode_home; ?></div>
					<div class="guess_box_4_name2"><?php echo $rs['home']; ?></div>
					<div class="guess_box_4_vs">VS<br><br><span>积分比 1:</span><span><?php echo round($odds,2) ?></span></div>
					<div class="guess_box_4_nameoftherace"><span>No.</span><?php echo $rs['num']; ?></div>
					<div class="guess_box_4_numbers1up"><span>积分:</span><?php echo $rs['guest_p']; ?></div>
					<div class="guess_box_4_numbers1down"><span>人数:</span><?php echo $rs['guest_n']; echo "(".round($rate_g*100,0)."%)"; ?></div>
					<div class="guess_box_4_numbers2up"><span>积分:</span><?php echo $rs['home_p'] ?></div>
					<div class="guess_box_4_numbers2down"><span>人数:</span><?php echo $rs['home_n']; echo "(".round($rate_h*100,0)."%)"; ?></div>
					<div class="guess_box_4_guessbutton">
						<form action="choice.php" method="post">
							<input type="radio" name="winner" value="1"><?php echo $rs['guest'] ?></input>
							<input type="radio" name="winner" value="0"><?php echo $rs['home'] ?></input>
							<input name="u_point" id="u_point" type="text" onkeypress="return event.keyCode>=48&&event.keyCode<=57" ng-pattern="/[^a-zA-Z]/" /></input>
							<br>
							<input type="submit" value="提交"></input>
						</form>
					</div>
				</div>
				<div class="guess_box_3">	
					<div class="guess_box_3_history1">
						<div class="guess_box_3_history1_name"></div>
						<div class="guess_box_3_history1_picture"></div>
						<div class="guess_box_3_history1_time"></div>
						<div class="guess_box_3_history1_points"></div>
						<div class="guess_box_3_history1_words"></div>
					</div>
				</div>
			</div>
			<div class="column_R">
					<div style="margin-top: 38px; margin-bottom: 38px;">
						<div class="title-hori title-box" style="width: 330px; margin-bottom: 25px">
							<img src="img/icon/排名.png">
						个人竞猜信息
						</div>
					</div>
			<div class="reply_box">
					<div class="reply_box_one"; style="height:200px">
						<div class="guess_mine_pic">
							<?php $imgcode = '<img src="'.$row7['picture'].'" style="width: 80px; border-radius: 20px">';
							echo $imgcode; ?>
						</div>
						<div class="guess_mine_inf">
							ID：<span><?php echo $row7["ID"] ?></span>
							<br>昵称：<span><?php echo $_SESSION["user"]; ?></span>
							<br>位次：<span><?php echo $row7["ranking"]; ?></span>
						</div>
						<div class="guess_mine_inf2">
							场次
							<br>
							<span style="color:green"><?php echo $row7["gamenumber"]; ?></span>／<span>1230</span>
						</div>
						<div class="guess_mine_inf3">
							正负值
							<br>
							<span style="color:green"><?php echo $pan; ?></span>
						</div>
						<div class="guess_mine_inf4">
							积分
							<br>
							<span><?php echo $row7["points"]; ?></span>
						</div>															
					</div>
					<div style="height:20px">
						<div class="box_title" style="width: 28px; margin-left: 46px; float: left">
							场次
						</div>
						<div class="box_title" style="width: 56px; margin-left: 58px; float: left">
							比赛结果
						</div>
						<div class="box_title" style="width: 28px; margin-left: 38px; float: left">
							积分
						</div>
						<div class="box_title" style="width: 42px; margin-left: 16px; float: left">
							正负值
						</div>
					</div>
					<?php foreach ($rows5 as $key => $val) { 
						$imgcode_guest = '<img src="'.$val['guest'].'" style="width: 30px">';
						$imgcode_home = '<img src="'.$val['home'].'" style="width: 30px">';
						?>
					<div class="reply_box_one" style="height: 50px">
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