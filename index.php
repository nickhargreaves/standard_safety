  <?php
  	require_once('config.php');
	require_once('timeline.php');
	require_once('heat.php');
	require_once('weapon.php');
	require_once('report.php');
	?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Standard Safety</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/docs.css" rel="stylesheet">
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">
	
	 <script type="text/javascript" src="clusters/jquery-1.6.1.min.js"></script>        
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="clusters/gmap3.min.js"></script> 
	
 <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>  
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar" onload="initialize()">

    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php">Standard Safety</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active">
                <a href="index.php">Home</a>
              </li>
      
            </ul>
          </div>
        </div>
      </div>
    </div>

<div class="jumbotron masthead">
  <div class="container">
    <p>Standard Safety</p>
     </div>
</div>

<div class="bs-docs-social">
  <div class="container">

  </div>
</div>

<div class="container">

  <div class="marketing">

    <div class="row-fluid">
	
	  
      <div class="span3">

         <h2>Filters</h2>
		 <script type='text/javascript'>
$(function () {
    $('.checkall').click(function () {
        $(this).parents('fieldset:eq(0)').find(':checkbox').attr('checked', this.checked);
    });
});
</script>
<form method='POST' action='<?php echo 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']?>'>
		<select name='county' style='width:100%'>
		<option value='all'>All counties</option>
		<?php
		$counties=mysql_query("SELECT * FROM gps");
		while($county=mysql_fetch_array($counties))
		{
			if(isset($_POST['county']))
			{
				if($_POST['county']==$county['county'])
				{
				echo "<option value='".$county['county']."' selected='selected'>".$county['county']."</option>";
				}
				else
				{
				echo "<option value='".$county['county']."'>".$county['county']."</option>";
				}
			}
			else
			{
				echo "<option value='".$county['county']."'>".$county['county']."</option>";
			}
		}
		?>
		</select>
<table width='100%'>		
	  <fieldset>
		<tr><td><input type='checkbox' name='type[]' class='checkall'></td><td>All</td></tr>
		<?php
		if(isset($_POST['filter']))
		{
			$types = $_POST['type'];
			foreach($categories as $cat)
			{
				if(in_array($cat, $types))
				{
				echo "<tr><td><input type='checkbox' name='type[]' value='".$cat."' checked='checked'></td><td>".$cat."</td></tr>";
				}
				else
				{
				echo "<tr><td><input type='checkbox' name='type[]' value='".$cat."'></td><td>".$cat."</td></tr>";
				}
			}
		}
		else
		{
			foreach($categories as $cat)
			{
				echo "<tr><td><input type='checkbox' name='type[]' value='".$cat."'></td><td>".$cat."</td></tr>";
			}
		}
		?>
		</fieldset>
		</table>
		<br>
		<input type='submit' value='Filter' name='filter' class='btn btn-primary'>
		</form>
		
	   </div>
       <div class="span7">
		<table>
<tr>
<td valign='top'>
<br>
<div class="slidingDiv" id="slidingDiv" style='padding-left:10px;padding-right:10px;padding-top:10px;-moz-box-shadow:1px 1px 2px 3px #ccc;-webkit-box-shadow: 1px 1px 2px 3px #ccc;box-shadow:1px 1px 2px 3px #ccc;'>
<?php
heat($categories);
?> 
</div>
</td>
<td>
  <div class="timeline">
  <?php
timeline($months, $categories);
?>
  </div>
  <br>
  <div class="weapon" style='margin-top:-30px;'>
<?php
weapon($weapons);
?> 
  </div>
</td>
</tr>
</table>
      </div>
	 

    </div>
<div class='row-fluid' style='width:100%;padding-left:10px;padding-right:10px;padding-top:10px;-moz-box-shadow:1px 1px 2px 3px #ccc;-webkit-box-shadow: 1px 1px 2px 3px #ccc;box-shadow:1px 1px 2px 3px #ccc;'>
<h3>County Report Card</h3>
<?php
report();
?>
<br>
   </div> <hr class="soften">

   

  </div>

</div>



    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <p class="pull-right"><a href="#">Back to top</a></p>
        
      </div>
    </footer>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap-affix.js"></script>
    <script src="assets/js/application.js"></script>



  </body>
</html>
