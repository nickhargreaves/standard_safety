<?php
function report()
{
	if(isset($_POST['filter']))
	{
		if($_POST['county']!='all')
				{
					$county = $_POST['county'];
					$sql = mysql_query("SELECT * FROM poverty WHERE county='$county'");
					$row=mysql_fetch_array($sql);
					
						echo "<div class='span4'><h3>Poverty</h3>Total Poor: ".$row['total'].
						"<br>Poverty Rate: ".$row['rate'];
					//urbanization
					echo "<h3>County Urbanization</h3>";
					$sql = mysql_query("SELECT * FROM urbanization WHERE county='$county'");
					$row = mysql_fetch_array($sql);
					echo "Urban population: ".$row['Urban']."(".$row['%Urban'].")<br />";
					echo "Rural population: ".$row['Rural']."(".$row['%Rural'].")";
					echo "</div>";
					
					//health facilicities
					echo "<div class='span4'><h3>Health Facilities</h3>";
					echo "<iframe src='show_map.php?county=".$county."' width='380px' height='400px' frameborder='0' scrolling='no'></iframe>";
					echo "</div>";
					
					
				}
				else
				{
				echo "No county selected!";
				}
					
	}
	else
	{
	echo "No county selected!";
	}
}
?>