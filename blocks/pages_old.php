<?php

if (isset($new))
	{
		$result = mysql_query("SELECT id FROM hotels",$db);
		if (mysql_num_rows($result) > $x)
			{
				$max_page = ceil(mysql_num_rows($result)/$x);
				
				echo "
				<div id='pages'>
				";
				
				if ($prev_2page > 1)
					{ echo "<a href='?new&amp;page=1'> << </a>"; }
				
				if ($prev_2page != 0 && $prev_2page != -1)
					{ echo "<a href='?new&amp;page=".$prev_2page."'> ".$prev_2page." </a>"; }
							
				if ($prev_page > 0)	
					{ echo "<a href='?new&amp;page=".$prev_page."'> ".$prev_page." </a>"; }
					
				echo "<span>".$page."</span>";
					
				if ($next_page < $max_page + 1)	
					{ echo "<a href='?new&amp;page=".$next_page."'> ".$next_page." </a>"; }
				
				if ($next_2page != $max_page + 1 && $next_2page != $max_page + 2)
					{ echo "<a href='?new&amp;page=".$next_2page."'> ".$next_2page." </a>"; }
				
				if ($next_2page < $max_page)
					{ echo "<a href='?new&amp;page=".$max_page."'> >> </a>"; }
					
				echo "
				</div>
				<br />
				";
			}
	}

if (isset($r))
	{
		$result = mysql_query("SELECT id FROM hotels WHERE region='$r'",$db);
		if (mysql_num_rows($result) > $x)
			{
				$max_page = ceil(mysql_num_rows($result)/$x);
				
				echo "
				<div id='pages'>
				";
				
				if ($prev_2page > 1)
					{ echo "<a href='?r=".$r."&amp;page=1&amp;s=".$s."'> << </a>"; }
				
				if ($prev_2page != 0 && $prev_2page != -1)
					{ echo "<a href='?r=".$r."&amp;page=".$prev_2page."&amp;s=".$s."'> ".$prev_2page." </a>"; }
							
				if ($prev_page > 0)	
					{ echo "<a href='?r=".$r."&amp;page=".$prev_page."&amp;s=".$s."'> ".$prev_page." </a>"; }
					
				echo "<span>".$page."</span>";
					
				if ($next_page < $max_page + 1)	
					{ echo "<a href='?r=".$r."&amp;page=".$next_page."&amp;s=".$s."'> ".$next_page." </a>"; }
				
				if ($next_2page != $max_page + 1 && $next_2page != $max_page + 2)
					{ echo "<a href='?r=".$r."&amp;page=".$next_2page."&amp;s=".$s."'> ".$next_2page." </a>"; }
				
				if ($next_2page < $max_page)
					{ echo "<a href='?r=".$r."&amp;page=".$max_page."&amp;s=".$s."'> >> </a>"; }
					
				echo "
				</div>
				<br />
				";
			}
	}
	
if (isset($qwe))
	{
		$result = mysql_query(
			"SELECT DISTINCT(h.id)
			FROM hotels h, hotels_countries as r
			WHERE
			h.id = r.hotel_id AND r.country_id = {$qwe} $s");

		if (mysql_num_rows($result) > $x)
			{
				$max_page = ceil(mysql_num_rows($result)/$x);
				
				echo "
				<div id='pages'>
				";
				
				if ($prev_2page > 1)
					{ echo "<a href='?qwe=".$qwe."&page=1'> << </a>"; }
				
				if ($prev_2page != 0 && $prev_2page != -1)
					{ echo "<a href='?qwe=".$qwe."&page=".$prev_2page."&amp;s=".$s."'> ".$prev_2page." </a>"; }
							
				if ($prev_page > 0)	
					{ echo "<a href='?qwe=".$qwe."&page=".$prev_page."&amp;s=".$s."'> ".$prev_page." </a>"; }
					
				echo "<span>".$page."</span>";
					
				if ($next_page < $max_page + 1)	
					{ echo "<a href='?qwe=".$qwe."&page=".$next_page."&amp;s=".$s."'> ".$next_page." </a>"; }
				
				if ($next_2page != $max_page + 1 && $next_2page != $max_page + 2)
					{ echo "<a href='?qwe=".$qwe."&page=".$next_2page."&amp;s=".$s."'> ".$next_2page." </a>"; }
				
				if ($next_2page < $max_page)
					{ echo "<a href='?qwe=".$qwe."&page=".$max_page."&amp;s=".$s."'> >> </a>"; }
					
				echo "
				</div>
				<br />
				";
			}
	}
	
if (isset($search)) {

		$result = mysql_query($count_sql);
	
	if (mysql_num_rows($result) > $x)
		{
			$max_page = ceil(mysql_num_rows($result)/$x);
			
			echo "
			<div id='pages'>
			";
			
			if ($prev_2page > 1)
				{ echo "<a href='?search=".$search."&page=1'> << </a>"; }
			
			if ($prev_2page != 0 && $prev_2page != -1)
				{ echo "<a href='?search&country=".$c."&max_price=".$max_price."&min_price=".$min_price."&min_rooms=".$min_rooms."&max_rooms=".$max_rooms."&page=".$prev_2page."&amp;s=".$s."'> ".$prev_2page." </a>"; }
						
			if ($prev_page > 0)	
				{ echo "<a href='?search&country=".$c."&max_price=".$max_price."&min_price=".$min_price."&min_rooms=".$min_rooms."&max_rooms=".$max_rooms."&page=".$prev_page."&amp;s=".$s."'> ".$prev_page." </a>"; }
				
			echo "<span>".$page."</span>";
				
			if ($next_page < $max_page + 1)	
				{ echo "<a href='?search=&country=".$c."&max_price=".$max_price."&min_price=".$min_price."&min_rooms=".$min_rooms."&max_rooms=".$max_rooms."&page=".$next_page."&amp;s=".$s."'> ".$next_page." </a>"; }
			
			if ($next_2page != $max_page + 1 && $next_2page != $max_page + 2)
				{ echo "<a href='?search=&country=".$c."&max_price=".$max_price."&min_price=".$min_price."&min_rooms=".$min_rooms."&max_rooms=".$max_rooms."&page=".$next_2page."&amp;s=".$s."'> ".$next_2page." </a>"; }
			
			if ($next_2page < $max_page)
				{ echo "<a href='?search=&country=".$c."&max_price=".$max_price."&min_price=".$min_price."&min_rooms=".$min_rooms."&max_rooms=".$max_rooms."&page=".$max_page."&amp;s=".$s."'> >> </a>"; }
				
			echo "
			</div>
			<br />
			";
		}
}
	
?>