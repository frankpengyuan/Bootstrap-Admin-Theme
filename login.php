<!DOCTYPE html>
<?php
//插入连接数据库的相干信息
//开启一个会话
session_start();
$error_msg = "";
//若是用户未登录，即未设置$_SESSION["user_id"]时，履行以下代码
$dbc = mysqli_connect("localhost", "root", "Incoming29", "acweb_db");
$home_url = "index.php";
if(!isset($_SESSION["user_id"])){
    if(isset($_POST["submit"])){//用户提交登录表单时履行如下代码
      if (strcasecmp($_POST["check"],$_SESSION["check"])!=0) {
        $error_msg = "wrong CAPTCHA!";
      } else {
        $user_ID = mysqli_real_escape_string($dbc,trim($_POST["userID"]));
        $user_password = mysqli_real_escape_string($dbc,trim($_POST["password"]));
        if(!empty($user_ID)&&!empty($user_password)){
            //MySql中的SHA()函数用于对字符串进行单向加密
            $query = "SELECT stuID, username FROM All_users WHERE stuID = \"".$user_ID."\" COLLATE utf8_bin AND password = \"".$user_password."\" COLLATE utf8_bin";
            $data = mysqli_query($dbc,$query);
            //用用户名和暗码进行查询，若查到的记录正好为一条，则设置SESSION和COOKIE，同时进行页面重定向
            if(mysqli_num_rows($data)>=1){ // TODO::
                $row = mysqli_fetch_array($data);
                $_SESSION["user_id"]=$row["stuID"];
                $_SESSION["username"]=$row["username"];
                setcookie("user_id",$row["stuID"],time()+(60*60*24*30));
                setcookie("username",$row["username"],time()+(60*60*24*30));
                header("Location: ".$home_url);
            }else{//若查到的记录不合错误，则设置错误信息
                $error_msg = "Sorry, you must enter a valid ID and password to log in.";
            }
        }else{
            $error_msg = "Sorry, you must enter a valid ID and password to log in.";
        }
      }
      $error_msg="<div class=\"alert alert-error\">".$error_msg."</div>";
    }
}else{//若是用户已经登录，则直接跳转到已经登录页面
    header("Location: ".$home_url);
}
mysqli_close($dbc);
?>
<html>
  <head>
    <title>Admin Login</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>

  <body id="login">
    <div class="container">

      <form class="form-signin" method = "post" action="<?php echo $_SERVER["PHP_SELF"];?>">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php
        if(!isset($_SESSION["user_id"])) {
          echo  $error_msg;
        ?>
        <input type="text" id="userID" name="userID" class="input-block-level" placeholder="User ID/Student ID" value="<?php if(!empty($user_ID)) echo $user_ID; ?>" />
        <input type="password" id="password" name="password" class="input-block-level" placeholder="Password">
        <div class=""><input type="text" name="check" placeholder="Captcha"><a href="login.php"><img align="right" src="captcha.php"></img></a></div>
        <button class="btn btn-large btn-primary" type="submit" name="submit">Sign in</button>
      
      </form>
    
    </div> <!-- /container -->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
  <?php
  }
  ?>
</html>