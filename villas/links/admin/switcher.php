<?php
switch($_POST['switch_page']) {
case "links_moder.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_moder.php'>
	  </HEAD></HTML>";
break;
case "links_older.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_older.php'>
	  </HEAD></HTML>";
break;
case "links_new.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_new.php'>
	  </HEAD></HTML>";
break;
case "links_well.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_well.php'>
	  </HEAD></HTML>";
break;	
case "links_badly.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_badly.php'>
	  </HEAD></HTML>";
break;
case "links_nolink.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_nolink.php'>
	  </HEAD></HTML>";
break;
case "links_noindex.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_noindex.php'>
	  </HEAD></HTML>";
break;
case "links_overlink.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_overlink.php'>
	  </HEAD></HTML>";
break;
case "links_lowindex.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_lowindex.php'>
	  </HEAD></HTML>";
break;
case "links_hide.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_hide.php'>
	  </HEAD></HTML>";
break;
case "links_noanswer.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_noanswer.php'>
	  </HEAD></HTML>";
break;
case "links_trash.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_trash.php'>
	  </HEAD></HTML>";
break;
case "links_black.php":
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=links_black.php'>
	  </HEAD></HTML>";
break;
default:
echo "<HTML><HEAD>
      <META HTTP-EQUIV='Refresh' CONTENT='0 URL=config.php'>
	  </HEAD></HTML>";
break;	
}
?>