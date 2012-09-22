<?php
	$result = mysql_query("SELECT * FROM banners WHERE id='$banner_stats'",$db);
	$banner = mysql_fetch_array($result);
	
	if ($banner['src'] == 'swf') {
		echo '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'.$banner['width'].'" height="'.$banner['height'].'" id="flash" align="center">
		<param name="allowScriptAccess" value="sameDomain" />
		<param name="movie" value="'.$banner['url'].'" />
		<param name="quality" value="high" />
		<param name="bgcolor" value="#fff" />
		<embed src="'.$banner['url'].'" quality="high" bgcolor="#fff" width="'.$banner['width'].'" height="'.$banner['height'].'" name="flash" align="center" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
		</object>';
	} else {
		echo "<img src='".$banner['url']."' alt='".$banner['title']."' width='".$banner['width']."' height='".$banner['height']."' />";
	}
	
	$today = date("Y-m-d");
	$yesterday = date("Y-").(date("m")-1).date("-d");
	
	$result = mysql_query("SELECT * FROM banner_clicks WHERE banner_id = '1' and date = '$today'",$db);
	$today = mysql_num_rows($result);
	$i = 1;
	$months = array('Nullember','January','February','March','April','May','June','July','August','September','October','November','December');
	
	if (mysql_num_rows($result) > 0) {
		
		echo "<br/><br/><b>Today</b></br><table cellpadding='0' cellspacing='3'>";
		do {
			$day = split('-',$today['date']);
			$day = $day[2];
			$month = split('-',$today['date']);
			$month = (int) $month[1];
			$month = $months[$month];
			$year = split('-',$today['date']);
			$year = $year[0];
			$style = ($i % 2 == 0) ? "style='background: #cdf'" : '';
			echo "<tr ".$style."><td style='padding: 5px 20px;'>".$i."</td><td style='padding: 5px 20px;'>".$day." of ".$month.", ".$year."</td><td style='padding: 5px 20px;'>".$today['time']."</td></tr>";
			$i++;
		} while ($today = mysql_fetch_array($result));
		echo "</table>";
	}
	
	
	
	$result = mysql_query("SELECT * FROM banner_clicks WHERE banner_id = '1' and date = '$yesterday'",$db);
	$today = mysql_num_rows($result);
	$i = 1;
	
	if (mysql_num_rows($result) > 0) {
			
		echo "<br/><br/><b>Yesterday</b></br><table cellpadding='0' cellspacing='3'>";
		do {
			$day = split('-',$today['date']);
			$day = $day[2];
			$month = split('-',$today['date']);
			$month = (int) $month[1];
			$month = $months[$month];
			$year = split('-',$today['date']);
			$year = $year[0];
			$style = ($i % 2 == 0) ? "style='background: #cdf'" : '';
			echo "<tr ".$style."><td style='padding: 5px 20px;'>".$i."</td><td style='padding: 5px 20px;'>".$day." of ".$month.", ".$year."</td><td style='padding: 5px 20px;'>".$today['time']."</td></tr>";
			$i++;
		} while ($today = mysql_fetch_array($result));
		echo "</table>";
		
	}
			
	$result = mysql_query("SELECT * FROM banner_clicks WHERE banner_id = '1'",$db);
	$today = mysql_num_rows($result);
	
	if (mysql_num_rows($result) > 0) {
		$i = 1;
		$months = array('Nullember','January','February','March','April','May','June','July','August','September','October','November','December');
		
		echo "<br/><br/><b>Total</b></br><table cellpadding='0' cellspacing='3'>";
		do {
			$day = split('-',$today['date']);
			$day = $day[2];
			$month = split('-',$today['date']);
			$month = (int) $month[1];
			$month = $months[$month];
			$year = split('-',$today['date']);
			$year = $year[0];
			$style = ($i % 2 == 0) ? "style='background: #cdf'" : '';
			echo "<tr ".$style."><td style='padding: 5px 20px;'>".$i."</td><td style='padding: 5px 20px;'>".$day." of ".$month.", ".$year."</td><td style='padding: 5px 20px;'>".$today['time']."</td></tr>";
			$i++;
		} while ($today = mysql_fetch_array($result));
		echo "</table>";
	}
		
?>