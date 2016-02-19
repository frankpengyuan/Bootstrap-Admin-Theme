<!DOCTYPE html>
<?php 
	include 'component.php';
	include 'function.php';
	$dbc = db_connect();
	init_web($dbc);
?>
<html lang="en">
  <head>
    <?php gen_header(); ?>
  </head>

  <body role="document">
  	<?php gen_navbar();?>
  	<div class="container">

      <div class="jumbotron">
        <h1>Welcome!</h1>
        <hr>
        <h3>UM-SJTU JI Student Affairs</h3>
        <p>say something~~</p>
      </div>
      <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="box">
          <div class="box-content box-nomargin">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
    </div>
    <hr>
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
      <?php gen_footer(); ?>

    </div><!--/.container-->
    <script src="vendors/jquery-1.9.1.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/docs.min.js"></script>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <link href='css/fullcalendar.css' rel='stylesheet' />
    <link href='css/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='js/moment.min.js'></script>
    <script src='js/fullcalendar.min.js'></script>
    <script>
    $(document).ready(function() {
      
      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay'
        },
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: [
          <?php 

          $query = "SELECT * FROM Events";
          $result = mysqli_query($dbc,$query);
          if ($result) {
            while ($one_event = $result -> fetch_array()) {
              echo "{";
              echo "title: '".$one_event['title']."',\n";
              echo "start: '".$one_event['time']."',\n";
              echo "end: '".$one_event['end_time']."',\n";
              echo "url: './org_events.php?org=".$one_event['org_name']."&event_id=".$one_event['event_id']."'\n";
              echo "},\n";
            }
          }
          ?>
          {
              title:"My repeating event",
              start: '10:00', // a start time (10am in this example)
              end: '14:00', // an end time (6pm in this example)
              dow: [ 1, 4 ] // Repeat monday and thursday
          }
        ]
      });
    });
  </script>
  <?php mysqli_close($dbc); ?>
  </body>
</html>