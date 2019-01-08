<?php
 
        $user = $_POST["username"];  
        $psw = $_POST["password"];  
        if($user == "" || $psw == "")  
        {  
            echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";  
        }  
        else  
        {
            echo $user;
            mysql_connect("localhost","test","test");  
            mysql_select_db("test");  
            mysql_query("set names 'utf8'");  
            mysql_query("SELECT COUNT(*) FROM PreX_user");
            $id = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM PreX_user"))[0] + 1;
            $sql = "insert into PreX_user values ('$user','$psw', $id)";  
            mysql_query($sql);  
            echo "注册成功";
            mysql_query("INSERT INTO PreX_mine1 VALUES ($id, '0', 0, 0, 0, 0, 0, 100, 0)");
        }
  
?>  