<?php
$con = mysql_connect("localhost", "test", "test");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db_selected = mysql_select_db("test",$con);
mysql_query("set names 'utf8'");

	session_start();
	$user = $_SESSION['user'];
	$sql1 = "SELECT * FROM PreX_news_user WHERE newsID = ".$_SESSION['newsID']."";
	$sqlcount1 = mysql_query($sql1);
	$num = mysql_num_rows($sqlcount1);
	$new_no = $num + 1;
	$sql2 = "INSERT INTO PreX_news_user (user, newsID, content, time, no) VALUES ('$user', $_SESSION[newsID], '$_POST[content]', now(), $new_no)";
	$sqlcount2 = mysql_query($sql2) or die("输入失败2"); 
	header('Location: http://202.114.71.171/~2015302580195/PreX/news.php?number='.$_SESSION[newsID].''); 
?>