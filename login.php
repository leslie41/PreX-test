<?php
        $user = $_POST["username"];  
        $psw = $_POST["password"];  
        if($user == "" || $psw == "")  
        {  
            echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";  
        }  
        else  
        {  
            mysql_connect("localhost","test","test");  
            mysql_select_db("test");  
            mysql_query("set names 'gbk'");  
            $sql = "select username, password from PreX_user where username = '$_POST[username]' and password = '$_POST[password]'";  
            $result = mysql_query($sql);  
            $num = mysql_num_rows($result);  
            if($num)  
            {  
                $row = mysql_fetch_array($result);  //将数据以索引方式储存在数组中  
                $url = "mine.php" ;
                header('Location: http://202.114.71.171/~2015g7/PreX/mine.php'); 
                session_start();
                $_SESSION["user"] = $_POST["username"];  
            }  
            else  
            {  
                echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>";  
            }  
        }
?>