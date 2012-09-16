<?php
// куда вернуться
$back="http://"."$_SERVER[HTTP_HOST]"."$_SERVER[PHP_SELF]"."?page="."$_GET[page]";

echo "<form action=sendmail.php method=POST><table cellspacing=0 cellpadding=0 width=360>
      <tr><td align=right valign=top width=1px><img src=images/login_lu.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_ru.gif width=8 height=8 border=0></td></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right><font color=white><b>Отправить сообщения на e-mail</b></font><br><select name=choose_letter style=\"width:350px;\">";
	    
	  echo "<option value=\"none\">Выбор письма из шаблонов</option>";
	  for($i=12;$i<=15;$i++) {
	  $path_w[$i] = "letters/w"."$i".".txt";
      $letter_swith[$i] = file("$path_w[$i]");
      $letter_swith[$i] = implode("",$letter_swith[$i]);
	  if(trim($letter_swith[$i])=="on") {
	     $path_t[$i] = "letters/t"."$i".".txt";
         $letter_title[$i] = file("$path_t[$i]");
         $letter_title[$i] = implode("",$letter_title[$i]);
	  	 echo "<option value=\""."$letter_title[$i]"."\">"."$letter_title[$i]"."</option>";
      } // end if
	  } // end for
	  echo "</select>
	  <input name=back type=hidden value="."$back".">";
	  
echo "</td><td bgcolor=#8f95ac width=1px></tr>
      <tr><td bgcolor=#8f95ac width=1px></td><td bgcolor=#8f95ac align=right>отметить всех > <input type=checkbox value=on name=allbox onclick=checkAll()> <input name=sendmail style=\"width:120px;\" type=submit value=\"Отправить\"></td><td bgcolor=#8f95ac width=1px></tr>
	  <tr><td align=right valign=top width=1px><img src=images/login_ld.gif width=8 height=8 border=0></td><td valign=top bgcolor=#8f95ac></td><td align=left valign=top width=1px><img src=images/login_rd.gif width=8 height=8 border=0></td></tr>
      </table>";
?>