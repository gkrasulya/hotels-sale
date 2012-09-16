<?php
// куда вернуться
$back="http://"."$_SERVER[HTTP_HOST]"."$_SERVER[PHP_SELF]"."?page="."$_GET[page]";

echo "<form action= method=POST><table cellspacing=0 cellpadding=0 width=360>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center>
	  <input name=back type=hidden value="."$back".">
      </td><td bgcolor=#8f95ac width=1px></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=center>&nbsp;</td><td bgcolor=#8f95ac width=1px></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
?>