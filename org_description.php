
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
    <?php gen_header(); ?>
  </head>

  <body>
    <?php gen_navbar($org_name);?>

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">
        <?php gen_sidebar($org_name, 0);?>
        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>

          <?php
              $org_info = array();

              $query = "SELECT * FROM Organization WHERE org_name='".$org_name."' COLLATE utf8_bin";
              $result = mysqli_query($dbc,$query);
              if ($result) {
                if($result->num_rows > 0){
                    $org_info = $result->fetch_array();
                    ?>
                    <div class="col-xs-12 col-sm-12">
                      <h1><?php echo $org_info['org_name']?></h1>
                      <hr>
                      <img style="maxwidth: 260px; maxheight: 180px;" src="<?php echo $org_info['photo_link']?>">
                      <hr>
                      <p><?php echo $org_info['description']?></p>
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
          
          
        </div><!--/span-->

        
      </div><!--/row-->

      <hr>

      <?php
      gen_footer(); 
      mysqli_close($dbc);
      ?>

    </div><!--/.container-->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="vendors/jquery.uniform.min.js"></script>
    <script src="vendors/chosen.jquery.min.js"></script>
    <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/offcanvas.js"></script>

  </body>
</html>
