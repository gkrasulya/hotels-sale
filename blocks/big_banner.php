<?php 
	$result = mysql_query("SELECT * FROM banners WHERE type='big'",$db);
	$myrow = mysql_fetch_array($result);
	if ($myrow['levoe'] == 'yes') {
		if ($myrow['src'] == 'swf') { ?>
			
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
			  	width="<?= $myrow['width'] ?>" height="<?= $myrow['height'] ?>" id="FlashID" title="header">
			  <param name="movie" value="<?=$myrow['url']?>" />
			  <param name="quality" value="high" />
			  <param name="wmode" value="opaque" />
			  <param name="swfversion" value="8.0.35.0" />
			  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
			  <param name="expressinstall" value="Scripts/expressInstall.swf" />
			  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
			  <!--[if !IE]>-->
			  <object type="application/x-shockwave-flash" data="header2.swf"
			  	width="<?=$myrow['width']?>" height="<?=$myrow['height']?>">
				<!--<![endif]-->
				<param name="quality" value="high" />
				<param name="wmode" value="opaque" />
				<param name="swfversion" value="8.0.35.0" />
				<param name="expressinstall" value="Scripts/expressInstall.swf" />
				<!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
				<div>
				  <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
				  <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
				</div>
				<!--[if !IE]>-->
			  </object>
			  <!--<![endif]-->
			</object>
			<script type="text/javascript">
				<!--
				swfobject.registerObject("FlashID");
				//-->
			</script>
			
		<? } else { ?>
			<div id='bigBanner'>
				<a target='_blank' href='/go.php?to=<?=$myrow['id']?>'
					alt='<?=$myrow['title']?>'>
					<img src='<?=$myrow['url']?>' alt='<?=$myrow['title']?>'
						width='<?=$myrow['width']?>' height='<?=$myrow['height']?>' />
				</a>
			</div>
		<? }
	}
?>