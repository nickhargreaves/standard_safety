<?php
$link = mysql_connect('localhost', 'root', '');
mysql_select_db('crime', $link)or die('db does not exist');
		  
$categories = array('Arson', 'Assault', 'Banditry', 'Carjacking', 'Conmanship', 'Domestic Murder', 'Forgery', 'Fraud', 'Mob Justice', 'Murder', 'Rape', 'Robbery', 'Sodomy', 'Stock Theft', 'Traffic Offence');
$months = array('Janurary', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$weapons = array('Acid', 'Arrow', 'Arrows', 'Arrows and Pangas', 'Assault', 'Axe', 'Blunt Objesct', 'Card-shuffling', 'Carjacking', 'Club', 'Crude Weapons', 'Defilement', 'Drowning', 'Drugs', 'Exhibition Stands', 'Fake Documents', 'Fake Tickets', 'False alarm', 'Fire', 'Fleecing', 'Flouting Traffic Rules', 'Gun', 'Guns', 'Hacking', 'Hot water', 'Illicit Brews', 'Iron bars and machetes', 'Knife', 'Machete', 'Major Vehicle defects', 'Metal bar', 'Murder', 'Mutilation', 'N/A', 'No PSV Documents', 'Panga', 'Pangas', 'Physical', 'Piece of wood', 'Plank of wood', 'Poisoned Arrow', 'Rape', 'Recruitment', 'Robbery', 'Sharp object', 'Stabbing', 'Stone', 'Strangling', 'Swords', 'Theft', 'Unknown');
?>