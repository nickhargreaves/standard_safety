<?php
function heat($categories)
{
?>  
  <link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization"></script>
    <script>
      var map, pointarray, heatmap;

      var taxiData = [
        <?php

		
		if(isset($_POST['filter']))
		{
			$query=array();
			$types=$_POST['type'];
			foreach($types as $type)
			{
				if($_POST['county']!='all')
				{
					$county = $_POST['county'];
					$query[]="county='".$county."' AND category='".$type."'";
					
				}
				else
				{
					$query[]="category='".$type."'";
				}
				//$query[]="category='".$type."'";
				
			}
			$query =implode(" OR ", $query);
			
			$sql =mysql_query("SELECT * FROM crimeapp WHERE ".$query);
			
			
			
		}
		else
		{
		$sql = mysql_query("SELECT * FROM crimeapp");
		}
		$data = array();
		
		while($row=mysql_fetch_array($sql))
		{
			$sql2 = mysql_query("SELECT * FROM gps WHERE county='".$row['county']."'");
			$row2 = mysql_fetch_array($sql2);
			if($row2['gps']!='')
			{
			$data[] = "new google.maps.LatLng".$row2['gps'];
			}
		}
		echo implode (',', $data);
		?>
     
      ];

      function initialize() {
        var mapOptions = {
          zoom: 6,
          center: new google.maps.LatLng(0.574546, 37.433523),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById('map_canvas'),
            mapOptions);

        pointArray = new google.maps.MVCArray(taxiData);

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: pointArray
        });
		 heatmap.setOptions({opacity: heatmap.get('opacity') ? null : 0.9});
heatmap.setOptions({radius: heatmap.get('radius') ? null : 30});

        heatmap.setMap(map);
      }   
    </script>

<b>Heat Map</b><br>
<div id="map_canvas" style="height: 400px; width: 400px;"></div>
<br>

<?php
}
?>