<?php 
$link = mysqli_connect("localhost","test","test","test") or die ("错误：连接数据库失败");   //一次为：服务器，用户名，密码，库名
mysqli_query($link,"set names 'utf8'"); //输出的编码方式，这句一定要有。

//连接表:
error_reporting(E_ERROR); 
ini_set("display_errors","Off");//取消警告
$sql0 = "SELECT * FROM PreX_teams, PreX_game WHERE PreX_teams.team = PreX_game.guest";
$sql1 = "SELECT url AS url_home FROM PreX_teams, PreX_game WHERE PreX_teams.team = PreX_game.home";
mysqli_query($link,$sql0);
$sqlcount0 = mysqli_query($link,$sql0) or die ("查询失败");
$sqlcount1 = mysqli_query($link,$sql1) or die ("查询失败");
$row0 = mysqli_fetch_array($sqlcount0);
$row1 = mysqli_fetch_array($sqlcount1);
$i = 0;
do{
	$rows[$i] = $row0;
	$i++;
}
while($row0 = mysqli_fetch_array($sqlcount0));
$a = 0;
do{
	$rows1[$a] = $row1;
	$a++;
}
while($row1 = mysqli_fetch_array($sqlcount1));
//以下为右边的内容
session_start();
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
$sql5="SELECT * FROM history";
$sqlcount5 = mysqli_query($link,$sql5) or die ("查询失败5");
$row5 = mysqli_fetch_array($sqlcount5); 
$i = 0;
do{
	$rows5[$i] = $row5;
	$i++;
}
while($row5 = mysqli_fetch_array($sqlcount5));
mysqli_query($link,"DROP view history");
mysqli_query($link,"DROP view urlB");//以上是把页面右边的竞猜历史的处理
//以下是为了把用户信息显示出来
$sql7 = "SELECT * FROM PreX_mine1 WHERE id = '$row6[0]'";
$sqlcount7 = mysqli_query($link,$sql7) or die ("查询失败");
$row7 = mysqli_fetch_array($sqlcount7); 
//以上把用户的个人信息提取出来
$sql8 = "CREATE view guess (guess, result, gp, hp, points)
AS SELECT PreX_cookie.guess, PreX_game.result, PreX_game.guest_p, PreX_game.home_p, PreX_cookie.points
FROM PreX_cookie, PreX_game
WHERE PreX_cookie.userID = '$row6[0]' and PreX_cookie.raceNumber = PreX_game.num";
$sqlcount8_0 = mysqli_query($link,$sql8) or die ("查询失败8_0");
$sqlcount8 = mysqli_query($link,"SELECT * FROM guess") or die ("查询失败8");
$row8 = mysqli_fetch_array($sqlcount8); 
mysqli_query($link,"drop view guess");//删除正负值计算临时表
$n = 0;
do{
	$rows8[$n] = $row8;
	$n++;
}
while($row8 = mysqli_fetch_array($sqlcount8)); 
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
						<a href="#">竞猜</a>
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
				<?php foreach($rows as $key=>$val)  {
					$imgcode = '<img src="'.$val['url'].'" width="50px">';
					$imgcode2 = '<img src="'.$rows1[$key][0].'" width="50px">';
					?>
				<div class="guess_box_2">
					<div class="guess_box_no"><?php echo $val['num']; ?></div>
					<div class="guess_box_team3"><?php echo $imgcode; ?></div>
					<div class="guess_box_team4"><?php echo $imgcode2; ?></div>
					<div class="guess_box_name3"><?php echo $val[5]; ?></div>
					<div class="guess_box_name4"><?php echo $val['home']; ?></div>
					<div class="guess_box_vs2">VS</div>
					<div class="guess_box_time2"><?php echo $val['date']; ?><br><?php echo $val['time']; ?></div>
					<div class="guess_box_person_number"> 当前人数 1672</div>
					<div class="guess_box_persent">积分比 1 : <?php echo round(($val['home_p']+1)/($val['guest_p']+1),2); ?></div>
					<div class="guess_box_button2"><a href="guess2.php?num='<?php echo $val['num']?>'" target="_blank">进入竞猜</a></div>
				</div>
				<?php }  mysqli_close($link);  ?>
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