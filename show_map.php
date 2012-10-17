<?php

require_once('config.php');
?>

    <script type="text/javascript" src="clusters/jquery-1.6.1.min.js"></script>        
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <script type="text/javascript" src="clusters/gmap3.min.js"></script> 
    <script type="text/javascript">
	var macDoList = [
  <?php
	if(isset($_GET['county']))
	{
	$county=$_GET['county'];
	$sql=mysql_query("SELECT * FROM sh_facilities WHERE Geolocation!='' AND District='$county'");
	}
	else
	{
	$sql=mysql_query("SELECT * FROM sh_facilities WHERE Geolocation!=''");
	}
	$markers=array();
	while($row=mysql_fetch_array($sql))
	{
	$gps=$row['Geolocation'];
	$gps=explode(', ', $gps);
	$lat = str_replace('(', '', $gps[0]);
	$lon = str_replace(')', '', $gps[1]);
	$name=$row['name'];
	$name = ereg_replace("[^A-Za-z0-9 ]", "", $name );
	$markers[]= "{lat:".$lat.",lng:".$lon.",data:{drive:false,zip:".$row['id'].",city:'".$name."'}}";
	}
	
	echo implode(', ', $markers);
  ?>

];
	</script> 
    <style>
      #container{
        position:relative;
        height:300px;
		
      }
      #googleMap{
       
        width: 100%;
        height: 300px;
      }
      .black{
	  color: #000;
		
	  }
      /* cluster */
      .cluster{
      	color: #fff;
		background-color:#000;
      	text-align:center;
      	font-family: Verdana;
      	font-size:12px;
      	font-weight:bold;
      	text-shadow: 0 0 2px #000;
        -moz-text-shadow: 0 0 2px #000;
        -webkit-text-shadow: 0 0 2px #000;
      }
      .cluster-1{
        background: url(clusters/images/m1.png) no-repeat;
        line-height:50px;
      	width: 50px;
      	height: 50px;
      }
      .cluster-2{
        background: url(clusters/images/m2.png) no-repeat;
        line-height:60px;
      	width: 60px;
      	height: 60px;
      }
      .cluster-3{
        background: url(clusters/images/m3.png) no-repeat;
        line-height:70px;
      	width: 70px;
      	height: 70px;
      }
      
      /* infobulle */
      .infobulle{
        overflow: hidden; 
        cursor: default; 
        clear: both; 
        position: relative; 
        height: 34px; 
        padding: 0pt; 
        background-color: #fff;
      
        border: 1px solid #2C2C2C;
      }
      .infobulle .bg{
        font-size:1px;
        height:16px;
        border:0px;
        width:100%;
        padding: 0px;
        margin:0px;
        background-color: #fff;
      }
      .infobulle .text{
        color:#000;
        font-family: Verdana;
        font-size:11px;
        font-weight:bold;
        line-height:25px;
        padding:4px 20px;
        text-shadow:0 -1px 0 #000000;
        white-space: nowrap;
        margin-top: -17px;
      }
      .infobulle.drive .text{
        background: url(clusters/images/drive.png) no-repeat 2px center;
        padding:4px 20px 4px 36px;
      }
      .arrow{
        position: absolute; 
        left: 45px; 
        height: 0pt; 
        width: 0pt; 
        margin-left: 0pt; 
        border-width: 10px 10px 0pt 0pt; 
        border-color: #2C2C2C transparent transparent; 
        border-style: solid;
      }
      
    </style>
    
    <script type="text/javascript">
    
      $(function(){
      
        $('#googleMap').gmap3(
          {action: 'init',
            options:{
			<?php
			if(isset($_GET['county']))
		{
	$gps=mysql_fetch_array(mysql_query("SELECT * FROM sh_facilities WHERE Geolocation!='' AND District='$county'"))['Geolocation'];

	$gps=explode(', ', $gps);
	$lat = str_replace('(', '', $gps[0]);
	$lon = str_replace(')', '', $gps[1]);
	echo "center:[".$lat.",".$lon."],
	zoom: 9,";
	
		}
	else
		{ 
	echo "center:[0.452,36.75],
	zoom: 7,";
		}
		?>
              
              mapTypeId: google.maps.MapTypeId.TERRAIN
            }
          },
          {action: 'addMarkers',
            radius:100,
            markers: macDoList,
            clusters:{
              // This style will be used for clusters with more than 0 markers
              0: {
                content: '<div class="cluster cluster-1"><span class="black">CLUSTER_COUNT</span></div>',
                width: 53,
                height: 52
              },
              // This style will be used for clusters with more than 20 markers
              20: {
                content: '<div class="cluster cluster-2"><span class="black">CLUSTER_COUNT</span></div>',
                width: 56,
                height: 55
              },
              // This style will be used for clusters with more than 50 markers
              50: {
                content: '<div class="cluster cluster-3"><span class="black">CLUSTER_COUNT</span></div>',
                width: 66,
                height: 65
              }
            },
            marker: {
              options: {
                icon: new google.maps.MarkerImage('http://maps.gstatic.com/mapfiles/icon_green.png')
              },
              events:{  
                mouseover: function(marker, event, data){
                  $(this).gmap3(
                    { action:'clear', name:'overlay'},
                    { action:'addOverlay',
                      latLng: marker.getPosition(),
                      content:  '<div class="infobulle'+(data.drive ? ' drive' : '')+'">' +
                                  '<div class="bg"></div>' +
                                  '<div class="text">' + data.city + ' (' + data.zip + ')</div>' +
                                '</div>' +
                                '<div class="arrow"></div>',
                      offset: {
                        x:-46,
                        y:-73
                      }
                    }
                  );
                },
                mouseout: function(){
                  $(this).gmap3({action:'clear', name:'overlay'});
                }
              }
            }
          }
        );
      });
    </script>  
	
	 <div id="googleMap"></div><br>
	 <?php


?>