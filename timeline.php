<?php
function timeline($months, $categories){
?>
 
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          
          <?php
		  echo "['Month',"; 
		  if(isset($_POST['filter']))
			{
				$types = $_POST['type'];
				$bla = array();
				foreach($types as $type)
				{
				$bla []= "'".$type."'";
				}
				echo implode(', ', $bla);
			}
			else
			{
			echo "'Arson', 'Assault', 'Banditry', 'Carjacking', 'Conmanship', 'Domestic Murder', 'Forgery', 'Fraud', 'Mob Justice', 'Murder', 'Rape', 'Robbery', 'Sodomy', 'Stock Theft', 'Traffic Offence'";
			}
			echo "],";
		  $monthdata = array();
		  foreach($months as $month)
		  {
		  $string =  "['".$month."',";
		  	 $totals = array();
			if(isset($_POST['filter']))
			{
				$types = $_POST['type'];
				foreach($categories as $cat)
				{
					if(in_array($cat, $types))
					{
						if($_POST['county']!='all')
						{
							$county = $_POST['county'];
							$sql = mysql_query("SELECT * FROM crimeapp WHERE category='$cat' AND month='$month' AND county='$county'");
						}
						else
						{
							$sql = mysql_query("SELECT * FROM crimeapp WHERE category='$cat' AND month='$month'");
						}
					
					$total = mysql_num_rows($sql);
					$totals[]=$total;
					}
					else
					{
					
					}
				}
			}
			else
			{
				 foreach($categories as $cat)
				 {
				 $sql = mysql_query("SELECT * FROM crimeapp WHERE category='$cat' AND month='$month'");
				 $total = mysql_num_rows($sql);
				 $totals[]=$total;
				 }
			 }
			 $string .= implode(', ', $totals);
		   $string .= "]";
		   $monthdata[]=$string;
		  }
		  echo implode(', ', $monthdata);
		  ?>
         ]);

        var options = {
          title: 'Crime Trend'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
  
    <div id="chart_div" style="width: 100%; height: 250px;"></div>
<?php
}
?>