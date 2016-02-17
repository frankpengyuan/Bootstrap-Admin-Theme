<!DOCTYPE html>
<?php 
	include 'component.php';
	include 'function.php';
	init_web();
	$dbc = db_connect();
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
    <!-- Bootstrap theme -->
    <link href="./css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/theme.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body role="document">
  	<?php gen_navbar();?>
  	<div class="container">
	    <?php
	    $org_info = array();

		$query = "SELECT * FROM Organization";
		$result = mysqli_query($dbc,$query);
		if ($result) {
            if($result->num_rows > 0){
                while($org_info = $result->fetch_array()){
                    ?>
                    <div class="jumbotron">
                      <h1><?php echo $org_info['org_name']?></h1>
                      <p><?php echo $org_info['short_description']?></p>
                      <hr>
			        <p align="left">
			        	<a href="org_description.php?org=<?php echo $org_info['org_name']?>" class="btn btn-default btn-lg" role="button">Learn more &raquo;</a>
			        </p>
                    </div>
                    <?php
                }
            }
        }
        ?>
            
	    <hr>
      <footer>
        <p>&copy; Company 2014</p>
      </footer>

    </div><!--/.container-->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/docs.min.js"></script>

  </body>
</html>