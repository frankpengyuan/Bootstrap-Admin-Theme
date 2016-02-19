<?php
	function gen_sidebar($org_name="", $page=-1)
	{
	?>
		<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
          <div class="list-group">
            <a href="<?php echo "org_description.php?org=".$org_name ?>" class="list-group-item <?php if($page == 0) echo "active";?>">About us</a>
            <a href="<?php echo "org_member.php?org=".$org_name ?>" class="list-group-item <?php if($page == 1) echo "active";?>">Members</a>
            <a href="<?php echo "org_calender.php?org=".$org_name ?>" class="list-group-item <?php if($page == 2) echo "active";?>">Calendar</a>
            <a href="<?php echo "org_events.php?org=".$org_name ?>" class="list-group-item <?php if($page == 3) echo "active";?>">Events</a>
            <a href="<?php echo "org_files.php?org=".$org_name ?>" class="list-group-item <?php if($page == 4) echo "active";?>">Files</a>
            <a href="<?php echo "org_contacts.php?org=".$org_name ?>" class="list-group-item <?php if($page == 5) echo "active";?>">Contact us</a>
          </div>
        </div><!--/span-->
    <?php
	}

	function gen_navbar_dropdown($org_name='')
	{
	?>
		<ul class="dropdown-menu">
	      <li>
	          <a tabindex="-1" href="<?php echo "org_member.php?org=".$org_name ?>">Members</a>
	      </li>
	      <li>
	          <a tabindex="-1" href="<?php echo "org_calender.php?org=".$org_name ?>">Calendar</a>
	      </li>
	      <li>
	          <a tabindex="-1" href="<?php echo "org_events.php?org=".$org_name ?>">Events</a>
	      </li>
	      <li>
	          <a tabindex="-1" href="<?php echo "org_files.php?org=".$org_name ?>">Files</a>
	      </li>
	      <li class="divider"></li>
	      <li>
	          <a tabindex="-1" href="<?php echo "org_contacts.php?org=".$org_name ?>">Contact us</a>
	      </li>
	      <li class="divider"></li>
	  	</ul>
    <?php
	}

	function gen_navbar($page="")
	{
	?>
	<div class="navbar navbar-fixed-top navbar-default" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">UM-SJTU JI Student Affairs</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown <?php if($page=="Advising Center") echo "active"?>">
              <a href="./org_description.php?org=Advising Center" role="button" class="dropdown-toggle">Advising Center<i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Advising Center");?>
          	</li>
          	<li class="dropdown <?php if($page=="Writing Center") echo "active"?>">
              <a href="./org_description.php?org=Writing Center" role="button" class="dropdown-toggle">Writing Center <i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Writing Center");?>
          	</li>
            <li class="dropdown <?php if($page=="Honor Council") echo "active"?>">
              <a href="./org_description.php?org=Honor Council" role="button" class="dropdown-toggle">Honor Council<i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Honor Council");?>
          	</li>
            <li class="dropdown <?php if($page=="Student Union") echo "active"?>">
              <a href="./org_description.php?org=Student Union" role="button" class="dropdown-toggle">Student Union<i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Student Union");?>
          	</li>
          	<li class="dropdown <?php if($page=="AST") echo "active"?>">
              <a href="./org_description.php?org=AST" role="button" class="dropdown-toggle">AST <i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("AST");?>
          	</li>
          	<li class="dropdown <?php if($page=="Staff") echo "active"?>">
              <a href="./org_description.php?org=Staff" role="button" class="dropdown-toggle">Staff <i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Staff");?>
          	</li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <li class="dropdown">
            	<?php
            	if (isset($_SESSION["username"])) {
            	?>
            	<a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> <?php echo $_SESSION["username"]?> <i class="caret"></i></a>
                <ul class="dropdown-menu">
                    <li>
                        <a tabindex="-1" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a tabindex="-1" href="logout.php">Logout</a>
                    </li>
                </ul>
            	<?php
            	} else {
            	?>
            		<a href="login.php" role="button" class="dropdown-toggle">Sign in</a>
            	<?php
            	}
                ?>
            </li>
        </ul>
        </div><!-- /.nav-collapse -->
        
      </div><!-- /.container -->
    </div><!-- /.navbar -->
    <?php
	}

	function gen_sidebar_admin($page=-1)
	{
	?>
	<div class="span3" id="sidebar">
	    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
	        <li class="<?php if($page == 0) echo "active";?>">
	            <a href="dashboard.php"><i class="icon-chevron-right"></i> Dashboard</a>
	        </li>
	        <li class="<?php if($page == 1) echo "active";?>">
	            <a href="admin_org.php"><i class="icon-chevron-right"></i> Oranization Admin</a>
	        </li>
	        <li class="<?php if($page == 2) echo "active";?>">
	            <a href="admin_member.php"><i class="icon-chevron-right"></i> Member Admin</a>
	        </li>
	        <li class="<?php if($page == 3) echo "active";?>">
	            <a href="admin_events.php"><i class="icon-chevron-right"></i> Events Admin</a>
	        </li>
	        <li class="<?php if($page == 4) echo "active";?>">
	            <a href="admin_feedback.php"><i class="icon-chevron-right"></i> Feedbacks</a>
	        </li>
	        <li class="<?php if($page == 5) echo "active";?>">
	            <a href="admin_cal.php"><i class="icon-chevron-right"></i> Calendar</a>
	        </li>
	        <li class="<?php if($page == 6) echo "active";?>">
	            <a href="admin_reservation.php"><i class="icon-chevron-right"></i> Reservations</a>
	        </li>
	        <li class="<?php if($page == 7) echo "active";?>">
	            <a href=""><i class="icon-chevron-right"></i> Cases</a>
	        </li>
	    </ul>
	</div>
	<?php
	}


	function gen_navbar_admin($page='')
	{
	?>
		<div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Admin Panel</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> <?php echo $_SESSION["username"]?> <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="logout.php">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="dashboard.php">Dashboard</a>
                            </li>
							<li>
                                <a href="index.php">View Site</a>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
	<?php
	}


	function gen_Admin_pageEnd($value='')
	{
	?>
		<script src="vendors/jquery-1.9.1.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/DT_bootstrap.js"></script>
        <script src="vendors/easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="assets/scripts.js"></script>
        <script>
        $(function() {
            // Easy pie charts
            $('.chart').easyPieChart({animate: 1000});
        });
        </script>
        <!--link href="vendors/datepicker.css" rel="stylesheet" media="screen"-->
        <link href="vendors/uniform.default.css" rel="stylesheet" media="screen">
        <link href="vendors/chosen.min.css" rel="stylesheet" media="screen">

        <link href="vendors/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet" media="screen">
        <script src="vendors/jquery.uniform.min.js"></script>
        <script src="vendors/chosen.jquery.min.js"></script>
        <!--script src="vendors/bootstrap-datepicker.js"></script-->

        <script src="vendors/wysiwyg/wysihtml5-0.3.0.js"></script>
        <script src="vendors/wysiwyg/bootstrap-wysihtml5.js"></script>

        <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>
        <script src="vendors/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
        <script src="vendors/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script>
        <script src="vendors/ckeditor/ckeditor.js"></script>
        <script src="vendors/ckeditor/adapters/jquery.js"></script>
        <script type="text/javascript" src="vendors/tinymce/js/tinymce/tinymce.min.js"></script>
        <script src="assets/scripts.js"></script>
        <script type="text/javascript" src="vendors/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="assets/form-validation.js"></script>
        <link type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
        <script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.min.js"></script>
        <link href="css/jquery-ui-timepicker-addon.css" type="text/css" />
        <script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
        <script type="text/javascript">
        jQuery(function () {
            jQuery('.datetimepicker').datetimepicker({
                timeFormat: "HH:mm:00",
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
                stepMinute: 10
            });

        });
    </script>

        <script>

        jQuery(document).ready(function() {   
           FormValidation.init();
        });
    

        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true
            });
            $(".uniform_on").uniform();
            $(".chzn-select").chosen();
            $('.textarea').wysihtml5();

            $('#rootwizard').bootstrapWizard({onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                $('#rootwizard').find('.bar').css({width:$percent+'%'});
                // If it's the last tab then hide the last button and show the finish instead
                if($current >= $total) {
                    $('#rootwizard').find('.pager .next').hide();
                    $('#rootwizard').find('.pager .finish').show();
                    $('#rootwizard').find('.pager .finish').removeClass('disabled');
                } else {
                    $('#rootwizard').find('.pager .next').show();
                    $('#rootwizard').find('.pager .finish').hide();
                }
            }});
            $('#rootwizard .finish').click(function() {
                alert('Finished!, Starting over!');
                $('#rootwizard').find("a[href*='tab1']").trigger('click');
            });
        });
        </script>
        <script>
        $(function() {
            // Bootstrap
            $('#bootstrap-editor').wysihtml5();

            // Ckeditor standard
            $( 'textarea#ckeditor_standard' ).ckeditor({width:'98%', height: '150px', toolbar: [
                { name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] }, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],          // Defines toolbar group without name.
                { name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
            ]});
            $( 'textarea#ckeditor_full' ).ckeditor({width:'98%', height: '150px'});
        });

        

        </script>
        <script>
        $(function() {
            
        });
        </script>
	<?php
	}


    function gen_header($title='UM-SJTU JI Student Affairs')
    { ?>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="./assets/ico/favicon.ico">

        <title><?php echo $title ?></title>

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
    <?php }

	function gen_header_admin($title='UM-SJTU JI Student Affairs - Admin')
	{
		?>
		<title><?php echo $title ?></title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <link href="assets/DT_bootstrap.css" rel="stylesheet" media="screen">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <?php
	}


	function gen_footer_admin($title='UM-SJTU JI Student Affairs - Admin')
	{
		?>
		<footer>
            <p>&copy; <?php echo $title ?></p>
        </footer>
	<?php
	}

	function gen_footer($title='UM-SJTU JI Student Affairs')
	{
		?>
		<footer>
            <p>&copy; <?php echo $title ?></p>
        </footer>
	<?php
	}

?>