<?php 
function weapon($weapons)
{
?>

    <script type="text/javascript">
      google.setOnLoadCallback(weapons);
      function weapons() {
        var data_wp = google.visualization.arrayToDataTable([
          ['Weapon', 'Total'],
        
			<?php
			$weapondata = array();
			foreach($weapons as $weapon)
				{
					if(isset($_POST['filter']))
					{
						$types=$_POST['type'];
						
						$totalweapons =0;
						$string = "['".$weapon."', ";
						if($_POST['county']!='all')
						{
							$county = $_POST['county'];
							$sql = mysql_query("SELECT * FROM crimeapp WHERE weapon='$weapon' AND county='$county'");
						}
						else
						{
							$sql = mysql_query("SELECT * FROM crimeapp WHERE weapon='$weapon'");
						}
						while($row=mysql_fetch_array($sql))
						{
							if(in_array($row['category'], $types))
							{
							$totalweapons++;
							}
						}
						
						$string .= $totalweapons."]";
						$weapondata[] = $string;
					}
					else
					{
						
						$string = "['".$weapon."', ";
						$totalweapons = mysql_num_rows(mysql_query("SELECT * FROM crimeapp WHERE weapon='$weapon'"));
						$string .= $totalweapons."]";
						$weapondata[] = $string;
						
					}
				}
				echo implode(', ', $weapondata);
			?>
        ]);

        var options = {
          title: 'Weapons used'
		  
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_wp'));
        chart.draw(data_wp, options);
      }
    </script>

    <div id="chart_wp" style="width: 100%;height:250px"></div>
<?php
}
?>