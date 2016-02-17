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

	function gen_navbar($page=-1)
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
            <li class="dropdown <?php if($page==1) echo "active"?>">
              <a href="./org_description.php?org=Advising Center" role="button" class="dropdown-toggle">Advising Center<i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Advising Center");?>
          	</li>
          	<li class="dropdown <?php if($page==3) echo "active"?>">
              <a href="./org_description.php?org=Writing Center" role="button" class="dropdown-toggle">Writing Center <i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Writing Center");?>
          	</li>
            <li class="dropdown <?php if($page==2) echo "active"?>">
              <a href="./org_description.php?org=Honor Council" role="button" class="dropdown-toggle">Honor Council<i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Honor Council");?>
          	</li>
            <li class="dropdown <?php if($page==3) echo "active"?>">
              <a href="./org_description.php?org=Student Union" role="button" class="dropdown-toggle">Student Union<i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("Student Union");?>
          	</li>
          	<li class="dropdown <?php if($page==3) echo "active"?>">
              <a href="./org_description.php?org=AST" role="button" class="dropdown-toggle">AST <i class="caret"></i>
              </a>
              <?php gen_navbar_dropdown("AST");?>
          	</li>
          	<li class="dropdown <?php if($page==3) echo "active"?>">
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
	            <a href=""><i class="icon-chevron-right"></i> User Admin</a>
	        </li>
	        <li class="<?php if($page == 3) echo "active";?>">
	            <a href=""><i class="icon-chevron-right"></i> Events Admin</a>
	        </li>
	        <li class="<?php if($page == 4) echo "active";?>">
	            <a href=""><i class="icon-chevron-right"></i> Feedbacks</a>
	        </li>
	        <li class="<?php if($page == 5) echo "active";?>">
	            <a href=""><i class="icon-chevron-right"></i> Calendar</a>
	        </li>
	        <li class="<?php if($page == 6) echo "active";?>">
	            <a href=""><i class="icon-chevron-right"></i> Reservations</a>
	        </li>
	        <li class="<?php if($page == 7) echo "active";?>">
	            <a href=""><i class="icon-chevron-right"></i> Cases</a>
	        </li>
	    </ul>
	</div>
	<?php
	}
?>