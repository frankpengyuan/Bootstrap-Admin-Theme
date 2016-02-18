
<!DOCTYPE html>
<?php
session_start();
//若是会话没有被设置，查看是否设置了cookie
include 'function.php';
include 'component.php';
$dbc = db_connect();
init_web($dbc);
if (isset($_GET['org'])) {
  $org_name = $_GET['org'];
} else {
  $home_url = "index.php";
  header("Location:".$home_url);
}


?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="./assets/ico/favicon.ico">

    <title>UM-SJTU JI Student Affairs</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="./css/offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <?php gen_navbar();?>

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">
        <?php gen_sidebar($org_name, 1);?>
        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>

          <?php
            if (!isset($_GET['memberID'])) {
              $org_info = array();

              $query = "SELECT * FROM Organization WHERE org_name='".$org_name."' COLLATE utf8_bin";
              $result = mysqli_query($dbc,$query);
              if ($result) {
                if($result->num_rows > 0){
                    $org_info = $result->fetch_array();
                    ?>
                    <div class="jumbotron">
                      <h1><?php echo $org_info['org_name']?></h1>
                      <p><?php echo $org_info['short_description']?></p>
                    </div>
                    <?php
                } else {
                  ?>
                    <div class="jumbotron">
                      <h1>Sorry... </h1>
                      <h3>We could not find such organization.</h3>
                    </div>
                  <?php
                  return;
                }
              }
          ?>
          

          <?php
              $mem_info = array();
              $query = "SELECT * FROM Member WHERE belong_org='".$org_name."' COLLATE utf8_bin";
              $result = mysqli_query($dbc,$query);
              if ($result) {
                  while($mem_info = $result->fetch_array())
                  {
                    $new_query = "SELECT * FROM All_users WHERE stuID='".$mem_info['stuID']."' COLLATE utf8_bin";
                      $new_result = mysqli_query($dbc,$new_query);
                      if ($new_result) {
                        $person_info = $new_result->fetch_array();
                        ?>
                        <div class="row">
                  
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <hr>
                            <img src="<?php echo $mem_info['photo_link']?>">
                          </div>

                          <div class="col-xs-12 col-sm-6 col-md-8">
                            <hr>
                              <p><strong><a href="org_member.php?org=<?php echo $org_name?>&memberID=<?php echo $mem_info['stuID']?>"><?php echo $person_info['username'];?>  &raquo;</a></strong></p>
                              <p><strong>Email: </strong><a href="mailto:<?php echo $person_info['email'];?>"><?php echo $person_info['email'];?></a></p>
                              <p><strong>Phone: </strong><?php echo $person_info['phone'];?></p>
                              <p><?php echo $mem_info['tag']?></p>
                          </div>
                        </div>
                    <?php
                    }
                  }
              }
          ?>

          <?php
          } else {
            $query = "SELECT * FROM Member WHERE stuID='".$_GET['memberID']."' COLLATE utf8_bin AND belong_org='".$org_name."' COLLATE utf8_bin";
              $result = mysqli_query($dbc,$query);
              if ($result) {
                $member_info = $result->fetch_array();
              }
            $new_query = "SELECT * FROM All_users WHERE stuID='".$_GET['memberID']."' COLLATE utf8_bin";
              $new_result = mysqli_query($dbc,$new_query);
              if ($new_result) {
                $person_info = $new_result->fetch_array();
              }
            ?>
            <div class="row">
              
              <div class="col-xs-12 col-sm-6 col-md-4">
                <hr>
                <img src="<?php echo $member_info['photo_link']?>">
              </div>

              <div class="col-xs-12 col-sm-6 col-md-8">
                <hr>
                  <p><strong><?php echo $person_info['username'];?></strong></p>
                  <p><strong>Email: </strong><a href="mailto:<?php echo $person_info['email'];?>"><?php echo $person_info['email'];?></a></p>
                  <p><strong>Phone: </strong><?php echo $person_info['phone'];?></p>
                  <p><?php echo $member_info['tag']?></p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-xs-12 col-sm-12">
                <p><?php echo $member_info['description']?></p>
              </div>
            </div>
            <?php
          }
          ?>
        </div><!--/span-->

        
      </div><!--/row-->

      <hr>

      <?php gen_footer(); ?>

    </div><!--/.container-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script-->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/offcanvas.js"></script>
  </body>
</html>
