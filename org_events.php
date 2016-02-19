
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

function check_field()
{
  return !empty($_POST['name']) && !empty($_POST['userID']) && !empty($_POST['email']) && !empty($_POST['captcha']);
}

$reg_event_err_msg = "";
if (isset($_POST['submit'])) {
  if (check_field() == true) {
    if (strcasecmp($_POST['captcha'],$_SESSION["check"])==0) {
      $query = "SELECT * FROM Event_reg WHERE userID='".mysqli_real_escape_string($dbc, $_POST['userID'])
      ."' COLLATE utf8_bin AND event_id='".mysqli_real_escape_string($dbc, $_POST['event_id'])."'";
      $result = mysqli_query($dbc,$query);
      //echo $query;
      echo mysqli_error($dbc);
      if ($result) {
        if ($result -> num_rows > 0) {
          $reg_event_err_msg = "You are already registed.";
        } else {
          $query = "INSERT INTO Event_reg SET userID='".mysqli_real_escape_string($dbc, $_POST['userID'])
          ."', event_id='".mysqli_real_escape_string($dbc, $_POST['event_id'])
          ."', name='".mysqli_real_escape_string($dbc, $_POST['name'])
          ."', email='".mysqli_real_escape_string($dbc, $_POST['email'])."'";
          $result = mysqli_query($dbc,$query);
          //echo $query;
          echo mysqli_error($dbc);
        }
      } else {
        $reg_event_err_msg = "Database query failed.";
      }
    } else {
      $reg_event_err_msg = "Wrong captcha.";
    }
  } else {
    $reg_event_err_msg = "Information insufficient.";
  }
}

?>
<html lang="en">
  <head>
    <?php gen_header(); ?>
  </head>

  <body>
    <?php gen_navbar($org_name);?>

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">
        <?php gen_sidebar($org_name, 3);?>
        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>

          <?php // handle error msg
          if (!empty($_POST["event_id"]))
          {
              if ($reg_event_err_msg != "") { ?>
                  <div class="alert alert-danger">
                      <button class="close" data-dismiss="alert">&times;</button>
                      <strong>Error! </strong><?php echo $reg_event_err_msg;?>.
                  </div>
              <?php } else {?>
                  <div class="alert alert-success">
                      <button class="close" data-dismiss="alert">&times;</button>
                      <strong>Success! </strong>Your information has been well received.
                  </div>
              <?php }
          }?>

          <?php
            if (!isset($_GET['event_id'])) {
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
              $event_info = array();
              $query = "SELECT * FROM Events WHERE org_name='".$org_name."' COLLATE utf8_bin";
              $result = mysqli_query($dbc,$query);
              if ($result) {
                  while($event_info = $result->fetch_array())
                  {
                        ?>
                        <div class="row">
                  
                          <div class="col-xs-12 col-sm-6 col-md-4">
                            <hr>
                            <img width="200" src="<?php echo $event_info['photo_link']?>">
                          </div>

                          <div class="col-xs-12 col-sm-6 col-md-8">
                            <hr>
                              <h2><strong><a href="org_events.php?org=<?php echo $org_name?>&event_id=<?php echo $event_info['event_id']?>"><?php echo $event_info['title'];?></a></strong></h2>
                              <p><strong>Time: </strong><?php echo $event_info['time'];?></p>
                              <p><strong>Location: </strong><?php echo $event_info['location'];?></p>
                              <p><strong>Contact us: </strong><a href="mailto:<?php echo $event_info['contact_email'];?>"><?php echo $event_info['contact_email'];?></a></p>
                              <p><?php echo $event_info['short_description'];?></p>
                              <a href="org_events.php?org=<?php echo $org_name?>&event_id=<?php echo $event_info['event_id']?>#reg_anchor"><button class="btn btn-default">register</button></a>
                          </div>
                        </div>
                    <?php
                  }
              }
          ?>

          <?php
          } else {
            $query = "SELECT * FROM Events WHERE event_id='".$_GET['event_id']."' COLLATE utf8_bin";
              $result = mysqli_query($dbc,$query);
              if ($result) {
                $event_info = $result->fetch_array();
              }
            ?>
            <div class="row">
              <div class="col-xs-12 col-sm-12">
                <h1><?php echo $event_info['title'];?></h1>
                <hr>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-10 col-lg-9">
                  <img style="width: 600;" src="<?php echo $event_info['photo_link']?>">
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 col-lg-3">
                  <p><strong>From </strong><?php echo $event_info['time'];?></p>
                  <p><strong>To </strong><?php echo $event_info['end_time'];?></p>
                  <p><strong>Location: </strong><?php echo $event_info['location'];?></p>
                  <p><strong>Speaker: </strong><?php echo $event_info['speaker'];?></p>
                  <p><strong>Event Manager: </strong><?php echo $event_info['manager'];?></p>
                  <p><strong>Contact us: </strong><a href="mailto:<?php echo $event_info['contact_email'];?>"><?php echo $event_info['contact_email'];?></a></p>
                  <a href="#reg_anchor"><button class="btn btn-default">Register</button></a>
                  </div>
                </div>
                <hr>
                <p><?php echo $event_info['description']?></p>
                <hr>
              </div>
              <a name="reg_anchor"></a>
              <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];?>">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="FirstName LastName" 
                    name="name" value="<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];} ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">ID</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Student ID / User ID" 
                    name="userID" value="<?php if(isset($_SESSION['user_id'])){echo $_SESSION['user_id'];} ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="eg. example@example.com" 
                    name="email" value="<?php if(isset($_SESSION['useremail'])){echo $_SESSION['useremail'];} ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Captcha</label>
                  <div class="">
                    <div class="col-sm-2">
                      <input type="text" name="captcha" class="form-control" placeholder="Captcha">
                    </div>
                    <div class="col-sm-1">
                    <a href="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']."#reg_anchor";?>"><img src="captcha.php"></img></a>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="event_id" value="<?php echo $event_info['event_id']?>">
                    <button type="submit" class="btn btn-default" name="submit">Join Event!</button>
                  </div>
                </div>
              </form>
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
