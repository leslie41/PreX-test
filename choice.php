<?php
$con = mysql_connect("localhost", "test", "test");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
$db_selected = mysql_select_db("test",$con);

	session_start();
	$raceNumber = $_SESSION["raceNumber"];
	$user = $_SESSION["user"];
	$sql1 = "SELECT id FROM PreX_user WHERE username = '$_SESSION[user]'";
	$sqlcount1 = mysql_query($sql1)  or die ("查询失败");
	$row1 = mysql_fetch_array($sqlcount1); 
	$sql2 = "SELECT * FROM PreX_mine1 WHERE id = '$row1[0]'";
	$sqlcount2 = mysql_query($sql2) or die ("查询失败");
	$row2 = mysql_fetch_array($sqlcount2); 
    $winner = $_POST["winner"];  
    $u_points = $_POST["u_point"];
    echo $u_points;
    echo $row2['points'];
    if($u_points > $row2['points']) 	
    {
    	echo "输入的积分不能大于你当前的积分。";
    }
    else
    {
    	$sql3 = "INSERT INTO PreX_cookie VALUES ($row2[ID], $raceNumber, $winner, $u_points)";
    	$sqlcount3 = mysql_query($sql3) or die ("您已竞猜过本场比赛");//生成新的竞猜记录
    	$sql4 = "SELECT points FROM PreX_mine1 WHERE id = '$row1[0]'";
    	$sqlcount4 = mysql_query($sql4) or die ("输入失败4");//给该用户扣除使用的积分
    	$row4 = mysql_fetch_array($sqlcount4);
    	$u2_points = $row4[0] - $u_points + 100; //用户竞猜后的未结算的积分
    	$sql5 = "UPDATE PreX_mine1 set points='$u2_points' where ID='$row1[0]'";
    	$sqlcount5 = mysql_query($sql5) or die ("输入失败5");//输入用户现在的积分
    	if($winner == 1)
    	{
    		$sql6 = "SELECT guest_p FROM PreX_game WHERE num = $raceNumber ";
    		$sqlcount6 = mysql_query($sql6) or die ("输入失败6");
    		$row6 = mysql_fetch_array($sqlcount6);
    		$u3_points = $row6[0] + $u_points;
    		$sql7 = "UPDATE PreX_game set guest_p='$u3_points' where num = $raceNumber ";
    		$sqlcount7 = mysql_query($sql7) or die ("输入失败7_1");//选择客队，给客队的积分池增加用户下注的积分；
            $sql8 = "SELECT guest_n FROM PreX_game where num = $raceNumber";
            $sqlcount8 = mysql_query($sql8) or die ("输入失败8_1");
            $row8 = mysql_fetch_array($sqlcount8);//获得客队的人数
            $new_nop = $row8[0] + 1;
            $sql9 = "UPDATE PreX_game set guest_n = '$new_nop' where num = $raceNumber ";//
            $sqlcount9 = mysql_query($sql9) or die ("输入失败9_1");
		}
		else
    	{
    		$sql6 = "SELECT home_p FROM PreX_game WHERE num = $raceNumber ";
    		$sqlcount6 = mysql_query($sql6) or die ("输入失败6");
    		$row6 = mysql_fetch_array($sqlcount6);
    		$u3_points = $row6[0] + $u_points;
    		$sql7 = "UPDATE PreX_game set home_p='$u3_points' where num = $raceNumber ";
    		$sqlcount7 = mysql_query($sql7) or die ("输入失败7_2");//选择主队，给主队的积分池增加用户下注的积分；
            $sql8 = "SELECT home_n FROM PreX_game where num = $raceNumber";
            $sqlcount8 = mysql_query($sql8) or die ("输入失败8_2");
            $row8 = mysql_fetch_array($sqlcount8);
            $new_nop = $row8[0] + 1;
            $sql9 = "UPDATE PreX_game set home_n = '$new_nop' where num = $raceNumber ";
            $sqlcount9 = mysql_query($sql9) or die ("输入失败9_2");
		}
        $sqlcount10 = mysql_query("UPDATE PreX_mine1 set gamenumber = gamenumber + 1 WHERE id = '$row1[0]'") or die ("输入失败10");
    }

?>