<?php


	if (isset($b)) {
		if($b=='big') {
			echo "
				big |
				<a href='?t=banners&b=medium'>medium</a> |
				<a href='?t=banners&b=subscribe'>under subscribe</a>
			";		
		}elseif($b=='medium'){							
			echo "
				<a href='?t=banners&b=big'>большой баннер</a> |
				medium |
				<a href='?t=banners&b=subscribe'>under subscribe</a>
			";		
		}elseif($b=='small') {
			echo "
				<a href='?t=banners&b=big'>большой баннер</a> |
				<a href='?t=banners&b=medium'>medium</a> |
				<a href='?t=banners&b=subscribe'>under subscribe</a>
			";		
		}elseif($b=='search') {
			echo "
				<a href='?t=banners&b=big'>большой баннер</a> |
				<a href='?t=banners&b=medium'>medium</a> |
				<a href='?t=banners&b=subscribe'>under subscribe</a>
			";		
		}elseif($b=='subscribe') {
			echo "
				<a href='?t=banners&b=big'>большой баннер</a> |
				<a href='?t=banners&b=medium'>medium</a> |
				under subscribe
			";	
			
			if (isset($a) && ($a == 'add' || $a == 'edit')) {
				echo "<br/><br/><a href='?t=banners&b=small'>&larr; back to list</a>";
			}
		}
		
		
	}
											
										
										

	echo "<h2>Banners</h2>";
									
									if (!isset($b)) {
										
										echo "
											<a href='?t=banners&b=big' onmouseover='document.getElementById(\"pointer\").style.left = \"110px\"; document.getElementById(\"pointer\").style.top = \"38px\"; document.getElementById(\"pointer\").style.height = \"20px\"; document.getElementById(\"pointer\").style.width = \"90px\" '>
												<b>big</b>
											</a><br/>
											<a href='?t=banners&b=medium' onmouseover='document.getElementById(\"pointer\").style.left = \"5px\"; document.getElementById(\"pointer\").style.top = \"60px\"; document.getElementById(\"pointer\").style.height = \"25px\"; document.getElementById(\"pointer\").style.width = \"50px\" '>
												<b>medium</b>
											</a><br/>
											<a href='?t=banners&b=subscribe'  onmouseover='document.getElementById(\"pointer\").style.left = \"5px\"; document.getElementById(\"pointer\").style.top = \"190px\"; document.getElementById(\"pointer\").style.height = \"25px\"; document.getElementById(\"pointer\").style.width = \"50px\" '>
												<b>under subscribe</b>
											</a>
											
											<div id='mapmap' style='width: 200px; height: 358px; background: url(http://hotels-sale.ru/map.gif) top left no-repeat; float: right; position: relative; top: -100px;'>
												<div id='pointer' style='background: red; position: absolute;'></div>
											</div>
											
											<script type='text/javascript'>
												var mapmap = document.getElementById('mapmap');
											</script>
										";
									
									} else {
									
										if ($b=='big') {
										
											if(isset($do)) {
											
												$width = array(384,400,468,468,500);
												$height = array(115,40,60,120,100);
												$size = array('384x115','400x40','468x60','468x120','500x100');
											
												$url = $_POST['url'];												
												$refresh = $_POST['refresh'];
												$sh = $_POST['show'] == 1 ? 'yes' : 'no';
												$title = $_POST['title'];
												$src = $url == '' ? 'none' : substr($url, strlen($url)-3, strlen($url));
												$width = $width[$_POST['props']];
												$height = $height[$_POST['props']];
												$size = $size[$_POST['props']];
												$href = $_POST['href'];
												
												if ($refresh == '1') {
													mysql_query("DELETE FROM banner_clicks WHERE banner_id='1'",$db);
												}
												
												$result = mysql_query("UPDATE banners SET url='$url', levoe='$sh', href='$href', width='$width', height='$height', size='$size', src='$src', title='$title' WHERE type='big'",$db);
												if ($result) {
												echo "<h2>It's all ok</h2>";
												} else {
												echo "<h2>Bad!</h2>";
												}
											}
											
											$result = mysql_query("SELECT * FROM banners WHERE type='big'",$db);
											$myrow = mysql_fetch_array($result);
											$banner = $myrow;
											$checked = $banner['levoe'] == 'yes' ? "checked='checked'" : '';
											
											$banner['size'] == '384x115' ? $w0 = 'selected' : $w0 = '';
											$banner['size'] == '400x40' ? $w1 = 'selected' : $w1 = '';
											$banner['size'] == '468x60' ? $w2 = 'selected' : $w2 = '';
											$banner['size'] == '468x120' ? $w3 = 'selected' : $w3 = '';
											$banner['size'] == '500x100' ? $w4 = 'selected' : $w4 = '';
											
											if ($banner['url'] != '') {
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
											} else {
												echo "This banner isn't exists";
											}
											
											$today = date("Y-m-d");
											$yesterday = date("Y-").(date("m")-1).date("-d");
											
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '1' and date = '$today'",$db);
											$today = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '1' and date = '$yesterday'",$db);
											$yesterday = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '1'",$db);
											$total = mysql_num_rows($result);
											
											echo "<br/><br/><a href='?banner_stats=1'><b>Stats:</b></a><br/><br/>
												Today: ".$today."<br/>
												Yesterday: ".$yesterday."<br/>
												Total: ".$total."<br/>
											";
											
											echo "<br/><br/>
												<form action='?t=banners&b=big&do' method='post' enctype='multipart/form-data'>
												<p>
													<label for='title'>Заголовок:</label><br/>
													<input type='text' name='title' value='".$banner['title']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='url'>Адрес баннера:</label><br/>
													<input type='text' name='url' value='".$banner['url']."' style='width: 300px' />
												</p><br/>";
											echo "<p>
													<label for='url'>Ссылка (куда перейдет браузер при клике, только для картинок):</label><br/>
													<input type='text' name='href' value='".$banner['href']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='props'>Размер:</label><br/>
													<select name='props'>
														<option value='0' ".$w0.">384x115</option>
														<option value='1' ".$w1.">400x40</option>
														<option value='2' ".$w2.">468x60</option>
														<option value='3' ".$w3.">468x120</option>
														<option value='4' ".$w4.">500x100</option>
													</select>
												</p><br/>
												<p>
													<label for='show'>Show this banner</label>
													<input name='show' type='checkbox' value='1' ".$checked." />
												</p><br/>
												<p>
													<label for='show'>Refresh stats</label>
													<input name='refresh' type='checkbox' value='1' />
												</p><br/>
												<p>
													<input type='submit' value='submit' />
												</p>
												</form>
											";
										
												
										} elseif ($b=='medium') {
										
											if(isset($do)) {
											
												$width = array(125,125,150,160,160,160,170,200,280,120);
												$height = array(125,250,160,60,120,400,100,80,80,60);
												$size = array('125x125','125x250','150x160','160x60','160x120','160x400','170x100','200x80','280x80','120x60');
												
												$prop = $_POST['props'];
												
												$url = $_POST['url'];												
												$refresh = $_POST['refresh'];
												$sh = $_POST['show'] == 1 ? 'yes' : 'no';
												$title = $_POST['title'];
												$src = $url == '' ? 'none' : substr($url, strlen($url)-3, strlen($url));
												$width = $width[$_POST['props']];
												$height = $height[$_POST['props']];
												$size = $size[$_POST['props']];
												$href = $_POST['href'];
												
												if ($refresh == '1') {
													mysql_query("DELETE FROM banner_clicks WHERE banner_id='2'",$db);
												}
												
												$result = mysql_query("UPDATE banners SET url='$url', levoe='$sh', href='$href', width='$width', height='$height', size='$size', src='$src', title='$title' WHERE type='medium'",$db);
												if ($result) {
												echo "<h2>It's all ok</h2>";
												} else {
												echo "<h2>Bad!</h2>";
												}
											}
											
											$result = mysql_query("SELECT * FROM banners WHERE type='medium'",$db);
											$myrow = mysql_fetch_array($result);
											$banner = $myrow;
											$checked = $banner['levoe'] == 'yes' ? "checked='checked'" : '';
											
											$banner['size'] == '125x125' ? $w0 = 'selected' : $w0 = '';
											$banner['size'] == '125x250' ? $w1 = 'selected' : $w1 = '';
											$banner['size'] == '150x160' ? $w2 = 'selected' : $w2 = '';
											$banner['size'] == '160x60' ? $w3 = 'selected' : $w3 = '';
											$banner['size'] == '160x120' ? $w4 = 'selected' : $w4 = '';
											$banner['size'] == '160x400' ? $w5 = 'selected' : $w5 = '';
											$banner['size'] == '170x100' ? $w6 = 'selected' : $w6 = '';
											$banner['size'] == '200x80' ? $w7 = 'selected' : $w7 = '';
											$banner['size'] == '280x80' ? $w8 = 'selected' : $w8 = '';
											$banner['size'] == '120x60' ? $w9 = 'selected' : $w9 = '';
											
											if ($banner['url'] != '') {
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
											} else {
												echo "This banner isn't exists";
											}
											
											$today = date("Y-m-d");
											$yesterday = date("Y-").(date("m")-1).date("-d");
											
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '2' and date = '$today'",$db);
											$today = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '2' and date = '$yesterday'",$db);
											$yesterday = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '2'",$db);
											$total = mysql_num_rows($result);
											
											echo "<br/><br/><a href='?banner_stats=2'><b>Stats:</b></a><br/><br/>
												Today: ".$today."<br/>
												Yesterday: ".$yesterday."<br/>
												Total: ".$total."<br/>
											";
											
											echo "<br/><br/>
												<form action='?t=banners&b=medium&do' method='post' enctype='multipart/form-data'>
												<p>
													<label for='title'>Заголовок:</label><br/>
													<input type='text' name='title' value='".$banner['title']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='url'>Адрес баннера:</label><br/>
													<input type='text' name='url' value='".$banner['url']."' style='width: 300px' />
												</p><br/>";
											echo "<p>
													<label for='url'>Ссылка (куда перейдет браузер при клике, только для картинок):</label><br/>
													<input type='text' name='href' value='".$banner['href']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='props'>Размер:</label><br/>
													<select name='props'>
														<option value='0' ".$w0.">125x125</option>
														<option value='1' ".$w1.">125x250</option>
														<option value='2' ".$w2.">150x160</option>
														<option value='3' ".$w3.">160x60</option>
														<option value='4' ".$w4.">160x120</option>
														<option value='5' ".$w5.">160x400</option>
														<option value='6' ".$w6.">170x100</option>
														<option value='7' ".$w7.">200x80</option>
														<option value='8' ".$w8.">280x80</option>
														<option value='9' ".$w9.">120x60</option>
													</select>
												</p><br/>
												<p>
													<label for='show'>Show this banner</label>
													<input name='show' type='checkbox' value='1' ".$checked." />
												</p><br/>
												<p>
													<label for='show'>Refresh stats</label>
													<input name='refresh' type='checkbox' value='1' />
												</p><br/>
												<p>
													<input type='submit' value='submit' />
												</p>
												</form>
											";
										
										}elseif ($b=='search') {
										
											if(isset($do)) {
											
												$width = array(125,125,150,160,160,160,170,200,280,120);
												$height = array(125,250,160,60,120,400,100,80,80,60);
												$size = array('125x125','125x250','150x160','160x60','160x120','160x400','170x100','200x80','280x80','120x60');
												
												$prop = $_POST['props'];
												
												$url = $_POST['url'];												
												$refresh = $_POST['refresh'];
												$sh = $_POST['show'] == 1 ? 'yes' : 'no';
												$title = $_POST['title'];
												$src = $url == '' ? 'none' : substr($url, strlen($url)-3, strlen($url));
												$width = $width[$_POST['props']];
												$height = $height[$_POST['props']];
												$size = $size[$_POST['props']];
												$href = $_POST['href'];
												
												if ($refresh == '1') {
													mysql_query("DELETE FROM banner_clicks WHERE banner_id='8'",$db);
												}
												
												$result = mysql_query("UPDATE banners SET url='$url', levoe='$sh', href='$href', width='$width', height='$height', size='$size', src='$src', title='$title' WHERE type='search'",$db);
												if ($result) {
												echo "<h2>It's all ok</h2>";
												} else {
												echo "<h2>Bad!</h2>";
												}
											}
											
											$result = mysql_query("SELECT * FROM banners WHERE type='search'",$db);
											$myrow = mysql_fetch_array($result);
											$banner = $myrow;
											$checked = $banner['levoe'] == 'yes' ? "checked='checked'" : '';
											
											$banner['size'] == '125x125' ? $w0 = 'selected' : $w0 = '';
											$banner['size'] == '125x250' ? $w1 = 'selected' : $w1 = '';
											$banner['size'] == '150x160' ? $w2 = 'selected' : $w2 = '';
											$banner['size'] == '160x60' ? $w3 = 'selected' : $w3 = '';
											$banner['size'] == '160x120' ? $w4 = 'selected' : $w4 = '';
											$banner['size'] == '160x400' ? $w5 = 'selected' : $w5 = '';
											$banner['size'] == '170x100' ? $w6 = 'selected' : $w6 = '';
											$banner['size'] == '200x80' ? $w7 = 'selected' : $w7 = '';
											$banner['size'] == '280x80' ? $w8 = 'selected' : $w8 = '';
											$banner['size'] == '120x60' ? $w9 = 'selected' : $w9 = '';
											
											if ($banner['url'] != '') {
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
											} else {
												echo "This banner isn't exists";
											}
											
											$today = date("Y-m-d");
											$yesterday = date("Y-").(date("m")-1).date("-d");
											
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '8' and date = '$today'",$db);
											$today = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '8' and date = '$yesterday'",$db);
											$yesterday = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '8'",$db);
											$total = mysql_num_rows($result);
											
											echo "<br/><br/><a href='?banner_stats=8'><b>Stats:</b></a><br/><br/>
												Today: ".$today."<br/>
												Yesterday: ".$yesterday."<br/>
												Total: ".$total."<br/>
											";
											
											echo "<br/><br/>
												<form action='?t=banners&b=search&do' method='post' enctype='multipart/form-data'>
												<p>
													<label for='title'>Заголовок:</label><br/>
													<input type='text' name='title' value='".$banner['title']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='url'>Адрес баннера:</label><br/>
													<input type='text' name='url' value='".$banner['url']."' style='width: 300px' />
												</p><br/>";
											echo "<p>
													<label for='url'>Ссылка (куда перейдет браузер при клике, только для картинок):</label><br/>
													<input type='text' name='href' value='".$banner['href']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='props'>Размер:</label><br/>
													<select name='props'>
														<option value='0' ".$w0.">125x125</option>
														<option value='1' ".$w1.">125x250</option>
														<option value='2' ".$w2.">150x160</option>
														<option value='3' ".$w3.">160x60</option>
														<option value='4' ".$w4.">160x120</option>
														<option value='5' ".$w5.">160x400</option>
														<option value='6' ".$w6.">170x100</option>
														<option value='7' ".$w7.">200x80</option>
														<option value='8' ".$w8.">280x80</option>
														<option value='9' ".$w9.">120x60</option>
													</select>
												</p><br/>
												<p>
													<label for='show'>Show this banner</label>
													<input name='show' type='checkbox' value='1' ".$checked." />
												</p><br/>
												<p>
													<label for='show'>Refresh stats</label>
													<input name='refresh' type='checkbox' value='1' />
												</p><br/>
												<p>
													<input type='submit' value='submit' />
												</p>
												</form>
											";
										
										} elseif ($b=='subscribe') {
										
											if(isset($do)) {
											
												$width = array(125,125,150,160,160,160,170,200,280);
												$height = array(125,250,160,60,120,400,100,80,80);
												$size = array('125x125','125x250','150x160','160x60','160x120','160x400','170x100','200x80','280x80');
												
												$prop = $_POST['props'];
												
												$url = $_POST['url'];												
												$refresh = $_POST['refresh'];
												$sh = $_POST['show'] == 1 ? 'yes' : 'no';
												$title = $_POST['title'];
												$src = $url == '' ? 'none' : substr($url, strlen($url)-3, strlen($url));
												$width = $width[$_POST['props']];
												$height = $height[$_POST['props']];
												$size = $size[$_POST['props']];
												$href = $_POST['href'];
												
												if ($refresh == '1') {
													mysql_query("DELETE FROM banner_clicks WHERE banner_id='9'",$db);
												}
												
												$result = mysql_query("UPDATE banners SET url='$url', levoe='$sh', href='$href', width='$width', height='$height', size='$size', src='$src', title='$title' WHERE type='subscribe'",$db);
												if ($result) {
												echo "<h2>It's all ok</h2>";
												} else {
												echo "<h2>Bad!</h2>";
												}
											}
											
											$result = mysql_query("SELECT * FROM banners WHERE type='subscribe'",$db);
											$myrow = mysql_fetch_array($result);
											$banner = $myrow;
											$checked = $banner['levoe'] == 'yes' ? "checked='checked'" : '';
											
											$banner['size'] == '125x125' ? $w0 = 'selected' : $w0 = '';
											$banner['size'] == '125x250' ? $w1 = 'selected' : $w1 = '';
											$banner['size'] == '150x160' ? $w2 = 'selected' : $w2 = '';
											$banner['size'] == '160x60' ? $w3 = 'selected' : $w3 = '';
											$banner['size'] == '160x120' ? $w4 = 'selected' : $w4 = '';
											$banner['size'] == '160x400' ? $w5 = 'selected' : $w5 = '';
											$banner['size'] == '170x100' ? $w6 = 'selected' : $w6 = '';
											$banner['size'] == '200x80' ? $w7 = 'selected' : $w7 = '';
											$banner['size'] == '280x80' ? $w8 = 'selected' : $w8 = '';
											
											if ($banner['url'] != '') {
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
											} else {
												echo "This banner isn't exists";
											}
											
											$today = date("Y-m-d");
											$yesterday = date("Y-").(date("m")-1).date("-d");
											
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '9' and date = '$today'",$db);
											$today = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '9' and date = '$yesterday'",$db);
											$yesterday = mysql_num_rows($result);
											$result = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '9'",$db);
											$total = mysql_num_rows($result);
											
											echo "<br/><br/><a href='?banner_stats=9'><b>Stats:</b></a><br/><br/>
												Today: ".$today."<br/>
												Yesterday: ".$yesterday."<br/>
												Total: ".$total."<br/>
											";
											
											echo "<br/><br/>
												<form action='?t=banners&b=subscribe&do' method='post' enctype='multipart/form-data'>
												<p>
													<label for='title'>Заголовок:</label><br/>
													<input type='text' name='title' value='".$banner['title']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='url'>Адрес баннера:</label><br/>
													<input type='text' name='url' value='".$banner['url']."' style='width: 300px' />
												</p><br/>";
											echo "<p>
													<label for='url'>Ссылка (куда перейдет браузер при клике, только для картинок):</label><br/>
													<input type='text' name='href' value='".$banner['href']."' style='width: 300px' />
												</p><br/>
												<p>
													<label for='props'>Размер:</label><br/>
													<select name='props'>
														<option value='0' ".$w0.">125x125</option>
														<option value='1' ".$w1.">125x250</option>
														<option value='2' ".$w2.">150x160</option>
														<option value='3' ".$w3.">160x60</option>
														<option value='4' ".$w4.">160x120</option>
														<option value='5' ".$w5.">160x400</option>
														<option value='6' ".$w6.">170x100</option>
														<option value='7' ".$w7.">200x80</option>
														<option value='8' ".$w8.">280x80</option>
													</select>
												</p><br/>
												<p>
													<label for='show'>Show this banner</label>
													<input name='show' type='checkbox' value='1' ".$checked." />
												</p><br/>
												<p>
													<label for='show'>Refresh stats</label>
													<input name='refresh' type='checkbox' value='1' />
												</p><br/>
												<p>
													<input type='submit' value='submit' />
												</p>
												</form>
											";
										
										} elseif ($b=='small') {
										
											if (!isset($a)) {												
											
												$result = mysql_query("SELECT * FROM banners WHERE type='small'",$db);
												$banner = mysql_fetch_array($result);
												
												if (mysql_num_rows($result) == 0) {
													echo "no small banners";
												}else {
													do {
														echo "<div style='margin-top: 20px;'>";
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
														
														$result_c = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '$banner[id]' and date = '$today'",$db);
														$today = mysql_num_rows($result_c);
														$result_c = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '$banner[id]' and date = '$yesterday'",$db);
														$yesterday = mysql_num_rows($result_c);
														$result_c = mysql_query("SELECT id FROM banner_clicks WHERE banner_id = '$banner[id]'",$db);
														$total = mysql_num_rows($result_c);
														
														echo "<br/><br/><a href='?banner_stats=".$banner['id']."'><b>Stats:</b></a><br/><br/>
															Today: ".$today."<br/>
															Yesterday: ".$yesterday."<br/>
															Total: ".$total."<br/>
														";	
														
														echo "<br/><a href='?t=banners&b=small&a=edit&banner_id=".$banner['id']."'>редактировать</a> | <a href='?t=banners&b=small&a=delete&banner_id=".$banner['id']."' onclick='if (confirm(\"are you sure?\")) { return true } else { return false }'>удалить</a></div>";
													} while ($banner = mysql_fetch_array($result));
												}
												
												echo "<br/><br/><a href='?t=banners&b=small&a=add'>добавить</a><br/";
											} else {
												if ($a=='add') {
										
													if(isset($do)) {
														$width = array(125,125,150,160,160,160,170,200,280);
														$height = array(125,250,160,60,120,400,100,80,80);
														$size = array('125x125','125x250','150x160','160x60','160x120','160x400','170x100','200x80','280x80');
														$url = $_POST['url'];		
														$sh = $_POST['show'] == 1 ? 'yes' : 'no';
														$title = $_POST['title'];
														$src = $url == '' ? 'none' : substr($url, strlen($url)-3, strlen($url));
														$width = $width[$_POST['props']];
														$height = $height[$_POST['props']];
														$size = $size[$_POST['props']];
														$href = $_POST['href'];
														
														$result = mysql_query("INSERT INTO banners (url,levoe,href,width,height,size,src,title,type) VALUES ('$url','$sh','$href','$width','$height','$size','$src','$title','small')",$db);
														if ($result) {
														echo "<h2>It's all ok</h2>";
														} else {
														echo "<h2>Bad!</h2>";
														}
													}
													$checked = "checked='checked'";
													
													echo "<br/><br/>
														<form action='?t=banners&b=small&a=add&do' method='post' enctype='multipart/form-data'>
														<p>
															<label for='title'>Заголовок:</label><br/>
															<input type='text' name='title' value='' style='width: 300px' />
														</p><br/>
														<p>
															<label for='url'>Адрес баннера:</label><br/>
															<input type='text' name='url' value='' style='width: 300px' />
														</p><br/>";
													echo "<p>
															<label for='url'>Ссылка (куда перейдет браузер при клике, только для картинок):</label><br/>
															<input type='text' name='href' value='' style='width: 300px' />
														</p><br/>
														<p>
															<label for='props'>Размер:</label><br/>
															<select name='props'>
																<option value='0'>125x125</option>
																<option value='1'>125x250</option>
																<option value='2'>150x160</option>
																<option value='3'>160x60</option>
																<option value='4'>160x120</option>
																<option value='5'>160x400</option>
																<option value='6'>170x100</option>
																<option value='7'>200x80</option>
																<option value='8'>280x80</option>
															</select>
														</p><br/>
														<p>
															<label for='show'>Show this banner</label>
															<input name='show' type='checkbox' value='1' ".$checked." />
														</p><br/>
														<p>
															<label for='show'>Refresh stats</label>
															<input name='refresh' type='checkbox' value='1' />
														</p><br/>
														<p>
															<input type='submit' value='submit' />
														</p>
														</form>
													";
												
												
												}elseif($a=='edit') {
										
													if(isset($do)) {
														
														$banner_id = $_GET['banner_id'];
														$width = array(125,125,150,160,160,160,170,200,280);
														$height = array(125,250,160,60,120,400,100,80,80);
														$size = array('125x125','125x250','150x160','160x60','160x120','160x400','170x100','200x80','280x80');
													
														$url = $_POST['url'];												
														$refresh = $_POST['refresh'];
														$sh = $_POST['show'] == 1 ? 'yes' : 'no';
														$title = $_POST['title'];
														$src = $url == '' ? 'none' : substr($url, strlen($url)-3, strlen($url));
														$width = $width[$_POST['props']];
														$height = $height[$_POST['props']];
														$size = $size[$_POST['props']];
														$href = $_POST['href'];
														
														if ($refresh == '1') {
															mysql_query("DELETE FROM banner_clicks WHERE banner_id='$banner_id'",$db);
														}
														
														$result = mysql_query("UPDATE banners SET url='$url', levoe='$sh', href='$href', width='$width', height='$height', size='$size', src='$src', title='$title' WHERE id='$banner_id'",$db);
														if ($result) {
														echo "<h2>It's all ok</h2>";
														} else {
														echo "<h2>Bad!</h2>";
														}
													}
													
													$result = mysql_query("SELECT * FROM banners WHERE id='$banner_id'",$db);
													$myrow = mysql_fetch_array($result);
													$banner = $myrow;
													$checked = $banner['levoe'] == 'yes' ? "checked='checked'" : '';
													
													$banner['size'] == '125x125' ? $w0 = 'selected' : $w0 = '';
													$banner['size'] == '125x250' ? $w1 = 'selected' : $w1 = '';
													$banner['size'] == '150x160' ? $w2 = 'selected' : $w2 = '';
													$banner['size'] == '160x60' ? $w3 = 'selected' : $w3 = '';
													$banner['size'] == '160x120' ? $w4 = 'selected' : $w4 = '';
													$banner['size'] == '160x400' ? $w5 = 'selected' : $w5 = '';
													$banner['size'] == '170x100' ? $w6 = 'selected' : $w6 = '';
													$banner['size'] == '200x80' ? $w7 = 'selected' : $w7 = '';
													$banner['size'] == '280x80' ? $w8 = 'selected' : $w8 = '';
													
													if ($banner['url'] != '') {
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
													} else {
														echo "This banner isn't exists";
													}
													
													echo "<br/><br/>
														<form action='?t=banners&b=small&a=edit&banner_id=".$banner_id."&do' method='post' enctype='multipart/form-data'>
														<p>
															<label for='title'>Заголовок:</label><br/>
															<input type='text' name='title' value='".$banner['title']."' style='width: 300px' />
														</p><br/>
														<p>
															<label for='url'>Адрес баннера:</label><br/>
															<input type='text' name='url' value='".$banner['url']."' style='width: 300px' />
														</p><br/>";
													echo "<p>
															<label for='url'>Ссылка (куда перейдет браузер при клике, только для картинок):</label><br/>
															<input type='text' name='href' value='".$banner['href']."' style='width: 300px' />
														</p><br/>
														<p>
															<label for='props'>Размер:</label><br/>
															<select name='props'>
																<option value='0' ".$w0.">125x125</option>
																<option value='1' ".$w1.">125x250</option>
																<option value='2' ".$w2.">150x160</option>
																<option value='3' ".$w3.">160x60</option>
																<option value='4' ".$w4.">160x120</option>
																<option value='5' ".$w5.">160x400</option>
																<option value='6' ".$w6.">170x100</option>
																<option value='7' ".$w7.">200x80</option>
																<option value='8' ".$w8.">280x80</option>
															</select>
														</p><br/>
														<p>
															<label for='show'>Show this banner</label>
															<input name='show' type='checkbox' value='1' ".$checked." />
														</p><br/>
														<p>
															<label for='show'>Refresh stats</label>
															<input name='refresh' type='checkbox' value='1' />
														</p><br/>
														<p>
															<input type='submit' value='submit' />
														</p>
														</form>
													";
												
														
												}elseif($a=='delete') {
												
													$banner_id = $_GET['banner_id'];
													mysql_query("DELETE FROM banners WHERE id='$banner_id'",$db);
													echo "<html><head>
													<meta http-equiv='Refresh' content='0; URL=?t=banners&b=small'>
													</head></html>";
												
												}
											}
										
										}
									
									}

?>